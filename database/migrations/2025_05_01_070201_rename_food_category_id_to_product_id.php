<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // Drop old foreign key if it exists
            $table->dropForeign(['food_category_id']);
            
            // Rename the column
            $table->renameColumn('food_category_id', 'product_id');

            // Re-add foreign key
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->renameColumn('product_id', 'food_category_id');
            $table->foreign('food_category_id')->references('id')->on('food_categories')->onDelete('cascade');
        });
    }
};
