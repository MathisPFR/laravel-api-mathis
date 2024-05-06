<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsApiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::get('/products', [ProductsApiController::class, 'index']);
    Route::post('/products', [ProductsApiController::class, 'store']);
    Route::put('/products/{id}', [ProductsApiController::class, 'update']);
    Route::delete('/products/{id}', [ProductsApiController::class, 'destroy']);
    Route::get('/products/{id}', [ProductsApiController::class, 'show']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});

// Routes pour l'authentification
Route::post('/auth/register', [UserController::class, 'createUser']);
Route::post('/auth/login', [UserController::class, 'loginUser']);
Route::get('/welcome', function () {
    return "Tu es arrivé sur cette page entre nous tu es une légende !";
});
