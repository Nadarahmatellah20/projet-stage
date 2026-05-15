<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'order_id',
        'title',
        'group',
        'is_done',
        'is_paid',
        'cost',
    ];

    // ✅ Casting
    protected $casts = [
        'is_done' => 'boolean',
        'is_paid' => 'boolean',
        'cost'    => 'float',
    ];

    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}