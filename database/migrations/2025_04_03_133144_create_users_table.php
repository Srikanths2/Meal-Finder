<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID field
            $table->string('firstname'); // First name
            $table->string('lastname'); // Last name
            $table->string('phonenumber'); // Phone number (nullable if not required)
            $table->string('email')->unique(); // Email, with a unique constraint
            $table->string('password'); // Password field
            $table->date('date_of_birth'); // Date of birth
            $table->enum('gender', ['male', 'female', 'other']); // Gender field
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->text('address'); // Address (nullable if not required)
            $table->timestamps(); // Created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
