<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);

        // Get user
        $user = User::first();
        // Add super admin role
        $role = Role::where('name', 'super-admin')->first();

        $user->roles()->sync($role->id);
    }
}
