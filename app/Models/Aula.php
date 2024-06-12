<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Aulas';

    /*ID de la tabla*/
    protected $primaryKey = 'idAula';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Aulas' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Áula y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Aula::select('Aulas.idAula','Aulas.nombreAula','Aulas.estado','Aulas.fechaRegistro','Aulas.fechaActualizacion','Aulas.idUsuario', 'Usuarios.correo')
        ->leftjoin('Usuarios', 'Aulas.idUsuario', '=', 'Usuarios.idUsuario')
        ->where('Aulas.estado', '=', 1)
        ->whereAny([
            'Aulas.nombreAula',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Aulas.idAula')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Aula.*/
    public function selectAula($idAula){
        $aula = Aula::find($idAula);
        return $aula;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Asignaturas' pertenecientes a un registro de la tabla 'Aulas'.*/
    public function selectAula_Asignaturas($idAula){
        $queryAsignaturasPertenecientesDeAula = Aula::select('Asignaturas.idAsignatura','Asignaturas.nombreAsignatura','Asignaturas.nombreCorto','Asignaturas.tipoCalificacion','Asignaturas.tipoBloque','Asignaturas.tipoAsignatura','Asignaturas.fechaRegistro','Asignaturas.fechaActualizacion')
        ->leftjoin('Asignaturas', 'Aulas.idAula', '=', 'Asignaturas.idAula')
        ->where('Asignaturas.idAula', '=', $idAula)
        ->where('Asignaturas.estado', '=', '1')
        ->orderBy('Asignaturas.idAsignatura')
        ->get();
        return $queryAsignaturasPertenecientesDeAula;
    }
}
