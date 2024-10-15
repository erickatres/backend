<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliesTable extends Migration
{
    
    public function up()
    {
        Schema::create('supplies', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('supply_name')->unique(); 
            $table->text('description')->nullable(); 
            $table->integer('quantity'); 
            $table->decimal('price', 8, 2); 
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('supplies'); 
    }
}
