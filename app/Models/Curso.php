<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'cursos';

    /*ID de la tabla*/
    protected $primaryKey = 'idCurso';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'cursos' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Curso, nombre de Grado, posición ordinal de Grado, nombre de paralelo y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Curso::select('cursos.idCurso','cursos.nombreCurso','grados.nombreGrado','paralelos.nombreParalelo','niveles.nombreNivel','cursos.estado','cursos.fechaRegistro','cursos.fechaActualizacion','cursos.idUsuario','usuarios.correo')
        ->leftjoin('usuarios', 'cursos.idUsuario', '=', 'usuarios.idUsuario')
        ->join('grados', 'cursos.idGrado', '=', 'grados.idGrado')
        ->join('paralelos', 'cursos.idParalelo', '=', 'paralelos.idParalelo')
        ->join('niveles', 'grados.idNivel', '=', 'niveles.idNivel')
        ->where('cursos.estado', '=', 1)
        ->whereAny([
            'cursos.nombreCurso',
            'grados.nombreGrado',
            'grados.posicionOrdinal',
            'paralelos.nombreParalelo',
            'usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('niveles.posicionOrdinal', 'ASC')
        ->orderBy('grados.posicionOrdinal', 'ASC')
        ->orderBy('cursos.nombreCurso', 'ASC')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Curso.*/
    public function selectCurso($idCurso){
        $curso = Curso::find($idCurso);
        return $curso;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'estudiantes' pertenecientes a un registro de la tabla 'cursos'.*/
    public function selectCurso_Estudiantes($idCurso){
        $queryEstudiantesPertenecientesDeCurso = Curso::select('estudiantes.idEstudiante','estudiantes.idCurso','personas.apellidoPaterno','personas.apellidoMaterno','personas.nombres','estudiantes.fechaRegistro','estudiantes.fechaActualizacion')
        ->join('estudiantes', 'cursos.idCurso', '=', 'estudiantes.idCurso')
        ->join('personas', 'personas.idPersona', '=', 'estudiantes.idPersona')
        ->where('cursos.idCurso', '=', $idCurso)
        ->where('estudiantes.estado', '=', '1')
        ->orderBy('personas.apellidoPaterno', 'ASC')
        ->orderBy('personas.apellidoMaterno', 'ASC')
        ->orderBy('personas.nombres', 'ASC')
        ->get();
        return $queryEstudiantesPertenecientesDeCurso;
    }
}
