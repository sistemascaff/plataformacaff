<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paralelo extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Paralelos';
    /*ID de la tabla*/
    protected $primaryKey = 'idParalelo';
    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    public function selectDisponibles($busqueda){
        $selectAll = Paralelo::select('Paralelos.idParalelo','Paralelos.nombreParalelo','Paralelos.estado','Paralelos.fechaRegistro','Paralelos.fechaActualizacion','Paralelos.idUsuario','Usuarios.correo')
        ->leftjoin('Usuarios', 'Paralelos.idUsuario', '=', 'Usuarios.idUsuario')
        ->where('Paralelos.estado', '=', 1)
        ->whereAny([
            'Paralelos.nombreParalelo',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Paralelos.idParalelo')
        ->get();
        return $selectAll;
    }

    public function selectParalelo($idParalelo){
        $selectParalelo = Paralelo::find($idParalelo);
        return $selectParalelo;
    }

    public function selectParalelo_Cursos($idParalelo){
        $selectParalelo = Paralelo::select('Cursos.idCurso','Cursos.nombreCurso','Cursos.fechaRegistro','Cursos.fechaActualizacion')
        ->leftjoin('Cursos', 'Paralelos.idParalelo', '=', 'Cursos.idParalelo')
        ->where('Cursos.idParalelo', '=', $idParalelo)
        ->where('Cursos.estado', '=', '1')
        ->orderBy('Cursos.idCurso')
        ->get();
        return $selectParalelo;
    }
}
