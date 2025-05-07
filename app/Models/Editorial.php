<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Editoriales';

    /*ID de la tabla*/
    protected $primaryKey = 'idEditorial';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Editoriales' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Áula y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Editorial::select('Editoriales.idEditorial','Editoriales.nombreEditorial','Editoriales.estado','Editoriales.fechaRegistro','Editoriales.fechaActualizacion','Editoriales.idUsuario', 'Usuarios.correo')
        ->selectraw('COUNT(Libros.idLibro) AS countLibros')
        ->leftjoin('Usuarios', 'Editoriales.idUsuario', '=', 'Usuarios.idUsuario')
        ->join('Libros', 'Editoriales.idEditorial', '=', 'Libros.idEditorial')
        ->where('Editoriales.estado', '=', 1)
        ->whereAny([
            'Editoriales.nombreEditorial',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Editoriales.nombreEditorial')
        ->groupBy('Editoriales.idEditorial')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Editorial.*/
    public function selectEditorial($idEditorial){
        $editorial = Editorial::find($idEditorial);
        return $editorial;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Libros' pertenecientes a un registro de la tabla 'Editoriales'.*/
    public function selectEditorial_Libros($idEditorial){
        $queryLibrosPertenecientesDeEditorial = Editorial::select('Libros.idLibro','Libros.nombreLibro','Libros.codigoLibro','Libros.costo','Libros.observacion','Libros.descripcion','Libros.adquisicion','Libros.prestadoA','Libros.estado','Libros.fechaRegistro','Libros.fechaActualizacion')
        ->leftjoin('Libros', 'Editoriales.idEditorial', '=', 'Libros.idEditorial')
        ->where('Libros.idEditorial', '=', $idEditorial)
        ->orderBy('Libros.nombreLibro')
        ->get();
        return $queryLibrosPertenecientesDeEditorial;
    }
}
