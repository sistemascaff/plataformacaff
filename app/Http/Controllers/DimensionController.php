<?php

namespace App\Http\Controllers;

use App\Http\Requests\DimensionValidation;
use App\Models\Dimension;
use App\Models\Usuario;
use App\Models\Periodo;
use App\Models\Gestion;
use App\Models\Rol;
use Illuminate\Http\Request;

class DimensionController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'Dimensiones'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $tableDimension = (new Dimension())->selectDisponibles($request->busqueda);
            return view('Dimension.inicio', [
                'headTitle' => 'DIMENSIONES - INICIO',
                'tableDimension' => $tableDimension,
                'busqueda' => $request->busqueda
            ]);
        } else {
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra la información de un registro específico de la tabla 'Dimensiones'.*/
    public function show($idDimension)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $dimension = (new Dimension())->selectDimension($idDimension);
            $usuario = (new Usuario())->selectUsuario($dimension->idUsuario);
            $periodo = (new Periodo())->selectPeriodo($dimension->idPeriodo);
            $gestion = (new Gestion())->selectGestion($periodo->idGestion);
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            return view('Dimension.detalle', [
                'headTitle' => $dimension->nombreDimension,
                'dimension' => $dimension,
                'usuario' => $usuario,
                'periodo' => $periodo,
                'gestion' => $gestion
            ]);
        } else {
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para CREAR un nuevo registro en la tabla 'Dimensiones'.*/
    public function new($idSelect = null)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $Periodos = (new Periodo())->selectDisponibles('');
            if (!$idSelect) {
                $idSelect = 0;
            }
            return view('Dimension.create', [
                'headTitle' => 'DIMENSIONES - NUEVO DIMENSION',
                'Titulos' => "NUEVO DIMENSION",
                'Periodos' => $Periodos,
                'idSelect' => $idSelect
            ]);
        } else {
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar el registro creado de la tabla 'Dimensiones' y retorna el método show() con el registro.*/
    public function store(DimensionValidation $request)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $dimension = new Dimension();
            $dimension->nombreDimension = strtoupper($request->nombreDimension);
            $dimension->puntajeMaximo = $request->puntajeMaximo;
            $dimension->tipoCalculo = $request->tipoCalculo;
            $dimension->idPeriodo = $request->idPeriodo;
            $dimension->idUsuario = session('idUsuario');
            $dimension->ip = session('ip');
            $dimension->dispositivo = session('dispositivo');
            $dimension->save();
            return redirect()->route('dimensiones.details', $dimension);
        } else {
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para ACTUALIZAR un registro existente de la tabla 'Dimensiones'.*/
    public function edit(Dimension $dimension)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $Periodos = (new Periodo())->selectDisponibles('');
            return view('Dimension.update', [
                'headTitle' => 'EDITAR - ' . $dimension->nombreDimension,
                'dimension' => $dimension,
                'Periodos' => $Periodos,
                'Titulos' => "MODIFICAR AREA"
            ]);
        } else {
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'Dimensiones' y retorna el método show() con el registro actualizado.*/
    public function update(DimensionValidation $request, Dimension $dimension)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $dimension->nombreDimension = strtoupper($request->nombreDimension);
            $dimension->puntajeMaximo = $request->puntajeMaximo;
            $dimension->tipoCalculo = $request->tipoCalculo;
            $dimension->idPeriodo = $request->idPeriodo;
            $dimension->idUsuario = session('idUsuario');
            $dimension->ip = session('ip');
            $dimension->dispositivo = session('dispositivo');
            $dimension->save();
            return redirect()->route('dimensiones.details', $dimension);
        } else {
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'Dimensiones' y retorna el método index().*/
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $request->validate([
                'idDimension' => ['required', 'numeric', 'integer']
            ]);
            $dimension = (new Dimension())->selectDimension($request->idDimension);
            $dimension->estado = '0';
            $dimension->idUsuario = session('idUsuario');
            $dimension->ip = session('ip');
            $dimension->dispositivo = session('dispositivo');
            $dimension->save();
            return redirect()->route('dimensiones.index');
        } else {
            return redirect()->route('usuarios.index');
        }
    }
}
