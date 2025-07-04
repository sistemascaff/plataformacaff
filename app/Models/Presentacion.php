<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presentacion extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'presentaciones';

    /*ID de la tabla*/
    protected $primaryKey = 'idPresentacion';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'presentaciones' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Áula y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Presentacion::select('presentaciones.idPresentacion','presentaciones.nombrePresentacion','presentaciones.estado','presentaciones.fechaRegistro','presentaciones.fechaActualizacion','presentaciones.idUsuario', 'usuarios.correo')
        ->selectraw('COUNT(libros.idLibro) AS countLibros')
        ->leftjoin('usuarios', 'presentaciones.idUsuario', '=', 'usuarios.idUsuario')
        ->leftjoin('libros', 'presentaciones.idPresentacion', '=', 'libros.idPresentacion')
        ->where('presentaciones.estado', '=', 1)
        ->whereAny([
            'presentaciones.nombrePresentacion',
            'usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('presentaciones.nombrePresentacion')
        ->groupBy('presentaciones.idPresentacion')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Presentacion.*/
    public function selectPresentacion($idPresentacion){
        $presentacion = Presentacion::find($idPresentacion);
        return $presentacion;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'libros' pertenecientes a un registro de la tabla 'presentaciones'.*/
    public function selectPresentacion_Libros($idPresentacion){
        $queryLibrosPertenecientesDePresentacion = Presentacion::select('libros.idLibro','libros.nombreLibro','libros.codigoLibro','libros.costo','libros.observacion','libros.descripcion','libros.adquisicion','libros.prestadoA','libros.estado','libros.fechaRegistro','libros.fechaActualizacion')
        ->leftjoin('libros', 'presentaciones.idPresentacion', '=', 'libros.idPresentacion')
        ->where('libros.idPresentacion', '=', $idPresentacion)
        ->orderBy('libros.nombreLibro')
        ->get();
        return $queryLibrosPertenecientesDePresentacion;
    }
}
