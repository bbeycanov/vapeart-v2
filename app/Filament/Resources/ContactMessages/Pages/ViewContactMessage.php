<?php

namespace App\Filament\Resources\ContactMessages\Pages;

use App\Filament\Resources\ContactMessages\ContactMessageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Mark as read when viewing
        if (!$data['is_read']) {
            $this->record->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
            $data['is_read'] = true;
            $data['read_at'] = now()->toDateTimeString();
        }

        return $data;
    }
}
