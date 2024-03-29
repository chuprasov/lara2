<?php

namespace Tests\Unit\Support\ValuesObjects;

use InvalidArgumentException;
use Support\ValueObjects\Price;
use Tests\TestCase;

class PriceTest extends TestCase
{
    public function test_price(): void
    {
        $price = Price::make(10000);

        $this->assertInstanceOf(Price::class, $price);
        $this->assertEquals(10000, $price->raw());
        $this->assertEquals('RUB', $price->currency());
        $this->assertEquals('₽', $price->symbol());
        $this->assertEquals('100,00 ₽', $price);

        $this->expectException(InvalidArgumentException::class);
        $price = Price::make(-10000);
    }

    public function test_price_invalid_currency(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Price::make(10000, 'USD');
    }
}
