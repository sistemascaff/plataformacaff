<?php

namespace App\Http\Controllers;

use App\Http\Requests\MateriaValidation;
use App\Models\Materia;
use App\Models\Usuario;
use App\Models\Area;
use App\Models\Rol;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'Materias'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $tableMateria = (new Materia())->selectDisponibles($request->busqueda);
            return view('Materia.inicio', [
                'headTitle' => 'MATERIAS - INICIO',
                'tableMateria' => $tableMateria,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }        
    }

    /**Muestra la información de un registro específico de la tabla 'Materias'.*/
    public function show($idMateria)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $materia = (new Materia())->selectMateria($idMateria);
            $usuario = (new Usuario())->selectUsuario($materia->idUsuario);
            $area = (new Area())->selectArea($materia->idArea);

            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            return view('Materia.detalle', [
                'headTitle' => $materia->nombreMateria,
                'materia' => $materia,
                'usuario' => $usuario,
                'area' => $area
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para CREAR un nuevo registro en la tabla 'Materias'.*/
    public function new($idSelect = null){
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $Areas = (new Area())->selectDisponibles('');
            if(!$idSelect){
                $idSelect = 0;
            }
            return view('Materia.create', [
                'headTitle' => 'MATERIAS - NUEVA MATERIA',
                'Titulos' => "NUEVA MATERIA",
                'Areas' => $Areas,
                'idSelect' => $idSelect
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar el registro creado de la tabla 'Materias' y retorna el método show() con el registro.*/
    public function store(MateriaValidation $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $materia = new Materia();
            $materia->nombreMateria = strtoupper($request->nombreMateria);
            $materia->nombreCorto = strtoupper($request->nombreCorto);
            $materia->posicionOrdinal = $request->posicionOrdinal;
            $materia->idArea = $request->idArea;
            $materia->idUsuario = session('idUsuario');
            $materia->ip = session('ip');
            $materia->dispositivo = session('dispositivo');
            $materia->save();
            return redirect()->route('materias.details', $materia);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para ACTUALIZAR un registro existente de la tabla 'Materias'.*/
    public function edit(Materia $materia)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $Areas = (new Area())->selectDisponibles('');
            return view('Materia.update', [
                'headTitle' => 'EDITAR - ' . $materia->nombreMateria,
                'materia' => $materia,
                'Areas' => $Areas,
                'Titulos' => "MODIFICAR MATERIA"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
    
    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'Materias' y retorna el método show() con el registro actualizado.*/
    public function update(MateriaValidation $request, Materia $materia)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $materia->nombreMateria = strtoupper($request->nombreMateria);
            $materia->nombreCorto = strtoupper($request->nombreCorto);
            $materia->posicionOrdinal = $request->posicionOrdinal;
            $materia->idArea = $request->idArea;
            $materia->idUsuario = session('idUsuario');
            $materia->ip = session('ip');
            $materia->dispositivo = session('dispositivo');
            $materia->save();
            return redirect()->route('materias.details', $materia);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'Materias' y retorna el método index().*/
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idMateria' => ['required','numeric','integer']
            ]);
            $materia = (new Materia())->selectMateria($request->idMateria);
            $materia->estado = '0';
            $materia->idUsuario = session('idUsuario');
            $materia->ip = session('ip');
            $materia->dispositivo = session('dispositivo');
            $materia->save();
            return redirect()->route('materias.index');
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
}
