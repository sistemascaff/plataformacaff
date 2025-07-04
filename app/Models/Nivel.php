<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'niveles';

    /*ID de la tabla*/
    protected $primaryKey = 'idNivel';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'niveles' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Nivel, posición ordinal de Nivel y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Nivel::select('niveles.idNivel','niveles.nombreNivel','niveles.posicionOrdinal','niveles.fechaRegistro','niveles.fechaActualizacion','niveles.idUsuario','niveles.estado', 'usuarios.correo')
        ->leftjoin('usuarios', 'niveles.idUsuario', '=', 'usuarios.idUsuario')
        ->where('niveles.estado', '=', 1)
        ->whereAny([
            'niveles.nombreNivel',
            'niveles.posicionOrdinal',
            'usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('niveles.idNivel')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Nivel.*/
    public function selectNivel($idNivel){
        $nivel = Nivel::find($idNivel);
        return $nivel;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'grados' pertenecientes a un registro de la tabla 'niveles'.*/
    public function selectNivel_Grados($idNivel){
        $queryGradosPertenecientesDeNivel = Nivel::select('grados.idGrado','grados.nombreGrado','grados.posicionOrdinal','grados.fechaRegistro','grados.fechaActualizacion')
        ->leftjoin('grados', 'niveles.idNivel', '=', 'grados.idNivel')
        ->where('grados.idNivel', '=', $idNivel)
        ->where('grados.estado', '=', '1')
        ->orderBy('grados.idGrado')
        ->get();
        return $queryGradosPertenecientesDeNivel;
    }
}
