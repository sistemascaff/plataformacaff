<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
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
});

// Agregar en este grupo todas las rutas que pertenezcan a esta clase.
Route::controller(UsuarioController::class)->group(function(){
    Route::get('usuario','index');
});
/*
Route::get('inicio/{modulo}/{accion?}', function($modulo, $accion = null) {
    return view('inicio');
});*/