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
        $queryActivos = Coordinacion::select('Coordinaciones.idCoordinacion','Coordinaciones.nombreCoordinacion','Coordinaciones.fechaRegistro','Coordinaciones.fechaActualizacion','Coordinaciones.idUsuario','Coordinaciones.estado', 'usuarios.correo')
        ->leftjoin('usuarios', 'Coordinaciones.idUsuario', '=', 'usuarios.idUsuario')
        ->where('Coordinaciones.estado', '=', 1)
        ->whereAny([
            'Coordinaciones.nombreCoordinacion',
            'usuarios.correo',
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

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'asignaturas' pertenecientes a un registro de la tabla 'Coordinaciones'.*/
    public function selectCoordinacion_Asignaturas($idCoordinacion){
        $queryAsignaturasPertenecientesDeCoordinacion = Coordinacion::select('asignaturas.idAsignatura','asignaturas.nombreAsignatura','asignaturas.nombreCorto','asignaturas.fechaRegistro','asignaturas.fechaActualizacion')
        ->leftjoin('asignaturas', 'Coordinaciones.idCoordinacion', '=', 'asignaturas.idCoordinacion')
        ->where('asignaturas.idCoordinacion', '=', $idCoordinacion)
        ->where('asignaturas.estado', '=', '1')
        ->orderBy('asignaturas.idAsignatura')
        ->get();
        return $queryAsignaturasPertenecientesDeCoordinacion;
    }
}
