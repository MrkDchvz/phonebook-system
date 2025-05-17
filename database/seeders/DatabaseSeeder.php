<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => '1234',
        ]);
        $adminRole = Role::create(['name' => 'Admin']);
        $admin->assignRole($adminRole);

        $user = User::factory()->create([
            'name' => 'Miles Morales',
            'email' => 'milesmorales@example.com',
            'password' => '1234',
        ]);
        $userRole = Role::create(['name' => 'User']);
        $user->assignRole($userRole);
    }
}
