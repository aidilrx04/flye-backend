<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'name' => fake()->words(3, true),
            'price' => fake()->randomFloat(2, 20, 50),
            'rating' => fake()->randomFloat(1, 0, 5),
            'image_urls' => collect([1, 1, 1])->map(fn() => "https://loremflickr.com/" . fake()->numberBetween(360, 1080) . "/" . fake()->numberBetween(360, 1080)),
            'description' => fake()->paragraph(),
            'tagline' => fake()->words(10, true)
        ];
    }
}
