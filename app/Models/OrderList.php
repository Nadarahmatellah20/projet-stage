<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;

class OrderList extends Model
{
use HasFactory;
use Compoships;

protected $table = 'order_list';

protected $fillable = [
'order_id',
'prod_id',
'prod_category',
'volume',
'user_id'
];

public function Order(){
return $this->belongsTo(Order::class,'order_id');
}




 
public function Product($category)
{
    switch($category){
        case 'course':
            return \App\Models\Course::where('id', $this->prod_id);
        case 'hardware':
            return \App\Models\Hardware::where('id', $this->prod_id);
        case 'software':
            return \App\Models\Software::where('id', $this->prod_id);
        case 'service':
            return \App\Models\Service::where('id', $this->prod_id);
    }
 }
  }