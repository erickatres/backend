<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Extend Authenticatable for authentication
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clients extends Authenticatable // Use singular name and Authenticatable for authentication
{
    use HasFactory;

    // Define the fields that are mass assignable
    protected $fillable = [
        'fullname',    // Added fullname field
        'username',    // Unique username
        'email',       // Added email field
        'password',    // Hashed password
    ];

    // Hide sensitive fields when returning the model
    protected $hidden = [
        'password',        // Hide password
        'remember_token',  // Hide remember token
    ];

    // Method to reset password
    public function resetPassword($newPassword)
    {
        $this->password = bcrypt($newPassword); // Hash the new password
        $this->save(); // Save changes to the database
    }
}
