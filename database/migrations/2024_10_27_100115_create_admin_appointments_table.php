<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('type'); // Type of notification (appointment or pet boarding)
            $table->unsignedBigInteger('reference_id'); // ID of the associated appointment or pet boarding
            $table->text('message'); // Notification message
            $table->boolean('is_read')->default(false); // To track if the notification has been read
            $table->timestamps(); // created_at and updated_at

            // Optional: add an index for quicker lookups
            $table->index(['type', 'reference_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_notifications');
    }
}
