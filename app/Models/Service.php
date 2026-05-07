<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Product
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'prod_category',
        'name',
        'header',
        'desc',
        'page',
        'price'
    ];

public function prod_images()
{
    return $this->hasMany(\App\Models\ProdImage::class, 'prod_id')
                ->where('prod_category', 'service');
}
}