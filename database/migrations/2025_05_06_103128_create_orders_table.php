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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number');
            $table->string('alternate_phone')->nullable();
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_method',['cod'])->default('cod');
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');
            $table->enum('order_status', ['processing', 'shipped', 'delivered', 'cancelled'])->default('processing');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
