<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Awobaz\Compoships\Compoships;

class Software extends Product
{
    use HasFactory, Compoships;

    protected $table = 'softwares';

    protected $fillable = [
        'name',
        'header',
        'desc',
        'payment',
        'price',
        'category'
    ];

    public function prod_images()
    {
        return $this->hasMany(ProdImage::class,'prod_id','id')
                    ->where('prod_category','software'); // ✅ موحد
    }
}