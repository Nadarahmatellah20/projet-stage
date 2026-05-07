<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hardware extends Product
{
    use HasFactory;

    protected $table = 'hardwares';

    // CORRECTION: kolchi les champs li ka-ytbedlo
    protected $fillable = [
        'prod_category',
        'name',
        'header',
        'desc',
        'datasheet',
        'category',
        'price',
        'image',
    ];

    public function prod_images(){
        return $this->hasMany(ProdImage::class,'prod_id','id')
                    ->where('prod_category','hardware');
    }

    public function OrderItem(){
        return $this->hasMany(OrderList::class,'prod_id','id')
                    ->where('prod_category','hardware');
    }
}