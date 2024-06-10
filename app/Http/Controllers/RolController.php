<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function store(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $rol = new Rol();
            $rol->idUsuario = $request->idUsuario;
            if ($request->tipoPerfil == "ESTUDIANTE") {
                $rol->estudiante = 1;
            }
            elseif($request->tipoPerfil == "SUBDIRECTOR"){
                $rol->subdirector = 1;
                $rol->coordinador = 0;
                $rol->profesor = 1;
            }
            elseif($request->tipoPerfil == "COORDINADOR"){
                $rol->subdirector = 0;
                $rol->coordinador = 1;
                $rol->profesor = 1;
            }
            elseif($request->tipoPerfil == "PROFESOR"){
                $rol->profesor = 1;
            }
            $rol->idUsuarioResponsable = session('idUsuario');
            $rol->ip = session('ip');
            $rol->dispositivo = session('dispositivo');
            $rol->save();
            return $rol;
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
    public function update(Request $request, $idRol)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $rol = (new Rol)->selectRol($idRol);
            $rol->idUsuario = $request->idUsuario;
            if ($request->tipoPerfil == "ESTUDIANTE") {
                $rol->estudiante = 1;
            }
            elseif($request->tipoPerfil == "SUBDIRECTOR"){
                $rol->subdirector = 1;
                $rol->coordinador = 0;
                $rol->profesor = 1;
            }
            elseif($request->tipoPerfil == "COORDINADOR"){
                $rol->subdirector = 0;
                $rol->coordinador = 1;
                $rol->profesor = 1;
            }
            elseif($request->tipoPerfil == "PROFESOR"){
                $rol->profesor = 1;
            }
            $rol->idUsuarioResponsable = session('idUsuario');
            $rol->ip = session('ip');
            $rol->dispositivo = session('dispositivo');
            $rol->save();
            return $rol;
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idRol' => ['required','numeric','integer']
            ]);
            $rol = (new Rol())->selectRol($request->idRol);
            $rol->estado = '0';
            $rol->idUsuarioResponsable = session('idUsuario');
            $rol->ip = session('ip');
            $rol->dispositivo = session('dispositivo');
            $rol->save();
            return $rol;
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
}
