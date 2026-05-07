<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'fname',
        'lname',
        'company',
        'country',
        'city',
        'zip',
        'adress',
        'phone',
        'email',
        'password',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Orders(){
        return $this->hasMany(Order::class, 'client_id', 'id');
    }

    public function Reviews(){
        return $this->hasMany(Review::class, 'client_id', 'id');
    }

    public function Tickets(){
        return $this->hasMany(Ticket::class, 'user_id', 'id');
    }
}