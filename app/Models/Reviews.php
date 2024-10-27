<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;

    // Define the table name (optional if the table name follows Laravel's naming convention)
    protected $table = 'reviews';

    // Allow mass assignment for these attributes
    protected $fillable = [
        'rating',
        'comments',
        'is_editable',
    ];

    /**
     * Define validation rules for creating or updating a review
     *
     * @return array
     */
    public static function validationRules()
    {
        return [
            'rating' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string|max:255', // Added a max length for comments
            'is_editable' => 'boolean',
        ];
    }

    /**
     * Accessor to get formatted rating as "X / 5"
     *
     * @return string
     */
    public function getFormattedRatingAttribute()
    {
        return $this->rating . ' / 5';
    }

    /**
     * Additional relationships can be added here.
     */
    
    // Example: If you plan to add a relationship with User
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
