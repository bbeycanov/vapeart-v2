<?php

namespace App\Filament\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

/**
 * Trait to preserve non-translatable fields (relationships, media, etc.)
 * when switching locales in Filament forms.
 *
 * Use this trait in CreateRecord pages that use LaraZeus Translatable.
 */
trait PreservesNonTranslatableData
{
    /**
     * Store non-translatable data separately to preserve during locale switches
     */
    public array $nonTranslatableData = [];

    /**
     * Override this method in your page to specify which fields should be preserved.
     * Include all relationship fields, media uploads, and other non-translatable fields.
     */
    protected function getNonTranslatableFields(): array
    {
        return [];
    }

    public function updatingActiveLocale(): void
    {
        $this->oldActiveLocale = $this->activeLocale;

        // Store non-translatable data before locale switch using raw Livewire data
        $rawData = $this->data;
        $fieldsToPreserve = $this->getNonTranslatableFields();

        foreach ($fieldsToPreserve as $field) {
            if (isset($rawData[$field])) {
                $this->nonTranslatableData[$field] = $rawData[$field];
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
                $this->data,
                $translatableAttributes
            );

            // Get translatable data for new locale (empty if not set yet)
            $newLocaleTranslatableData = $this->otherLocaleData[$this->activeLocale] ?? [];

            // Initialize empty translatable fields for new locale if not set
            $emptyTranslatableData = [];
            foreach ($translatableAttributes as $attr) {
                // Use empty string instead of null for CKEditor compatibility
                $emptyTranslatableData[$attr] = $newLocaleTranslatableData[$attr] ?? '';
            }

            // Merge: non-translatable data + translatable data (empty or existing)
            $mergedData = array_merge($this->nonTranslatableData, $emptyTranslatableData);

            // Use form->fill() to properly update form state and trigger validation
            $this->form->fill($mergedData);

            // Also update Livewire data directly to ensure multi-select fields are preserved
            foreach ($this->nonTranslatableData as $key => $value) {
                $this->data[$key] = $value;
            }

            unset($this->otherLocaleData[$this->activeLocale]);
        } catch (ValidationException $e) {
            $this->activeLocale = $this->oldActiveLocale;
            throw $e;
        }
    }
}
