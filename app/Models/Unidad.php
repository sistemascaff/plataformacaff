<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'unidades';

    /*ID de la tabla*/
    protected $primaryKey = 'idUnidad';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'unidades' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Área, nombre de Asignatura, correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Unidad::select('unidades.idUnidad','unidades.nombreUnidad','unidades.posicionOrdinal','asignaturas.nombreAsignatura','periodos.nombrePeriodo','unidades.estado','unidades.fechaRegistro','unidades.fechaActualizacion','unidades.idUsuario','usuarios.correo')
        ->selectRaw('
            (SUM(silabos.estado) / (COUNT(silabos.idSilabo) * 2)) * 100 AS porcentajeAvance
        ')
        ->leftjoin('usuarios', 'unidades.idUsuario', '=', 'usuarios.idUsuario')
        ->join('asignaturas', 'unidades.idAsignatura', '=', 'asignaturas.idAsignatura')
        ->join('periodos', 'unidades.idPeriodo', '=', 'periodos.idPeriodo')
        ->leftJoin('silabos', function($join) {
            $join->on('unidades.idUnidad', '=', 'silabos.idUnidad')
            ->where('silabos.estado', '>=', '0');
        })
        ->where('unidades.estado', '=', 1)
        ->where('asignaturas.estado', '=', 1)
        ->whereAny([
            'unidades.nombreUnidad',
            'periodos.nombrePeriodo',
            'asignaturas.nombreAsignatura',
            'usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->groupBy('unidades.idUnidad', 'unidades.nombreUnidad', 'periodos.nombrePeriodo') 
        ->orderBy('asignaturas.nombreAsignatura')
        ->orderBy('periodos.posicionOrdinal')
        ->orderBy('unidades.posicionOrdinal')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Unidad.*/
    public function selectUnidad($idUnidad){
        $unidad = Unidad::find($idUnidad);
        return $unidad;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'silabos' pertenecientes a un registro de la tabla 'unidades'.*/
    public function selectUnidad_Silabos($idUnidad){
        $querySilabosPertenecientesDeUnidad = Unidad::select('silabos.idSilabo','silabos.nombreSilabo','silabos.estado','silabos.fechaInicio','silabos.fechaFin')
        ->join('silabos', 'unidades.idUnidad', '=', 'silabos.idUnidad')
        ->where('silabos.idUnidad', '=', $idUnidad)
        ->where('silabos.estado', '>=', '0')
        ->orderBy('silabos.nombreSilabo', 'ASC')
        ->get();
        return $querySilabosPertenecientesDeUnidad;
    }
}
