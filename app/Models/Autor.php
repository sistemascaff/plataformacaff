<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Autores';

    /*ID de la tabla*/
    protected $primaryKey = 'idAutor';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Autores' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Áula y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Autor::select('Autores.idAutor','Autores.nombreAutor','Autores.estado','Autores.fechaRegistro','Autores.fechaActualizacion','Autores.idUsuario', 'Usuarios.correo')
        ->selectraw('COUNT(Libros.idLibro) AS countLibros')
        ->leftjoin('Usuarios', 'Autores.idUsuario', '=', 'Usuarios.idUsuario')
        ->join('Libros', 'Autores.idAutor', '=', 'Libros.idAutor')
        ->where('Autores.estado', '=', 1)
        ->whereAny([
            'Autores.nombreAutor',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Autores.nombreAutor')
        ->groupBy('Autores.idAutor')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Autor.*/
    public function selectAutor($idAutor){
        $autor = Autor::find($idAutor);
        return $autor;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Libros' pertenecientes a un registro de la tabla 'Autores'.*/
    public function selectAutor_Libros($idAutor){
        $queryLibrosPertenecientesDeAutor = Autor::select('Libros.idLibro','Libros.nombreLibro','Libros.codigoLibro','Libros.costo','Libros.observacion','Libros.descripcion','Libros.adquisicion','Libros.prestadoA','Libros.estado','Libros.fechaRegistro','Libros.fechaActualizacion')
        ->leftjoin('Libros', 'Autores.idAutor', '=', 'Libros.idAutor')
        ->where('Libros.idAutor', '=', $idAutor)
        ->orderBy('Libros.nombreLibro')
        ->get();
        return $queryLibrosPertenecientesDeAutor;
    }
}
