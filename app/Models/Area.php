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

    public function selectDisponibles($busqueda){
        $selectAll = Area::select('Areas.idArea','Areas.nombreCorto','Campos.nombreCampo','Areas.nombreArea','Areas.estado','Areas.fechaRegistro','Areas.fechaActualizacion','Areas.idUsuario','Usuarios.correo')
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
        return $selectAll;
    }

    public function selectArea($idArea){
        $selectArea = Area::find($idArea);
        return $selectArea;
    }

    public function selectArea_Materias($idArea){
        $selectMaterias = Area::select('Materias.idMateria','Materias.nombreMateria','Materias.nombreCorto','Materias.fechaRegistro','Materias.fechaActualizacion')
        ->join('Materias', 'Areas.idArea', '=', 'Materias.idArea')
        ->where('Materias.idArea', '=', $idArea)
        ->where('Materias.estado', '=', '1')
        ->orderBy('Materias.nombreMateria', 'ASC')
        ->get();
        return $selectMaterias;
    }
}
