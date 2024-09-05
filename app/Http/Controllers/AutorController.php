<?php

namespace App\Http\Controllers;

use App\Http\Requests\AutorValidation;
use App\Models\Autor;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'Autores'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $tableAutor = (new Autor())->selectDisponibles($request->busqueda);
            return view('Autor.inicio', [
                'headTitle' => 'AUTORES - INICIO',
                'tableAutor' => $tableAutor,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }        
    }

    /**Muestra la información de un registro específico de la tabla 'Autores'.*/
    public function show($idAutor)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $autor = (new Autor())->selectAutor($idAutor);
            $usuario = (new Usuario())->selectUsuario($autor->idUsuario);
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            $Libros = (new Autor())->selectAutor_Libros($idAutor);
            return view('Autor.detalle', [
                'headTitle' => $autor->nombreAutor,
                'autor' => $autor,
                'usuario' => $usuario,
                'Libros' => $Libros
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para CREAR un nuevo registro en la tabla 'Autores'.*/
    public function new(){
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            return view('Autor.create', [
                'headTitle' => 'AUTORES - NUEVO AUTOR',
                'Titulos' => "NUEVO AUTOR"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar el registro creado de la tabla 'Autores' y retorna el método show() con el registro.*/
    public function store(AutorValidation $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $autor = new Autor();
            $autor->nombreAutor = strtoupper($request->nombreAutor);
            $autor->idUsuario = session('idUsuario');
            $autor->ip = session('ip');
            $autor->dispositivo = session('dispositivo');
            $autor->save();
            return redirect()->route('autores.details', $autor);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para ACTUALIZAR un registro existente de la tabla 'Autores'.*/
    public function edit(Autor $autor)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            return view('Autor.update', [
                'headTitle' => 'EDITAR - ' . $autor->nombreAutor,
                'autor' => $autor,
                'Titulos' => "MODIFICAR AUTOR"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
    
    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'Autores' y retorna el método show() con el registro actualizado.*/
    public function update(AutorValidation $request, Autor $autor)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $autor->nombreAutor = strtoupper($request->nombreAutor);
            $autor->idUsuario = session('idUsuario');
            $autor->ip = session('ip');
            $autor->dispositivo = session('dispositivo');
            $autor->save();
            return redirect()->route('autores.details', $autor);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'Autores' y retorna el método index().*/
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idAutor' => ['required','numeric','integer']
            ]);
            $autor = (new Autor())->selectAutor($request->idAutor);
            $autor->estado = '0';
            $autor->idUsuario = session('idUsuario');
            $autor->ip = session('ip');
            $autor->dispositivo = session('dispositivo');
            $autor->save();
            return redirect()->route('autores.index');
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
}
