<?php

namespace App\Http\Controllers\Api\Employee;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Waiter\OrderResource;
use App\Models\Order;
use App\Traits\ResponseApi;
use Illuminate\Support\Facades\Auth;

class chefController extends Controller
{
    use ResponseApi;

    public function __construct()
    {   
        $this->middleware('role:manager|chef');
    }

    public function showOrders()
    {
        $orders = Order::withWhereHas('table',
            fn ( $query ) => $query->where('branch_id',Auth::user()->branch->id)
        )->where('status',OrderStatus::Received)->get();
        return $this->responseSuccess('show all order ,it has been received',OrderResource::collection($orders));
    }

    public function takeOrder(String $id)
    {
        $order = Order::withWhereHas('table',
            fn ( $query ) => $query->where('branch_id',Auth::user()->branch->id)
        )->firstWhere('id',$id);
        if(!$order)
        {
            return $this->responseError('there is not order this is name',400);
        }
        $order->status = OrderStatus::Preparing;
        return $this->responseSuccess('A order is being prepared',[]);
    }

    public function completeOrder(string $id)
    {
        $order = Order::withWhereHas('table',
            fn ( $query ) => $query->where('branch_id',Auth::user()->branch->id)
        )->firstWhere('id',$id);
        if(!$order)
        {
            return $this->responseError('there is not order this is name',400);
        }
        $order->status = OrderStatus::Complete;
        return $this->responseSuccess('a order completed',new OrderResource($order));
    }

}
