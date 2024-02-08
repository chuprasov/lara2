<?php

namespace Domain\Order\Processes;

use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\Exceptions\OrderProcessException;
use Domain\Order\Models\Order;

class CheckProductQuantities implements OrderProcessContract
{
    public function handle(Order $order, $next)
    {
        foreach (cart()->items() as $item) {
            if ($item->product->quantity > 1000) {
                throw new OrderProcessException('Недостаточно товара на складе');
            }
        }

        return $next($order);
    }
}
