<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Cursos';
    /*ID de la tabla*/
    protected $primaryKey = 'idCurso';
    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    public function selectDisponibles($busqueda){
        $selectAll = Curso::select('Cursos.idCurso','Cursos.nombreCurso','Grados.nombreGrado','Paralelos.nombreParalelo','Cursos.estado','Cursos.fechaRegistro','Cursos.fechaActualizacion','Cursos.idUsuario','Usuarios.correo')
        ->leftjoin('Usuarios', 'Cursos.idUsuario', '=', 'Usuarios.idUsuario')
        ->join('Grados', 'Cursos.idGrado', '=', 'Grados.idGrado')
        ->join('Paralelos', 'Cursos.idParalelo', '=', 'Paralelos.idParalelo')
        ->join('Niveles', 'Grados.idNivel', '=', 'Niveles.idNivel')
        ->where('Cursos.estado', '=', 1)
        ->whereAny([
            'Cursos.nombreCurso',
            'Grados.nombreGrado',
            'Grados.posicionOrdinal',
            'Paralelos.nombreParalelo',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Niveles.posicionOrdinal', 'ASC')
        ->orderBy('Grados.posicionOrdinal', 'ASC')
        ->get();
        return $selectAll;
    }

    public function selectCurso($idCurso){
        $selectCurso = Curso::find($idCurso);
        return $selectCurso;
    }

    public function selectCurso_Estudiantes($idCurso){
        $selectEstudiantes = Curso::select('Estudiantes.idCurso','Personas.apellidoPaterno','Personas.apellidoMaterno','Personas.nombres','Estudiantes.fechaRegistro','Estudiantes.fechaActualizacion')
        ->join('Estudiantes', 'Cursos.idCurso', '=', 'Estudiantes.idCurso')
        ->join('Personas', 'Personas.idPersona', '=', 'Estudiantes.idPersona')
        ->where('Cursos.idCurso', '=', $idCurso)
        ->where('Estudiantes.estado', '=', '1')
        ->orderBy('Personas.apellidoPaterno', 'ASC')
        ->orderBy('Personas.apellidoMaterno', 'ASC')
        ->orderBy('Personas.nombres', 'ASC')
        ->get();
        return $selectEstudiantes;
    }
}
