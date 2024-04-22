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

    public function selectDisponibles($busqueda){
        $selectAll = Gestion::select('Gestiones.idGestion','Gestiones.anhoGestion','Gestiones.estado','Gestiones.fechaRegistro','Gestiones.fechaActualizacion','Gestiones.idUsuario', 'Usuarios.correo')
        ->leftjoin('Usuarios', 'Gestiones.idUsuario', '=', 'Usuarios.idUsuario')
        ->where('Gestiones.estado', '=', 1)
        ->whereAny([
            'Gestiones.anhoGestion',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Gestiones.idGestion')
        ->get();
        return $selectAll;
    }

    public function selectGestion($idGestion){
        $selectGestion = Gestion::find($idGestion);
        return $selectGestion;
    }

    public function selectGestion_Periodos($idGestion){
        $selectGestion = Gestion::select('Periodos.idPeriodo','Periodos.nombrePeriodo','Periodos.posicionOrdinal','Periodos.fechaRegistro','Periodos.fechaActualizacion')
        ->leftjoin('Periodos', 'Gestiones.idGestion', '=', 'Periodos.idGestion')
        ->where('Periodos.idGestion', '=', $idGestion)
        ->where('Periodos.estado', '=', '1')
        ->orderBy('Periodos.posicionOrdinal')
        ->get();
        return $selectGestion;
    }
}
