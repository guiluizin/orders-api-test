<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Refund extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'note',
        'total_amount',
        'processed_at',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'processed_at' => 'timestamp'
    ];

    protected function totalAmount(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => $value / 100,
            set: fn (float $value) => (int) round($value * 100, 2)
        );
    }

    public function order(): BelongsTo {

        return $this->belongsTo(Order::class);
    }
}
