<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampoValidation;
use App\Models\Campo;
use App\Models\Usuario;
use Illuminate\Http\Request;

class CampoController extends Controller
{
    public function index(Request $request)
    {
        if (session('idRol') == 1) {
            $tableCampo = (new Campo())->selectDisponibles($request->busqueda);
            return view('Campo.inicio', [
                'headTitle' => 'CAMPOS - INICIO',
                'tableCampo' => $tableCampo,
                'busqueda' => $request->busqueda
            ]);
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
                'headTitle' => $campo->nombreCampo,
                'campo' => $campo,
                'usuario' => $usuario,
                'Areas' => $Areas
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function new(){
        if (session('idRol') == 1) {
            return view('Campo.create', [
                'headTitle' => 'CAMPOS - NUEVO CAMPO',
                'Titulos' => "NUEVO CAMPO"
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function store(CampoValidation $request)
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
                'headTitle' => 'EDITAR - ' . $campo->nombreCampo,
                'campo' => $campo,
                'Titulos' => "EDITAR CAMPO"
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }
    
    public function update(CampoValidation $request, Campo $campo)
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
            $request->validate([
                'idCampo' => ['required','numeric']
            ]);
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
