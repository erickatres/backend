<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetBoarding extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'pet_boardings'; // Ensure this matches your actual table name

    // Allow mass assignment for these fields
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'furbabys_name',
        'pet_type',
        'pet_check_in', // Added pet_check_in here
        'check_in_date',
        'check_in_time',
        'days',
        'hours',
        'additional_details',
    ];

    // Casting check_in_date to a date instance and check_in_time to a time instance
    protected $casts = [
        'check_in_date' => 'date',
        'check_in_time' => 'time',
    ];

    // If you are not using timestamps in your table, set to false
    public $timestamps = true;  // Set to false if 'created_at' and 'updated_at' are not used

    /**
     * Scope a query to only include boarding for a specific pet type.
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
     * Scope a query to only include boarding appointments on a specific check-in date.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForCheckInDate($query, string $date)
    {
        return $query->whereDate('check_in_date', $date);
    }
}
