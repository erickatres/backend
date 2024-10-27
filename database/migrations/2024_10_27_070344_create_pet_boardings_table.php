<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetBoardingsTable extends Migration
{
    public function up()
    {
        Schema::create('pet_boardings', function (Blueprint $table) {
            $table->id();
            // Client information
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('phone', 25);
            $table->string('email', 255);
            $table->string('address', 255)->nullable();
            
            // Pet information
            $table->string('furbabys_name', 255);
            $table->string('pet_type', 50);
            $table->string('pet_check_in', 255); // Ensure this field is defined as needed
            $table->date('check_in_date');
            $table->string('check_in_time', 10);
            $table->integer('days'); // Duration of stay
            $table->integer('hours')->nullable(); // Additional hours if applicable
            $table->string('additional_details', 500)->nullable();

            // Timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pet_boardings');
    }
}
