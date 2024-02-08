<?php

namespace Domain\Order\States;

class NewOrderState extends OrderState
{
    protected array $allowedTransitions = [
        PendigOrderState::class,
        CanceledOrderState::class,
    ];

    public function canBeCanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return 'new';
    }

    public function humanValue(): string
    {
        return 'Новый заказ';
    }
}
