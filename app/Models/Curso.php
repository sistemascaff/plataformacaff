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

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Cursos' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Curso, nombre de Grado, posición ordinal de Grado, nombre de paralelo y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Curso::select('Cursos.idCurso','Cursos.nombreCurso','Grados.nombreGrado','Paralelos.nombreParalelo','Niveles.nombreNivel','Cursos.estado','Cursos.fechaRegistro','Cursos.fechaActualizacion','Cursos.idUsuario','Usuarios.correo')
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
        ->orderBy('Cursos.nombreCurso', 'ASC')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Curso.*/
    public function selectCurso($idCurso){
        $curso = Curso::find($idCurso);
        return $curso;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Estudiantes' pertenecientes a un registro de la tabla 'Cursos'.*/
    public function selectCurso_Estudiantes($idCurso){
        $queryEstudiantesPertenecientesDeCurso = Curso::select('Estudiantes.idEstudiante','Estudiantes.idCurso','Personas.apellidoPaterno','Personas.apellidoMaterno','Personas.nombres','Estudiantes.fechaRegistro','Estudiantes.fechaActualizacion')
        ->join('Estudiantes', 'Cursos.idCurso', '=', 'Estudiantes.idCurso')
        ->join('Personas', 'Personas.idPersona', '=', 'Estudiantes.idPersona')
        ->where('Cursos.idCurso', '=', $idCurso)
        ->where('Estudiantes.estado', '=', '1')
        ->orderBy('Personas.apellidoPaterno', 'ASC')
        ->orderBy('Personas.apellidoMaterno', 'ASC')
        ->orderBy('Personas.nombres', 'ASC')
        ->get();
        return $queryEstudiantesPertenecientesDeCurso;
    }
}
