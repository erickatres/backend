<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Extend Authenticatable for authentication
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens; // Import HasApiTokens for API token management
use Illuminate\Support\Facades\Hash;

class Clients extends Authenticatable // Use singular name and Authenticatable for authentication
{
    use HasFactory, HasApiTokens; // Include HasApiTokens trait

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
        $this->password = Hash::make($newPassword); // Hash the new password
        $this->save(); // Save changes to the database
    }

    // Optionally, you can define additional relationships or methods here

    // Example: If Clients can have many appointments
    public function appointments()
    {
        return $this->hasMany(Appointments::class); // Adjust Appointment to the appropriate model
    }

    // Example: To set the password automatically on creation or update
    public static function boot()
    {
        parent::boot();

        static::creating(function ($client) {
            // Automatically hash the password before creating the client
            $client->password = bcrypt($client->password);
        });

        static::updating(function ($client) {
            // Automatically hash the password before updating the client, if it has changed
            if ($client->isDirty('password')) {
                $client->password = bcrypt($client->password);
            }
        });
    }
}