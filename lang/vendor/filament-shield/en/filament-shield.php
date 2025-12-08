<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Table Columns
    |--------------------------------------------------------------------------
    */

    'column' => [
        'name' => 'Name',
        'guard_name' => 'Guard Name',
        'roles' => 'Roles',
        'permissions' => 'Permissions',
        'team' => 'Team',
        'updated_at' => 'Updated At',
    ],

    /*
    |--------------------------------------------------------------------------
    | Form Fields
    |--------------------------------------------------------------------------
    */

    'field' => [
        'name' => 'Name',
        'guard_name' => 'Guard Name',
        'permissions' => 'Permissions',
        'team' => 'Team',
        'team.placeholder' => 'Select a Team',
        'select_all' => [
            'name' => 'Select All',
            'message' => 'Enable all Permissions currently <span class="text-primary font-medium">Enabled</span> for this <span class="text-primary font-medium">Guard</span>',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Navigation & Resource
    |--------------------------------------------------------------------------
    */

    'nav' => [
        'group' => 'User Management',
        'role' => [
            'label' => 'Roles',
            'icon' => 'heroicon-o-shield-check',
        ],
        'permission' => [
            'label' => 'Permissions',
            'icon' => 'heroicon-o-lock-closed',
        ],
    ],

    'resource' => [
        'label' => [
            'role' => 'Role',
            'roles' => 'Roles',
            'permission' => 'Permission',
            'permissions' => 'Permissions',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Section & Tabs
    |--------------------------------------------------------------------------
    */

    'section' => 'Entities',
    'sections' => [
        'roles_tab' => 'Role Permissions',
        'permission_tab' => 'Permission Management',
    ],

    /*
    |--------------------------------------------------------------------------
    | Messages
    |--------------------------------------------------------------------------
    */

    'message' => [
        'resource_permission_created' => 'Permissions created for resource',
        'setting_permissions_created' => 'Permissions created for settings',
    ],

    /*
    |--------------------------------------------------------------------------
    | Permission Prefixes
    |--------------------------------------------------------------------------
    */

    'prefix' => [
        'view' => 'View',
        'view_any' => 'View Any',
        'create' => 'Create',
        'update' => 'Update',
        'delete' => 'Delete',
        'delete_any' => 'Delete Any',
        'force_delete' => 'Force Delete',
        'force_delete_any' => 'Force Delete Any',
        'restore' => 'Restore',
        'restore_any' => 'Restore Any',
        'replicate' => 'Replicate',
        'reorder' => 'Reorder',
    ],

    /*
    |--------------------------------------------------------------------------
    | Permission Actions
    |--------------------------------------------------------------------------
    */

    'action' => [
        'view' => 'View',
        'view_any' => 'View Any',
        'create' => 'Create',
        'update' => 'Update',
        'delete' => 'Delete',
        'delete_any' => 'Delete Any',
        'force_delete' => 'Force Delete',
        'force_delete_any' => 'Force Delete Any',
        'restore' => 'Restore',
        'restore_any' => 'Restore Any',
        'replicate' => 'Replicate',
        'reorder' => 'Reorder',
    ],

    /*
    |--------------------------------------------------------------------------
    | Extra Permission Actions
    |--------------------------------------------------------------------------
    */

    'extra_permissions' => [
        'page' => 'Page',
        'widget' => 'Widget',
    ],
];
