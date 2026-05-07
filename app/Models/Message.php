<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    // ✅ FIX: كانت مفقودة، كيسبب MassAssignmentException عند create()
    protected $fillable = [
        'ticket_id',
        'sender_name',
        'body',
    ];

    // ✅ FIX: belongsTo هي الصحيحة (message تنتمي لـ ticket)
    public function Ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}