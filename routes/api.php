<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\OrderController;

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

Route::fallback(function () {
    return response()->json(['error' => 'This API is  Not Found!! please check the API Url'], 404);
});


Route::post('/register', [RegisterController::class, 'registerUser']);
Route::post('/login', [RegisterController::class, 'loginUser']);
 
        
Route::middleware('auth:sanctum')->group( function () {

    Route::post('/logout', [RegisterController::class, 'logoutUser']);
    Route::get('/import-customers', [RegisterController::class, 'importUsers']);

    // Products API Routes
    Route::get('/import-products', [ProductController::class, 'importProduct']);
    Route::get('/get-products', [ProductController::class, 'getProducts']);

    // Cart API Routes
    Route::post('/add-to-cart', [CartController::class, 'addToCart']);
    Route::post('/update-cart', [CartController::class, 'UpdateCart']);
    Route::post('/delete-cart', [CartController::class, 'deleteCart']);
    Route::get('/get-cart-data', [CartController::class, 'getCartData']);


    Route::get('/place-order', [OrderController::class, 'placeOrder']);
    Route::get('/get-order-data', [OrderController::class, 'getOrderData']);



});
