<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\TableController;
use App\Http\Controllers\Api\TableSeatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login',[AuthController::class,'login'])->name('login');

Route::middleware('auth:sanctum')
->group(function(){

    // auth
    Route::put('update',[AuthController::class,'update']);

    Route::apiResource('restaurant',RestaurantController::class);
    Route::apiResource('branch',BranchController::class);
    Route::apiResource('employee',EmployeeController::class);
    Route::apiResource('table',TableController::class);
    Route::apiResource('table/seat',TableSeatController::class);
    Route::apiResource('menu',MenuController::class);


});


