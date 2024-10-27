<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations to create the reviews table.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedTinyInteger('rating')->comment('1-5 rating'); // Rating must be between 1 and 5
            $table->text('comments')->nullable(); // Comments can be null
            $table->boolean('is_editable')->default(true); // Default is editable
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews'); // Drop the reviews table if it exists
    }
}
