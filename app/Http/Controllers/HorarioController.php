<?php

namespace App\Http\Controllers;

use App\Http\Requests\HorarioValidation;
use App\Models\Horario;
use App\Models\Usuario;
use App\Models\Asignatura;
use App\Models\Rol;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'Horarios'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $tableHorario = (new Horario())->selectDisponibles($request->busqueda);
            return view('Horario.inicio', [
                'headTitle' => 'HORARIOS - INICIO',
                'tableHorario' => $tableHorario,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('dashboard');
        }        
    }

    /**Muestra la información de un registro específico de la tabla 'Horarios'.*/
    public function show($idHorario)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $horario = (new Horario())->selectHorario($idHorario);
            $usuario = (new Usuario())->selectUsuario($horario->idUsuario);
            $asignatura = (new Asignatura())->selectAsignatura($horario->idAsignatura);
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            return view('Horario.detalle', [
                'headTitle' => 'HORARIO DE ' . $asignatura->nombreAsignatura,
                'horario' => $horario,
                'usuario' => $usuario,
                'asignatura' => $asignatura
            ]);
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    /**Muestra el formulario con los atributos requeridos para CREAR un nuevo registro en la tabla 'Horarios'.*/
    public function new($idSelect = null){
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $Asignaturas = (new Asignatura())->selectDisponibles('');
            if(!$idSelect){
                $idSelect = 0;
            }
            return view('Horario.create', [
                'headTitle' => 'HORARIOS - NUEVO HORARIO',
                'Titulos' => "NUEVO HORARIO",
                'Asignaturas' => $Asignaturas,
                'idSelect' => $idSelect
            ]);
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    /**Método que permite almacenar el registro creado de la tabla 'Horarios' y retorna el método show() con el registro.*/
    public function store(HorarioValidation $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $horario = new Horario();
            $horario->dia = $request->dia;
            $horario->horaInicio = $request->horaInicio;
            $horario->horaFin = $request->horaFin;
            $horario->idAsignatura = $request->idAsignatura;
            $horario->idUsuario = session('idUsuario');
            $horario->ip = session('ip');
            $horario->dispositivo  = session('dispositivo');
            $horario->save();
            return redirect()->route('horarios.details', $horario);
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    /**Muestra el formulario con los atributos requeridos para ACTUALIZAR un registro existente de la tabla 'Horarios'.*/
    public function edit(Horario $horario)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $Asignaturas = (new Asignatura())->selectDisponibles('');
            return view('Horario.update', [
                'headTitle' => 'HORARIO - EDITAR',
                'horario' => $horario,
                'Asignaturas' => $Asignaturas,
                'Titulos' => "MODIFICAR HORARIO"
            ]);
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'Horarios' y retorna el método show() con el registro actualizado.*/
    public function update(HorarioValidation $request, Horario $horario)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $horario->dia = $request->dia;
            $horario->horaInicio = $request->horaInicio;
            $horario->horaFin = $request->horaFin;
            $horario->idAsignatura = $request->idAsignatura;
            $horario->idUsuario = session('idUsuario');
            $horario->ip = session('ip');
            $horario->dispositivo  = session('dispositivo');
            $horario->save();
            return redirect()->route('horarios.details', $horario);
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'Horarios' y retorna el método index().*/
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idHorario' => ['required','numeric','integer']
            ]);
            $horario = (new Horario())->selectHorario($request->idHorario);
            $horario->estado = '0';
            $horario->idUsuario = session('idUsuario');
            $horario->ip = session('ip');
            $horario->dispositivo  = session('dispositivo');
            $horario->save();
            return redirect()->route('horarios.index');
        }
        else{
            return redirect()->route('dashboard');
        }
    }
}
