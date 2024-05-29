<?php

namespace App\Http\Controllers;

use App\Http\Requests\DimensionValidation;
use App\Models\Dimension;
use App\Models\Usuario;
use App\Models\Periodo;
use App\Models\Rol;
use Illuminate\Http\Request;

class DimensionController extends Controller
{
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

    public function show($idDimension)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $dimension = (new Dimension())->selectDimension($idDimension);
            $usuario = (new Usuario())->selectUsuario($dimension->idUsuario);
            $periodo = (new Periodo())->selectPeriodo($dimension->idPeriodo);
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            return view('Dimension.detalle', [
                'headTitle' => $dimension->nombreDimension,
                'dimension' => $dimension,
                'usuario' => $usuario,
                'periodo' => $periodo
            ]);
        } else {
            return redirect()->route('usuarios.index');
        }
    }

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
