<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amount = 100;

        for ($i = 0; $i < $amount; $i++) {
            Order::factory()->has(
                OrderItem::factory()
                    ->count(fake()->numberBetween(1, 9)),
                'items'
            )->create();
        }
        // ->for(
        //     $products->shuffle()->take(fake()->randomDigit())
        // )
    }
}
