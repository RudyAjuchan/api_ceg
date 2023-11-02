<?php

use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\NotificacionController;
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
Route::post('/apiCEG/listarAsistencias', [AsistenciaController::class, 'listarAsistenciaAlumno']);
Route::post('/apiCEG/estadisticaAsistencia', [AsistenciaController::class, 'estadisticaAsistencia']); 
Route::post('/apiCEG/estadisticaHoraEntrada', [AsistenciaController::class, 'estadisticaHoraEntrada']); 
Route::post('/apiCEG/estadisticaHoraSalida', [AsistenciaController::class, 'estadisticaHoraSalida']); 
Route::post('/apiCEG/listarNotificaciones', [NotificacionController::class, 'listarNotificacionAlumno']);
Route::post('/apiCEG/getToken', [AsistenciaController::class, 'getToken']);
Route::apiResource('/apiCEG/justificar', 'JustificacionController');
Route::get('/', function () {
    return view('welcome');
});