<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
<<<<<<< Updated upstream
Route::get('/calendrier', [\App\Http\Controllers\calendrierController::class, 'getCoursTachesEleves']);
Route::get('/test', [\App\Http\Controllers\calendrierController::class, 'getCoursTachesEleves']);
=======
Route::get('/calendrier', [\App\Http\Controllers\calendrierController::class, 'getCalendrier']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
>>>>>>> Stashed changes
