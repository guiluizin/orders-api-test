<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'sku',
    ];

    public function orderProducts(): HasMany {

        return $this->hasMany(OrderProduct::class);
    }
}
