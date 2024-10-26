<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('phone');
            $table->string('email');
            $table->string('address')->nullable();
            $table->string('furbabys_name');
            $table->string('pet_type');
            $table->date('appointment_date');
            $table->string('appointment_time');
            $table->string('service_type');
            $table->string('choosen_service');
            $table->string('additional_details')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
