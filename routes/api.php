<?php

use App\Http\Controllers\BrandController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
    Route::post('show/{id}', 'store');
    Route::put('update_brand/{id}', 'update_brand');
    Route::delete('delete_brand/{id}', 'delete_brand');
});