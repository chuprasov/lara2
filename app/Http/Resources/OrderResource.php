<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'state' => $this->state,
            'user_id' => $this->user_id,
            'payment_method_id' => $this->payment_method_id,
            'amount' => $this->amount,
            'orderItems' => OrderItemResource::collection($this->orderItems),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

    }
}
