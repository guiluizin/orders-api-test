<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Order extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'number',
        'total_paid',
        'payment_status',
        'fulfillment_status',
        'payment_brand',
        'address_street',
        'address_zip',
        'address_province',
        'address_country',
        'processed_at',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'number' => 'integer',
        'processed_at' => 'timestamp'
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

    public function refund(): HasOne {

        return $this->hasOne(Refund::class);
    }

    protected function totalPaid(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => $value / 100,
            set: fn (float $value) => (int) round($value * 100, 2)
        );
    }
}
