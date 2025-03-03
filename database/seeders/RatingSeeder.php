<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Rating;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amount = 500;

        Rating::factory($amount)->create();

        $products = Product::all();

        foreach ($products as $product) {
            $rate_total = $product->ratings()->sum('rate');
            $rate_count = $product->ratings()->count();

            $product->rating()->create([
                'total_star' => $rate_total,
                'total_rating' => $rate_count
            ]);
        }
    }
}
