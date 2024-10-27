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
            $table->string('first_name', 255); // First name of the client
            $table->string('last_name', 255);  // Last name of the client
            $table->string('phone', 25);        // Phone number (increased length for international)
            $table->string('email', 255);       // Email address
            $table->string('address', 255)->nullable(); // Address can be null

            // Pet information
            $table->string('furbabys_name', 255); // Pet's name
            $table->string('pet_type', 50);        // Type of pet (e.g., "dog", "cat")

            // Appointment details
            $table->date('appointment_date');       // Date of the appointment
            $table->string('appointment_time', 10); // Time of the appointment (format: "09:00 AM")
            $table->string('service_type', 100);    // Type of service requested
            $table->string('chosen_service', 100);   // Chosen specific service
            $table->string('additional_details', 500)->nullable(); // Optional field for extra details

            // Timestamps
            $table->timestamps(); // Includes created_at and updated_at

            // Indexing commonly searched fields
            $table->index(['appointment_date']); // Index on appointment_date for faster querying
            $table->index(['first_name', 'last_name']); // Combined index on first and last name for frequent lookups
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
