<?php

namespace App\Http\Controllers;

use App\Http\Requests\GradoValidation;
use App\Models\Grado;
use App\Models\Usuario;
use App\Models\Nivel;
use App\Models\Paralelo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Can;

class GradoController extends Controller
{
    public function index(Request $request)
    {
        if (session('idRol') == 1) {
            $tableGrado = (new Grado())->selectDisponibles($request->busqueda);
            return view('Grado.inicio', [
                'headTitle' => 'GRADOS - INICIO',
                'tableGrado' => $tableGrado,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('login');
        }        
    }

    public function show($idGrado)
    {
        if (session('idRol') == 1) {
            $grado = (new Grado())->selectGrado($idGrado);
            $usuario = (new Usuario())->selectUsuario($grado->idUsuario);
            $nivel = (new Nivel())->selectNivel($grado->idNivel);
            $Cursos = (new Grado())->selectGrado_Cursos($idGrado);
            $Paralelos = (new Paralelo())->selectDisponibles('');
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            return view('Grado.detalle', [
                'headTitle' => $grado->nombreGrado,
                'grado' => $grado,
                'usuario' => $usuario,
                'nivel' => $nivel,
                'Cursos' => $Cursos,
                'Paralelos' => $Paralelos
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function new($idSelect = null){
        if (session('idRol') == 1) {
            $Niveles = (new Nivel())->selectDisponibles('');
            if(!$idSelect){
                $idSelect = 0;
            }
            return view('Grado.create', [
                'headTitle' => 'GRADOS - NUEVO GRADO',
                'Titulos' => "NUEVO GRADO",
                'Niveles' => $Niveles,
                'idSelect' => $idSelect
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function store(GradoValidation $request)
    {
        if (session('idRol') == 1) {
            $grado = new Grado();
            $grado->nombreGrado = strtoupper($request->nombreGrado);
            $grado->posicionOrdinal = $request->posicionOrdinal;
            $grado->idNivel = $request->idNivel;
            $grado->idUsuario = session('idUsuario');
            $grado->save();
            return redirect()->route('grados.details', $grado);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function edit(Grado $grado)
    {
        if (session('idRol') == 1) {
            $Niveles = (new Nivel())->selectDisponibles('');
            return view('Grado.update', [
                'headTitle' => 'EDITAR - ' . $grado->nombreGrado,
                'grado' => $grado,
                'Niveles' => $Niveles,
                'Titulos' => "MODIFICAR AREA"
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }
    
    public function update(GradoValidation $request, Grado $grado)
    {
        if (session('idRol') == 1) {
            $grado->nombreGrado = strtoupper($request->nombreGrado);
            $grado->posicionOrdinal = $request->posicionOrdinal;
            $grado->idNivel = $request->idNivel;
            $grado->idUsuario = session('idUsuario');
            $grado->save();
            return redirect()->route('grados.details', $grado);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function delete(Request $request)
    {
        if (session('idRol') == 1) {
            $request->validate([
                'idGrado' => ['required','numeric','integer']
            ]);
            $grado = (new Grado())->selectGrado($request->idGrado);
            $grado->estado = '0';
            $grado->idUsuario = session('idUsuario');
            $grado->save();
            return redirect()->route('grados.index');
        }
        else{
            return redirect()->route('login');
        }
    }
}
