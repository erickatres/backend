<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Admins extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Define the fields that are mass assignable
    protected $fillable = [
        'fullname',   // Added fullname field
        'username',   // Unique username
        'email',      // Added email field
        'password',   // Hashed password
    ];

    // Hide sensitive fields when returning the model
    protected $hidden = [
        'password',         // Hide password
        'remember_token',   // Hide remember token
    ];

    // Define any additional methods or relationships as needed
    public function getAuthPassword()
    {
        return $this->password; // For authentication
    }
}
