<?php

declare(strict_types=1);

namespace Domain\Order\States;

use Domain\Order\Events\OrderStateChanged;
use Domain\Order\Models\Order;
use InvalidArgumentException;

abstract class OrderState
{
    protected array $allowedTransitions = [

    ];

    abstract public function canBeCanged(): bool;

    abstract public function value(): string;

    abstract public function humanValue(): string;

    public function __construct(
        protected Order $order
    ) {
    }

    public function transitionTo(OrderState $state): void
    {
        if (! $this->canBeCanged()) {
            throw new InvalidArgumentException('Статус не может быть изменен');
        }

        if (! in_array(get_class($state), $this->allowedTransitions)) {
            throw new InvalidArgumentException(
                "Нельзя изменить статус c {$this->order->state->value()} на {$state->value()}"
            );
        }

        $this->order->updateQuietly([
            'status' => $state->value()
        ]);

        event(new OrderStateChanged(
            $this->order,
            $this->order->state,
            $state
        ));
    }

}
