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
//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/me', [\App\Http\Controllers\Api\AuthController::class, 'me']);
    Route::post('logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::post('/upload', [\App\Http\Controllers\Api\FilesController::class, 'upload']);
    Route::get('/files', [\App\Http\Controllers\Api\FilesController::class, 'index']);
    Route::post('/message', [\App\Http\Controllers\Api\MessageController::class, 'newMessage']);
});
//Route::get('/me', [\App\Http\Controllers\Api\AuthController::class, 'me'])->middleware(['auth:sanctum', 'role:admin']);

Route::get('test', [\App\Http\Controllers\FetchUsers::class, 'index'])->middleware(['auth:sanctum', 'role:admin']);
