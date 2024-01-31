<?php

namespace App\Http\Controllers;

use Domain\Order\Models\DeliveryType;
use Domain\Order\Models\PaymentMethod;
use DomainException;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class OrderController
{
    public function index(): Factory|View|Application
    {
        $items = cart()->items();

        if ($items->isEmpty()) {
            throw new DomainException("В корзине пусто");
        }

        return view('order.index', [
            'items' => $items,
            'payments' => PaymentMethod::query()->get(),
            'deliveries' => DeliveryType::query()->get(),
        ]);
    }

    public function handle(): RedirectResponse
    {
        return redirect()->route('home');
    }
}
