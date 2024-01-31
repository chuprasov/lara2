<?php

namespace Domain\Order\Enums;

enum OrderStates: string
{
    case New = 'new';
    case Pending = 'prnding';
    case Paid = 'paid';
    case Canceled = 'canceled';
}
