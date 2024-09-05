<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditorialValidation;
use App\Models\Editorial;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;

class EditorialController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'Editoriales'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $tableEditorial = (new Editorial())->selectDisponibles($request->busqueda);
            return view('Editorial.inicio', [
                'headTitle' => 'EDITORIALES - INICIO',
                'tableEditorial' => $tableEditorial,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }        
    }

    /**Muestra la información de un registro específico de la tabla 'Editoriales'.*/
    public function show($idEditorial)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $editorial = (new Editorial())->selectEditorial($idEditorial);
            $usuario = (new Usuario())->selectUsuario($editorial->idUsuario);
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            $Libros = (new Editorial())->selectEditorial_Libros($idEditorial);
            return view('Editorial.detalle', [
                'headTitle' => $editorial->nombreEditorial,
                'editorial' => $editorial,
                'usuario' => $usuario,
                'Libros' => $Libros
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para CREAR un nuevo registro en la tabla 'Editoriales'.*/
    public function new(){
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            return view('Editorial.create', [
                'headTitle' => 'EDITORIALES - NUEVA EDITORIAL',
                'Titulos' => "NUEVA EDITORIAL"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar el registro creado de la tabla 'Editoriales' y retorna el método show() con el registro.*/
    public function store(EditorialValidation $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $editorial = new Editorial();
            $editorial->nombreEditorial = strtoupper($request->nombreEditorial);
            $editorial->idUsuario = session('idUsuario');
            $editorial->ip = session('ip');
            $editorial->dispositivo = session('dispositivo');
            $editorial->save();
            return redirect()->route('editoriales.details', $editorial);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para ACTUALIZAR un registro existente de la tabla 'Editoriales'.*/
    public function edit(Editorial $editorial)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            return view('Editorial.update', [
                'headTitle' => 'EDITAR - ' . $editorial->nombreEditorial,
                'editorial' => $editorial,
                'Titulos' => "MODIFICAR EDITORIAL"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
    
    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'Editoriales' y retorna el método show() con el registro actualizado.*/
    public function update(EditorialValidation $request, Editorial $editorial)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $editorial->nombreEditorial = strtoupper($request->nombreEditorial);
            $editorial->idUsuario = session('idUsuario');
            $editorial->ip = session('ip');
            $editorial->dispositivo = session('dispositivo');
            $editorial->save();
            return redirect()->route('editoriales.details', $editorial);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'Editoriales' y retorna el método index().*/
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idEditorial' => ['required','numeric','integer']
            ]);
            $editorial = (new Editorial())->selectEditorial($request->idEditorial);
            $editorial->estado = '0';
            $editorial->idUsuario = session('idUsuario');
            $editorial->ip = session('ip');
            $editorial->dispositivo = session('dispositivo');
            $editorial->save();
            return redirect()->route('editoriales.index');
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
}
