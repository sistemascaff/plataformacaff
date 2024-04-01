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

    public function selectDisponibles(){
        $selectAll = Campo::select('Campos.idCampo','Campos.nombreCampo','Campos.fechaRegistro','Campos.fechaActualizacion','Campos.idUsuario','Campos.estado', 'Usuarios.correo')
        ->leftjoin('Usuarios', 'Campos.idUsuario', '=', 'Usuarios.idUsuario')
        ->where('Campos.estado', '=', 1)
        ->orderBy('Campos.idCampo')
        ->get();
        return $selectAll;
    }

    public function selectCampo($idCampo){
        $selectCampo = Campo::find($idCampo);
        return $selectCampo;
    }

    public function selectCampo_Areas($idCampo){
        $selectCampo = Campo::select('Areas.idArea','Areas.nombreArea','Areas.fechaRegistro','Areas.fechaActualizacion')
        ->leftjoin('Areas', 'Campos.idCampo', '=', 'Areas.idCampo')
        ->where('Areas.idCampo', '=', $idCampo)
        ->where('Areas.estado', '=', '1')
        ->orderBy('Areas.idArea')
        ->get();
        return $selectCampo;
    }
}
