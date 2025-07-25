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
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\AsignaturaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UnidadController;
use App\Http\Controllers\SilaboController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\LibroPrestamoController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PresentacionController;
use App\Http\Controllers\ListaMaterialController;
use App\Http\Controllers\TutorController;
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

// Ruta por defecto
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::controller(UsuarioController::class)->group(function(){
    /*get(URL web, método de controlador)->name(nombre para referenciar ruta)*/
    Route::get('panel','dashboard')->name('dashboard');
    Route::get('iniciar-sesion','signIn')->name('login');
    Route::post('verify','verify')->name('login.verify');
    Route::get('cerrar-sesion','signOut')->name('logout');
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
Route::controller(ListaMaterialController::class)->group(function(){
    Route::get('listasmateriales','index')->name('listasmateriales.index');
    Route::get('listasmateriales/crear/{asignatura?}','new')->name('listasmateriales.create');
    Route::post('listasmateriales','store')->name('listasmateriales.store');
    Route::get('listasmateriales/detalle','show')->name('listasmateriales.details');
    Route::get('listasmateriales/editar','edit')->name('listasmateriales.edit');
    Route::put('listasmateriales/update','update')->name('listasmateriales.update');
    Route::put('listasmateriales','delete')->name('listasmateriales.delete');
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
Route::controller(DocenteController::class)->group(function(){
    Route::get('docentes','index')->name('docentes.index');
    Route::get('docentes/crear','new')->name('docentes.create');
    Route::post('docentes','store')->name('docentes.store');
    Route::get('docentes/{docente}','show')->name('docentes.details');
    Route::get('docentes/{docente}/editar','edit')->name('docentes.edit');
    Route::put('docentes/{docente}','update')->name('docentes.update');
    Route::put('docentes','delete')->name('docentes.delete');
});
Route::controller(TutorController::class)->group(function(){
    Route::get('tutores','index')->name('tutores.index');
    Route::get('tutores/crear','new')->name('tutores.create');
    Route::post('tutores','store')->name('tutores.store');
    Route::get('tutores/{tutor}','show')->name('tutores.details');
    Route::get('tutores/{tutor}/editar','edit')->name('tutores.edit');
    Route::put('tutores/{tutor}','update')->name('tutores.update');
    Route::put('tutores','delete')->name('tutores.delete');
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

/*MÓDULO DE BIBLIOTECA*/

Route::controller(LibroController::class)->group(function(){
    Route::get('libros','index')->name('libros.index');
    Route::get('libros/crear/{campo?}','new')->name('libros.create');
    Route::post('libros','store')->name('libros.store');
    Route::get('libros/{libro}','show')->name('libros.details');
    Route::get('libros/{libro}/editar','edit')->name('libros.edit');
    Route::put('libros/{libro}','update')->name('libros.update');
    Route::put('libros','delete')->name('libros.delete');
    Route::get('autores','indexAutores')->name('autores.index');
    Route::get('autores/{autor}','showAutorLibros')->name('autores.details');
    Route::get('editoriales','indexEditoriales')->name('editoriales.index');
    Route::get('editoriales/{editorial}','showEditorialLibros')->name('editoriales.details');
});
Route::controller(LibroPrestamoController::class)->group(function(){
    Route::get('prestamoslibros','index')->name('librosprestamos.index');
    Route::get('prestamoslibros/crear/{campo?}','new')->name('librosprestamos.create');
    Route::post('prestamoslibros','store')->name('librosprestamos.store');
    Route::get('prestamoslibros/reportes','reports')->name('librosprestamos.reports');
    Route::get('prestamoslibros/reportes/pdf','imprimirReporte')->name('librosprestamos.reports.pdf');
    Route::get('prestamoslibros/{prestamolibro}','show')->name('librosprestamos.details');
    Route::get('prestamoslibros/{libroprestamo}/editar','edit')->name('librosprestamos.edit');
    Route::put('prestamoslibros/{libroprestamo}','update')->name('librosprestamos.update');
    Route::put('prestamoslibros','delete')->name('librosprestamos.delete');
    Route::put('prestamoslibros/{prestamolibro}/actualizarFechaRetorno','actualizarFechaRetorno')->name('librosprestamosdetalles.dateReturnUpdate');
    Route::get('prestamoslibros/{prestamolibro}/comprobante','imprimirComprobante')->name('librosprestamos.imprimirComprobantePDF');
});
Route::controller(CategoriaController::class)->group(function(){
    Route::get('categorias','index')->name('categorias.index');
    Route::get('categorias/crear','new')->name('categorias.create');
    Route::post('categorias','store')->name('categorias.store');
    Route::get('categorias/{categoria}','show')->name('categorias.details');
    Route::get('categorias/{categoria}/editar','edit')->name('categorias.edit');
    Route::put('categorias/{categoria}','update')->name('categorias.update');
    Route::put('categorias','delete')->name('categorias.delete');
});
Route::controller(PresentacionController::class)->group(function(){
    Route::get('presentaciones','index')->name('presentaciones.index');
    Route::get('presentaciones/crear','new')->name('presentaciones.create');
    Route::post('presentaciones','store')->name('presentaciones.store');
    Route::get('presentaciones/{presentacion}','show')->name('presentaciones.details');
    Route::get('presentaciones/{presentacion}/editar','edit')->name('presentaciones.edit');
    Route::put('presentaciones/{presentacion}','update')->name('presentaciones.update');
    Route::put('presentaciones','delete')->name('presentaciones.delete');
});
/*
Route::get('inicio/{modulo}/{accion?}', function($modulo, $accion = null) {
    return view('inicio');
});*/