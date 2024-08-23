<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Asignaturas';

    /*ID de la tabla*/
    protected $primaryKey = 'idAsignatura';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Asignaturas' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Asignatura, Abreviatura de Asignatura, nombre de Horario, nombre de Campo y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda)
    {
        $queryActivos = Asignatura::select(
            'Asignaturas.idAsignatura',
            'Asignaturas.nombreAsignatura',
            'Asignaturas.nombreCorto',
            'Asignaturas.tipoCalificacion',
            'Asignaturas.tipoBloque',
            'Asignaturas.tipoAsignatura',
            'Asignaturas.estado',
            'Asignaturas.fechaRegistro',
            'Asignaturas.fechaActualizacion',
            'Asignaturas.idUsuario',
            'Usuarios.correo',
            'Personas.nombres AS profesor_nombre',
            'Personas.apellidoPaterno AS profesor_paterno',
            'Personas.apellidoMaterno AS profesor_materno',
            'Materias.nombreMateria',
            'Coordinaciones.nombreCoordinacion',
            'Aulas.nombreAula'
        )
            ->leftjoin('Usuarios', 'Asignaturas.idUsuario', '=', 'Usuarios.idUsuario')
            ->join('Materias', 'Asignaturas.idMateria', '=', 'Materias.idMateria')
            ->leftjoin('Coordinaciones', 'Asignaturas.idCoordinacion', '=', 'Coordinaciones.idCoordinacion')
            ->join('Aulas', 'Asignaturas.idAula', '=', 'Aulas.idAula')
            ->join('Profesores', 'Asignaturas.idProfesor', '=', 'Profesores.idProfesor')
            ->join('Personas', 'Profesores.idPersona', '=', 'Personas.idPersona')
            ->where('Asignaturas.estado', '=', 1)
            ->where('Materias.estado', '=', 1)
            ->where(function ($query) use ($busqueda) {
                $query->where('Usuarios.correo', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('Asignaturas.nombreAsignatura', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('Asignaturas.nombreCorto', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('Coordinaciones.nombreCoordinacion', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('Materias.nombreMateria', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('Personas.nombres', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('Personas.apellidoPaterno', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('Personas.apellidoMaterno', 'LIKE', '%' . $busqueda . '%')
                    ->orWhereRaw("CONCAT(Personas.nombres, ' ', Personas.apellidoPaterno) LIKE ?", ['%' . $busqueda . '%'])
                    ->orWhereRaw("CONCAT(Personas.nombres, ' ', Personas.apellidoMaterno) LIKE ?", ['%' . $busqueda . '%'])
                    ->orWhereRaw("CONCAT(Personas.apellidoPaterno, ' ', Personas.nombres) LIKE ?", ['%' . $busqueda . '%'])
                    ->orWhereRaw("CONCAT(Personas.apellidoMaterno, ' ', Personas.nombres) LIKE ?", ['%' . $busqueda . '%'])
                    ->orWhereRaw("CONCAT(Personas.apellidoPaterno, ' ', Personas.apellidoMaterno) LIKE ?", ['%' . $busqueda . '%'])
                    ->orWhereRaw("CONCAT(Personas.apellidoMaterno, ' ', Personas.apellidoPaterno) LIKE ?", ['%' . $busqueda . '%'])
                    ->orWhereRaw("CONCAT(Personas.nombres, ' ', Personas.apellidoPaterno, ' ', Personas.apellidoMaterno) LIKE ?", ['%' . $busqueda . '%'])
                    ->orWhereRaw("CONCAT(Personas.apellidoPaterno, ' ', Personas.apellidoMaterno, ' ', Personas.nombres) LIKE ?", ['%' . $busqueda . '%']);
            })
            ->orderBy('Asignaturas.idAsignatura', 'ASC')
            ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Asignatura.*/
    public function selectAsignatura($idAsignatura)
    {
        $selectAsignatura = Asignatura::find($idAsignatura);
        return $selectAsignatura;
    }

    
    public function selectAsignatura_Estudiantes($idAsignatura)
    {
        $queryEstudiantesIntegrantesDeAsignatura = Estudiante::select(
            /*Estudiantes*/
            'Estudiantes.idEstudiante',
            'Estudiantes.idCurso',
            /*Curso*/
            'Cursos.nombreCurso',
            /*Personas*/
            'Personas.apellidoPaterno',
            'Personas.apellidoMaterno',
            'Personas.nombres',
            /*Usuarios*/
            'Usuarios.correo AS correoPersonal'
        )
            ->join('Usuarios', 'Estudiantes.idPersona', '=', 'Usuarios.idPersona')
            ->join('Cursos', 'Estudiantes.idCurso', '=', 'Cursos.idCurso')
            ->join('Personas', 'Estudiantes.idPersona', '=', 'Personas.idPersona')
            ->join('Integrantes', 'Estudiantes.idEstudiante', '=', 'Integrantes.idEstudiante')
            ->where('Integrantes.idAsignatura', '=', $idAsignatura)
            ->orderBy('Personas.apellidoPaterno', 'ASC')
            ->orderBy('Personas.apellidoMaterno', 'ASC')
            ->orderBy('Personas.nombres', 'ASC')
            ->get();
        return $queryEstudiantesIntegrantesDeAsignatura;
    }
    

    public function selectAsignatura_UnidadesySilabos($idAsignatura)
    {
        $queryUnidadesySilabosDeAsignatura = Unidad::select( 
            'Unidades.idUnidad', 
            'Unidades.nombreUnidad', 
            'Unidades.posicionOrdinal', 
            'Periodos.nombrePeriodo'
        ) 
        ->selectRaw('GROUP_CONCAT(Silabos.nombreSilabo ORDER BY Silabos.nombreSilabo ASC SEPARATOR "<br>") AS groupConcatSilabos') 
        ->selectRaw('
            (SUM(Silabos.estado) / (COUNT(Silabos.idSilabo) * 2)) * 100 AS porcentajeAvance
        ')
        ->join('Periodos', 'Unidades.idPeriodo', '=', 'Periodos.idPeriodo') 
        ->leftJoin('Silabos', function($join) {
            $join->on('Unidades.idUnidad', '=', 'Silabos.idUnidad')
            ->where('Silabos.estado', '>=', '0');
        }) 
        ->where('Unidades.idAsignatura', $idAsignatura)
        ->where('Unidades.estado', 1)
        ->groupBy('Unidades.idUnidad', 'Unidades.nombreUnidad', 'Periodos.nombrePeriodo') 
        ->orderBy('Periodos.posicionOrdinal', 'ASC') 
        ->orderBy('Unidades.posicionOrdinal', 'ASC') 
        ->get();

        return $queryUnidadesySilabosDeAsignatura;
    }

    public function selectAsignatura_Horarios($idAsignatura){
        $queryHorariosDeAsignatura = Asignatura::select('Horarios.idHorario','Horarios.dia','Horarios.horaInicio','Horarios.horaFin')
        ->leftjoin('Horarios', 'Asignaturas.idAsignatura', '=', 'Horarios.idAsignatura')
        ->where('Horarios.idAsignatura', '=', $idAsignatura)
        ->where('Horarios.estado', '=', '1')
        ->orderBy('Horarios.dia')
        ->orderBy('Horarios.horaInicio')
        ->get();
        return $queryHorariosDeAsignatura;
    }
}
