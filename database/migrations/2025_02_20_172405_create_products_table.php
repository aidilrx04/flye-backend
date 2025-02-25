<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->double('price');
            $table->double('rating')->default(0);
            $table->json('image_urls');
            $table->text('description');
            $table->string('tagline')->nullable();
            $table->enum('category', ['MEN', 'WOMEN', 'KID', "ACCESSORY"]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
