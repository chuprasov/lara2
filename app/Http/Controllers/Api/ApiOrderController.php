<?php

namespace App\Http\Controllers\Api;

use Domain\Order\Models\Order;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ApiOrderController extends Controller
{
    public function getAll()
    {
        return new OrderCollection(Order::all());
    }

    /**
     * Paginated order list
     *
     * @param int $cnt Orders per page
     *
     * @return AnonymousResourceCollection<LengthAwarePaginator<OrderResource>>
     */
    public function getPaginate(int $cnt)
    {
        return new OrderCollection(Order::paginate($cnt));
    }

    public function getOne(Order $product)
    {
        return new OrderResource($product);
    }
}
