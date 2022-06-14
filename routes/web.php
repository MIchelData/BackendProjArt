<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
    return redirect("/app");
});
Route::get('/user/info', function(){
    if(Auth::check()){
        return response()->json(Auth::user());
    }else{
        return response()->json("anonyme");
    }


});
Route::get("/horaire", [App\Http\Controllers\Api\HoraireController::class, 'index']);
Route::get("/horairetoutesclasses", [App\Http\Controllers\Api\HoraireController::class, 'horairestouteslesclasses']);
//Route::get('/calendrier', [\App\Http\Controllers\calendrierController::class, 'getCoursTachesEleves']);
//Route::get('/test', [\App\Http\Controllers\calendrierController::class, 'getCoursTachesEleves'])->middleware('enseignant');
Route::get('/calendrier', [\App\Http\Controllers\calendrierController::class, 'getCalendrier']);
Route::get('/enseignant', [\App\Http\Controllers\calendrierController::class, 'getCoursEnseignant']);
Route::get('/bonjour', [\App\Http\Controllers\Api\HoraireController::class, 'index']);
//Route::view('/horaire', 'horaireview');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
