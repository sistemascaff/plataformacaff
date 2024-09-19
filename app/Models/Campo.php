<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campo extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Campos';
    /*ID de la tabla*/
    protected $primaryKey = 'idCampo';
    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Campos' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Campo y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Campo::select('Campos.idCampo','Campos.nombreCampo','Campos.ordenBoletines','Campos.fechaRegistro','Campos.fechaActualizacion','Campos.idUsuario','Campos.estado', 'Usuarios.correo')
        ->leftjoin('Usuarios', 'Campos.idUsuario', '=', 'Usuarios.idUsuario')
        ->where('Campos.estado', '=', 1)
        ->whereAny([
            'Campos.nombreCampo',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Campos.ordenBoletines')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Campo.*/
    public function selectCampo($idCampo){
        $campo = Campo::find($idCampo);
        return $campo;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Areas' pertenecientes a un registro de la tabla 'Campos'.*/
    public function selectCampo_Areas($idCampo){
        $queryAreasPertenecientesDeCampo = Campo::select('Areas.idArea','Areas.nombreArea','Areas.fechaRegistro','Areas.fechaActualizacion')
        ->leftjoin('Areas', 'Campos.idCampo', '=', 'Areas.idCampo')
        ->where('Areas.idCampo', '=', $idCampo)
        ->where('Areas.estado', '=', '1')
        ->orderBy('Areas.idArea')
        ->get();
        return $queryAreasPertenecientesDeCampo;
    }
}
