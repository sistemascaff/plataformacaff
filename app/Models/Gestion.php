<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'gestiones';
    /*ID de la tabla*/
    protected $primaryKey = 'idGestion';
    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'gestiones' y también permite búsquedas.
     * Búsquedas soportadas: Año de la gestión y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Gestion::select('gestiones.idGestion','gestiones.anhoGestion','gestiones.estado','gestiones.fechaRegistro','gestiones.fechaActualizacion','gestiones.idUsuario', 'usuarios.correo')
        ->leftjoin('usuarios', 'gestiones.idUsuario', '=', 'usuarios.idUsuario')
        ->where('gestiones.estado', '=', 1)
        ->whereAny([
            'gestiones.anhoGestion',
            'usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('gestiones.idGestion')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Gestion.*/
    public function selectGestion($idGestion){
        $gestion = Gestion::find($idGestion);
        return $gestion;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'periodos' pertenecientes a un registro de la tabla 'gestiones'.*/
    public function selectGestion_Periodos($idGestion){
        $queryPeriodosPertenecientesDeGestion = Gestion::select('periodos.idPeriodo','periodos.nombrePeriodo','periodos.posicionOrdinal','periodos.fechaRegistro','periodos.fechaActualizacion')
        ->leftjoin('periodos', 'gestiones.idGestion', '=', 'periodos.idGestion')
        ->where('periodos.idGestion', '=', $idGestion)
        ->where('periodos.estado', '=', '1')
        ->orderBy('periodos.posicionOrdinal')
        ->get();
        return $queryPeriodosPertenecientesDeGestion;
    }
}
