<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoordinacionValidation;
use App\Models\Coordinacion;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;

class CoordinacionController extends Controller
{
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $tableCoordinacion = (new Coordinacion())->selectDisponibles($request->busqueda);
            return view('coordinacion.inicio', [
                'headTitle' => 'COORDINACIONES - INICIO',
                'tableCoordinacion' => $tableCoordinacion,
                'busqueda' => $request->busqueda
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    public function show($idCoordinacion)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $coordinacion = (new Coordinacion())->selectCoordinacion($idCoordinacion);
            $usuario = (new Usuario())->selectUsuario($coordinacion->idUsuario);
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            $Asignaturas = (new Coordinacion())->selectCoordinacion_Asignaturas($idCoordinacion);
            return view('coordinacion.detalle', [
                'headTitle' => $coordinacion->nombreCoordinacion,
                'coordinacion' => $coordinacion,
                'usuario' => $usuario,
                'Asignaturas' => $Asignaturas
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    public function new(){
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            return view('coordinacion.create', [
                'headTitle' => 'COORDINACIONES - NUEVO COORDINACION',
                'Titulos' => "NUEVO COORDINACION"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    public function store(CoordinacionValidation $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $coordinacion = new Coordinacion();
            $coordinacion->nombreCoordinacion = strtoupper($request->nombreCoordinacion);
            $coordinacion->idUsuario = session('idUsuario');
            $coordinacion->ip = session('ip');
            $coordinacion->dispositivo = session('dispositivo');
            $coordinacion->save();
            return redirect()->route('coordinaciones.details', $coordinacion);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    public function edit(Coordinacion $coordinacion)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            return view('coordinacion.update', [
                'headTitle' => 'EDITAR - ' . $coordinacion->nombreCoordinacion,
                'coordinacion' => $coordinacion,
                'Titulos' => "EDITAR COORDINACION"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
    
    public function update(CoordinacionValidation $request, Coordinacion $coordinacion)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $coordinacion->nombreCoordinacion = strtoupper($request->nombreCoordinacion);
            $coordinacion->idUsuario = session('idUsuario');
            $coordinacion->ip = session('ip');
            $coordinacion->dispositivo = session('dispositivo');
            $coordinacion->save();
            return redirect()->route('coordinaciones.details', $coordinacion);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idCoordinacion' => ['required','numeric','integer']
            ]);
            $coordinacion = (new Coordinacion())->selectCoordinacion($request->idCoordinacion);
            $coordinacion->estado = '0';
            $coordinacion->idUsuario = session('idUsuario');
            $coordinacion->ip = session('ip');
            $coordinacion->dispositivo = session('dispositivo');
            $coordinacion->save();
            return redirect()->route('coordinaciones.index');
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
}
