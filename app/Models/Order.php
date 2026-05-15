<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $table = 'orders';

    protected $fillable = [
        'title',
        'client_id',
        'description',
        'status',
        'order_status',
        'is_archived',
        'is_canceled',
    ];

    // ✅ Casting pour éviter les bugs de type
    protected $casts = [
        'is_archived' => 'boolean',
        'is_canceled' => 'boolean',
        'status'      => 'float',
    ];

    // ✅ Tasks
    public function Tasks(){
        return $this->hasMany(Task::class, 'order_id');
    }

    // ✅ Invoice
    public function Invoice(){
        return $this->hasOne(Invoice::class, 'order_id');
    }

    // ✅ Client
    public function Client(){
        return $this->belongsTo(User::class, 'client_id');
    }
    
    // ✅ OrderList
    public function OrderList(){
        return $this->hasMany(OrderList::class, 'order_id');
    }
}