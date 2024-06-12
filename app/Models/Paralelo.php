<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paralelo extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Paralelos';
    /*ID de la tabla*/
    protected $primaryKey = 'idParalelo';
    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Paralelos' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Paralelo y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Paralelo::select('Paralelos.idParalelo','Paralelos.nombreParalelo','Paralelos.estado','Paralelos.fechaRegistro','Paralelos.fechaActualizacion','Paralelos.idUsuario','Usuarios.correo')
        ->leftjoin('Usuarios', 'Paralelos.idUsuario', '=', 'Usuarios.idUsuario')
        ->where('Paralelos.estado', '=', 1)
        ->whereAny([
            'Paralelos.nombreParalelo',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Paralelos.idParalelo')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Paralelo.*/
    public function selectParalelo($idParalelo){
        $paralelo = Paralelo::find($idParalelo);
        return $paralelo;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Cursos' pertenecientes a un registro de la tabla 'Paralelos'.*/
    public function selectParalelo_Cursos($idParalelo){
        $queryCursosPertenecientesDeParalelo = Paralelo::select('Cursos.idCurso','Cursos.nombreCurso','Cursos.fechaRegistro','Cursos.fechaActualizacion')
        ->leftjoin('Cursos', 'Paralelos.idParalelo', '=', 'Cursos.idParalelo')
        ->where('Cursos.idParalelo', '=', $idParalelo)
        ->where('Cursos.estado', '=', '1')
        ->orderBy('Cursos.idCurso')
        ->get();
        return $queryCursosPertenecientesDeParalelo;
    }
}
