<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'client_id',
        'prod_id',
        'prod_category',
        'stars',
        'review',
        'is_approved'
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'prod_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'prod_id');
    }
}