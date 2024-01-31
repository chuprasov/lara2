<?php

namespace Domain\Order\Models;

use Support\Casts\PriceCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'with_address',
    ];

    protected $casts = [
        'price' => PriceCast::class,
    ];
}
