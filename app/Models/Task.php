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

    // ✅ FIX: belongsTo هي الصحيحة (task تنتمي لـ order)
    // hasOne كانت خاطئة لأن Task هي الطرف اللي عندو order_id
    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}