<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;

class ProdImage extends Model
{
    use HasFactory, Compoships;

    protected $table = 'prod_images';

    protected $fillable = [
        'prod_id',
        'prod_category',
        'path'
    ];

}