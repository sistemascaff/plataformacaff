<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dimension extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Dimensiones';

    /*ID de la tabla*/
    protected $primaryKey = 'idDimension';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Dimensiones' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Dimensión, nombre de Periodo, año de gestión y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Dimension::select('Dimensiones.idDimension','Dimensiones.idPeriodo','Periodos.nombrePeriodo','Gestiones.anhoGestion','Dimensiones.nombreDimension','Dimensiones.puntajeMaximo','Dimensiones.tipoCalculo','Dimensiones.estado','Dimensiones.fechaRegistro','Dimensiones.fechaActualizacion','Dimensiones.idUsuario','Usuarios.correo')
        ->leftjoin('Usuarios', 'Dimensiones.idUsuario', '=', 'Usuarios.idUsuario')
        ->join('Periodos', 'Dimensiones.idPeriodo', '=', 'Periodos.idPeriodo')
        ->join('Gestiones', 'Periodos.idGestion', '=', 'Gestiones.idGestion')
        ->where('Dimensiones.estado', '=', 1)
        ->where('Periodos.estado', '=', 1)
        ->whereAny([
            'Dimensiones.nombreDimension',
            'Periodos.nombrePeriodo',
            'Gestiones.anhoGestion',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Gestiones.anhoGestion')
        ->orderBy('Periodos.posicionOrdinal')
        ->orderBy('Dimensiones.idDimension')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Dimension.*/
    public function selectDimension($idDimension){
        $dimension = Dimension::find($idDimension);
        return $dimension;
    }
}
