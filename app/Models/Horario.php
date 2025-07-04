<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'horarios';

    /*ID de la tabla*/
    protected $primaryKey = 'idHorario';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'horarios' y también permite búsquedas.
     * Búsquedas soportadas: Nombre Asignatura y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Horario::select('horarios.idHorario','horarios.dia','horarios.horaInicio','horarios.horaFin','asignaturas.nombreAsignatura','horarios.estado','horarios.fechaRegistro','horarios.fechaActualizacion','horarios.idUsuario','usuarios.correo')
        ->leftjoin('usuarios', 'horarios.idUsuario', '=', 'usuarios.idUsuario')
        ->join('asignaturas', 'horarios.idAsignatura', '=', 'asignaturas.idAsignatura')
        ->where('horarios.estado', '=', 1)
        ->where('asignaturas.estado', '=', 1)
        ->whereAny([
            'asignaturas.nombreAsignatura',
            'usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('horarios.dia')
        ->orderBy('horarios.horaInicio')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Horario.*/
    public function selectHorario($idHorario){
        $horario = Horario::find($idHorario);
        return $horario;
    }
}
