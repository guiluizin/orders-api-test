<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'status',
        'carrier',
        'tracking',
        'created_at',
        'updated_at'
    ];
}
