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

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Periodos' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Periodo, posición ordinal de Periodo, año de Gestion y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Periodo::select('Periodos.idPeriodo','Gestiones.anhoGestion','Periodos.nombrePeriodo','Periodos.posicionOrdinal','Periodos.estado','Periodos.fechaRegistro','Periodos.fechaActualizacion','Periodos.idUsuario','Usuarios.correo')
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
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Periodo.*/
    public function selectPeriodo($idPeriodo){
        $periodo = Periodo::find($idPeriodo);
        return $periodo;
    }
    
    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Dimensiones' pertenecientes a un registro de la tabla 'Periodos'.*/
    public function selectPeriodo_Dimensiones($idPeriodo){
        $selectPeriodo = Periodo::select('Dimensiones.idDimension','Dimensiones.nombreDimension','Dimensiones.puntajeMaximo','Dimensiones.tipoCalculo','Dimensiones.fechaRegistro','Dimensiones.fechaActualizacion')
        ->join('Dimensiones', 'Periodos.idPeriodo', '=', 'Dimensiones.idPeriodo')
        ->where('Dimensiones.idPeriodo', '=', $idPeriodo)
        ->where('Dimensiones.estado', '=', '1')
        ->orderBy('Dimensiones.idDimension')
        ->get();
        return $selectPeriodo;
    }
}
