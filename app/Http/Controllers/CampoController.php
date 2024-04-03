<?php

namespace App\Http\Controllers;

use App\Models\Campo;
use App\Models\Usuario;
use Illuminate\Http\Request;

class CampoController extends Controller
{
    public function index()
    {
        if (session('idRol') == 1) {
            $tableCampo = (new Campo())->selectDisponibles();
            return view('Campo.inicio', ['tableCampo' => $tableCampo, 'retrocederDirectorioAssets' => 1]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function show($idCampo)
    {
        if (session('idRol') == 1) {
            $campo = (new Campo())->selectCampo($idCampo);
            $usuario = (new Usuario())->selectUsuario($campo->idUsuario);
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            $Areas = (new Campo())->selectCampo_Areas($idCampo);
            return view('Campo.detalle', [
                'campo' => $campo,
                'usuario' => $usuario,
                'Areas' => $Areas,
                'retrocederDirectorioAssets' => 2
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function new(){
        if (session('idRol') == 1) {
            return view('Campo.create', [
                'Titulos' => "NUEVO CAMPO",
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
            $campo = new Campo();
            $campo->nombreCampo = strtoupper($request->nombreCampo);
            $campo->idUsuario = session('idUsuario');
            $campo->save();
            return redirect()->route('campos.details', $campo);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function edit(Campo $campo)
    {
        if (session('idRol') == 1) {
            return view('Campo.update', [
                'campo' => $campo,
                'Titulos' => "EDITAR CAMPO",
                'retrocederDirectorioAssets' => 3
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }
    
    public function update(Request $request, Campo $campo)
    {
        if (session('idRol') == 1) {
            $campo->nombreCampo = strtoupper($request->nombreCampo);
            $campo->idUsuario = session('idUsuario');
            $campo->save();
            return redirect()->route('campos.details', $campo);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function delete(Request $request)
    {
        if (session('idRol') == 1) {
            $campo = (new Campo())->selectCampo($request->idCampo);
            $campo->estado = '0';
            $campo->idUsuario = session('idUsuario');
            $campo->save();
            return redirect()->route('campos.index');
        }
        else{
            return redirect()->route('login');
        }
    }
}
