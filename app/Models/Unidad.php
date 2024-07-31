<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Unidades';

    /*ID de la tabla*/
    protected $primaryKey = 'idUnidad';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Unidades' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Área, nombre de Asignatura, correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Unidad::select('Unidades.idUnidad','Unidades.nombreUnidad','Unidades.posicionOrdinal','Asignaturas.nombreAsignatura','Periodos.nombrePeriodo','Unidades.estado','Unidades.fechaRegistro','Unidades.fechaActualizacion','Unidades.idUsuario','Usuarios.correo')
        ->selectRaw('
            (SUM(Silabos.estado) / (COUNT(Silabos.idSilabo) * 2)) * 100 AS porcentajeAvance
        ')
        ->leftjoin('Usuarios', 'Unidades.idUsuario', '=', 'Usuarios.idUsuario')
        ->join('Asignaturas', 'Unidades.idAsignatura', '=', 'Asignaturas.idAsignatura')
        ->join('Periodos', 'Unidades.idPeriodo', '=', 'Periodos.idPeriodo')
        ->leftJoin('Silabos', function($join) {
            $join->on('Unidades.idUnidad', '=', 'Silabos.idUnidad')
            ->where('Silabos.estado', '>=', '0');
        })
        ->where('Unidades.estado', '=', 1)
        ->where('Asignaturas.estado', '=', 1)
        ->whereAny([
            'Unidades.nombreUnidad',
            'Periodos.nombrePeriodo',
            'Asignaturas.nombreAsignatura',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->groupBy('Unidades.idUnidad', 'Unidades.nombreUnidad', 'Periodos.nombrePeriodo') 
        ->orderBy('Asignaturas.nombreAsignatura')
        ->orderBy('Periodos.posicionOrdinal')
        ->orderBy('Unidades.posicionOrdinal')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Unidad.*/
    public function selectUnidad($idUnidad){
        $unidad = Unidad::find($idUnidad);
        return $unidad;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Silabos' pertenecientes a un registro de la tabla 'Unidades'.*/
    public function selectUnidad_Silabos($idUnidad){
        $querySilabosPertenecientesDeUnidad = Unidad::select('Silabos.idSilabo','Silabos.nombreSilabo','Silabos.estado','Silabos.fechaInicio','Silabos.fechaFin')
        ->join('Silabos', 'Unidades.idUnidad', '=', 'Silabos.idUnidad')
        ->where('Silabos.idUnidad', '=', $idUnidad)
        ->where('Silabos.estado', '>=', '0')
        ->orderBy('Silabos.nombreSilabo', 'ASC')
        ->get();
        return $querySilabosPertenecientesDeUnidad;
    }
}
