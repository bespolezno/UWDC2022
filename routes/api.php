<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/types', [\App\Http\Controllers\TypeController::class, 'index']);
Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index']);
Route::get('/tags', [\App\Http\Controllers\TagController::class, 'index']);

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [\App\Http\Controllers\AuthController::class, 'user']);
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);

    Route::apiResource('/sessions', \App\Http\Controllers\SessionController::class)->except(['destroy']);
});
