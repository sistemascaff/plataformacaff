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

    public function selectDisponibles(){
        $selectAll = Area::select('Areas.idArea','Campos.nombreCampo','Areas.nombreArea','Areas.estado','Areas.fechaRegistro','Areas.fechaActualizacion','Areas.idUsuario','Usuarios.correo')
        ->leftjoin('Usuarios', 'Areas.idUsuario', '=', 'Usuarios.idUsuario')
        ->join('Campos', 'Areas.idCampo', '=', 'Campos.idCampo')
        ->where('Areas.estado', '=', 1)
        ->where('Campos.estado', '=', 1)
        ->orderBy('Areas.idArea')
        ->get();
        return $selectAll;
    }

    public function selectArea($idArea){
        $selectArea = Area::find($idArea);
        return $selectArea;
    }
}
