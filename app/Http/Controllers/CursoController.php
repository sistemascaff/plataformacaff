<?php

namespace App\Http\Controllers;

use App\Http\Requests\CursoValidation;
use App\Models\Curso;
use App\Models\Usuario;
use App\Models\Grado;
use App\Models\Paralelo;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        if (session('idRol') == 1) {
            $tableCurso = (new Curso())->selectDisponibles($request->busqueda);
            return view('Curso.inicio', [
                'headTitle' => 'CURSOS - INICIO',
                'tableCurso' => $tableCurso,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function show($idCurso)
    {
        if (session('idRol') == 1) {
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
            return redirect()->route('login');
        }
    }

    public function new(Request $request){
        if (session('idRol') == 1) {
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
            return redirect()->route('login');
        }
    }

    public function store(CursoValidation $request)
    {
        if (session('idRol') == 1) {
            $curso = new Curso();
            $curso->nombreCurso = strtoupper($request->nombreCurso);
            $curso->idGrado = $request->idGrado;
            $curso->idParalelo = $request->idParalelo;
            $curso->idUsuario = session('idUsuario');
            $curso->save();
            return redirect()->route('cursos.details', $curso);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function edit(Curso $curso)
    {
        if (session('idRol') == 1) {
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
            return redirect()->route('login');
        }
    }
    
    public function update(CursoValidation $request, Curso $curso)
    {
        if (session('idRol') == 1) {
            $curso->nombreCurso = strtoupper($request->nombreCurso);
            $curso->idGrado = $request->idGrado;
            $curso->idParalelo = $request->idParalelo;
            $curso->idUsuario = session('idUsuario');
            $curso->save();
            return redirect()->route('cursos.details', $curso);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function delete(Request $request)
    {
        if (session('idRol') == 1) {
            $request->validate([
                'idCurso' => ['required','numeric']
            ]);
            $curso = (new Curso())->selectCurso($request->idCurso);
            $curso->estado = '0';
            $curso->idUsuario = session('idUsuario');
            $curso->save();
            return redirect()->route('cursos.index');
        }
        else{
            return redirect()->route('login');
        }
    }
}
