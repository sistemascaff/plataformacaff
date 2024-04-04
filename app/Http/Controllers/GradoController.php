<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use App\Models\Usuario;
use App\Models\Nivel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Can;

class GradoController extends Controller
{
    public function index()
    {
        if (session('idRol') == 1) {
            $tableGrado = (new Grado())->selectDisponibles();
            return view('Grado.inicio', ['tableGrado' => $tableGrado, 'retrocederDirectorioAssets' => 1]);
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
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            return view('Grado.detalle', [
                'grado' => $grado,
                'usuario' => $usuario,
                'nivel' => $nivel,
                'Cursos' => $Cursos,
                'retrocederDirectorioAssets' => 2
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function new($idSelect = null){
        if (session('idRol') == 1) {
            $valorAssets = 3;
            $Niveles = (new Nivel())->selectDisponibles();
            if(!$idSelect){
                $idSelect = 0;
                $valorAssets = 2;
            }
            return view('Grado.create', [
                'Titulos' => "NUEVO GRADO",
                'Niveles' => $Niveles,
                'idSelect' => $idSelect,
                'retrocederDirectorioAssets' => $valorAssets
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function store(Request $request)
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
            $Niveles = (new Nivel())->selectDisponibles();
            return view('Grado.update', [
                'grado' => $grado,
                'Niveles' => $Niveles,
                'Titulos' => "MODIFICAR AREA",
                'retrocederDirectorioAssets' => 3
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }
    
    public function update(Request $request, Grado $grado)
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
