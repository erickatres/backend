<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetBoarding extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'pet_boardings';

    // Allow mass assignment for these fields
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'furbabys_name',
        'pet_type',
        'pet_check_in',
        'check_in_date',
        'check_in_time',
        'days',
        'hours',
        'additional_details',
    ];

    // Casting fields
    protected $casts = [
        'check_in_date' => 'date',
        'check_in_time' => 'time',
    ];

    // Enable timestamps
    public $timestamps = true;

    /**
     * Scope a query to only include boarding for a specific pet type.
     */
    public function scopeForPetType($query, string $petType)
    {
        return $query->where('pet_type', $petType);
    }

    /**
     * Scope a query to only include boarding appointments on a specific check-in date.
     */
    public function scopeForCheckInDate($query, string $date)
    {
        return $query->whereDate('check_in_date', $date);
    }
}
