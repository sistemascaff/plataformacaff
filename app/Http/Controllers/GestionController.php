<?php

namespace App\Http\Controllers;

use App\Http\Requests\GestionValidation;
use App\Models\Gestion;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;

class GestionController extends Controller
{
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $tableGestion = (new Gestion())->selectDisponibles($request->busqueda);
            return view('Gestion.inicio', [
                'headTitle' => 'GESTIONES - INICIO',
                'tableGestion' => $tableGestion,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }        
    }

    public function show($idGestion)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $gestion = (new Gestion())->selectGestion($idGestion);
            $usuario = (new Usuario())->selectUsuario($gestion->idUsuario);
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            $Periodos = (new Gestion())->selectGestion_Periodos($idGestion);
            return view('Gestion.detalle', [
                'headTitle' => $gestion->anhoGestion,
                'gestion' => $gestion,
                'usuario' => $usuario,
                'Periodos' => $Periodos
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    public function new(){
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            return view('Gestion.create', [
                'headTitle' => 'GESTIONES - NUEVO GESTION',
                'Titulos' => "NUEVO GESTION"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    public function store(GestionValidation $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $gestion = new Gestion();
            $gestion->anhoGestion = strtoupper($request->anhoGestion);
            $gestion->idUsuario = session('idUsuario');
            $gestion->ip = session('ip');
            $gestion->dispositivo = session('dispositivo');
            $gestion->save();
            return redirect()->route('gestiones.details', $gestion);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    public function edit(Gestion $gestion)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            return view('Gestion.update', [
                'headTitle' => 'EDITAR - ' . $gestion->anhoGestion,
                'gestion' => $gestion,
                'Titulos' => "MODIFICAR GESTION"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
    
    public function update(GestionValidation $request, Gestion $gestion)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $gestion->anhoGestion = strtoupper($request->anhoGestion);
            $gestion->idUsuario = session('idUsuario');
            $gestion->ip = session('ip');
            $gestion->dispositivo = session('dispositivo');
            $gestion->save();
            return redirect()->route('gestiones.details', $gestion);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idGestion' => ['required','numeric','integer']
            ]);
            $gestion = (new Gestion())->selectGestion($request->idGestion);
            $gestion->estado = '0';
            $gestion->idUsuario = session('idUsuario');
            $gestion->ip = session('ip');
            $gestion->dispositivo = session('dispositivo');
            $gestion->save();
            return redirect()->route('gestiones.index');
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
}
