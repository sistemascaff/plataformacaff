<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Areas';

    /*ID de la tabla*/
    protected $primaryKey = 'idArea';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Areas' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Área, nombre de Campo, correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Area::select('Areas.idArea','Areas.nombreCorto','Campos.nombreCampo','Areas.nombreArea','Areas.estado','Areas.fechaRegistro','Areas.fechaActualizacion','Areas.idUsuario','Usuarios.correo')
        ->leftjoin('Usuarios', 'Areas.idUsuario', '=', 'Usuarios.idUsuario')
        ->join('Campos', 'Areas.idCampo', '=', 'Campos.idCampo')
        ->where('Areas.estado', '=', 1)
        ->where('Campos.estado', '=', 1)
        ->whereAny([
            'Areas.nombreArea',
            'Campos.nombreCampo',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Areas.idArea')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Area.*/
    public function selectArea($idArea){
        $area = Area::find($idArea);
        return $area;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Materias' pertenecientes a un registro de la tabla 'Areas'.*/
    public function selectArea_Materias($idArea){
        $queryMateriasPertenecientesDeArea = Area::select('Materias.idMateria','Materias.nombreMateria','Materias.nombreCorto','Materias.fechaRegistro','Materias.fechaActualizacion')
        ->join('Materias', 'Areas.idArea', '=', 'Materias.idArea')
        ->where('Materias.idArea', '=', $idArea)
        ->where('Materias.estado', '=', '1')
        ->orderBy('Materias.nombreMateria', 'ASC')
        ->get();
        return $queryMateriasPertenecientesDeArea;
    }
}
