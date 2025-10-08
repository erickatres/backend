<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('employee_id')->unique(); // Employee ID (unique)
            $table->string('email')->unique();       // Email (unique)
            $table->string('password');              // Hashed password
            $table->rememberToken();                 // For authentication (optional, good for Sanctum)
            $table->timestamps();                    // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
