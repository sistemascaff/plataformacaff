<?php

namespace App\Http\Controllers;

use App\Http\Requests\PresentacionValidation;
use App\Models\Presentacion;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;

class PresentacionController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'Presentaciones'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $tablePresentacion = (new Presentacion())->selectDisponibles($request->busqueda);
            return view('Presentacion.inicio', [
                'headTitle' => 'PRESENTACIONES - INICIO',
                'tablePresentacion' => $tablePresentacion,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }        
    }

    /**Muestra la información de un registro específico de la tabla 'Presentaciones'.*/
    public function show($idPresentacion)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $presentacion = (new Presentacion())->selectPresentacion($idPresentacion);
            $usuario = (new Usuario())->selectUsuario($presentacion->idUsuario);
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            $Libros = (new Presentacion())->selectPresentacion_Libros($idPresentacion);
            return view('Presentacion.detalle', [
                'headTitle' => $presentacion->nombrePresentacion,
                'presentacion' => $presentacion,
                'usuario' => $usuario,
                'Libros' => $Libros
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para CREAR un nuevo registro en la tabla 'Presentaciones'.*/
    public function new(){
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            return view('Presentacion.create', [
                'headTitle' => 'PRESENTACIONES - NUEVA PRESENTACION',
                'Titulos' => "NUEVA PRESENTACION"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar el registro creado de la tabla 'Presentaciones' y retorna el método show() con el registro.*/
    public function store(PresentacionValidation $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $presentacion = new Presentacion();
            $presentacion->nombrePresentacion = strtoupper($request->nombrePresentacion);
            $presentacion->idUsuario = session('idUsuario');
            $presentacion->ip = session('ip');
            $presentacion->dispositivo = session('dispositivo');
            $presentacion->save();
            return redirect()->route('presentaciones.details', $presentacion);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para ACTUALIZAR un registro existente de la tabla 'Presentaciones'.*/
    public function edit(Presentacion $presentacion)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            return view('Presentacion.update', [
                'headTitle' => 'EDITAR - ' . $presentacion->nombrePresentacion,
                'presentacion' => $presentacion,
                'Titulos' => "MODIFICAR PRESENTACION"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
    
    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'Presentaciones' y retorna el método show() con el registro actualizado.*/
    public function update(PresentacionValidation $request, Presentacion $presentacion)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $presentacion->nombrePresentacion = strtoupper($request->nombrePresentacion);
            $presentacion->idUsuario = session('idUsuario');
            $presentacion->ip = session('ip');
            $presentacion->dispositivo = session('dispositivo');
            $presentacion->save();
            return redirect()->route('presentaciones.details', $presentacion);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'Presentaciones' y retorna el método index().*/
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idPresentacion' => ['required','numeric','integer']
            ]);
            $presentacion = (new Presentacion())->selectPresentacion($request->idPresentacion);
            $presentacion->estado = '0';
            $presentacion->idUsuario = session('idUsuario');
            $presentacion->ip = session('ip');
            $presentacion->dispositivo = session('dispositivo');
            $presentacion->save();
            return redirect()->route('presentaciones.index');
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
}
