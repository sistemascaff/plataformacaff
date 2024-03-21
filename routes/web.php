<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PersonaController;
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

Route::get('/', function () {
    return view('login');
})->name('login');

// Agregar en este grupo todas las rutas que pertenezcan a esta clase.
Route::controller(UsuarioController::class)->group(function(){
    /*get(URL web, método de controlador)->name(nombre para referenciar ruta)*/
    Route::get('usuarios','index')->name('usuarios.index');
    Route::get('usuarios/{idUsuario}','show')->name('usuarios.details');
});
Route::controller(PersonaController::class)->group(function(){
    Route::get('persona','index');
});
/*
Route::get('inicio/{modulo}/{accion?}', function($modulo, $accion = null) {
    return view('inicio');
});*/