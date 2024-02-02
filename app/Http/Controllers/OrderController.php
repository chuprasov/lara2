<?php

namespace App\Http\Controllers;

use DomainException;
use Illuminate\Contracts\View\View;
use Domain\Order\Models\DeliveryType;
use Illuminate\Http\RedirectResponse;
use Domain\Order\Models\PaymentMethod;
use Illuminate\Contracts\View\Factory;
use Domain\Order\Actions\NewOrderAction;
use Domain\Order\Processes\OrderProcess;
use Domain\Order\Processes\AssignCustomer;
use Domain\Order\Processes\AssignProducts;
use Domain\Order\Requests\OrderFormRequest;
use Illuminate\Contracts\Foundation\Application;
use Domain\Order\Processes\CheckProductQuantities;

class OrderController
{
    public function index(): Factory|View|Application
    {
        $items = cart()->items();

        if ($items->isEmpty()) {
            throw new DomainException('В корзине пусто');
        }

        return view('order.index', [
            'items' => $items,
            'payments' => PaymentMethod::query()->get(),
            'deliveries' => DeliveryType::query()->get(),
        ]);
    }

    public function handle(OrderFormRequest $request, NewOrderAction $action): RedirectResponse
    {
        $order = $action($request);

        $orderProcess = new OrderProcess($order);

        $orderProcess->processes([
            new CheckProductQuantities(),
            new AssignCustomer(request('customer')),
            new AssignProducts()
        ])->run();

        return redirect()->route('home');
    }
}
