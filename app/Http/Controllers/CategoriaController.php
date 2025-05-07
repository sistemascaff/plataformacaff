<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaValidation;
use App\Models\Categoria;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'Categorias'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1] )) {
            $tableCategoria = (new Categoria())->selectDisponibles($request->busqueda);
            return view('Categoria.inicio', [
                'headTitle' => 'CATEGORIAS - INICIO',
                'tableCategoria' => $tableCategoria,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }        
    }

    /**Muestra la información de un registro específico de la tabla 'Categorias'.*/
    public function show($idCategoria)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1] )) {
            $categoria = (new Categoria())->selectCategoria($idCategoria);
            $usuario = (new Usuario())->selectUsuario($categoria->idUsuario);
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            $Libros = (new Categoria())->selectCategoria_Libros($idCategoria);
            return view('Categoria.detalle', [
                'headTitle' => $categoria->nombreCategoria,
                'categoria' => $categoria,
                'usuario' => $usuario,
                'Libros' => $Libros
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para CREAR un nuevo registro en la tabla 'Categorias'.*/
    public function new(){
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1] )) {
            return view('Categoria.create', [
                'headTitle' => 'CATEGORIAS - NUEVA CATEGORIA',
                'Titulos' => "NUEVA CATEGORIA"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar el registro creado de la tabla 'Categorias' y retorna el método show() con el registro.*/
    public function store(CategoriaValidation $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1] )) {
            $categoria = new Categoria();
            $categoria->nombreCategoria = strtoupper($request->nombreCategoria);
            $categoria->idUsuario = session('idUsuario');
            $categoria->ip = session('ip');
            $categoria->dispositivo = session('dispositivo');
            $categoria->save();
            return redirect()->route('categorias.details', $categoria);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para ACTUALIZAR un registro existente de la tabla 'Categorias'.*/
    public function edit(Categoria $categoria)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1] )) {
            return view('Categoria.update', [
                'headTitle' => 'EDITAR - ' . $categoria->nombreCategoria,
                'categoria' => $categoria,
                'Titulos' => "MODIFICAR CATEGORIA"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
    
    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'Categorias' y retorna el método show() con el registro actualizado.*/
    public function update(CategoriaValidation $request, Categoria $categoria)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1] )) {
            $categoria->nombreCategoria = strtoupper($request->nombreCategoria);
            $categoria->idUsuario = session('idUsuario');
            $categoria->ip = session('ip');
            $categoria->dispositivo = session('dispositivo');
            $categoria->save();
            return redirect()->route('categorias.details', $categoria);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'Categorias' y retorna el método index().*/
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1] )) {
            $request->validate([
                'idCategoria' => ['required','numeric','integer']
            ]);
            $categoria = (new Categoria())->selectCategoria($request->idCategoria);
            $categoria->estado = '0';
            $categoria->idUsuario = session('idUsuario');
            $categoria->ip = session('ip');
            $categoria->dispositivo = session('dispositivo');
            $categoria->save();
            return redirect()->route('categorias.index');
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
}
