<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Beycan',
                'surname' => 'Beycanov',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }

        $adminUser = User::where('email', 'admin@example.com')->first();

        if ($adminUser && !$adminUser->hasRole('super_admin')) {
            $adminUser->assignRole('super_admin');
        }
    }
}
