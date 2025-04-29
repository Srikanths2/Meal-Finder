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
        Schema::create('carts', function (Blueprint $table) {

            $table->id();
            // Foreign Key: user who added the item
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Foreign Key: food item added to cart
            $table->foreignId('food_category_id')->constrained('food_categories')->onDelete('cascade');
            
            // Optional: Add a quantity column if needed
            $table->integer('quantity')->default(1);

            $table->timestamps();
            
            // Prevent same food item duplicate in same user's cart
            $table->unique(['user_id', 'food_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
