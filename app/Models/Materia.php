<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Materias';

    /*ID de la tabla*/
    protected $primaryKey = 'idMateria';
    
    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Materias' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Materia, Abreviatura de Materia, nombre de Area, nombre de Campo y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Materia::select('Materias.idMateria','Materias.nombreMateria','Materias.nombreCorto','Materias.posicionOrdinal','Areas.nombreArea','Campos.nombreCampo','Materias.estado','Materias.fechaRegistro','Materias.fechaActualizacion','Materias.idUsuario','Usuarios.correo')
        ->leftjoin('Usuarios', 'Materias.idUsuario', '=', 'Usuarios.idUsuario')
        ->join('Areas', 'Materias.idArea', '=', 'Areas.idArea')
        ->join('Campos', 'Areas.idCampo', '=', 'Campos.idCampo')
        ->where('Materias.estado', '=', 1)
        ->where('Areas.estado', '=', 1)
        ->where('Campos.estado', '=', 1)
        ->whereAny([
            'Materias.nombreMateria',
            'Materias.nombreCorto',
            'Areas.nombreArea',
            'Campos.nombreCampo',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Campos.ordenBoletines','ASC')
        ->orderBy('Materias.posicionOrdinal','ASC')
        ->get();
        return $queryActivos;
    }
    
    /**Función que retorna un objeto del modelo Materia.*/
    public function selectMateria($idMateria){
        $selectMateria = Materia::find($idMateria);
        return $selectMateria;
    }
}
