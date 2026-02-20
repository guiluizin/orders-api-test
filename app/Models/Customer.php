<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'created_at',
        'updated_at'
    ];

    public function orders(): HasMany {

        return $this->hasMany(Order::class);
    }

    protected function phone(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => preg_replace('/^1?(\d{3})(\d{3})(\d{4})$/', '+1 ($1) $2-$3', $value),
            set: fn (string $value) => preg_replace('/\+/', '', $value)
        );
    }
}
