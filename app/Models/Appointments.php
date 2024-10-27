<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'appointments';

    // Allow mass assignment for these fields
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'furbabys_name',
        'pet_type',
        'appointment_date',
        'appointment_time',
        'service_type',
        'chosen_service',
        'additional_details',
    ];

    // Casting fields
    protected $casts = [
        'appointment_date' => 'datetime', 
    ];

    // Enable timestamps
    public $timestamps = true;

    /**
     * Scope a query to only include appointments for a specific pet type.
     */
    public function scopeForPetType($query, string $petType)
    {
        return $query->where('pet_type', $petType);
    }

    /**
     * Scope a query to only include appointments on a specific date.
     */
    public function scopeForAppointmentDate($query, string $date)
    {
        return $query->whereDate('appointment_date', $date);
    }
}
