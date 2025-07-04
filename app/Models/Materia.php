<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'materias';

    /*ID de la tabla*/
    protected $primaryKey = 'idMateria';
    
    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'materias' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Materia, Abreviatura de Materia, nombre de Area, nombre de Campo y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Materia::select('materias.idMateria','materias.nombreMateria','materias.nombreCorto','materias.posicionOrdinal','areas.nombreArea','campos.nombreCampo','materias.estado','materias.fechaRegistro','materias.fechaActualizacion','materias.idUsuario','usuarios.correo')
        ->leftjoin('usuarios', 'materias.idUsuario', '=', 'usuarios.idUsuario')
        ->join('areas', 'materias.idArea', '=', 'areas.idArea')
        ->join('campos', 'areas.idCampo', '=', 'campos.idCampo')
        ->where('materias.estado', '=', 1)
        ->where('areas.estado', '=', 1)
        ->where('campos.estado', '=', 1)
        ->whereAny([
            'materias.nombreMateria',
            'materias.nombreCorto',
            'areas.nombreArea',
            'campos.nombreCampo',
            'usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('campos.ordenBoletines','ASC')
        ->orderBy('materias.posicionOrdinal','ASC')
        ->get();
        return $queryActivos;
    }
    
    /**Función que retorna un objeto del modelo Materia.*/
    public function selectMateria($idMateria){
        $selectMateria = Materia::find($idMateria);
        return $selectMateria;
    }
}
