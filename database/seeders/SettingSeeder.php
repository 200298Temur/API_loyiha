<?php

namespace Database\Seeders;

use App\Enums\SettingType;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting=Setting::create([
            'name'=>[
                'uz'=>'Til',
                'ru'=>'ru til'
            ],
            'type'=>SettingType::SELECT->value,
        ]);

        $setting->values()->create([
             'name'=>[
                'uz'=>'O\'zbekcha',
                'ru'=>'O\'zbekcha',
             ]
        ]);
        $setting->values()->create([
            'name'=>[
               'uz'=>'Ruscha',
               'ru'=>'Ruscha',
            ]
       ]);
        // --------------
       
        $setting=Setting::create([
        'name'=>[
            'uz'=>'Pul birligi',
            'ru'=>'rus Pul birligi'
        ],
            'type'=>SettingType::SELECT->value,
        ]);

        $setting->values()->create([
            'name'=>[
                'uz'=>'So\'m',
                'ru'=>'Sum',
            ]
        ]);
        $setting->values()->create([
            'name'=>[
            'uz'=>'Dollar',
            'ru'=>'rus Dollar',
            ]
       ]); 

    //    -------------

        $setting=Setting::create([
        'name'=>[
            'uz'=>'Dark Mode',
            'ru'=>'rus Dark Mode'
        ],
            'type'=>SettingType::SWITCH->value,
        ]);

        $setting=Setting::create([
        'name'=>[
            'uz'=>'Xabarnomalar',
            'ru'=>'rus Xabarnomalar'
        ],
            'type'=>SettingType::SELECT->value,
        ]);
    }
}
