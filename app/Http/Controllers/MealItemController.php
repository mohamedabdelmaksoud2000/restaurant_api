<?php

namespace App\Http\Controllers;

use App\Models\MealItem;
use App\Http\Requests\StoreMealItemRequest;
use App\Http\Requests\UpdateMealItemRequest;

class MealItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMealItemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MealItem $mealItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MealItem $mealItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMealItemRequest $request, MealItem $mealItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MealItem $mealItem)
    {
        //
    }
}
