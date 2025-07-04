<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'periodos';

    /*ID de la tabla*/
    protected $primaryKey = 'idPeriodo';
    
    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'periodos' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Periodo, posición ordinal de Periodo, año de Gestion y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Periodo::select('periodos.idPeriodo','gestiones.anhoGestion','periodos.nombrePeriodo','periodos.posicionOrdinal','periodos.estado','periodos.fechaRegistro','periodos.fechaActualizacion','periodos.idUsuario','usuarios.correo')
        ->leftjoin('usuarios', 'periodos.idUsuario', '=', 'usuarios.idUsuario')
        ->join('gestiones', 'periodos.idGestion', '=', 'gestiones.idGestion')
        ->where('periodos.estado', '=', 1)
        ->where('gestiones.estado', '=', 1)
        ->whereAny([
            'periodos.nombrePeriodo',
            'periodos.posicionOrdinal',
            'gestiones.anhoGestion',
            'usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('periodos.idPeriodo')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Periodo.*/
    public function selectPeriodo($idPeriodo){
        $periodo = Periodo::find($idPeriodo);
        return $periodo;
    }
    
    /**Función que permite recuperar los registros disponibles o activos de la tabla 'dimensiones' pertenecientes a un registro de la tabla 'periodos'.*/
    public function selectPeriodo_Dimensiones($idPeriodo){
        $selectPeriodo = Periodo::select('dimensiones.idDimension','dimensiones.nombreDimension','dimensiones.puntajeMaximo','dimensiones.tipoCalculo','dimensiones.fechaRegistro','dimensiones.fechaActualizacion')
        ->join('dimensiones', 'periodos.idPeriodo', '=', 'dimensiones.idPeriodo')
        ->where('dimensiones.idPeriodo', '=', $idPeriodo)
        ->where('dimensiones.estado', '=', '1')
        ->orderBy('dimensiones.idDimension')
        ->get();
        return $selectPeriodo;
    }
}
