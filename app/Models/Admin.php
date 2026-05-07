<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins';

    protected $fillable = [
        'fname', 'lname', 'role', 'email', 'authname', 'password',
        'company', 'country', 'city', 'zip', 'adress', 'phone',
    ];

    protected $hidden = ['password'];

    // FIX: cast dates → Carbon objects حتى format() تخدم
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
