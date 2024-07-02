<?php

namespace App\Http\Controllers;

use App\Http\Requests\AsignaturaValidation;
use App\Models\Asignatura;
use App\Models\Aula;
use App\Models\Coordinacion;
use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Integrante;
use App\Models\Usuario;
use App\Models\Materia;
use App\Models\Profesor;
use App\Models\Persona;
use App\Models\Rol;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class AsignaturaController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'Asignaturas'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $tableAsignatura = (new Asignatura())->selectDisponibles($request->busqueda);
            return view('Asignatura.inicio', [
                'headTitle' => 'ASIGNATURAS - INICIO',
                'tableAsignatura' => $tableAsignatura,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }        
    }

    /**Muestra la información de un registro específico de la tabla 'Asignaturas'.*/
    public function show($idAsignatura)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $asignatura = (new Asignatura())->selectAsignatura($idAsignatura);
            $usuario = (new Usuario())->selectUsuario($asignatura->idUsuario);
            $materia = (new Materia())->selectMateria($asignatura->idMateria);
            $coordinacion = (new Coordinacion())->selectCoordinacion($asignatura->idCoordinacion);
            $aula = (new Aula())->selectAula($asignatura->idAula);
            $profesor = (new Profesor())->selectProfesor($asignatura->idProfesor);
            $persona = (new Persona())->selectPersona($profesor->idPersona);
            if (!$coordinacion) {
                $coordinacion = new Coordinacion();
                $coordinacion->nombreCoordinacion = '';
            }
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }

            $Estudiantes = (new Estudiante())->selectDisponibles('');
            $Integrantes = (new Asignatura())->selectAsignatura_Estudiantes($idAsignatura);

            return view('Asignatura.detalle', [
                'headTitle' => $asignatura->nombreAsignatura,
                'asignatura' => $asignatura,
                'usuario' => $usuario,
                'materia' => $materia,
                'coordinacion' => $coordinacion,
                'aula' => $aula,
                'profesor' => $profesor,
                'persona' => $persona,
                'Estudiantes' => $Estudiantes,
                'Integrantes' => $Integrantes
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para CREAR un nuevo registro en la tabla 'Asignaturas'.*/
    public function new($idSelect = null){
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $Materias = (new Materia())->selectDisponibles('');
            $Coordinaciones = (new Coordinacion())->selectDisponibles('');
            $Aulas = (new Aula())->selectDisponibles('');
            $Profesores = (new Profesor())->selectDisponibles('');
            if(!$idSelect){
                $idSelect = 0;
            }
            return view('Asignatura.create', [
                'headTitle' => 'ASIGNATURAS - NUEVA ASIGNATURA',
                'Titulos' => "NUEVA ASIGNATURA",
                'Materias' => $Materias,
                'Coordinaciones' => $Coordinaciones,
                'Aulas' => $Aulas,
                'Profesores' => $Profesores,
                'idSelect' => $idSelect
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar el registro creado de la tabla 'Asignaturas' y retorna el método show() con el registro.*/
    public function store(AsignaturaValidation $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $asignatura = new Asignatura();
            $asignatura->idMateria = $request->idMateria;
            $asignatura->idCoordinacion = $request->idCoordinacion;
            $asignatura->idAula = $request->idAula;
            $asignatura->idProfesor = $request->idProfesor;
            $asignatura->nombreAsignatura = strtoupper($request->nombreAsignatura);
            $asignatura->nombreCorto = strtoupper($request->nombreCorto);
            $asignatura->tipoCalificacion = $request->tipoCalificacion;
            $asignatura->tipoBloque = $request->tipoBloque;
            $asignatura->tipoAsignatura = $request->tipoAsignatura;
            $asignatura->idUsuario = session('idUsuario');
            $asignatura->ip = session('ip');
            $asignatura->dispositivo = session('dispositivo');
            $asignatura->save();
            return redirect()->route('asignaturas.details', $asignatura);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para ACTUALIZAR un registro existente de la tabla 'Asignaturas'.*/
    public function edit(Asignatura $asignatura)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $Materias = (new Materia())->selectDisponibles('');
            $Coordinaciones = (new Coordinacion())->selectDisponibles('');
            $Aulas = (new Aula())->selectDisponibles('');
            $Profesores = (new Profesor())->selectDisponibles('');
            return view('Asignatura.update', [
                'headTitle' => 'EDITAR - ' . $asignatura->nombreAsignatura,
                'asignatura' => $asignatura,
                'Materias' => $Materias,
                'Coordinaciones' => $Coordinaciones,
                'Aulas' => $Aulas,
                'Profesores' => $Profesores,
                'Titulos' => "MODIFICAR ASIGNATURA"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
    
    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'Asignaturas' y retorna el método show() con el registro actualizado.*/
    public function update(AsignaturaValidation $request, Asignatura $asignatura)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $asignatura->idMateria = $request->idMateria;
            $asignatura->idCoordinacion = $request->idCoordinacion;
            $asignatura->idAula = $request->idAula;
            $asignatura->idProfesor = $request->idProfesor;
            $asignatura->nombreAsignatura = strtoupper($request->nombreAsignatura);
            $asignatura->nombreCorto = strtoupper($request->nombreCorto);
            $asignatura->tipoCalificacion = $request->tipoCalificacion;
            $asignatura->tipoBloque = $request->tipoBloque;
            $asignatura->tipoAsignatura = $request->tipoAsignatura;
            $asignatura->idUsuario = session('idUsuario');
            $asignatura->ip = session('ip');
            $asignatura->dispositivo = session('dispositivo');
            $asignatura->save();
            return redirect()->route('asignaturas.details', $asignatura);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'Asignaturas' y retorna el método index().*/
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idAsignatura' => ['required','numeric','integer']
            ]);
            $asignatura = (new Asignatura())->selectAsignatura($request->idAsignatura);
            $asignatura->estado = '0';
            $asignatura->idUsuario = session('idUsuario');
            $asignatura->ip = session('ip');
            $asignatura->dispositivo = session('dispositivo');
            $asignatura->save();
            return redirect()->route('asignaturas.index');
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
    //Función de AJAX que permite agregar un integrante (Estudiante) a la Asignatura
    public function ajaxAgregarEstudiante(Request $request) {
        DB::table('integrantes')->insert([
            'idAsignatura' => $request->idAsignatura,
            'idEstudiante' => $request->idEstudiante
        ]);
        $estudiante = (new Estudiante())->selectEstudiante($request->idEstudiante);
        $curso = (new Curso())->selectCurso($estudiante->idCurso);
        $persona = (new Persona())->selectPersona($estudiante->idPersona);
        return response()->json([
            'idEstudiante' => $request->idEstudiante,
            'nombreCurso' => $curso->nombreCurso,
            'nombreEstudiante' => trim($persona->apellidoPaterno . ' ' . $persona->apellidoMaterno . ' ' . $persona->nombres)
        ]);
    }
    //Función de AJAX que permite agregar un integrante (Estudiante) a la Asignatura
    public function ajaxEliminarEstudiante(Request $request) {
        $affectedRows = DB::table('integrantes')
        ->where('idAsignatura', $request->idAsignatura)
        ->where('idEstudiante', $request->idEstudiante)
        ->delete();
        return response()->json([
            'affectedRows' => $affectedRows
        ]);
    }
}
