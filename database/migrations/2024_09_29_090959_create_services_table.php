<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('service_name')->unique(); 
            $table->text('description')->nullable(); 
            $table->decimal('price', 8, 2); 
            $table->timestamps(); 
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('services'); 
    }
}
