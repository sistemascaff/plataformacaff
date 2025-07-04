<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paralelo extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'paralelos';
    /*ID de la tabla*/
    protected $primaryKey = 'idParalelo';
    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'paralelos' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Paralelo y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Paralelo::select('paralelos.idParalelo','paralelos.nombreParalelo','paralelos.estado','paralelos.fechaRegistro','paralelos.fechaActualizacion','paralelos.idUsuario','usuarios.correo')
        ->leftjoin('usuarios', 'paralelos.idUsuario', '=', 'usuarios.idUsuario')
        ->where('paralelos.estado', '=', 1)
        ->whereAny([
            'paralelos.nombreParalelo',
            'usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('paralelos.idParalelo')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Paralelo.*/
    public function selectParalelo($idParalelo){
        $paralelo = Paralelo::find($idParalelo);
        return $paralelo;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'cursos' pertenecientes a un registro de la tabla 'paralelos'.*/
    public function selectParalelo_Cursos($idParalelo){
        $queryCursosPertenecientesDeParalelo = Paralelo::select('cursos.idCurso','cursos.nombreCurso','cursos.fechaRegistro','cursos.fechaActualizacion')
        ->leftjoin('cursos', 'paralelos.idParalelo', '=', 'cursos.idParalelo')
        ->where('cursos.idParalelo', '=', $idParalelo)
        ->where('cursos.estado', '=', '1')
        ->orderBy('cursos.idCurso')
        ->get();
        return $queryCursosPertenecientesDeParalelo;
    }
}
