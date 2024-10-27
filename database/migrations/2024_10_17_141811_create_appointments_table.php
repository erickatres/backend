<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID

            // Client information
            $table->string('first_name', 255);
            $table->string('last_name', 255);  // Limit string length for client_name
            $table->string('phone', 25);  // Increase length to accommodate international numbers
            $table->string('email', 255);  // Standard email length
            $table->string('address', 255)->nullable();  // Address can be null

            // Pet information
            $table->string('furbabys_name', 255);  // Standard length for pet's name
            $table->string('pet_type', 50);  // Limit to reasonable length (e.g., "dog", "cat")

            // Appointment details
            $table->date('appointment_date');  // Date field for appointments
            $table->string('appointment_time', 10);  // Time field, 10 chars should suffice (e.g., "09:00 AM")
            $table->string('service_type', 100);  // Limited length for service type
            $table->string('chosen_service', 100);  // Limit the chosen service field
            $table->string('additional_details', 500)->nullable();  // Optional field for additional details

            // Timestamps
            $table->timestamps();  // Includes created_at and updated_at

            // Optional: Indexing commonly searched fields
            $table->index('appointment_date');  // Index on appointment_date for faster querying
            $table->index('client_name');  // Index on client_name for frequent lookups
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
