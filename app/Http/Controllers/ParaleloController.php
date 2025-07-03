<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParaleloValidation;
use App\Models\Paralelo;
use App\Models\Usuario;
use App\Models\Grado;
use App\Models\Rol;
use Illuminate\Http\Request;

class ParaleloController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'Paralelos'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $tableParalelo = (new Paralelo())->selectDisponibles($request->busqueda);
            return view('Paralelo.inicio', [
                'headTitle' => 'PARALELOS - INICIO',
                'tableParalelo' => $tableParalelo,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('dashboard');
        }        
    }

    /**Muestra la información de un registro específico de la tabla 'Pralelos'.*/
    public function show($idParalelo)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $paralelo = (new Paralelo())->selectParalelo($idParalelo);
            $usuario = (new Usuario())->selectUsuario($paralelo->idUsuario);
            $Grados = (new Grado())->selectDisponibles('');
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            $Cursos = (new Paralelo())->selectParalelo_Cursos($idParalelo);
            return view('Paralelo.detalle', [
                'headTitle' => $paralelo->nombreParalelo,
                'paralelo' => $paralelo,
                'usuario' => $usuario,
                'Cursos' => $Cursos,
                'Grados' => $Grados
            ]);
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    /**Muestra el formulario con los atributos requeridos para CREAR un nuevo registro en la tabla 'Paralelos'.*/
    public function new(){
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            return view('Paralelo.create', [
                'headTitle' => 'PARALELOS - NUEVO PARALELO',
                'Titulos' => "NUEVO PARALELO"
            ]);
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    /**Método que permite almacenar el registro creado de la tabla 'Paralelos' y retorna el método show() con el registro.*/
    public function store(ParaleloValidation $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $paralelo = new Paralelo();
            $paralelo->nombreParalelo = strtoupper($request->nombreParalelo);
            $paralelo->idUsuario = session('idUsuario');
            $paralelo->ip = session('ip');
            $paralelo->dispositivo = session('dispositivo');
            $paralelo->save();
            return redirect()->route('paralelos.details', $paralelo);
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    /**Muestra el formulario con los atributos requeridos para ACTUALIZAR un registro existente de la tabla 'Paralelos'.*/
    public function edit(Paralelo $paralelo)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            return view('Paralelo.update', [
                'headTitle' => 'EDITAR - ' . $paralelo->nombreParalelo,
                'paralelo' => $paralelo,
                'Titulos' => "MODIFICAR PARALELO"
            ]);
        }
        else{
            return redirect()->route('dashboard');
        }
    }
    
    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'Paralelos' y retorna el método show() con el registro actualizado.*/
    public function update(ParaleloValidation $request, Paralelo $paralelo)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $paralelo->nombreParalelo = strtoupper($request->nombreParalelo);
            $paralelo->idUsuario = session('idUsuario');
            $paralelo->ip = session('ip');
            $paralelo->dispositivo = session('dispositivo');
            $paralelo->save();
            return redirect()->route('paralelos.details', $paralelo);
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'Paralelos' y retorna el método index().*/
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idParalelo' => ['required','numeric','integer']
            ]);
            $paralelo = (new Paralelo())->selectParalelo($request->idParalelo);
            $paralelo->estado = '0';
            $paralelo->idUsuario = session('idUsuario');
            $paralelo->ip = session('ip');
            $paralelo->dispositivo = session('dispositivo');
            $paralelo->save();
            return redirect()->route('paralelos.index');
        }
        else{
            return redirect()->route('dashboard');
        }
    }
}
