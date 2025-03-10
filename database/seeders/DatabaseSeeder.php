<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'full_name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '123123',
            'role' => "USER"
        ]);

        User::factory()->create([
            'full_name' => 'Bob',
            'email' => 'bob@mail.com',
            'password' => '123',
            'role' => 'ADMIN'
        ]);

        Auth::attempt(['email' => 'bob@mail.com', 'password' => '123']);

        User::factory(100)->create();


        $this->call([
            ProductSeeder::class,
            OrderSeeder::class,
            CartItemSeeder::class,
            PaymentSeeder::class,
            RatingSeeder::class
        ]);

        Auth::logout();
    }
}
