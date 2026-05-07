<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = [
        'user_id',
        'title',
        'type',
        'status',
        'isArchived',
        'closed_at',
    ];

    // ✅ FIX: كانت تستعمل client_id لكن في DB و Controller كاين user_id
    public function Client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Messages()
    {
        return $this->hasMany(Message::class, 'ticket_id', 'id');
    }
}