<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    // Define which attributes can be mass assigned
    protected $fillable = [
        'client_name',
        'phone',
        'email',
        'address',
        'furbabys_name',
        'pet_type',
        'appointment_date',
        'appointment_time',
        'service_type',
        'choosen_service',
        'additional_details'
    ];

    protected $casts = [
        'appointment_date' => 'datetime', // Automatically cast to Carbon instance
    ];

    // Example scope for retrieving appointments by pet type
    public function scopeForPetType($query, $petType)
    {
        return $query->where('pet_type', $petType);
    }
}
