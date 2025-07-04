<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campo extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'campos';
    /*ID de la tabla*/
    protected $primaryKey = 'idCampo';
    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'campos' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Campo y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Campo::select('campos.idCampo','campos.nombreCampo','campos.ordenBoletines','campos.fechaRegistro','campos.fechaActualizacion','campos.idUsuario','campos.estado', 'usuarios.correo')
        ->leftjoin('usuarios', 'campos.idUsuario', '=', 'usuarios.idUsuario')
        ->where('campos.estado', '=', 1)
        ->whereAny([
            'campos.nombreCampo',
            'usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('campos.ordenBoletines')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Campo.*/
    public function selectCampo($idCampo){
        $campo = Campo::find($idCampo);
        return $campo;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'areas' pertenecientes a un registro de la tabla 'campos'.*/
    public function selectCampo_Areas($idCampo){
        $queryAreasPertenecientesDeCampo = Campo::select('areas.idArea','areas.nombreArea','areas.fechaRegistro','areas.fechaActualizacion')
        ->leftjoin('areas', 'campos.idCampo', '=', 'areas.idCampo')
        ->where('areas.idCampo', '=', $idCampo)
        ->where('areas.estado', '=', '1')
        ->orderBy('areas.idArea')
        ->get();
        return $queryAreasPertenecientesDeCampo;
    }
}
