<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'number',
        'total_paid',
        'payment_status',
        'payment_brand',
        'fulfillment_status',
        'address_street',
        'address_zip',
        'address_province',
        'address_country',
        'processed_at',
    ];

    public function customer(): BelongsTo {

        return $this->belongsTo(Customer::class);
    }

    public function orderProducts(): HasMany {

        return $this->hasMany(OrderProduct::class);
    }

    public function shipping(): HasOne {

        return $this->hasOne(Shipping::class);
    }
}
