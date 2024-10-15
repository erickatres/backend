<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();                       // Primary key (auto-incrementing ID)
            $table->string('fullname');         // Full name of the client
            $table->string('username')->unique(); // Unique username
            $table->string('email')->unique();  // Unique email address
            $table->string('password');         // Hashed password
            $table->timestamps();               // Laravel's default timestamps: created_at and updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');      // Drop the clients table if it exists
    }
};
