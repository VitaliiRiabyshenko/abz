<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\APITokenIsValid;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\TokenController;
use App\Http\Controllers\Api\V1\PositionController;

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

Route::prefix('/v1')->group(function () {
    Route::get('/token', TokenController::class);
    Route::get('/positions', PositionController::class);

    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store'])->middleware(APITokenIsValid::class);
    Route::get('/users/{id}', [UserController::class, 'show']);
});
