<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'total' => fake()->randomFloat(2, 50, 250),
            'user_id' => User::inRandomOrder()->first(),
            'shipping_address' => fake()->address(),
            'status' => fake()->randomElement(['PENDING', 'PREPARING', 'DELIVERING', "DELIVERED", "COMPLETED", "CANCELLED"])
        ];
    }
}
