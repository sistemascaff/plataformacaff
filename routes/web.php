<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CampoController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\NivelController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\ParaleloController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\CoordinacionController;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\DimensionController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\AsignaturaController;
use App\Http\Controllers\UnidadController;
use App\Http\Controllers\SilaboController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\MaterialController;
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

Route::controller(UsuarioController::class)->group(function(){
    /*get(URL web, método de controlador)->name(nombre para referenciar ruta)*/
    Route::get('login','signIn')->name('login');
    Route::post('verify','verify')->name('login.verify');
    Route::get('logout','signOut')->name('logout');
    Route::get('usuarios','index')->name('usuarios.index');
    Route::post('usuarios/save','store')->name('usuarios.store');
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
Route::controller(MateriaController::class)->group(function(){
    Route::get('materias','index')->name('materias.index');
    Route::get('materias/crear/{area?}','new')->name('materias.create');
    Route::post('materias','store')->name('materias.store');
    Route::get('materias/{materia}','show')->name('materias.details');
    Route::get('materias/{materia}/editar','edit')->name('materias.edit');
    Route::put('materias/{materia}','update')->name('materias.update');
    Route::put('materias','delete')->name('materias.delete');
});
Route::controller(AsignaturaController::class)->group(function(){
    Route::get('asignaturas','index')->name('asignaturas.index');
    Route::get('asignaturas/crear/{materia?}','new')->name('asignaturas.create');
    Route::post('asignaturas','store')->name('asignaturas.store');
    Route::get('asignaturas/{asignatura}','show')->name('asignaturas.details');
    Route::get('asignaturas/{asignatura}/editar','edit')->name('asignaturas.edit');
    Route::put('asignaturas/{asignatura}','update')->name('asignaturas.update');
    Route::put('asignaturas','delete')->name('asignaturas.delete');
    Route::post('asignaturas/anhadirIntegrante','ajaxAgregarEstudiante')->name('asignaturas.addMember');
    Route::post('asignaturas/eliminarIntegrante','ajaxEliminarEstudiante')->name('asignaturas.deleteMember');
    Route::post('asignaturas/refrescarIntegrantes','refrescarIntegrantes')->name('asignaturas.refreshMembers');
});
Route::controller(UnidadController::class)->group(function(){
    Route::get('unidades','index')->name('unidades.index');
    Route::get('unidades/crear/{asignatura?}','new')->name('unidades.create');
    Route::post('unidades','store')->name('unidades.store');
    Route::get('unidades/{unidad}','show')->name('unidades.details');
    Route::get('unidades/{unidad}/editar','edit')->name('unidades.edit');
    Route::put('unidades/{unidad}','update')->name('unidades.update');
    Route::put('unidades','delete')->name('unidades.delete');
});
Route::controller(SilaboController::class)->group(function(){
    Route::get('silabos','index')->name('silabos.index');
    Route::get('silabos/crear/{unidad?}','new')->name('silabos.create');
    Route::post('silabos','store')->name('silabos.store');
    Route::get('silabos/{silabo}','show')->name('silabos.details');
    Route::get('silabos/{silabo}/editar','edit')->name('silabos.edit');
    Route::put('silabos/{silabo}','update')->name('silabos.update');
    Route::put('silabos','delete')->name('silabos.delete');
    Route::put('silabos/{silabo}/actualizarEstado','actualizarEstado')->name('silabos.statusUpdate');
});
Route::controller(HorarioController::class)->group(function(){
    Route::get('horarios','index')->name('horarios.index');
    Route::get('horarios/crear/{asignatura?}','new')->name('horarios.create');
    Route::post('horarios','store')->name('horarios.store');
    Route::get('horarios/{horario}','show')->name('horarios.details');
    Route::get('horarios/{horario}/editar','edit')->name('horarios.edit');
    Route::put('horarios/{horario}','update')->name('horarios.update');
    Route::put('horarios','delete')->name('horarios.delete');
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
Route::controller(AulaController::class)->group(function(){
    Route::get('aulas','index')->name('aulas.index');
    Route::get('aulas/crear','new')->name('aulas.create');
    Route::post('aulas','store')->name('aulas.store');
    Route::get('aulas/{aula}','show')->name('aulas.details');
    Route::get('aulas/{aula}/editar','edit')->name('aulas.edit');
    Route::put('aulas/{aula}','update')->name('aulas.update');
    Route::put('aulas','delete')->name('aulas.delete');
});
Route::controller(MaterialController::class)->group(function(){
    Route::get('materiales','index')->name('materiales.index');
    Route::get('materiales/crear','new')->name('materiales.create');
    Route::post('materiales','store')->name('materiales.store');
    Route::get('materiales/{material}','show')->name('materiales.details');
    Route::get('materiales/{material}/editar','edit')->name('materiales.edit');
    Route::put('materiales/{material}','update')->name('materiales.update');
    Route::put('materiales','delete')->name('materiales.delete');
});
Route::controller(GestionController::class)->group(function(){
    Route::get('gestiones','index')->name('gestiones.index');
    Route::get('gestiones/crear','new')->name('gestiones.create');
    Route::post('gestiones','store')->name('gestiones.store');
    Route::get('gestiones/{gestion}','show')->name('gestiones.details');
    Route::get('gestiones/{gestion}/editar','edit')->name('gestiones.edit');
    Route::put('gestiones/{gestion}','update')->name('gestiones.update');
    Route::put('gestiones','delete')->name('gestiones.delete');
});
Route::controller(PeriodoController::class)->group(function(){
    Route::get('periodos','index')->name('periodos.index');
    Route::get('periodos/crear/{gestion?}','new')->name('periodos.create');
    Route::post('periodos','store')->name('periodos.store');
    Route::get('periodos/{periodo}','show')->name('periodos.details');
    Route::get('periodos/{periodo}/editar','edit')->name('periodos.edit');
    Route::put('periodos/{periodo}','update')->name('periodos.update');
    Route::put('periodos','delete')->name('periodos.delete');
});
Route::controller(DimensionController::class)->group(function(){
    Route::get('dimensiones','index')->name('dimensiones.index');
    Route::get('dimensiones/crear/{gestion?}','new')->name('dimensiones.create');
    Route::post('dimensiones','store')->name('dimensiones.store');
    Route::get('dimensiones/{dimension}','show')->name('dimensiones.details');
    Route::get('dimensiones/{dimension}/editar','edit')->name('dimensiones.edit');
    Route::put('dimensiones/{dimension}','update')->name('dimensiones.update');
    Route::put('dimensiones','delete')->name('dimensiones.delete');
});
Route::controller(EstudianteController::class)->group(function(){
    Route::get('estudiantes','index')->name('estudiantes.index');
    Route::get('estudiantes/crear','new')->name('estudiantes.create');
    Route::post('estudiantes','store')->name('estudiantes.store');
    Route::get('estudiantes/{estudiante}','show')->name('estudiantes.details');
    Route::get('estudiantes/{estudiante}/editar','edit')->name('estudiantes.edit');
    Route::put('estudiantes/{estudiante}','update')->name('estudiantes.update');
    Route::put('estudiantes','delete')->name('estudiantes.delete');
});
Route::controller(ProfesorController::class)->group(function(){
    Route::get('profesores','index')->name('profesores.index');
    Route::get('profesores/crear','new')->name('profesores.create');
    Route::post('profesores','store')->name('profesores.store');
    Route::get('profesores/{profesor}','show')->name('profesores.details');
    Route::get('profesores/{profesor}/editar','edit')->name('profesores.edit');
    Route::put('profesores/{profesor}','update')->name('profesores.update');
    Route::put('profesores','delete')->name('profesores.delete');
});
Route::controller(CoordinacionController::class)->group(function(){
    Route::get('coordinaciones','index')->name('coordinaciones.index');
    Route::get('coordinaciones/crear','new')->name('coordinaciones.create');
    Route::post('coordinaciones','store')->name('coordinaciones.store');
    Route::get('coordinaciones/{coordinacion}','show')->name('coordinaciones.details');
    Route::get('coordinaciones/{coordinacion}/editar','edit')->name('coordinaciones.edit');
    Route::put('coordinaciones/{coordinacion}','update')->name('coordinaciones.update');
    Route::put('coordinaciones','delete')->name('coordinaciones.delete');
});
Route::controller(PersonaController::class)->group(function(){
    Route::get('perfil','information')->name('personas.profile');
});
/*
Route::get('inicio/{modulo}/{accion?}', function($modulo, $accion = null) {
    return view('inicio');
});*/