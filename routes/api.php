<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\{LoginController, RegisterController, RefreshTokenController};
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
Route::prefix('v1')->group(function () {
    Route::post('sign-in', [LoginController::class, 'login']);
    Route::post('sign-up', [RegisterController::class, 'register']);
    Route::post('refresh_token', [RefreshTokenController::class, 'refreshToken']);

    // Route::get('/me', [ProfileController::class, 'me'])->middleware('auth:sanctum');
});
