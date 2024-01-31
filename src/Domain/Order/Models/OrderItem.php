<?php

namespace Domain\Order\Models;

use Support\Casts\PriceCast;
use Support\ValueObjects\Price;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'price',
        'quantity',
    ];

    protected $casts = [
        'price' => PriceCast::class,
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function amount(): Attribute
    {
        return Attribute::make(
            get: fn () => Price::make(
                $this->price->raw() * $this->quantity
            )
        );
    }

}
