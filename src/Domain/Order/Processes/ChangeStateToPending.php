<?php

namespace Domain\Order\Processes;

use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\Models\Order;
use Domain\Order\States\PendigOrderState;

class ChangeStateToPending implements OrderProcessContract
{
    public function handle(Order $order, $next)
    {
        $order->state->transitionTo(new PendigOrderState($order));

        return $next($order);
    }
}