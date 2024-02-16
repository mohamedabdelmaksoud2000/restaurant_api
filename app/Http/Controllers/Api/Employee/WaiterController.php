<?php

namespace App\Http\Controllers\Api\Employee;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Waiter\RemoveItemRequest;
use App\Http\Requests\Waiter\RemoveMealRequest;
use App\Http\Requests\Waiter\StoreItemRequest;
use App\Http\Requests\Waiter\StoreMealRequest;
use App\Http\Requests\Waiter\StoreOrderRequest;
use App\Http\Resources\Waiter\MealItemResource;
use App\Http\Resources\Waiter\MealResource;
use App\Http\Resources\Waiter\OrderResource;
use App\Models\Meal;
use App\Models\MealItem;
use App\Models\Order;
use App\Traits\ResponseApi;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class WaiterController extends Controller
{
    
    use ResponseApi;

    public function __construct()
    {
        $this->middleware('role:waiter|manager');
    }

    public function showOrders()
    {
        $orders = Order::withWhereHas('table',fn($query)=>
        $query->where('branch_id',Auth::user()->branch->id)
        );
        $orders = QueryBuilder::for($orders)
        ->allowedFilters([
            AllowedFilter::exact('status'),
            AllowedFilter::exact('id'),
        ])->get();
        
        return $this->responseSuccess('show all orders',OrderResource::collection($orders));
    }

    public function createOrder(StoreOrderRequest $request)
    {
        $request->merge(['status' => OrderStatus::Received]);
        $order = Order::create($request->all());
        return $this->responseSuccess('Order has been created successfully!',new OrderResource($order));
    }

    public function addMeal(StoreMealRequest $request)
    {
        $meal = Meal::create($request->safe()->all());
        return $this->responseSuccess('Meal has been added successfully!',new MealResource($meal));
    }

    public function removeMeal(RemoveMealRequest $request)
    {
        $meal = Meal::find($request->meal_id);
        $meal->delete();
        return $this->responseSuccess('Meal has been Removed Successfully!',[]);
    }

    public function addItem(StoreItemRequest $request)
    {
        $item = MealItem::create($request->safe()->all());
        return $this->responseSuccess('meal\'s item has been added successfully!',new MealItemResource($item));
    }

    public function removeItem(RemoveItemRequest $request)
    {

    }

}
