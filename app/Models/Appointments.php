<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'appointments'; // Ensure this matches your actual table name

    // Allow mass assignment for these fields
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
        'chosen_service',
        'additional_details',
    ];

    // Casting appointment_date to a datetime instance
    protected $casts = [
        'appointment_date' => 'datetime', // Change to 'date' if you only want the date
    ];

    // If you are not using timestamps in your table, set to false
    public $timestamps = true;  // Set to false if 'created_at' and 'updated_at' are not used

    /**
     * Scope a query to only include appointments for a specific pet type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $petType
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForPetType($query, string $petType)
    {
        return $query->where('pet_type', $petType);
    }

    /**
     * Scope a query to only include appointments on a specific date.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForAppointmentDate($query, string $date)
    {
        return $query->whereDate('appointment_date', $date);
    }
}
