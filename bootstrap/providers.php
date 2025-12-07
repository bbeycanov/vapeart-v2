<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
    App\Providers\SettingsServiceProvider::class,
    App\Providers\RepositoryServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    App\Providers\ServiceLayerServiceProvider::class,
    Spatie\EloquentSortable\EloquentSortableServiceProvider::class,
];
