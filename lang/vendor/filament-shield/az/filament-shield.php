<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Table Columns
    |--------------------------------------------------------------------------
    */

    'column' => [
        'name' => 'Ad',
        'guard_name' => 'Guard Adı',
        'roles' => 'Rollar',
        'permissions' => 'İcazələr',
        'team' => 'Komanda',
        'updated_at' => 'Yenilənmə tarixi',
    ],

    /*
    |--------------------------------------------------------------------------
    | Form Fields
    |--------------------------------------------------------------------------
    */

    'field' => [
        'name' => 'Ad',
        'guard_name' => 'Guard Adı',
        'permissions' => 'İcazələr',
        'team' => 'Komanda',
        'team.placeholder' => 'Komanda seçin',
        'select_all' => [
            'name' => 'Hamısını Seç',
            'message' => 'Bu <span class="text-primary font-medium">Guard</span> üçün hazırda aktiv olan bütün İcazələri aktivləşdirin',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Navigation & Resource
    |--------------------------------------------------------------------------
    */

    'nav' => [
        'group' => 'İstifadəçi İdarəetməsi',
        'role' => [
            'label' => 'Rollar',
            'icon' => 'heroicon-o-shield-check',
        ],
        'permission' => [
            'label' => 'İcazələr',
            'icon' => 'heroicon-o-lock-closed',
        ],
    ],

    'resource' => [
        'label' => [
            'role' => 'Rol',
            'roles' => 'Rollar',
            'permission' => 'İcazə',
            'permissions' => 'İcazələr',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Section & Tabs
    |--------------------------------------------------------------------------
    */

    'section' => 'Entitylər',
    'sections' => [
        'roles_tab' => 'Rol İcazələri',
        'permission_tab' => 'İcazə İdarəetməsi',
    ],

    /*
    |--------------------------------------------------------------------------
    | Messages
    |--------------------------------------------------------------------------
    */

    'message' => [
        'resource_permission_created' => 'Resurs üçün icazələr yaradıldı',
        'setting_permissions_created' => 'Ayarlar üçün icazələr yaradıldı',
    ],

    /*
    |--------------------------------------------------------------------------
    | Permission Prefixes
    |--------------------------------------------------------------------------
    */

    'prefix' => [
        'view' => 'Bax',
        'view_any' => 'Hamısına Bax',
        'create' => 'Yarat',
        'update' => 'Yenilə',
        'delete' => 'Sil',
        'delete_any' => 'Hamısını Sil',
        'force_delete' => 'Zorla Sil',
        'force_delete_any' => 'Hamısını Zorla Sil',
        'restore' => 'Bərpa Et',
        'restore_any' => 'Hamısını Bərpa Et',
        'replicate' => 'Kopyala',
        'reorder' => 'Yenidən Sırala',
    ],

    /*
    |--------------------------------------------------------------------------
    | Permission Actions
    |--------------------------------------------------------------------------
    */

    'action' => [
        'view' => 'Bax',
        'view_any' => 'Hamısına Bax',
        'create' => 'Yarat',
        'update' => 'Yenilə',
        'delete' => 'Sil',
        'delete_any' => 'Hamısını Sil',
        'force_delete' => 'Zorla Sil',
        'force_delete_any' => 'Hamısını Zorla Sil',
        'restore' => 'Bərpa Et',
        'restore_any' => 'Hamısını Bərpa Et',
        'replicate' => 'Kopyala',
        'reorder' => 'Yenidən Sırala',
    ],

    /*
    |--------------------------------------------------------------------------
    | Extra Permission Actions
    |--------------------------------------------------------------------------
    */

    'extra_permissions' => [
        'page' => 'Səhifə',
        'widget' => 'Vidjet',
    ],
];
