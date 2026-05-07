<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Product
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'name',
        'category',
        'header',
        'desc',
        'period',
        'prof',
        'price'
    ];

    public function prod_images()
    {
        return $this->hasMany(ProdImage::class, 'prod_id')
                    ->where('prod_category', 'course');
    }

    // 🔗 Orders
    public function orderItems()
    {
        return $this->hasMany(OrderList::class, 'prod_id')
                    ->where('prod_category', 'course');
    }

    // 🔗 Reviews
    public function reviews()
    {
        return $this->hasMany(Review::class, 'prod_id')
                    ->where('prod_category', 'course');
    }
}