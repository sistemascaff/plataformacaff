<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Niveles';
    /*ID de la tabla*/
    protected $primaryKey = 'idNivel';
    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    public function selectDisponibles($busqueda){
        $selectAll = Nivel::select('Niveles.idNivel','Niveles.nombreNivel','Niveles.posicionOrdinal','Niveles.fechaRegistro','Niveles.fechaActualizacion','Niveles.idUsuario','Niveles.estado', 'Usuarios.correo')
        ->leftjoin('Usuarios', 'Niveles.idUsuario', '=', 'Usuarios.idUsuario')
        ->where('Niveles.estado', '=', 1)
        ->whereAny([
            'Niveles.nombreNivel',
            'Niveles.posicionOrdinal',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Niveles.idNivel')
        ->get();
        return $selectAll;
    }

    public function selectNivel($idNivel){
        $selectNivel = Nivel::find($idNivel);
        return $selectNivel;
    }

    public function selectNivel_Grados($idNivel){
        $selectNivel = Nivel::select('Grados.idGrado','Grados.nombreGrado','Grados.posicionOrdinal','Grados.fechaRegistro','Grados.fechaActualizacion')
        ->leftjoin('Grados', 'Niveles.idNivel', '=', 'Grados.idNivel')
        ->where('Grados.idNivel', '=', $idNivel)
        ->where('Grados.estado', '=', '1')
        ->orderBy('Grados.idGrado')
        ->get();
        return $selectNivel;
    }
}
