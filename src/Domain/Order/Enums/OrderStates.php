<?php

namespace Domain\Order\Enums;

use Domain\Order\Models\Order;
use Domain\Order\States\CanceledOrderState;
use Domain\Order\States\NewOrderState;
use Domain\Order\States\OrderState;
use Domain\Order\States\PaidOrderState;
use Domain\Order\States\PendigOrderState;

enum OrderStates: string
{
    case New = 'new';
    case Pending = 'prnding';
    case Paid = 'paid';
    case Canceled = 'canceled';

    public function createState(Order $order): OrderState
    {
        return match ($this) {
            OrderStates::New => new NewOrderState($order),
            OrderStates::Pending => new PendigOrderState($order),
            OrderStates::Paid => new PaidOrderState($order),
            OrderStates::Canceled => new CanceledOrderState($order),
        };
    }
}
