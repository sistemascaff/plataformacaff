<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Usuario;
use App\Models\Grado;
use App\Models\Paralelo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Can;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        if (session('idRol') == 1) {
            $tableCurso = (new Curso())->selectDisponibles($request->busqueda);
            return view('Curso.inicio', [
                'tableCurso' => $tableCurso,
                'busqueda' => $request->busqueda,
                'retrocederDirectorioAssets' => 1
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
                'curso' => $curso,
                'usuario' => $usuario,
                'grado' => $grado,
                'paralelo' => $paralelo,
                'Estudiantes' => $Estudiantes,
                'retrocederDirectorioAssets' => 2
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
                'Titulos' => "NUEVO CURSO",
                'Grados' => $Grados,
                'Paralelos' => $Paralelos,
                'idSelectGrado' => $request->idGrado,
                'idSelectParalelo' => $request->idParalelo,
                'retrocederDirectorioAssets' => 2
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function store(Request $request)
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
                'curso' => $curso,
                'Grados' => $Grados,
                'Paralelos' => $Paralelos,
                'Titulos' => "MODIFICAR CURSO",
                'retrocederDirectorioAssets' => 3
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }
    
    public function update(Request $request, Curso $curso)
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
