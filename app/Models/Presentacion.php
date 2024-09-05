<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presentacion extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Presentaciones';

    /*ID de la tabla*/
    protected $primaryKey = 'idPresentacion';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Presentaciones' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Áula y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Presentacion::select('Presentaciones.idPresentacion','Presentaciones.nombrePresentacion','Presentaciones.estado','Presentaciones.fechaRegistro','Presentaciones.fechaActualizacion','Presentaciones.idUsuario', 'Usuarios.correo')
        ->leftjoin('Usuarios', 'Presentaciones.idUsuario', '=', 'Usuarios.idUsuario')
        ->where('Presentaciones.estado', '=', 1)
        ->whereAny([
            'Presentaciones.nombrePresentacion',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Presentaciones.idPresentacion')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Presentacion.*/
    public function selectPresentacion($idPresentacion){
        $presentacion = Presentacion::find($idPresentacion);
        return $presentacion;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Libros' pertenecientes a un registro de la tabla 'Presentaciones'.*/
    public function selectPresentacion_Libros($idPresentacion){
        $queryLibrosPertenecientesDePresentacion = Presentacion::select('Libros.idLibro','Libros.nombreLibro','Libros.codigoLibro','Libros.costo','Libros.observacion','Libros.descripcion','Libros.adquisicion','Libros.prestadoA','Libros.estado','Libros.fechaRegistro','Libros.fechaActualizacion')
        ->leftjoin('Libros', 'Presentaciones.idPresentacion', '=', 'Libros.idPresentacion')
        ->where('Libros.idPresentacion', '=', $idPresentacion)
        ->orderBy('Libros.nombreLibro')
        ->get();
        return $queryLibrosPertenecientesDePresentacion;
    }
}
