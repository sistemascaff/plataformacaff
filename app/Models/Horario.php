<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Horarios';

    /*ID de la tabla*/
    protected $primaryKey = 'idHorario';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Horarios' y también permite búsquedas.
     * Búsquedas soportadas: Nombre Asignatura y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Horario::select('Horarios.idHorario','Horarios.dia','Horarios.horaInicio','Horarios.horaFin','Asignaturas.nombreAsignatura','Horarios.estado','Horarios.fechaRegistro','Horarios.fechaActualizacion','Horarios.idUsuario','Usuarios.correo')
        ->leftjoin('Usuarios', 'Horarios.idUsuario', '=', 'Usuarios.idUsuario')
        ->join('Asignaturas', 'Horarios.idAsignatura', '=', 'Asignaturas.idAsignatura')
        ->where('Horarios.estado', '=', 1)
        ->where('Asignaturas.estado', '=', 1)
        ->whereAny([
            'Asignaturas.nombreAsignatura',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Horarios.dia')
        ->orderBy('Horarios.horaInicio')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Horario.*/
    public function selectHorario($idHorario){
        $horario = Horario::find($idHorario);
        return $horario;
    }
}
