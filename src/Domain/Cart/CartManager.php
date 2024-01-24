<?php

declare(strict_types=1);

namespace Domain\Cart;

use Domain\Cart\Contracts\CartIdentityStorageContract;
use Domain\Cart\Models\Cart;
use Domain\Cart\Models\CartItem;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Support\ValueObjects\Price;

class CartManager
{
    public function __construct(
        public CartIdentityStorageContract $cartIdentityStorage
    ) {
    }

    private function storageData(string $id): array
    {
        $data = [
            'storage_id' => $id,
        ];

        if (auth()->check()) {
            $data['user_id'] = auth()->user()->id;
        }

        return $data;
    }

    private function cacheKey(): string
    {
        return str('cart_' . $this->cartIdentityStorage->get())
            ->slug('_')
            ->value();
    }

    private function forgetCache(): void
    {
        Cache::forget($this->cacheKey());
    }

    public function updateStorageId(string $old, string $current): void
    {
        Cart::query()
            ->where('storage_id', $old)
            ->update($this->storageData($current));
    }

    public function add(Product $product, int $quantity, array $optionValues = []): Builder|Model
    {
        $cart = Cart::query()
            ->updateOrCreate([
                'storage_id' => $this->cartIdentityStorage->get(),
            ], $this->storageData($this->cartIdentityStorage->get()));

        sort($optionValues);

        $cartItem = $cart->cartItems()
            ->updateOrCreate([
                'product_id' => $product->id,
                'string_option_values' => implode(';', $optionValues),
            ], [
                'price' => $product->price,
                'quantity' => DB::raw("quantity + $quantity"),
                'string_option_values' => implode(';', $optionValues),
            ]);

        $cartItem->optionValues()->sync($optionValues);

        $this->forgetCache();

        return $cart;
    }

    public function quantity(CartItem $cartItem, int $quantity): void
    {
        $cartItem->update([
            'quantity' => $quantity,
        ]);

        $this->forgetCache();
    }

    public function delete(CartItem $cartItem): void
    {
        $cartItem->delete();

        $this->forgetCache();
    }

    public function truncate(): void
    {
        $this->get()?->delete();

        $this->forgetCache();
    }

    public function get()
    {
        return Cache::remember($this->cacheKey(), now()->addHour(), function () {
            return Cart::query()
                ->with('cartItems')
                ->where('storage_id', $this->cartIdentityStorage->get())
                ->when(auth()->check(), fn (Builder $b) => $b->orWhere('user_id', auth()->id()))
                ->first();
        });
    }

    public function items(): Collection
    {
        if (!$this->get()) {
            return collect([]);
        }

        return CartItem::query()
            ->with(['product', 'optionValues.option'])
            ->whereBelongsTo($this->get())
            ->get();
    }

    public function cartItemsCollection(): Collection
    {
        return $this->get()?->cartItems ?? collect([]);
    }

    public function count(): int
    {
        return $this->cartItemsCollection()->sum(function ($item) {
            return $item->quantity;
        });
    }

    public function total(): Price
    {
        return Price::make(
            $this->cartItemsCollection()->sum(function ($item) {
                return $item->amount->raw();
            })
        );
    }

}
