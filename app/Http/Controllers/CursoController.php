<?php

namespace App\Http\Controllers;

use App\Http\Requests\CursoValidation;
use App\Models\Curso;
use App\Models\Usuario;
use App\Models\Grado;
use App\Models\Paralelo;
use App\Models\Rol;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'Cursos'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $tableCurso = (new Curso())->selectDisponibles($request->busqueda);
            return view('Curso.inicio', [
                'headTitle' => 'CURSOS - INICIO',
                'tableCurso' => $tableCurso,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra la información de un registro específico de la tabla 'Cursos'.*/
    public function show($idCurso)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $curso = (new Curso())->selectCurso($idCurso);
            $usuario = (new Usuario())->selectUsuario($curso->idUsuario);
            $grado = (new Grado())->selectGrado($curso->idGrado);
            $paralelo = (new Paralelo())->selectParalelo($curso->idParalelo);
            $Estudiantes = (new Curso())->selectCurso_Estudiantes($idCurso);
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            return view('Curso.detalle', [
                'headTitle' => $curso->nombreCurso,
                'curso' => $curso,
                'usuario' => $usuario,
                'grado' => $grado,
                'paralelo' => $paralelo,
                'Estudiantes' => $Estudiantes
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para CREAR un nuevo registro en la tabla 'Cursos'.*/
    public function new(Request $request){
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $Grados = (new Grado())->selectDisponibles('');
            $Paralelos = (new Paralelo())->selectDisponibles('');
            return view('Curso.create', [
                'headTitle' => 'CURSOS - NUEVO CURSO',
                'Titulos' => "NUEVO CURSO",
                'Grados' => $Grados,
                'Paralelos' => $Paralelos,
                'idSelectGrado' => $request->idGrado,
                'idSelectParalelo' => $request->idParalelo
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar el registro creado de la tabla 'Cursos' y retorna el método show() con el registro.*/
    public function store(CursoValidation $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $curso = new Curso();
            $curso->nombreCurso = strtoupper($request->nombreCurso);
            $curso->idGrado = $request->idGrado;
            $curso->idParalelo = $request->idParalelo;
            $curso->idUsuario = session('idUsuario');
            $curso->ip = session('ip');
            $curso->dispositivo = session('dispositivo');
            $curso->save();
            return redirect()->route('cursos.details', $curso);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para ACTUALIZAR un registro existente de la tabla 'Cursos'.*/
    public function edit(Curso $curso)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $Grados = (new Grado())->selectDisponibles('');
            $Paralelos = (new Paralelo())->selectDisponibles('');
            return view('Curso.update', [
                'headTitle' => 'EDITAR - ' . $curso->nombreCurso,
                'curso' => $curso,
                'Grados' => $Grados,
                'Paralelos' => $Paralelos,
                'Titulos' => "MODIFICAR CURSO"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
    
    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'Cursos' y retorna el método show() con el registro actualizado.*/
    public function update(CursoValidation $request, Curso $curso)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $curso->nombreCurso = strtoupper($request->nombreCurso);
            $curso->idGrado = $request->idGrado;
            $curso->idParalelo = $request->idParalelo;
            $curso->idUsuario = session('idUsuario');
            $curso->ip = session('ip');
            $curso->dispositivo = session('dispositivo');
            $curso->save();
            return redirect()->route('cursos.details', $curso);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'Cursos' y retorna el método index().*/
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idCurso' => ['required','numeric','integer']
            ]);
            $curso = (new Curso())->selectCurso($request->idCurso);
            $curso->estado = '0';
            $curso->idUsuario = session('idUsuario');
            $curso->ip = session('ip');
            $curso->dispositivo = session('dispositivo');
            $curso->save();
            return redirect()->route('cursos.index');
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
}
