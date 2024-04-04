<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Grados';
    /*ID de la tabla*/
    protected $primaryKey = 'idGrado';
    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    public function selectDisponibles(){
        $selectAll = Grado::select('Grados.idGrado','Niveles.nombreNivel','Grados.nombreGrado','Grados.posicionOrdinal','Grados.estado','Grados.fechaRegistro','Grados.fechaActualizacion','Grados.idUsuario','Usuarios.correo')
        ->leftjoin('Usuarios', 'Grados.idUsuario', '=', 'Usuarios.idUsuario')
        ->join('Niveles', 'Grados.idNivel', '=', 'Niveles.idNivel')
        ->where('Grados.estado', '=', 1)
        ->where('Niveles.estado', '=', 1)
        ->orderBy('Grados.idGrado')
        ->get();
        return $selectAll;
    }

    public function selectGrado($idGrado){
        $selectGrado = Grado::find($idGrado);
        return $selectGrado;
    }

    public function selectGrado_Cursos($idGrado){
        $selectGrado = Grado::select('Cursos.idCurso','Cursos.nombreCurso','Cursos.fechaRegistro','Cursos.fechaActualizacion')
        ->join('Cursos', 'Grados.idGrado', '=', 'Cursos.idGrado')
        ->where('Cursos.idGrado', '=', $idGrado)
        ->where('Cursos.estado', '=', '1')
        ->orderBy('Cursos.idCurso')
        ->get();
        return $selectGrado;
    }
}
