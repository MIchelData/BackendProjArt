<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http\Controllers;

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
//routes public
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

//routes privées
Route::group(['middleware'=>['auth:sanctum']],function () {
    Route::get('horaireactuelle', [\App\Http\Controllers\Api\HoraireController::class, 'index']);
    Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
});



