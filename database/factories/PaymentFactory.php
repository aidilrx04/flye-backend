<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->numberBetween(20, 200),
            'method' => 'toyyibpay',
            'url' => fake()->url(),
            'status' => fake()->randomElement(['PENDING', 'SUCCESS', 'FAILED']),
            'valid_until' => fake()->dateTimeBetween('now', '+2 hours')
        ];
    }
}
