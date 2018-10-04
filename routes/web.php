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
