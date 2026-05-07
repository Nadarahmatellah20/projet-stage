<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $fillable = [
        'order_id',
        'discount_percentage',
        'fees',
        'total_price',
        'payment_status',
        'payment_date',
    ];

    // ✅ FIX: belongsTo هي الصحيحة (invoice تنتمي لـ order)
    // hasOne كانت خاطئة لأن Invoice هي الطرف اللي عندو order_id
    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}