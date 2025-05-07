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
        Schema::create('checkouts', function (Blueprint $table) {
            
            $table->id(); // Primary Key
            $table->unsignedBigInteger('user_id'); // Foreign Key
            $table->string('name');
            $table->string('email');
            $table->string('phonenumber');
            $table->string('alternate_phone')->nullable(); // Optional field
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};
