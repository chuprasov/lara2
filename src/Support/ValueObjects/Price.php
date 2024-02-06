<?php

declare(strict_types=1);

namespace Support\ValueObjects;

use Stringable;
use Livewire\Wireable;
use Support\Traits\Makeable;
use InvalidArgumentException;

class Price implements Stringable //, Wireable
{
    use Makeable;

    private array $currencies = [
        'RUB' => '₽',
    ];

    public function __construct(
        public readonly int $value,
        public readonly string $currency = 'RUB',
        public readonly int $precision = 100
    ) {
        if ($value < 0) {
            throw new InvalidArgumentException('Price < 0');
        }

        if (!isset($this->currencies[$currency])) {
            throw new InvalidArgumentException('Currency not allowed');
        }
    }

    public function raw(): int
    {
        return $this->value;
    }

    public function value(): float|int
    {
        return $this->value / $this->precision;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function symbol(): string
    {
        return $this->currencies[$this->currency];
    }

    public function __toString(): string
    {
        return number_format($this->value(), 2, ',', ' ') . ' ' . $this->symbol();
    }

    /* public function toLivewire()
    {
        return [$this->value];
    }

    public static function fromLivewire($value)
    {
        return self::make($value[0]);
    } */
}
