<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'super_admin',
                'guard_name' => 'web',
                'permissions' => 'all'
            ]
        ];

        foreach ($roles as $role) {
            $createdRole = Role::updateOrCreate(
                ['name' => $role['name']],
                ['guard_name' => $role['guard_name']]
            );

            if ($role['permissions'] === 'all') {
                $createdRole->givePermissionTo(Permission::all());
            }
        }
    }
}
