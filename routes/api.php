<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Auth API Routes
|--------------------------------------------------------------------------
*/

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('logout', [AuthController::class, 'logout']);
});
/*
|--------------------------------------------------------------------------
| Application API Routes
|--------------------------------------------------------------------------
*/
