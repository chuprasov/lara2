<?php

namespace Domain\Order\States;

class PendigOrderState extends OrderState
{
    protected array $allowedTransitions = [
        PaidOrderState::class,
        CanceledOrderState::class,
    ];

    public function canBeCanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return 'pendig';
    }

    public function humanValue(): string
    {
        return 'В обработке';
    }

}
