<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsApiController;
use App\Http\Controllers\UserController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::get('/products', function (Request $request) {
//     return $products; 
// });





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::apiResource('products', ProductsApiController::class)->except([
//     'create', 'show', 'edit'
// ]);

Route::get('/products', [ProductsApiController::class, 'index']);
Route::post('/products', [ProductsApiController::class, 'store']);
Route::put('/products/{id}', [ProductsApiController::class, 'update']);
Route::delete('/products/{id}', [ProductsApiController::class, 'destroy']);
Route::get('/products/{id}', [ProductsApiController::class, 'show']);

// Route::apiResource('products', ProductsApiController::class);


Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);