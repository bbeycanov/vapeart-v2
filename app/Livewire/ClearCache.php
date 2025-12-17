<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;

class ClearCache extends Component
{
    public function clear()
    {
        Artisan::call('cache:clear');

        Notification::make()
            ->title('Cache ugurla silindi')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.clear-cache');
    }
}
