<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'categorias';

    /*ID de la tabla*/
    protected $primaryKey = 'idCategoria';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'categorias' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Áula y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Categoria::select('categorias.idCategoria','categorias.nombreCategoria','categorias.estado','categorias.fechaRegistro','categorias.fechaActualizacion','categorias.idUsuario', 'usuarios.correo')
        ->selectraw('COUNT(libros.idLibro) AS countLibros')
        ->leftjoin('usuarios', 'categorias.idUsuario', '=', 'usuarios.idUsuario')
        ->leftjoin('libros', 'categorias.idCategoria', '=', 'libros.idCategoria')
        ->where('categorias.estado', '=', 1)
        ->whereAny([
            'categorias.nombreCategoria',
            'usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('categorias.nombreCategoria')
        ->groupBy('categorias.idCategoria')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Categoria.*/
    public function selectCategoria($idCategoria){
        $categoria = Categoria::find($idCategoria);
        return $categoria;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'libros' pertenecientes a un registro de la tabla 'categorias'.*/
    public function selectCategoria_Libros($idCategoria){
        $queryLibrosPertenecientesDeCategoria = Categoria::select('libros.idLibro','libros.nombreLibro','libros.codigoLibro','libros.costo','libros.observacion','libros.descripcion','libros.adquisicion','libros.prestadoA','libros.estado','libros.fechaRegistro','libros.fechaActualizacion')
        ->leftjoin('libros', 'categorias.idCategoria', '=', 'libros.idCategoria')
        ->where('libros.idCategoria', '=', $idCategoria)
        ->orderBy('libros.nombreLibro')
        ->get();
        return $queryLibrosPertenecientesDeCategoria;
    }
}
