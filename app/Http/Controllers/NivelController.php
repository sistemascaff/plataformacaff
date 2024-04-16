<?php

namespace App\Http\Controllers;

use App\Http\Requests\NivelValidation;
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
            'headTitle' => 'NIVELES - INICIO',
            'tableNivel' => $tableNivel,
            'busqueda' => $request->busqueda
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
                'headTitle' => $nivel->nombreNivel,
                'nivel' => $nivel,
                'usuario' => $usuario,
                'Grados' => $Grados
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function new(){
        if (session('idRol') == 1) {
            return view('Nivel.create', [
                'headTitle' => 'NIVELES - NUEVO NIVEL',
                'Titulos' => "NUEVO NIVEL"
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function store(NivelValidation $request)
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
                'headTitle' => 'EDITAR - ' . $nivel->nombreNivel,
                'nivel' => $nivel,
                'Titulos' => "EDITAR NIVEL"
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }
    
    public function update(NivelValidation $request, Nivel $nivel)
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
            $request->validate([
                'idNivel' => ['required','numeric']
            ]);
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
