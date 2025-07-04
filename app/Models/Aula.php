<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'aulas';

    /*ID de la tabla*/
    protected $primaryKey = 'idAula';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'aulas' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Áula y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Aula::select('aulas.idAula','aulas.nombreAula','aulas.estado','aulas.fechaRegistro','aulas.fechaActualizacion','aulas.idUsuario', 'usuarios.correo')
        ->leftjoin('usuarios', 'aulas.idUsuario', '=', 'usuarios.idUsuario')
        ->where('aulas.estado', '=', 1)
        ->whereAny([
            'aulas.nombreAula',
            'usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('aulas.idAula')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Aula.*/
    public function selectAula($idAula){
        $aula = Aula::find($idAula);
        return $aula;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'asignaturas' pertenecientes a un registro de la tabla 'aulas'.*/
    public function selectAula_Asignaturas($idAula){
        $queryAsignaturasPertenecientesDeAula = Aula::select('asignaturas.idAsignatura','asignaturas.nombreAsignatura','asignaturas.nombreCorto','asignaturas.tipoCalificacion','asignaturas.tipoBloque','asignaturas.tipoAsignatura','asignaturas.fechaRegistro','asignaturas.fechaActualizacion')
        ->leftjoin('asignaturas', 'aulas.idAula', '=', 'asignaturas.idAula')
        ->where('asignaturas.idAula', '=', $idAula)
        ->where('asignaturas.estado', '=', '1')
        ->orderBy('asignaturas.idAsignatura')
        ->get();
        return $queryAsignaturasPertenecientesDeAula;
    }
}
