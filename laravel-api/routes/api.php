<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsApiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;

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

Route::get('/products', [ProductsApiController::class, 'index'])->middleware('auth:sanctum');
Route::post('/products', [ProductsApiController::class, 'store'])->middleware('auth:sanctum');
Route::put('/products/{id}', [ProductsApiController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/products/{id}', [ProductsApiController::class, 'destroy'])->middleware('auth:sanctum');
Route::get('/products/{id}', [ProductsApiController::class, 'show'])->middleware('auth:sanctum');



Route::get('/categories', [CategoryController::class, 'index'])->middleware('auth:sanctum');
Route::post('/categories', [CategoryController::class, 'store'])->middleware('auth:sanctum');
Route::put('/categories/{id}', [CategoryController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->middleware('auth:sanctum');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->middleware('auth:sanctum');

// Route::apiResource('products', ProductsApiController::class);


Route::get('/users', [UserController::class, 'index'])->middleware('auth:sanctum');
// Route::post('/users', [UserController::class, 'store'])->middleware('auth:sanctum');
Route::get('/users/{id}', [UserController::class, 'show'])->middleware('auth:sanctum');
Route::put('/users/{id}', [UserController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->middleware('auth:sanctum');


Route::post('/auth/register', [UserController::class, 'createUser']);
Route::post('/auth/login', [UserController::class, 'loginUser']);