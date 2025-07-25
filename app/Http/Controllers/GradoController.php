<?php

namespace App\Http\Controllers;

use App\Http\Requests\GradoValidation;
use App\Models\Grado;
use App\Models\Usuario;
use App\Models\Nivel;
use App\Models\Paralelo;
use App\Models\Rol;
use Illuminate\Http\Request;
class GradoController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'Grados'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $tableGrado = (new Grado())->selectDisponibles($request->busqueda);
            return view('Grado.inicio', [
                'headTitle' => 'GRADOS - INICIO',
                'tableGrado' => $tableGrado,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('dashboard');
        }        
    }

    /**Muestra la información de un registro específico de la tabla 'Grados'.*/
    public function show($idGrado)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $grado = (new Grado())->selectGrado($idGrado);
            $usuario = (new Usuario())->selectUsuario($grado->idUsuario);
            $nivel = (new Nivel())->selectNivel($grado->idNivel);
            $Cursos = (new Grado())->selectGrado_Cursos($idGrado);
            $Paralelos = (new Paralelo())->selectDisponibles('');
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            return view('Grado.detalle', [
                'headTitle' => $grado->nombreGrado,
                'grado' => $grado,
                'usuario' => $usuario,
                'nivel' => $nivel,
                'Cursos' => $Cursos,
                'Paralelos' => $Paralelos
            ]);
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    /**Muestra el formulario con los atributos requeridos para CREAR un nuevo registro en la tabla 'Grados'.*/
    public function new($idSelect = null){
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $Niveles = (new Nivel())->selectDisponibles('');
            if(!$idSelect){
                $idSelect = 0;
            }
            return view('Grado.create', [
                'headTitle' => 'GRADOS - NUEVO GRADO',
                'Titulos' => "NUEVO GRADO",
                'Niveles' => $Niveles,
                'idSelect' => $idSelect
            ]);
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    /**Método que permite almacenar el registro creado de la tabla 'Grados' y retorna el método show() con el registro.*/
    public function store(GradoValidation $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $grado = new Grado();
            $grado->nombreGrado = strtoupper($request->nombreGrado);
            $grado->posicionOrdinal = $request->posicionOrdinal;
            $grado->idNivel = $request->idNivel;
            $grado->idUsuario = session('idUsuario');
            $grado->ip = session('ip');
            $grado->dispositivo = session('dispositivo');
            $grado->save();
            return redirect()->route('grados.details', $grado);
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    /**Muestra el formulario con los atributos requeridos para ACTUALIZAR un registro existente de la tabla 'Grados'.*/
    public function edit(Grado $grado)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $Niveles = (new Nivel())->selectDisponibles('');
            return view('Grado.update', [
                'headTitle' => 'EDITAR - ' . $grado->nombreGrado,
                'grado' => $grado,
                'Niveles' => $Niveles,
                'Titulos' => "MODIFICAR AREA"
            ]);
        }
        else{
            return redirect()->route('dashboard');
        }
    }
    
    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'Grados' y retorna el método show() con el registro actualizado.*/
    public function update(GradoValidation $request, Grado $grado)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $grado->nombreGrado = strtoupper($request->nombreGrado);
            $grado->posicionOrdinal = $request->posicionOrdinal;
            $grado->idNivel = $request->idNivel;
            $grado->idUsuario = session('idUsuario');
            $grado->ip = session('ip');
            $grado->dispositivo = session('dispositivo');
            $grado->save();
            return redirect()->route('grados.details', $grado);
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'Grados' y retorna el método index().*/
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idGrado' => ['required','numeric','integer']
            ]);
            $grado = (new Grado())->selectGrado($request->idGrado);
            $grado->estado = '0';
            $grado->idUsuario = session('idUsuario');
            $grado->ip = session('ip');
            $grado->dispositivo = session('dispositivo');
            $grado->save();
            return redirect()->route('grados.index');
        }
        else{
            return redirect()->route('dashboard');
        }
    }
}
