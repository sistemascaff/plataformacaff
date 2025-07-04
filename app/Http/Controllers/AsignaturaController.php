<?php

namespace App\Http\Controllers;

use App\Http\Requests\AsignaturaValidation;
use App\Models\Asignatura;
use App\Models\Aula;
use App\Models\Coordinacion;
use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Usuario;
use App\Models\Materia;
use App\Models\Docente;
use App\Models\Persona;
use App\Models\Rol;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class AsignaturaController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'Asignaturas'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $tableAsignatura = (new Asignatura())->selectDisponibles($request->busqueda);
            return view('Asignatura.inicio', [
                'headTitle' => 'ASIGNATURAS - INICIO',
                'tableAsignatura' => $tableAsignatura,
                'busqueda' => $request->busqueda
            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    /**Muestra la información de un registro específico de la tabla 'Asignaturas'.*/
    public function show($idAsignatura)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $asignatura = (new Asignatura())->selectAsignatura($idAsignatura);
            $usuario = (new Usuario())->selectUsuario($asignatura->idUsuario);
            $materia = (new Materia())->selectMateria($asignatura->idMateria);
            $coordinacion = (new Coordinacion())->selectCoordinacion($asignatura->idCoordinacion);
            $aula = (new Aula())->selectAula($asignatura->idAula);
            $docente = (new Docente())->selectDocente($asignatura->idDocente);
            $persona = (new Persona())->selectPersona($docente->idPersona);
            if (!$coordinacion) {
                $coordinacion = new Coordinacion();
                $coordinacion->nombreCoordinacion = '';
            }
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }

            $Estudiantes = (new Estudiante())->selectDisponibles('');
            $Cursos = (new Curso())->selectDisponibles('');
            $integrantes = (new Asignatura())->selectAsignatura_Estudiantes($idAsignatura);
            $Unidades = (new Asignatura())->selectAsignatura_UnidadesySilabos($idAsignatura);
            $Horarios = (new Asignatura())->selectAsignatura_Horarios($idAsignatura);
            $Materiales = (new Asignatura())->selectAsignatura_Materiales($idAsignatura);

            return view('Asignatura.detalle', [
                'headTitle' => $asignatura->nombreAsignatura,
                'asignatura' => $asignatura,
                'usuario' => $usuario,
                'materia' => $materia,
                'coordinacion' => $coordinacion,
                'aula' => $aula,
                'docente' => $docente,
                'persona' => $persona,
                'Estudiantes' => $Estudiantes,
                'Cursos' => $Cursos,
                'integrantes' => $integrantes,
                'Unidades' => $Unidades,
                'Horarios' => $Horarios,
                'Materiales' => $Materiales
            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    /**Muestra el formulario con los atributos requeridos para CREAR un nuevo registro en la tabla 'Asignaturas'.*/
    public function new($idSelect = null)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $Materias = (new Materia())->selectDisponibles('');
            $Coordinaciones = (new Coordinacion())->selectDisponibles('');
            $Aulas = (new Aula())->selectDisponibles('');
            $Docentes = (new Docente())->selectDisponibles('');
            if (!$idSelect) {
                $idSelect = 0;
            }
            return view('Asignatura.create', [
                'headTitle' => 'ASIGNATURAS - NUEVA ASIGNATURA',
                'Titulos' => "NUEVA ASIGNATURA",
                'Materias' => $Materias,
                'Coordinaciones' => $Coordinaciones,
                'Aulas' => $Aulas,
                'Docentes' => $Docentes,
                'idSelect' => $idSelect
            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    /**Método que permite almacenar el registro creado de la tabla 'Asignaturas' y retorna el método show() con el registro.*/
    public function store(AsignaturaValidation $request)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $asignatura = new Asignatura();
            $asignatura->idMateria = $request->idMateria;
            $asignatura->idCoordinacion = $request->idCoordinacion;
            $asignatura->idAula = $request->idAula;
            $asignatura->idDocente = $request->idDocente;
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
        } else {
            return redirect()->route('dashboard');
        }
    }

    /**Muestra el formulario con los atributos requeridos para ACTUALIZAR un registro existente de la tabla 'Asignaturas'.*/
    public function edit(Asignatura $asignatura)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $Materias = (new Materia())->selectDisponibles('');
            $Coordinaciones = (new Coordinacion())->selectDisponibles('');
            $Aulas = (new Aula())->selectDisponibles('');
            $Docentes = (new Docente())->selectDisponibles('');
            return view('Asignatura.update', [
                'headTitle' => 'EDITAR - ' . $asignatura->nombreAsignatura,
                'asignatura' => $asignatura,
                'Materias' => $Materias,
                'Coordinaciones' => $Coordinaciones,
                'Aulas' => $Aulas,
                'Docentes' => $Docentes,
                'Titulos' => "MODIFICAR ASIGNATURA"
            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'Asignaturas' y retorna el método show() con el registro actualizado.*/
    public function update(AsignaturaValidation $request, Asignatura $asignatura)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $asignatura->idMateria = $request->idMateria;
            $asignatura->idCoordinacion = $request->idCoordinacion;
            $asignatura->idAula = $request->idAula;
            $asignatura->idDocente = $request->idDocente;
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
        } else {
            return redirect()->route('dashboard');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'Asignaturas' y retorna el método index().*/
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $request->validate([
                'idAsignatura' => ['required', 'numeric', 'integer']
            ]);
            $asignatura = (new Asignatura())->selectAsignatura($request->idAsignatura);
            $asignatura->estado = '0';
            $asignatura->idUsuario = session('idUsuario');
            $asignatura->ip = session('ip');
            $asignatura->dispositivo = session('dispositivo');
            $asignatura->save();
            return redirect()->route('asignaturas.index');
        } else {
            return redirect()->route('dashboard');
        }
    }
    //Función de AJAX que permite agregar un Integrante (Estudiante) a la Asignatura
    public function ajaxAgregarEstudiante(Request $request)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
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
        } else {
            return redirect()->route('dashboard');
        }
    }
    //Función de AJAX que permite eliminar un Integrante (Estudiante) de la Asignatura
    public function ajaxEliminarEstudiante(Request $request)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $registrosAfectados = DB::table('integrantes')
                ->where('idAsignatura', $request->idAsignatura)
                ->where('idEstudiante', $request->idEstudiante)
                ->delete();
            return response()->json([
                'registrosAfectados' => $registrosAfectados
            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }
    //Método que elimina todos los integrantes de la Asignatura y añade a un conjunto de 'Estudiantes' que pertenecen a un 'Curso'
    public function refrescarIntegrantes(Request $request)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            // Primero elimina a todos los integrantes de la Asignatura
            DB::table('integrantes')->where('idAsignatura', $request->idAsignatura)->delete();
            $curso = (new Curso())->selectCurso_Estudiantes($request->idCurso);
            foreach ($curso as $row) {
                DB::table('integrantes')->insert([
                    'idAsignatura' => $request->idAsignatura,
                    'idEstudiante' => $row->idEstudiante
                ]);
            }
            $asignatura = (new Asignatura())->selectAsignatura($request->idAsignatura);
            return redirect()->route('asignaturas.details', $asignatura);
        } else {
            return redirect()->route('dashboard');
        }
    }
}
