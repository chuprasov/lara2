<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\CartController;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_is_empty_cart(): void
    {
        $this->get(action([CartController::class, 'index']))
            ->assertOk()
            ->assertViewIs('cart.index')
            ->assertViewHas('cartItems', collect([]));
    }

    public function test_is_not_empty_cart(): void
    {
        $product = ProductFactory::new()->create();

        cart()->add($product, 1);

        $this->get(action([CartController::class, 'index']))
            ->assertOk()
            ->assertViewIs('cart.index')
            ->assertViewHas('cartItems', cart()->items());
    }

    public function test_added_success(): void
    {
        $product = ProductFactory::new()->create();

        $this->assertEquals(0, cart()->count());

        $this->post(
            action([CartController::class, 'add'], $product),
            ['quantity' => 3]
        );

        $this->assertEquals(3, cart()->count());
    }

    public function test_quantity_changed(): void
    {
        $product = ProductFactory::new()->create();

        cart()->add($product, 3);

        $this->assertEquals(3, cart()->count());

        $this->post(
            action([CartController::class, 'quantity'], cart()->items()->first()),
            ['quantity' => 5]
        );

        $this->assertEquals(5, cart()->count());
    }

    public function test_delete_success(): void
    {
        $product = ProductFactory::new()->create();

        cart()->add($product, 3);

        $this->assertEquals(3, cart()->count());

        $this->delete(
            action([CartController::class, 'delete'], cart()->items()->first())
        );

        $this->assertEquals(0, cart()->count());
    }

    public function test_truncate_success(): void
    {
        $product = ProductFactory::new()->create();

        cart()->add($product, 3);

        $this->assertEquals(3, cart()->count());

        $this->delete(
            action([CartController::class, 'truncate'])
        );

        $this->assertEquals(0, cart()->count());
    }
}
