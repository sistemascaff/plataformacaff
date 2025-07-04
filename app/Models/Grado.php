<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'grados';

    /*ID de la tabla*/
    protected $primaryKey = 'idGrado';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'cursos' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Grado, nombre de Nivel, posición ordinal de Grado y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Grado::select('grados.idGrado','niveles.nombreNivel','grados.nombreGrado','grados.posicionOrdinal','grados.estado','grados.fechaRegistro','grados.fechaActualizacion','grados.idUsuario','usuarios.correo')
        ->leftjoin('usuarios', 'grados.idUsuario', '=', 'usuarios.idUsuario')
        ->join('niveles', 'grados.idNivel', '=', 'niveles.idNivel')
        ->where('grados.estado', '=', 1)
        ->where('niveles.estado', '=', 1)
        ->whereAny([
            'grados.nombreGrado',
            'niveles.nombreNivel',
            'grados.posicionOrdinal',
            'usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('grados.idGrado')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Grado.*/
    public function selectGrado($idGrado){
        $grado = Grado::find($idGrado);
        return $grado;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'cursos' pertenecientes a un registro de la tabla 'grados'.*/
    public function selectGrado_Cursos($idGrado){
        $queryCursosPertenecientesDeGrado = Grado::select('cursos.idCurso','cursos.nombreCurso','cursos.fechaRegistro','cursos.fechaActualizacion')
        ->join('cursos', 'grados.idGrado', '=', 'cursos.idGrado')
        ->where('cursos.idGrado', '=', $idGrado)
        ->where('cursos.estado', '=', '1')
        ->orderBy('cursos.idCurso')
        ->get();
        return $queryCursosPertenecientesDeGrado;
    }
}
