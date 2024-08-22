<?php

use App\Http\Controllers\StatsController;
use App\Models\Status;
use Illuminate\Support\Facades\Route;


Route::prefix('admin/stats')->group(function(){
   
    Route::get('orders-count',[StatsController::class,'ordersCount'])->middleware('auth:sanctum');
    Route::get('orders-sales',[StatsController::class,'orderSalesSum'])->middleware('auth:sanctum');
    Route::get('delivery-methods-ratio',[StatsController::class,'deliveryMethodsRatio'])->middleware('auth:sanctum');
    Route::get('orders-count-by-days',[StatsController::class,'ordersCountByDays'])->middleware('auth:sanctum');

});