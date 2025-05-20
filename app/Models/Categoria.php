<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Categorias';

    /*ID de la tabla*/
    protected $primaryKey = 'idCategoria';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Categorias' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Áula y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Categoria::select('Categorias.idCategoria','Categorias.nombreCategoria','Categorias.estado','Categorias.fechaRegistro','Categorias.fechaActualizacion','Categorias.idUsuario', 'Usuarios.correo')
        ->selectraw('COUNT(Libros.idLibro) AS countLibros')
        ->leftjoin('Usuarios', 'Categorias.idUsuario', '=', 'Usuarios.idUsuario')
        ->leftjoin('Libros', 'Categorias.idCategoria', '=', 'Libros.idCategoria')
        ->where('Categorias.estado', '=', 1)
        ->whereAny([
            'Categorias.nombreCategoria',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Categorias.nombreCategoria')
        ->groupBy('Categorias.idCategoria')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Categoria.*/
    public function selectCategoria($idCategoria){
        $categoria = Categoria::find($idCategoria);
        return $categoria;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Libros' pertenecientes a un registro de la tabla 'Categorias'.*/
    public function selectCategoria_Libros($idCategoria){
        $queryLibrosPertenecientesDeCategoria = Categoria::select('Libros.idLibro','Libros.nombreLibro','Libros.codigoLibro','Libros.costo','Libros.observacion','Libros.descripcion','Libros.adquisicion','Libros.prestadoA','Libros.estado','Libros.fechaRegistro','Libros.fechaActualizacion')
        ->leftjoin('Libros', 'Categorias.idCategoria', '=', 'Libros.idCategoria')
        ->where('Libros.idCategoria', '=', $idCategoria)
        ->orderBy('Libros.nombreLibro')
        ->get();
        return $queryLibrosPertenecientesDeCategoria;
    }
}
