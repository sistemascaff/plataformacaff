<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnidadValidation;
use App\Models\Unidad;
use App\Models\Usuario;
use App\Models\Asignatura;
use App\Models\Periodo;
use App\Models\Rol;
use Illuminate\Http\Request;

class UnidadController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'Unidades'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $tableUnidad = (new Unidad())->selectDisponibles($request->busqueda);
            return view('Unidad.inicio', [
                'headTitle' => 'UNIDADES - INICIO',
                'tableUnidad' => $tableUnidad,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }        
    }

    /**Muestra la información de un registro específico de la tabla 'Unidades'.*/
    public function show($idUnidad)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $unidad = (new Unidad())->selectUnidad($idUnidad);
            $usuario = (new Usuario())->selectUsuario($unidad->idUsuario);
            $asignatura = (new Asignatura())->selectAsignatura($unidad->idAsignatura);
            $periodo = (new Periodo())->selectPeriodo($unidad->idPeriodo);
            $Silabos = (new Unidad())->selectUnidad_Silabos($idUnidad);

            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            return view('Unidad.detalle', [
                'headTitle' => $unidad->nombreUnidad,
                'unidad' => $unidad,
                'usuario' => $usuario,
                'asignatura' => $asignatura,
                'periodo' => $periodo,
                'Silabos' => $Silabos

            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para CREAR un nuevo registro en la tabla 'Unidades'.*/
    public function new($idSelect = null){
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $Asignaturas = (new Asignatura())->selectDisponibles('');
            $Periodos = (new Periodo())->selectDisponibles('');
            if(!$idSelect){
                $idSelect = 0;
            }
            return view('Unidad.create', [
                'headTitle' => 'UNIDADES - NUEVA UNIDAD',
                'Titulos' => "NUEVA UNIDAD",
                'Asignaturas' => $Asignaturas,
                'Periodos' => $Periodos,
                'idSelect' => $idSelect
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar el registro creado de la tabla 'Unidades' y retorna el método show() con el registro.*/
    public function store(UnidadValidation $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $unidad = new Unidad();
            $unidad->nombreUnidad = strtoupper($request->nombreUnidad);
            $unidad->posicionOrdinal = $request->posicionOrdinal;
            $unidad->idAsignatura = $request->idAsignatura;
            $unidad->idPeriodo = $request->idPeriodo;
            $unidad->idUsuario = session('idUsuario');
            $unidad->ip = session('ip');
            $unidad->dispositivo  = session('dispositivo');
            $unidad->save();
            return redirect()->route('unidades.details', $unidad);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para ACTUALIZAR un registro existente de la tabla 'Unidades'.*/
    public function edit(Unidad $unidad)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $Asignaturas = (new Asignatura())->selectDisponibles('');
            $Periodos = (new Periodo())->selectDisponibles('');
            return view('Unidad.update', [
                'headTitle' => 'EDITAR - ' . $unidad->nombreUnidad,
                'unidad' => $unidad,
                'Asignaturas' => $Asignaturas,
                'Periodos' => $Periodos,
                'Titulos' => "MODIFICAR UNIDAD"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'Unidades' y retorna el método show() con el registro actualizado.*/
    public function update(UnidadValidation $request, Unidad $unidad)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $unidad->nombreUnidad = strtoupper($request->nombreUnidad);
            $unidad->posicionOrdinal = $request->posicionOrdinal;
            $unidad->idAsignatura = $request->idAsignatura;
            $unidad->idPeriodo = $request->idPeriodo;
            $unidad->idUsuario = session('idUsuario');
            $unidad->ip = session('ip');
            $unidad->dispositivo  = session('dispositivo');
            $unidad->save();
            return redirect()->route('unidades.details', $unidad);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'Unidades' y retorna el método index().*/
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idUnidad' => ['required','numeric','integer']
            ]);
            $unidad = (new Unidad())->selectUnidad($request->idUnidad);
            $unidad->estado = '0';
            $unidad->idUsuario = session('idUsuario');
            $unidad->ip = session('ip');
            $unidad->dispositivo  = session('dispositivo');
            $unidad->save();
            return redirect()->route('unidades.index');
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
}
