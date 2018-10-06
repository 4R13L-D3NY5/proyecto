<?php

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
    return view('contenido/contenido');
});

Route::get('/estudiante', 'EstudianteController@index');
Route::post('/estudiante/registrar', 'EstudianteController@store');
Route::put('/estudiante/actualizar', 'EstudianteController@update');
Route::put('/estudiante/desactivar', 'EstudianteController@desactivar');
Route::put('/estudiante/activar', 'EstudianteController@activar');
Route::get('/estudiante/seleccionarEstudiantes', 'EstudianteController@seleccionarEstudiantes');

Route::get('/paciente', 'PacienteController@index');
Route::post('/paciente/registrar', 'PacienteController@store');
Route::put('/paciente/actualizar', 'PacienteController@update');
Route::put('/paciente/desactivar', 'PacienteController@desactivar');
Route::put('/paciente/activar', 'PacienteController@activar');
Route::get('/paciente/edad', 'PacienteController@edad');

Route::get('/carpeta', 'CarpetaController@index');
