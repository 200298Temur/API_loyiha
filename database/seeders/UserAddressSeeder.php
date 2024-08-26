<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::find(2)->addresses()->create([
            "latitude"=>"40.133328",
            "longitude"=>"67.822777",
            "region"=>"Джизак",
            "district"=>"Шарафа Рашидова",
            "street"=>"63 Джизак",
            "home"=>"11"
        ]);

        User::find(2)->addresses()->create([
            "latitude"=>"40.133328",
            "longitude"=>"67.822777",
            "region"=>"Джизак",
            "district"=>"Шарафа Рашидова",
            "street"=>"65 Джизак",
            "home"=>"13"
        ]);

    }
}
