<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialValidation;
use App\Models\Material;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'Materiales'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $tableMaterial = (new Material())->selectDisponibles($request->busqueda);
            return view('Material.inicio', [
                'headTitle' => 'MATERIALES - INICIO',
                'tableMaterial' => $tableMaterial,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }        
    }

    /**Muestra la información de un registro específico de la tabla 'Materiales'.*/
    public function show($idMaterial)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $material = (new Material())->selectMaterial($idMaterial);
            $usuario = (new Usuario())->selectUsuario($material->idUsuario);
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            return view('Material.detalle', [
                'headTitle' => $material->nombreMaterial,
                'material' => $material,
                'usuario' => $usuario
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para CREAR un nuevo registro en la tabla 'Materiales'.*/
    public function new(){
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            return view('Material.create', [
                'headTitle' => 'MATERIALES - NUEVO MATERIAL',
                'Titulos' => "NUEVO MATERIAL"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar el registro creado de la tabla 'Materiales' y retorna el método show() con el registro.*/
    public function store(MaterialValidation $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $material = new Material();
            $material->nombreMaterial = strtoupper($request->nombreMaterial);
            $material->idUsuario = session('idUsuario');
            $material->ip = session('ip');
            $material->dispositivo = session('dispositivo');
            $material->save();
            return redirect()->route('materiales.details', $material);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para ACTUALIZAR un registro existente de la tabla 'Materiales'.*/
    public function edit(Material $material)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            return view('Material.update', [
                'headTitle' => 'EDITAR - ' . $material->nombreMaterial,
                'material' => $material,
                'Titulos' => "MODIFICAR MATERIAL"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
    
    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'Materiales' y retorna el método show() con el registro actualizado.*/
    public function update(MaterialValidation $request, Material $material)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $material->nombreMaterial = strtoupper($request->nombreMaterial);
            $material->idUsuario = session('idUsuario');
            $material->ip = session('ip');
            $material->dispositivo = session('dispositivo');
            $material->save();
            return redirect()->route('materiales.details', $material);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'Materiales' y retorna el método index().*/
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idMaterial' => ['required','numeric','integer']
            ]);
            $material = (new Material())->selectMaterial($request->idMaterial);
            $material->estado = '0';
            $material->idUsuario = session('idUsuario');
            $material->ip = session('ip');
            $material->dispositivo = session('dispositivo');
            $material->save();
            return redirect()->route('materiales.index');
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
}
