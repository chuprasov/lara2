<?php

namespace Domain\Order\Actions;

use Domain\Auth\Contracts\RegisterUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Domain\Order\Models\Order;
use Domain\Order\Requests\OrderFormRequest;

class NewOrderAction
{
    public function __invoke(OrderFormRequest $request): Order
    {
        $registerAction = app(RegisterUserContract::class);

        $customer = request()->get('customer');

        if (request()->boolean('create_account')) {
            $registerAction(NewUserDTO::make(
                $customer['first_name'].' '.$customer['last_name'],
                $customer['email'],
                $request->get('password')
            ));
        }

        return Order::query()->create([
            'user_id' => auth()->id(),
            'payment_method_id' => $request->get('payment_method_id'),
            'delivery_type_id' => $request->get('delivery_type_id'),
        ]);
    }
}
