<?php

namespace Database\Seeders;

use App\Models\Role;
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
        // Create an admin user
        $admin = User::create([
            "first_name" => "Admin",
            "last_name" => "Admin",
            "email" => "admin@com.uz",
            "phone" => '+998976454560',
            "password" => Hash::make("password"),
        ]);

        // Attach the admin role to the admin user
        $admin->roles()->syncWithoutDetaching([1]); // Assuming role ID 1 is for admin

        // Create 10 regular users and attach a regular role to each
        User::factory(10)->create()->each(function ($user) {
            $user->roles()->attach(2); // Assuming role ID 2 is for regular users
        });
    }
}
