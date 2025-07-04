<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Silabo extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'silabos';

    /*ID de la tabla*/
    protected $primaryKey = 'idSilabo';

    /*Modifica los Timestamps por defecto de Eloquent*/
    public $timestamps = false;

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'silabos' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Área, nombre de Unidad, correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Silabo::select('silabos.idSilabo','unidades.nombreUnidad','asignaturas.nombreAsignatura','periodos.nombrePeriodo','silabos.nombreSilabo','silabos.estado','silabos.fechaInicio','silabos.fechaFin','silabos.idUsuario','usuarios.correo')
        ->leftjoin('usuarios', 'silabos.idUsuario', '=', 'usuarios.idUsuario')
        ->join('unidades', 'silabos.idUnidad', '=', 'unidades.idUnidad')
        ->join('asignaturas', 'unidades.idAsignatura', '=', 'asignaturas.idAsignatura')
        ->join('periodos', 'unidades.idPeriodo', '=', 'periodos.idPeriodo')
        ->where('silabos.estado', '>=', 0)
        ->where('unidades.estado', '=', 1)
        ->where('asignaturas.estado', '=', 1)
        ->where('periodos.estado', '=', 1)
        ->whereAny([
            'silabos.nombreSilabo',
            'silabos.estado',
            'unidades.nombreUnidad',
            'usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('asignaturas.nombreAsignatura')
        ->orderBy('periodos.posicionOrdinal')
        ->orderBy('unidades.posicionOrdinal')
        ->orderBy('silabos.nombreSilabo')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Silabo.*/
    public function selectSilabo($idSilabo){
        $silabo = Silabo::find($idSilabo);
        return $silabo;
    }
}
