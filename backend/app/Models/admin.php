<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens; // <- ADD THIS

class Admin extends Authenticatable
{
    use HasFactory, HasApiTokens; // <- ADD HasApiTokens

    protected $table = 'admins';

    protected $fillable = [
        'employee_id',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
