<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum', 'role:customer'])->group(function () {
    Route::get('/trips', [TripController::class, 'index']);
    Route::post('/booking', [TripController::class, 'booking']);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
});



Route::post('/login', [AuthController::class, 'login']);
