<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Domain\Order\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Order
 */
class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'state' => $this->state->value(),
            'user_id' => $this->user_id,
            'payment_method_id' => $this->payment_method_id,
            'amount' => $this->amount,
            'items' => OrderItemResource::collection($this->orderItems),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
