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
        $admin->assignRole('admin');

        $user1=User::create([
            "first_name" => "Samir",
            "last_name" => "Usmonov",
            "email" => "samir@com.uz",
            "phone" => '+998990999977',
            "password" => Hash::make("password"),
        ]);
        $user1->assignRole('customer');

        $user2=User::create([
            "first_name" => "Sara",
            "last_name" => "Gomez",
            "email" => "sara@gmail.com",
            "phone" => '+998991999977',
            "password" => Hash::make("password"),
        ]);
        $user2->assignRole('editor');
        
      
        $users=User::factory()->count(10)->create();
        foreach($users as $user)
        {
            $user->assignRole('customer');
        }
    }
}
