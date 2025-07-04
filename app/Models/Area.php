<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'areas';

    /*ID de la tabla*/
    protected $primaryKey = 'idArea';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'areas' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Área, nombre de Campo, correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Area::select('areas.idArea','areas.nombreCorto','campos.nombreCampo','areas.nombreArea','areas.estado','areas.fechaRegistro','areas.fechaActualizacion','areas.idUsuario','usuarios.correo')
        ->leftjoin('usuarios', 'areas.idUsuario', '=', 'usuarios.idUsuario')
        ->join('campos', 'areas.idCampo', '=', 'campos.idCampo')
        ->where('areas.estado', '=', 1)
        ->where('campos.estado', '=', 1)
        ->whereAny([
            'areas.nombreArea',
            'campos.nombreCampo',
            'usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('areas.idArea')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Area.*/
    public function selectArea($idArea){
        $area = Area::find($idArea);
        return $area;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'materias' pertenecientes a un registro de la tabla 'areas'.*/
    public function selectArea_Materias($idArea){
        $queryMateriasPertenecientesDeArea = Area::select('materias.idMateria','materias.nombreMateria','materias.nombreCorto','materias.fechaRegistro','materias.fechaActualizacion')
        ->join('materias', 'areas.idArea', '=', 'materias.idArea')
        ->where('materias.idArea', '=', $idArea)
        ->where('materias.estado', '=', '1')
        ->orderBy('materias.nombreMateria', 'ASC')
        ->get();
        return $queryMateriasPertenecientesDeArea;
    }
}
