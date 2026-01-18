<?php

namespace App\Filament\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

/**
 * Trait to preserve non-translatable fields when switching locales in Filament forms.
 * This includes media/file upload fields which have special state management.
 */
trait PreservesNonTranslatableData
{
    public array $nonTranslatableData = [];
    public array $preservedUploads = [];

    /**
     * Override this method to specify which fields should be preserved.
     */
    protected function getNonTranslatableFields(): array
    {
        return [];
    }

    public function updatingActiveLocale(): void
    {
        $this->oldActiveLocale = $this->activeLocale;

        // Store ALL current form data before locale switch
        $this->nonTranslatableData = $this->data;

        // Store file upload state separately
        $this->preservedUploads = [];
        foreach (['thumbnail', 'images'] as $field) {
            if (isset($this->data[$field])) {
                $this->preservedUploads[$field] = $this->data[$field];
            }
        }
    }

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

            // Restore file uploads
            foreach ($this->preservedUploads as $field => $value) {
                $restoredData[$field] = $value;
            }

            // Update Livewire data directly
            $this->data = $restoredData;

            // Force component to recognize file uploads
            $this->dispatch('form-data-restored');

            unset($this->otherLocaleData[$this->activeLocale]);
        } catch (ValidationException $e) {
            $this->activeLocale = $this->oldActiveLocale;
            throw $e;
        }
    }
}
