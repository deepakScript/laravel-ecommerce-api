<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// Protected routes (require JWT token)
// Route::middleware('auth:api')->group(function () {
//     Route::post('logout', [AuthController::class, 'logout']);
//     Route::get('me', [AuthController::class, 'me']);
// });

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
});


// brand crud
Route::controller(BrandController::class)->group(function () {
    Route::get('index', 'index');
    Route::get('show/{id}', 'show');
    Route::post('store', 'store');
    Route::put('update_brand/{id}', 'update_brand');
    Route::delete('delete_brand/{id}', 'delete_brand');
});

//category controlelr

Route::controller(CategoryController::class)->group(function () {
    Route::get('index', 'index');
    Route::get('show/{id}', 'show');
    Route::post('store', 'store');
    Route::put('update_category/{id}', 'update_category');
    Route::delete('delete_category/{id}', 'delete_category');
});

//location controller

Route::controller(LocationController::class)->group(function () {
    Route::post('store', 'store');
    Route::put('update/{id}', 'update');
    Route::delete('destroy/{id}', 'destroy');
});


//product routes for the 

Route::controller(ProductController::class)->group(function () {
    Route::get('index', 'index');
    Route::get('show/{id}', 'show');
    Route::post('store', 'store');
    Route::put('update_product/{id}', 'update');
    Route::delete('delete_product/{id}', 'destory');
});