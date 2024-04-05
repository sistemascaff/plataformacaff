<?php

namespace App\Http\Controllers;

use App\Models\Nivel;
use App\Models\Usuario;
use Illuminate\Http\Request;

class NivelController extends Controller
{
    public function index(Request $request)
    {
        if (session('idRol') == 1) {
            $tableNivel = (new Nivel())->selectDisponibles($request->busqueda);
            return view('Nivel.inicio', [
            'tableNivel' => $tableNivel,
            'busqueda' => $request->busqueda,
            'retrocederDirectorioAssets' => 1
        ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function show($idNivel)
    {
        if (session('idRol') == 1) {
            $nivel = (new Nivel())->selectNivel($idNivel);
            $usuario = (new Usuario())->selectUsuario($nivel->idUsuario);
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            $Grados = (new Nivel())->selectNivel_Grados($idNivel);
            return view('Nivel.detalle', [
                'nivel' => $nivel,
                'usuario' => $usuario,
                'Grados' => $Grados,
                'retrocederDirectorioAssets' => 2
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function new(){
        if (session('idRol') == 1) {
            return view('Nivel.create', [
                'Titulos' => "NUEVO NIVEL",
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
            $nivel = new Nivel();
            $nivel->nombreNivel = strtoupper($request->nombreNivel);
            $nivel->posicionOrdinal = $request->posicionOrdinal;
            $nivel->idUsuario = session('idUsuario');
            $nivel->save();
            return redirect()->route('niveles.details', $nivel);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function edit(Nivel $nivel)
    {
        if (session('idRol') == 1) {
            return view('Nivel.update', [
                'nivel' => $nivel,
                'Titulos' => "EDITAR NIVEL",
                'retrocederDirectorioAssets' => 3
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }
    
    public function update(Request $request, Nivel $nivel)
    {
        if (session('idRol') == 1) {
            $nivel->nombreNivel = strtoupper($request->nombreNivel);
            $nivel->posicionOrdinal = strtoupper($request->posicionOrdinal);
            $nivel->idUsuario = session('idUsuario');
            $nivel->save();
            return redirect()->route('niveles.details', $nivel);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function delete(Request $request)
    {
        if (session('idRol') == 1) {
            $nivel = (new Nivel())->selectNivel($request->idNivel);
            $nivel->estado = '0';
            $nivel->idUsuario = session('idUsuario');
            $nivel->save();
            return redirect()->route('niveles.index');
        }
        else{
            return redirect()->route('login');
        }
    }
}
