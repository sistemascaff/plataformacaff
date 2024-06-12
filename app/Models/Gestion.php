<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Gestiones';
    /*ID de la tabla*/
    protected $primaryKey = 'idGestion';
    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Gestiones' y también permite búsquedas.
     * Búsquedas soportadas: Año de la gestión y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Gestion::select('Gestiones.idGestion','Gestiones.anhoGestion','Gestiones.estado','Gestiones.fechaRegistro','Gestiones.fechaActualizacion','Gestiones.idUsuario', 'Usuarios.correo')
        ->leftjoin('Usuarios', 'Gestiones.idUsuario', '=', 'Usuarios.idUsuario')
        ->where('Gestiones.estado', '=', 1)
        ->whereAny([
            'Gestiones.anhoGestion',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Gestiones.idGestion')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Gestion.*/
    public function selectGestion($idGestion){
        $gestion = Gestion::find($idGestion);
        return $gestion;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Periodos' pertenecientes a un registro de la tabla 'Gestiones'.*/
    public function selectGestion_Periodos($idGestion){
        $queryPeriodosPertenecientesDeGestion = Gestion::select('Periodos.idPeriodo','Periodos.nombrePeriodo','Periodos.posicionOrdinal','Periodos.fechaRegistro','Periodos.fechaActualizacion')
        ->leftjoin('Periodos', 'Gestiones.idGestion', '=', 'Periodos.idGestion')
        ->where('Periodos.idGestion', '=', $idGestion)
        ->where('Periodos.estado', '=', '1')
        ->orderBy('Periodos.posicionOrdinal')
        ->get();
        return $queryPeriodosPertenecientesDeGestion;
    }
}
