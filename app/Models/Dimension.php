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

    public function selectDisponibles($busqueda){
        $selectAll = Dimension::select('Dimensiones.idDimension','Dimensiones.idPeriodo','Periodos.nombrePeriodo','Gestiones.anhoGestion','Dimensiones.nombreDimension','Dimensiones.puntajeMaximo','Dimensiones.tipoCalculo','Dimensiones.estado','Dimensiones.fechaRegistro','Dimensiones.fechaActualizacion','Dimensiones.idUsuario','Usuarios.correo')
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
        return $selectAll;
    }

    public function selectDimension($idDimension){
        $selectDimension = Dimension::find($idDimension);
        return $selectDimension;
    }
}
