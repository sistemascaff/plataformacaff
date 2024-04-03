<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CampoController;
use App\Http\Controllers\NivelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PersonaController;
use App\Models\Nivel;

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
    Route::get('areas/crear','new')->name('areas.create');
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
Route::controller(PersonaController::class)->group(function(){
    Route::get('personas','index')->name('personas.index');
});
/*
Route::get('inicio/{modulo}/{accion?}', function($modulo, $accion = null) {
    return view('inicio');
});*/