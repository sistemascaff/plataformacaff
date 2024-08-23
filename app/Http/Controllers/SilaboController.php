<?php

namespace App\Http\Controllers;

use App\Http\Requests\SilaboValidation;
use App\Models\Asignatura;
use App\Models\Silabo;
use App\Models\Usuario;
use App\Models\Unidad;
use App\Models\Periodo;
use App\Models\Rol;
use Illuminate\Http\Request;

class SilaboController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'Silabos'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $tableSilabo = (new Silabo())->selectDisponibles($request->busqueda);
            return view('Silabo.inicio', [
                'headTitle' => 'SILABOS - INICIO',
                'tableSilabo' => $tableSilabo,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }        
    }

    /**Muestra la información de un registro específico de la tabla 'Silabos'.*/
    public function show($idSilabo)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $silabo = (new Silabo())->selectSilabo($idSilabo);
            $usuario = (new Usuario())->selectUsuario($silabo->idUsuario);
            $unidad = (new Unidad())->selectUnidad($silabo->idUnidad);
            $periodo = (new Periodo())->selectPeriodo($unidad->idPeriodo);
            $asignatura = (new Asignatura())->selectAsignatura($unidad->idAsignatura);

            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            return view('Silabo.detalle', [
                'headTitle' => $silabo->nombreSilabo,
                'silabo' => $silabo,
                'usuario' => $usuario,
                'unidad' => $unidad,
                'periodo' => $periodo,
                'asignatura' => $asignatura
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para CREAR un nuevo registro en la tabla 'Silabos'.*/
    public function new($idSelect = null){
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $Unidades = (new Unidad())->selectDisponibles('');
            if(!$idSelect){
                $idSelect = 0;
            }
            return view('Silabo.create', [
                'headTitle' => 'SILABOS - NUEVO SILABO',
                'Titulos' => "NUEVO SILABO",
                'Unidades' => $Unidades,
                'idSelect' => $idSelect
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar el registro creado de la tabla 'Silabos' y retorna el método show() con el registro.*/
    public function store(SilaboValidation $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $silabo = new Silabo();
            $silabo->nombreSilabo = strtoupper($request->nombreSilabo);
            $silabo->idUnidad = $request->idUnidad;
            $silabo->idUsuario = session('idUsuario');
            $silabo->ip = session('ip');
            $silabo->dispositivo  = session('dispositivo');
            $silabo->save();
            return redirect()->route('silabos.details', $silabo);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para ACTUALIZAR un registro existente de la tabla 'Silabos'.*/
    public function edit(Silabo $silabo)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $Unidades = (new Unidad())->selectDisponibles('');
            return view('Silabo.update', [
                'headTitle' => 'EDITAR - ' . $silabo->nombreSilabo,
                'silabo' => $silabo,
                'Unidades' => $Unidades,
                'Titulos' => "MODIFICAR SILABO"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'Silabos' y retorna el método show() con el registro actualizado.*/
    public function update(SilaboValidation $request, Silabo $silabo)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $silabo->nombreSilabo = strtoupper($request->nombreSilabo);
            $silabo->idUnidad = $request->idUnidad;
            $silabo->idUsuario = session('idUsuario');
            $silabo->ip = session('ip');
            $silabo->dispositivo  = session('dispositivo');
            $silabo->save();
            return redirect()->route('silabos.details', $silabo);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'Silabos' y retorna el método index().*/
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idSilabo' => ['required','numeric','integer']
            ]);
            $silabo = (new Silabo())->selectSilabo($request->idSilabo);
            $silabo->estado = '-1';
            $silabo->idUsuario = session('idUsuario');
            $silabo->ip = session('ip');
            $silabo->dispositivo  = session('dispositivo');
            $silabo->save();
            return redirect()->route('silabos.index');
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
    /**Método que permite ACTUALIZAR el atributo estado de un registro de la tabla 'Silabos' y retorna el método index().*/
    public function actualizarEstado(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idSilabo' => ['required','numeric','integer']
            ]);
            $silabo = (new Silabo())->selectSilabo($request->idSilabo);
            switch ($silabo->estado) {
                case '0':
                    $silabo->estado = '1';
                    $silabo->fechaInicio = date('Y-m-d H:i:s');
                    break;
                case '1':
                    $silabo->estado = '2';
                    $silabo->fechaFin = date('Y-m-d H:i:s');
                    break;
                case '2':
                    $silabo->estado = '0';
                    $silabo->fechaInicio = null;
                    $silabo->fechaFin = null;
                    break;
                default:
                    break;
            }
            $silabo->idUsuario = session('idUsuario');
            $silabo->ip = session('ip');
            $silabo->dispositivo  = session('dispositivo');
            $silabo->save();
            return redirect()->back()->with('mensaje','OK.');
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
}
