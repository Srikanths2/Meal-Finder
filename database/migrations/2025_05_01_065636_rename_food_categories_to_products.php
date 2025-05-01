<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('food_categories', 'products');
    }

    public function down(): void
    {
        Schema::rename('products', 'food_categories');
    }
};
