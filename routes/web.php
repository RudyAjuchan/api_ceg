<?php

use App\Http\Controllers\TokenController;
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

Route::apiResource('/apiCEG/asistencias', 'AsistenciaController');
Route::apiResource('/apiCEG/token', 'TokenController');
Route::post('/apiCEG/listarToken', [TokenController::class, 'getTokenAlumno']);
Route::get('/', function () {
    return view('welcome');
});


