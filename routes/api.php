<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\TicketController;
use Illuminate\Support\Facades\Route;

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


Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);


Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'profile']);
        Route::put('/update', [ProfileController::class, 'update']);
    });

    Route::group(['prefix' => 'tickets'], function () {
        Route::get('/', [TicketController::class, 'index']);
        Route::get('/{ticket_id}', [TicketController::class, 'show']);
        Route::post('/store', [TicketController::class, 'store']);
        Route::put('/update', [TicketController::class, 'update']);
        Route::delete('/{ticket}', [TicketController::class, 'destroy']);
    });
});
