<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminAppointments extends Model
{
    use HasFactory;

    protected $table = 'admin_notifications'; // Ensure this matches your actual table name

    protected $fillable = [
        'type', // To differentiate between appointment and pet boarding
        'reference_id', // ID of the appointment or pet boarding
        'message', // Notification message
        'is_read', // Indicates if the notification has been read
        'created_at', // Timestamp of when the notification was created
    ];

    public $timestamps = true;

    /**
     * Define a polymorphic relationship.
     */
    public function notifiable()
    {
        return $this->morphTo();
    }
}
