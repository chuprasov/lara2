<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use Domain\Order\Models\Order;

class ApiOrderController extends Controller
{
    public function getAll()
    {
        return new OrderCollection(Order::all());
    }

    public function getPaginate(int $cnt)
    {
        return new OrderCollection(Order::paginate($cnt));
    }

    public function getOne(Order $product)
    {
        return new OrderResource($product);
    }

}
