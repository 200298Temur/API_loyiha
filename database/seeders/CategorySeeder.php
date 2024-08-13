<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            "name"=> [
                "uz"=> "Stol",
                "ru"=>"Стол"
            ],
        ]);
        
        $category=Category::create([
            "name"=> [
                "uz"=> "Kreslo",
                "ru"=>"ru Kreslo"
            ],
        ]);

        $category->childCategories()->create([
            "name"=> [
                "uz"=> "Office",
                "ru"=>"Office"
            ],
        ]);
        $Childcategory=$category->childCategories()->create([
            "name"=> [
                "uz"=> "Gaming",
                "ru"=>"Gaming"
            ],
        ]);
        $Childcategory->childCategories()->create([
            "name"=> [
                "uz"=>"Rgb",
                "ru"=>"ru Rgb"
            ],
        ]);
        $Childcategory->childCategories()->create([
            "name"=> [
                "uz"=>"Woemn",
                "ru"=>"ru Women"
            ],
        ]);
        $Childcategory->childCategories()->create([
            "name"=> [
                "uz"=>"Black",
                "ru"=>"ru Black"
            ],
        ]);



        $category->childCategories()->create([
            "name"=> [
                "uz"=>"Yumshoq",
                "ru"=>"ru Yumshoq"
            ],
        ]); 

        Category::create([
            "name"=> [
                "uz"=> "Yotoq",
                "ru"=>"Кровать"
            ],
        ]);
        Category::create([
            "name"=> [
                "uz"=> "Stul",
                "ru"=>"Стул"
            ],
        ]);
    }
}
