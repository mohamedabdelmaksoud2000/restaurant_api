<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Http\Resources\RestaurantCollection;
use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use App\Traits\ResponseApi;


class RestaurantController extends Controller
{

    use ResponseApi;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurants = Restaurant::paginate(20);
        return $this->responseSuccess('show all restaurants',new RestaurantCollection($restaurants));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRestaurantRequest $request)
    {
        $restaurant = Restaurant::create($request->safe()->all());
        return $this->responseSuccess('restaurant has been created successfully!',new RestaurantResource($restaurant));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $restaurant = Restaurant::find($id);
        if(!$restaurant)
        {
            return $this->responseError('not found restaurant this is id',404);
        }
        return $this->responseSuccess('show restaurant',new RestaurantResource($restaurant));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRestaurantRequest $request, string $id)
    {
        $restaurant = Restaurant::find($id);
        if(!$restaurant)
        {
            return $this->responseError('not found restaurant this is id',404);
        }
        $restaurant->update($request->safe()->all());
        return $this->responseSuccess('restaurant has been updated successfully!',new RestaurantResource($restaurant));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $restaurant = Restaurant::find($id);
        if(!$restaurant || $restaurant->branch)
        {
            return $this->responseError('you can\'t deleted',404);
        }
        $restaurant->delete();
        return $this->responseSuccess('restaurant has been deleted successfully!',[]);

    }
}
