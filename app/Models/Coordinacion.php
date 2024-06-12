<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinacion extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Coordinaciones';
    /*ID de la tabla*/
    protected $primaryKey = 'idCoordinacion';
    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Coordinaciones' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Coordinación y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Coordinacion::select('Coordinaciones.idCoordinacion','Coordinaciones.nombreCoordinacion','Coordinaciones.fechaRegistro','Coordinaciones.fechaActualizacion','Coordinaciones.idUsuario','Coordinaciones.estado', 'Usuarios.correo')
        ->leftjoin('Usuarios', 'Coordinaciones.idUsuario', '=', 'Usuarios.idUsuario')
        ->where('Coordinaciones.estado', '=', 1)
        ->whereAny([
            'Coordinaciones.nombreCoordinacion',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Coordinaciones.idCoordinacion')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Coordinacion.*/
    public function selectCoordinacion($idCoordinacion){
        $coordinacion = Coordinacion::find($idCoordinacion);
        return $coordinacion;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Asignaturas' pertenecientes a un registro de la tabla 'Coordinaciones'.*/
    public function selectCoordinacion_Asignaturas($idCoordinacion){
        $queryAsignaturasPertenecientesDeCoordinacion = Coordinacion::select('Asignaturas.idAsignatura','Asignaturas.nombreAsignatura','Asignaturas.nombreCorto','Asignaturas.fechaRegistro','Asignaturas.fechaActualizacion')
        ->leftjoin('Asignaturas', 'Coordinaciones.idCoordinacion', '=', 'Asignaturas.idCoordinacion')
        ->where('Asignaturas.idCoordinacion', '=', $idCoordinacion)
        ->where('Asignaturas.estado', '=', '1')
        ->orderBy('Asignaturas.idAsignatura')
        ->get();
        return $queryAsignaturasPertenecientesDeCoordinacion;
    }
}
