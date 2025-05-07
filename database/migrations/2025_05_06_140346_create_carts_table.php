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

            // Accept both registered and guest user IDs (string)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // Reference to product/food item
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

            // Optional: quantity
            $table->integer('quantity')->default(1);

            $table->timestamps();

            // Prevent duplicate product for the same user
            $table->unique(['user_id', 'product_id']);
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