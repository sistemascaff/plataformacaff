<?php

namespace App\Http\Controllers;

use App\Http\Requests\NivelValidation;
use App\Models\Nivel;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;

class NivelController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'Niveles'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $tableNivel = (new Nivel())->selectDisponibles($request->busqueda);
            return view('Nivel.inicio', [
            'headTitle' => 'NIVELES - INICIO',
            'tableNivel' => $tableNivel,
            'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra la información de un registro específico de la tabla 'Niveles'.*/
    public function show($idNivel)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
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
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para CREAR un nuevo registro en la tabla 'Niveles'.*/
    public function new(){
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            return view('Nivel.create', [
                'headTitle' => 'NIVELES - NUEVO NIVEL',
                'Titulos' => "NUEVO NIVEL"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar el registro creado de la tabla 'Niveles' y retorna el método show() con el registro.*/
    public function store(NivelValidation $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $nivel = new Nivel();
            $nivel->nombreNivel = strtoupper($request->nombreNivel);
            $nivel->posicionOrdinal = $request->posicionOrdinal;
            $nivel->idUsuario = session('idUsuario');
            $nivel->ip = session('ip');
            $nivel->dispositivo = session('dispositivo');
            $nivel->save();
            return redirect()->route('niveles.details', $nivel);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para ACTUALIZAR un registro existente de la tabla 'Niveles'.*/
    public function edit(Nivel $nivel)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            return view('Nivel.update', [
                'headTitle' => 'EDITAR - ' . $nivel->nombreNivel,
                'nivel' => $nivel,
                'Titulos' => "EDITAR NIVEL"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
    
    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'Niveles' y retorna el método show() con el registro actualizado.*/
    public function update(NivelValidation $request, Nivel $nivel)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $nivel->nombreNivel = strtoupper($request->nombreNivel);
            $nivel->posicionOrdinal = strtoupper($request->posicionOrdinal);
            $nivel->idUsuario = session('idUsuario');
            $nivel->ip = session('ip');
            $nivel->dispositivo = session('dispositivo');
            $nivel->save();
            return redirect()->route('niveles.details', $nivel);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'Niveles' y retorna el método index().*/
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idNivel' => ['required','numeric','integer']
            ]);
            $nivel = (new Nivel())->selectNivel($request->idNivel);
            $nivel->estado = '0';
            $nivel->idUsuario = session('idUsuario');
            $nivel->ip = session('ip');
            $nivel->dispositivo = session('dispositivo');
            $nivel->save();
            return redirect()->route('niveles.index');
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
}
