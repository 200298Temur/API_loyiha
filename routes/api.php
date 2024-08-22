<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\DeliveryMethodController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentCardTypeController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\StatusOrderController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserPaymentCardsController;
use App\Http\Controllers\UserSettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:api')->group(function () {
//     Route::get('/dashboard', function () {
//         return response()->json(['message' => 'Welcome to API Dashboard']);
//     });

// });
 
 
require __DIR__.'/admin.php';



Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout']);
Route::post('register',[AuthController::class,'register']);
Route::post('change-password',[AuthController::class,'changePassword']);
Route::get('user',[AuthController::class,'user'])->middleware('auth:sanctum');

Route::get('products/{product}/releted',[ProductController::class,'releted']);

Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('categories.products', CategoryProductController::class);
Route::apiResource('favorites', FavoriteController::class)->middleware('auth:sanctum');
Route::apiResource('orders', OrderController::class)->middleware('auth:sanctum');
Route::apiResource('delivet-methods', DeliveryMethodController::class);
Route::apiResource('payment-types', PaymentTypeController::class);
Route::apiResource('user-addresses', UserAddressController::class)->middleware('auth:sanctum');

Route::apiResource('statuses', StatusController::class)->middleware('auth:sanctum');
Route::apiResource('statuses.orders', StatusOrderController::class);

Route::apiResource('reviews',ReviewController::class)->middleware('auth:sanctum');
Route::apiResource('products.reviews',ProductReviewController::class)->middleware('auth:sanctum');

Route::apiResource('settings',SettingController::class);
Route::apiResource('user-settings',UserSettingController::class)->middleware('auth:sanctum');
Route::apiResource('payment-card-types',PaymentCardTypeController::class)->middleware('auth:sanctum');
Route::apiResource('user-payment-cards', UserPaymentCardsController::class)->middleware('auth:sanctum');