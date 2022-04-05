<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Application API Routes
|--------------------------------------------------------------------------
*/

/*-------------------------- start auth routes  --------------------------*/
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->prefix('auth')->controller(UserController::class)->group(function () {
    Route::get('/', 'auth');
    Route::get('/details', 'auth_details');
    Route::get('/profile', 'profile');
    Route::post('/update', 'update');
    Route::post('/confirm-email', function () {
        dd('not implimented yet');
    });
});
/*-------------------------- End  Auth Routes  --------------------------*/