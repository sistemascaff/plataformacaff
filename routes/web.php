<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CampoController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\NivelController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\ParaleloController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Agregar en este grupo todas las rutas que pertenezcan a esta clase.
Route::controller(UsuarioController::class)->group(function(){
    /*get(URL web, método de controlador)->name(nombre para referenciar ruta)*/
    Route::get('login','signIn')->name('login');
    Route::post('verify','verify')->name('login.verify');
    Route::get('logout','signOut')->name('logout');
    Route::get('usuarios','index')->name('usuarios.index');
    Route::get('usuarios/crear','new')->name('usuarios.create');
    Route::post('usuarios/save','store')->name('usuarios.store');
    Route::get('usuarios/{idUsuario}','show')->name('usuarios.details');
});
Route::controller(CampoController::class)->group(function(){
    Route::get('campos','index')->name('campos.index');
    Route::get('campos/crear','new')->name('campos.create');
    Route::post('campos','store')->name('campos.store');
    Route::get('campos/{campo}','show')->name('campos.details');
    Route::get('campos/{campo}/editar','edit')->name('campos.edit');
    Route::put('campos/{campo}','update')->name('campos.update');
    Route::put('campos','delete')->name('campos.delete');
});
Route::controller(AreaController::class)->group(function(){
    Route::get('areas','index')->name('areas.index');
    Route::get('areas/crear/{campo?}','new')->name('areas.create');
    Route::post('areas','store')->name('areas.store');
    Route::get('areas/{area}','show')->name('areas.details');
    Route::get('areas/{area}/editar','edit')->name('areas.edit');
    Route::put('areas/{area}','update')->name('areas.update');
    Route::put('areas','delete')->name('areas.delete');
});
Route::controller(NivelController::class)->group(function(){
    Route::get('niveles','index')->name('niveles.index');
    Route::get('niveles/crear','new')->name('niveles.create');
    Route::post('niveles','store')->name('niveles.store');
    Route::get('niveles/{nivel}','show')->name('niveles.details');
    Route::get('niveles/{nivel}/editar','edit')->name('niveles.edit');
    Route::put('niveles/{nivel}','update')->name('niveles.update');
    Route::put('niveles','delete')->name('niveles.delete');
});
Route::controller(GradoController::class)->group(function(){
    Route::get('grados','index')->name('grados.index');
    Route::get('grados/crear/{nivel?}','new')->name('grados.create');
    Route::post('grados','store')->name('grados.store');
    Route::get('grados/{grado}','show')->name('grados.details');
    Route::get('grados/{grado}/editar','edit')->name('grados.edit');
    Route::put('grados/{grado}','update')->name('grados.update');
    Route::put('grados','delete')->name('grados.delete');
});
Route::controller(CursoController::class)->group(function(){
    Route::get('cursos','index')->name('cursos.index');
    Route::get('cursos/crear','new')->name('cursos.create');
    Route::post('cursos','store')->name('cursos.store');
    Route::get('cursos/{curso}','show')->name('cursos.details');
    Route::get('cursos/{curso}/editar','edit')->name('cursos.edit');
    Route::put('cursos/{curso}','update')->name('cursos.update');
    Route::put('cursos','delete')->name('cursos.delete');
});
Route::controller(ParaleloController::class)->group(function(){
    Route::get('paralelos','index')->name('paralelos.index');
    Route::get('paralelos/crear','new')->name('paralelos.create');
    Route::post('paralelos','store')->name('paralelos.store');
    Route::get('paralelos/{paralelo}','show')->name('paralelos.details');
    Route::get('paralelos/{paralelo}/editar','edit')->name('paralelos.edit');
    Route::put('paralelos/{paralelo}','update')->name('paralelos.update');
    Route::put('paralelos','delete')->name('paralelos.delete');
});
Route::controller(PersonaController::class)->group(function(){
    Route::get('personas','index')->name('personas.index');
});
/*
Route::get('inicio/{modulo}/{accion?}', function($modulo, $accion = null) {
    return view('inicio');
});*/