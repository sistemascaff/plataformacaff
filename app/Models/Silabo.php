<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Silabo extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Silabos';

    /*ID de la tabla*/
    protected $primaryKey = 'idSilabo';

    /*Modifica los Timestamps por defecto de Eloquent*/
    public $timestamps = false;

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Silabos' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Área, nombre de Unidad, correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Silabo::select('Silabos.idSilabo','Unidades.nombreUnidad','Asignaturas.nombreAsignatura','Periodos.nombrePeriodo','Silabos.nombreSilabo','Silabos.estado','Silabos.fechaInicio','Silabos.fechaFin','Silabos.idUsuario','Usuarios.correo')
        ->leftjoin('Usuarios', 'Silabos.idUsuario', '=', 'Usuarios.idUsuario')
        ->join('Unidades', 'Silabos.idUnidad', '=', 'Unidades.idUnidad')
        ->join('Asignaturas', 'Unidades.idAsignatura', '=', 'Asignaturas.idAsignatura')
        ->join('Periodos', 'Unidades.idPeriodo', '=', 'Periodos.idPeriodo')
        ->where('Silabos.estado', '>=', 0)
        ->where('Unidades.estado', '=', 1)
        ->where('Asignaturas.estado', '=', 1)
        ->where('Periodos.estado', '=', 1)
        ->whereAny([
            'Silabos.nombreSilabo',
            'Silabos.estado',
            'Unidades.nombreUnidad',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Asignaturas.nombreAsignatura')
        ->orderBy('Periodos.posicionOrdinal')
        ->orderBy('Unidades.posicionOrdinal')
        ->orderBy('Silabos.nombreSilabo')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Silabo.*/
    public function selectSilabo($idSilabo){
        $silabo = Silabo::find($idSilabo);
        return $silabo;
    }
}
