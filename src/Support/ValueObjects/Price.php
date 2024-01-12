<?php

declare(strict_types=1);

namespace Support\ValueObjects;

use Support\Traits\Makeable;
use InvalidArgumentException;
use Stringable;

class Price implements Stringable
{
    use Makeable;

    private array $currencies = [
        'RUB' => '₽'
    ];

    public function __construct(
        public readonly int $value,
        public readonly string $currency = 'RUB',
        public readonly int $precision = 100
    )
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Price < 0');
        }

        if (!in_array($currency, $this->currencies)) {
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
}
