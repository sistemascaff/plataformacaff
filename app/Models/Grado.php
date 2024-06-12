<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Grados';

    /*ID de la tabla*/
    protected $primaryKey = 'idGrado';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Cursos' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Grado, nombre de Nivel, posición ordinal de Grado y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Grado::select('Grados.idGrado','Niveles.nombreNivel','Grados.nombreGrado','Grados.posicionOrdinal','Grados.estado','Grados.fechaRegistro','Grados.fechaActualizacion','Grados.idUsuario','Usuarios.correo')
        ->leftjoin('Usuarios', 'Grados.idUsuario', '=', 'Usuarios.idUsuario')
        ->join('Niveles', 'Grados.idNivel', '=', 'Niveles.idNivel')
        ->where('Grados.estado', '=', 1)
        ->where('Niveles.estado', '=', 1)
        ->whereAny([
            'Grados.nombreGrado',
            'Niveles.nombreNivel',
            'Grados.posicionOrdinal',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Grados.idGrado')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Grado.*/
    public function selectGrado($idGrado){
        $grado = Grado::find($idGrado);
        return $grado;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Cursos' pertenecientes a un registro de la tabla 'Grados'.*/
    public function selectGrado_Cursos($idGrado){
        $queryCursosPertenecientesDeGrado = Grado::select('Cursos.idCurso','Cursos.nombreCurso','Cursos.fechaRegistro','Cursos.fechaActualizacion')
        ->join('Cursos', 'Grados.idGrado', '=', 'Cursos.idGrado')
        ->where('Cursos.idGrado', '=', $idGrado)
        ->where('Cursos.estado', '=', '1')
        ->orderBy('Cursos.idCurso')
        ->get();
        return $queryCursosPertenecientesDeGrado;
    }
}
