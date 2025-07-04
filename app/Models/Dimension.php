<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dimension extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'dimensiones';

    /*ID de la tabla*/
    protected $primaryKey = 'idDimension';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'dimensiones' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Dimensión, nombre de Periodo, año de gestión y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Dimension::select('dimensiones.idDimension','dimensiones.idPeriodo','periodos.nombrePeriodo','gestiones.anhoGestion','dimensiones.nombreDimension','dimensiones.puntajeMaximo','dimensiones.tipoCalculo','dimensiones.estado','dimensiones.fechaRegistro','dimensiones.fechaActualizacion','dimensiones.idUsuario','usuarios.correo')
        ->leftjoin('usuarios', 'dimensiones.idUsuario', '=', 'usuarios.idUsuario')
        ->join('periodos', 'dimensiones.idPeriodo', '=', 'periodos.idPeriodo')
        ->join('gestiones', 'periodos.idGestion', '=', 'gestiones.idGestion')
        ->where('dimensiones.estado', '=', 1)
        ->where('periodos.estado', '=', 1)
        ->whereAny([
            'dimensiones.nombreDimension',
            'periodos.nombrePeriodo',
            'gestiones.anhoGestion',
            'usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('gestiones.anhoGestion')
        ->orderBy('periodos.posicionOrdinal')
        ->orderBy('dimensiones.idDimension')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Dimension.*/
    public function selectDimension($idDimension){
        $dimension = Dimension::find($idDimension);
        return $dimension;
    }
}
