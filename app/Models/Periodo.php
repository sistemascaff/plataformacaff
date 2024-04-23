<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Periodos';
    /*ID de la tabla*/
    protected $primaryKey = 'idPeriodo';
    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    public function selectDisponibles($busqueda){
        $selectAll = Periodo::select('Periodos.idPeriodo','Gestiones.anhoGestion','Periodos.nombrePeriodo','Periodos.posicionOrdinal','Periodos.estado','Periodos.fechaRegistro','Periodos.fechaActualizacion','Periodos.idUsuario','Usuarios.correo')
        ->leftjoin('Usuarios', 'Periodos.idUsuario', '=', 'Usuarios.idUsuario')
        ->join('Gestiones', 'Periodos.idGestion', '=', 'Gestiones.idGestion')
        ->where('Periodos.estado', '=', 1)
        ->where('Gestiones.estado', '=', 1)
        ->whereAny([
            'Periodos.nombrePeriodo',
            'Periodos.posicionOrdinal',
            'Gestiones.anhoGestion',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Periodos.idPeriodo')
        ->get();
        return $selectAll;
    }

    public function selectPeriodo($idPeriodo){
        $selectPeriodo = Periodo::find($idPeriodo);
        return $selectPeriodo;
    }
    /*
    public function selectPeriodo_Cursos($idPeriodo){
        $selectPeriodo = Periodo::select('Cursos.idCurso','Cursos.nombreCurso','Cursos.fechaRegistro','Cursos.fechaActualizacion')
        ->join('Cursos', 'Periodos.idPeriodo', '=', 'Cursos.idPeriodo')
        ->where('Cursos.idPeriodo', '=', $idPeriodo)
        ->where('Cursos.estado', '=', '1')
        ->orderBy('Cursos.idCurso')
        ->get();
        return $selectPeriodo;
    }*/
}
