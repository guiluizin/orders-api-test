<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProduct extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'order_id',
        'unit_quantity',
        'package_quantity',
        'unit_price',
        'total_price',
    ];

    protected $casts = [
        'unit_quantity' => 'integer',
        'package_quantity' => 'integer',
        'unit_price' => 'float',
        'total_price' => 'float'
    ];

    public function order(): BelongsTo {

        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo {

        return $this->belongsTo(Product::class);
    }

    protected function unitPrice(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => $value / 100,
            set: fn (float $value) => (int) round($value * 100, 2)
        );
    }

    protected function totalPrice(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => $value / 100,
            set: fn (float $value) => (int) round($value * 100, 2)
        );
    }
}
