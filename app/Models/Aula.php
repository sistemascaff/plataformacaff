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

    public function selectDisponibles($busqueda){
        $selectAll = Aula::select('Aulas.idAula','Aulas.nombreAula','Aulas.estado','Aulas.fechaRegistro','Aulas.fechaActualizacion','Aulas.idUsuario', 'Usuarios.correo')
        ->leftjoin('Usuarios', 'Aulas.idUsuario', '=', 'Usuarios.idUsuario')
        ->where('Aulas.estado', '=', 1)
        ->whereAny([
            'Aulas.nombreAula',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Aulas.idAula')
        ->get();
        return $selectAll;
    }

    public function selectAula($idAula){
        $selectAula = Aula::find($idAula);
        return $selectAula;
    }

    public function selectAula_Asignaturas($idAula){
        $selectAula = Aula::select('Asignaturas.idAsignatura','Asignaturas.nombreAsignatura','Asignaturas.nombreCorto','Asignaturas.tipoCalificacion','Asignaturas.tipoBloque','Asignaturas.tipoAsignatura','Asignaturas.fechaRegistro','Asignaturas.fechaActualizacion')
        ->leftjoin('Asignaturas', 'Aulas.idAula', '=', 'Asignaturas.idAula')
        ->where('Asignaturas.idAula', '=', $idAula)
        ->where('Asignaturas.estado', '=', '1')
        ->orderBy('Asignaturas.idAsignatura')
        ->get();
        return $selectAula;
    }
}
