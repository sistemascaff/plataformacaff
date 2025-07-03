<?php

namespace App\Http\Controllers;

use App\Http\Requests\LibroValidation;
use App\Models\Libro;
use App\Models\Usuario;
use App\Models\Categoria;
use App\Models\Presentacion;
use App\Models\Rol;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'Libros'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1] )) {
            $tableLibro = (new Libro())->selectDisponibles($request->busqueda);
            return view('Libro.inicio', [
                'headTitle' => 'LIBROS - INICIO',
                'tableLibro' => $tableLibro,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('dashboard');
        }        
    }

    public function indexAutores(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1] )) {
            $tableAutor = (new Libro())->selectAutores($request->busqueda);
            return view('Autor.inicio', [
                'headTitle' => 'AUTORES - INICIO',
                'tableAutor' => $tableAutor,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('dashboard');
        }        
    }

    public function indexEditoriales(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1] )) {
            $tableEditorial = (new Libro())->selectEditoriales($request->busqueda);
            return view('Editorial.inicio', [
                'headTitle' => 'EDITORIALES - INICIO',
                'tableEditorial' => $tableEditorial,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('dashboard');
        }        
    }

    /**Muestra la información de un registro específico de la tabla 'Libros'.*/
    public function show($idLibro)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1] )) {
            $libro = (new Libro())->selectLibro($idLibro);
            $usuario = (new Usuario())->selectUsuario($libro->idUsuario);
            $categoria = (new Categoria())->selectCategoria($libro->idCategoria);
            $presentacion = (new Presentacion())->selectPresentacion($libro->idPresentacion);
            $Prestamos = (new Libro())->selectLibro_Prestamos($idLibro);

            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            return view('Libro.detalle', [
                'headTitle' => $libro->nombreLibro,
                'libro' => $libro,
                'usuario' => $usuario,
                'categoria' => $categoria,
                'presentacion' => $presentacion,
                'Prestamos' => $Prestamos
            ]);
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    public function showAutorLibros($nombreAutor)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1] )) {
            $Libros = (new Libro())->selectAutor_Libros($nombreAutor);
            return view('Autor.detalle', [
                'headTitle' => $nombreAutor,
                'nombreAutor' => $nombreAutor,
                'usuario' => '-',
                'Libros' => $Libros
            ]);
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    public function showEditorialLibros($nombreEditorial)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1] )) {
            $Libros = (new Libro())->selectEditorial_Libros($nombreEditorial);
            return view('Editorial.detalle', [
                'headTitle' => $nombreEditorial,
                'nombreEditorial' => $nombreEditorial,
                'usuario' => '-',
                'Libros' => $Libros
            ]);
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    /**Muestra el formulario con los atributos requeridos para CREAR un nuevo registro en la tabla 'Libros'.*/
    public function new($idSelect = null){
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1] )) {
            $Categorias = (new Categoria())->selectDisponibles('');
            $Autores = (new Libro())->selectAutores('');
            $Editoriales = (new Libro())->selectEditoriales('');
            $Presentaciones = (new Presentacion())->selectDisponibles('');
            $formatoCodigo = (new Libro())->selectFormatoCodigoLibro();
            if(!$idSelect){
                $idSelect = 0;
            }
            return view('Libro.create', [
                'headTitle' => 'LIBROS - NUEVO LIBRO',
                'Titulos' => "NUEVO LIBRO",
                'Categorias' => $Categorias,
                'Autores' => $Autores,
                'Editoriales' => $Editoriales,
                'Presentaciones' => $Presentaciones,
                'formatoCodigo' => $formatoCodigo,
                'idSelect' => $idSelect
            ]);
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    /**Método que permite almacenar el registro creado de la tabla 'Libros' y retorna el método show() con el registro.*/
    public function store(LibroValidation $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1] )) {
            $libro = new Libro();
            $libro->nombreLibro = strtoupper($request->nombreLibro);
            $libro->codigoLibro = strtoupper($request->codigoLibro);
            $libro->costo = $request->costo;
            $libro->observacion = strtoupper($request->observacion);
            $libro->descripcion = strtoupper($request->descripcion);
            $libro->adquisicion = $request->adquisicion;
            $libro->idCategoria = $request->idCategoria;
            $libro->nombreAutor = strtoupper($request->nombreAutor);
            $libro->nombreEditorial = strtoupper($request->nombreEditorial);
            $libro->anhoLibro = $request->anhoLibro;
            $libro->idPresentacion = $request->idPresentacion;
            $libro->fechaIngresoCooperativa = $request->fechaIngresoCooperativa;
            $libro->idUsuario = session('idUsuario');
            $libro->ip = session('ip');
            $libro->dispositivo  = session('dispositivo');
            $libro->save();
            return redirect()->route('libros.details', $libro);
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    /**Muestra el formulario con los atributos requeridos para ACTUALIZAR un registro existente de la tabla 'Libros'.*/
    public function edit(Libro $libro)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1] )) {
            $Categorias = (new Categoria())->selectDisponibles('');
            $Autores = (new Libro())->selectAutores('');
            $Editoriales = (new Libro())->selectEditoriales('');
            $Presentaciones = (new Presentacion())->selectDisponibles('');
            return view('Libro.update', [
                'headTitle' => 'EDITAR - ' . $libro->nombreLibro,
                'libro' => $libro,
                'Categorias' => $Categorias,
                'Autores' => $Autores,
                'Editoriales' => $Editoriales,
                'Presentaciones' => $Presentaciones,
                'Titulos' => "MODIFICAR LIBRO"
            ]);
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'Libros' y retorna el método show() con el registro actualizado.*/
    public function update(LibroValidation $request, Libro $libro)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1] )) {
            $libro->nombreLibro = strtoupper($request->nombreLibro);
            $libro->codigoLibro = strtoupper($request->codigoLibro);
            $libro->costo = $request->costo;
            $libro->observacion = strtoupper($request->observacion);
            $libro->descripcion = strtoupper($request->descripcion);
            $libro->adquisicion = $request->adquisicion;
            $libro->idCategoria = $request->idCategoria;
            $libro->nombreAutor = strtoupper($request->nombreAutor);
            $libro->nombreEditorial = strtoupper($request->nombreEditorial);
            $libro->anhoLibro = $request->anhoLibro;
            $libro->idPresentacion = $request->idPresentacion;
            $libro->fechaIngresoCooperativa = $request->fechaIngresoCooperativa;
            $libro->idUsuario = session('idUsuario');
            $libro->ip = session('ip');
            $libro->dispositivo  = session('dispositivo');
            $libro->save();
            return redirect()->route('libros.details', $libro);
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'Libros' y redirecciona al método index().*/
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1] )) {
            $request->validate([
                'idLibro' => ['required','numeric','integer']
            ]);
            $libro = (new Libro())->selectLibro($request->idLibro);
            $libro->estado = '0';
            $libro->idUsuario = session('idUsuario');
            $libro->ip = session('ip');
            $libro->dispositivo  = session('dispositivo');
            $libro->save();
            return redirect()->route('libros.index');
        }
        else{
            return redirect()->route('dashboard');
        }
    }
}
