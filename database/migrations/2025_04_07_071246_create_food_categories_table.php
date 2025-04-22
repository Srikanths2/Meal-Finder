<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('food_categories', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            // $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Foreign key to categories
            $table->integer('category_id'); // Category name (could be an enum or simple string)
            $table->string('name'); // Name of the food item or category
            $table->string('image')->nullable(); // Image URL or path
            $table->text('description')->nullable(); // Description of the food item (nullable)
            $table->decimal('amount', 8, 2); // Amount (e.g., price, quantity, etc.)
            $table->boolean('active')->default(true); // Active flag (true or false)
            $table->timestamps(); // Created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food_categories');
    }
};
