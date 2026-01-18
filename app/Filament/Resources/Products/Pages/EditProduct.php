<?php

namespace App\Filament\Resources\Products\Pages;

use Exception;
use App\Models\Menu;
use App\Models\Language;
use Illuminate\Support\Arr;
use App\Enums\MenuPosition;
use App\Services\MenuService;
use Illuminate\Support\Facades\Log;
use App\Services\ElasticsearchService;
use Psr\SimpleCache\InvalidArgumentException;
use Illuminate\Validation\ValidationException;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Services\Contracts\ProductServiceInterface;
use App\Filament\Resources\Products\ProductResource;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\EditRecord\Concerns\Translatable;

class EditProduct extends EditRecord
{
    use Translatable;

    protected static string $resource = ProductResource::class;

    /**
     * Relationship data stored before save
     */
    protected array $relationships = [];

    /**
     * Non-translatable data preserved during locale switch
     */
    public array $nonTranslatableData = [];

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    /**
     * Override locale switching to preserve non-translatable fields
     */
    public function updatingActiveLocale(): void
    {
        $this->oldActiveLocale = $this->activeLocale;

        // Store ALL current form data before locale switch
        $this->nonTranslatableData = $this->data;
    }

    /**
     * Override locale switching to restore non-translatable fields
     * @throws ValidationException
     */
    public function updatedActiveLocale(string $newActiveLocale): void
    {
        if (blank($this->oldActiveLocale)) {
            return;
        }

        $this->resetValidation();

        $translatableAttributes = static::getResource()::getTranslatableAttributes();

        try {
            // Store translatable data for old locale
            $this->otherLocaleData[$this->oldActiveLocale] = Arr::only(
                $this->nonTranslatableData,
                $translatableAttributes
            );

            // Get translatable data for new locale (or empty)
            $newLocaleTranslatableData = $this->otherLocaleData[$this->activeLocale] ?? [];

            // Start with all preserved data (includes media, relationships, etc.)
            $restoredData = $this->nonTranslatableData;

            // Update only translatable fields with new locale data
            foreach ($translatableAttributes as $attr) {
                $restoredData[$attr] = $newLocaleTranslatableData[$attr] ?? '';
            }

            // Update Livewire data directly instead of form->fill()
            // This preserves file upload component state
            $this->data = $restoredData;

            unset($this->otherLocaleData[$this->activeLocale]);
        } catch (ValidationException $e) {
            $this->activeLocale = $this->oldActiveLocale;
            throw $e;
        }
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load relationships into form data
        $data['categories'] = $this->record->categories()->pluck('categories.id')->toArray();
        $data['tags'] = $this->record->tags()->pluck('tags.id')->toArray();
        $data['discounts'] = $this->record->discounts()->pluck('discounts.id')->toArray();

        // Split menus by position
        $menus = $this->record->menus()->get();

        $data['featured_menus'] = $menus
            ->where('position', MenuPosition::FEATURED->value)
            ->pluck('id')
            ->toArray();

        $data['sidebar_menus'] = $menus
            ->where('position', MenuPosition::SIDEBAR->value)
            ->pluck('id')
            ->toArray();

        return $data;
    }

    protected function beforeSave(): void
    {
        // Capture form state before any processing
        $formData = $this->form->getState();

        $this->relationships = [
            'categories' => $formData['categories'] ?? [],
            'tags' => $formData['tags'] ?? [],
            'discounts' => $formData['discounts'] ?? [],
            'menus' => array_unique(array_merge(
                $formData['featured_menus'] ?? [],
                $formData['sidebar_menus'] ?? []
            )),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Remove relationship fields - they can't be mass assigned
        unset(
            $data['categories'],
            $data['tags'],
            $data['discounts'],
            $data['featured_menus'],
            $data['sidebar_menus']
        );

        return $data;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function afterSave(): void
    {
        $this->syncRelationships();
        $this->clearProductCache();
        $this->indexToElasticsearch();
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function afterDelete(): void
    {
        $this->clearProductCache();
        $this->removeFromElasticsearch();
    }

    protected function syncRelationships(): void
    {
        $this->record->categories()->sync($this->relationships['categories'] ?? []);
        $this->record->tags()->sync($this->relationships['tags'] ?? []);
        $this->record->discounts()->sync($this->relationships['discounts'] ?? []);
        $this->record->menus()->sync($this->relationships['menus'] ?? []);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function clearProductCache(): void
    {
        app(ProductServiceInterface::class)->flushServiceCache();
        app(MenuService::class)->flushServiceCache();

        $menuIds = Menu::where('position', MenuPosition::FEATURED->value)->pluck('id');
        $locales = Language::pluck('code')->toArray();

        foreach ($menuIds as $menuId) {
            foreach ($locales as $locale) {
                cache()->forget("featured_products_menu_{$menuId}_$locale");
            }
        }
    }

    protected function indexToElasticsearch(): void
    {
        try {
            $elasticsearchService = app(ElasticsearchService::class);
            $this->record->load(['brand', 'categories', 'tags']);
            $elasticsearchService->indexProduct($this->record);
        } catch (Exception $e) {
            Log::error('Elasticsearch indexing failed: ' . $e->getMessage());
        }
    }

    protected function removeFromElasticsearch(): void
    {
        try {
            $elasticsearchService = app(ElasticsearchService::class);
            $elasticsearchService->deleteProduct($this->record->id);
        } catch (Exception $e) {
            Log::error('Elasticsearch deletion failed: ' . $e->getMessage());
        }
    }
}
