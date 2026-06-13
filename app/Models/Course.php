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

    // ✅ هاد accessor هو اللي كان ناقص
    public function getImageAttribute(): ?string
    {
        return $this->prod_images->first()?->path;
    }

    // 🔗 Images
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