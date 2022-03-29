<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Auth API Routes
|--------------------------------------------------------------------------
*/


Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
/*
|--------------------------------------------------------------------------
| Application API Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum'])->prefix('auth')->controller(UserController::class)->group(function () {
    Route::get('/', 'auth');
    Route::get('/details', 'auth_details');
    Route::post('/update', 'update_auth_general_details');
});
