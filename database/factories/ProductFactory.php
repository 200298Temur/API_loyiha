<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categoryIds = Category::pluck('id')->toArray();
        $fakerRu = FakerFactory::create('ru_RU');

        return [
            'category_id' => $this->faker->randomElement($categoryIds),
            'name' => [
                'uz' => $this->faker->sentence(3), // Assuming uzbek can be handled by the default faker
                'ru' =>"Это предложение состоит из трех слов.",
            ],
            'price' => rand(50000, 10000000),
            'description' => [
                'uz' => $this->faker->paragraph(5), // Assuming uzbek can be handled by the default faker
                'ru' => "Этот абзац состоит из пяти предложений. Этот абзац состоит из пяти предложений. Этот абзац состоит из пяти предложений. Этот абзац состоит из пяти предложений. Этот абзац состоит из пяти предложений.",
            ],
        ];
       
    }
}
