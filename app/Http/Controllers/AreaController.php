<?php

namespace App\Http\Controllers;

use App\Http\Requests\AreaValidation;
use App\Models\Area;
use App\Models\Usuario;
use App\Models\Campo;
use App\Models\Rol;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'Areas'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $tableArea = (new Area())->selectDisponibles($request->busqueda);
            return view('Area.inicio', [
                'headTitle' => 'AREAS - INICIO',
                'tableArea' => $tableArea,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }        
    }

    /**Muestra la información de un registro específico de la tabla 'Areas'.*/
    public function show($idArea)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $area = (new Area())->selectArea($idArea);
            $usuario = (new Usuario())->selectUsuario($area->idUsuario);
            $campo = (new Campo())->selectCampo($area->idCampo);
            $Materias = (new Area())->selectArea_Materias($idArea);

            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            return view('Area.detalle', [
                'headTitle' => $area->nombreArea,
                'area' => $area,
                'usuario' => $usuario,
                'campo' => $campo,
                'Materias' => $Materias

            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para CREAR un nuevo registro en la tabla 'Areas'.*/
    public function new($idSelect = null){
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $Campos = (new Campo())->selectDisponibles('');
            if(!$idSelect){
                $idSelect = 0;
            }
            return view('Area.create', [
                'headTitle' => 'AREAS - NUEVA AREA',
                'Titulos' => "NUEVA AREA",
                'Campos' => $Campos,
                'idSelect' => $idSelect
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar el registro creado de la tabla 'Areas' y retorna el método show() con el registro.*/
    public function store(AreaValidation $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $area = new Area();
            $area->nombreArea = strtoupper($request->nombreArea);
            $area->nombreCorto = strtoupper($request->nombreCorto);
            $area->idCampo = $request->idCampo;
            $area->idUsuario = session('idUsuario');
            $area->ip = session('ip');
            $area->dispositivo  = session('dispositivo');
            $area->save();
            return redirect()->route('areas.details', $area);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para ACTUALIZAR un registro existente de la tabla 'Areas'.*/
    public function edit(Area $area)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $Campos = (new Campo())->selectDisponibles('');
            return view('Area.update', [
                'headTitle' => 'EDITAR - ' . $area->nombreArea,
                'area' => $area,
                'Campos' => $Campos,
                'Titulos' => "MODIFICAR AREA"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'Areas' y retorna el método show() con el registro actualizado.*/
    public function update(AreaValidation $request, Area $area)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $area->nombreArea = strtoupper($request->nombreArea);
            $area->nombreCorto = strtoupper($request->nombreCorto);
            $area->idCampo = $request->idCampo;
            $area->idUsuario = session('idUsuario');
            $area->ip = session('ip');
            $area->dispositivo  = session('dispositivo');
            $area->save();
            return redirect()->route('areas.details', $area);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'Areas' y retorna el método index().*/
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idArea' => ['required','numeric','integer']
            ]);
            $area = (new Area())->selectArea($request->idArea);
            $area->estado = '0';
            $area->idUsuario = session('idUsuario');
            $area->ip = session('ip');
            $area->dispositivo  = session('dispositivo');
            $area->save();
            return redirect()->route('areas.index');
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
}
