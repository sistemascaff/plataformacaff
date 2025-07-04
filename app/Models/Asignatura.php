<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'asignaturas';

    /*ID de la tabla*/
    protected $primaryKey = 'idAsignatura';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'asignaturas' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Asignatura, Abreviatura de Asignatura, nombre de Horario, nombre de Campo y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda)
    {
        $queryActivos = Asignatura::select(
            'asignaturas.idAsignatura',
            'asignaturas.nombreAsignatura',
            'asignaturas.nombreCorto',
            'asignaturas.tipoCalificacion',
            'asignaturas.tipoBloque',
            'asignaturas.tipoAsignatura',
            'asignaturas.estado',
            'asignaturas.fechaRegistro',
            'asignaturas.fechaActualizacion',
            'asignaturas.idUsuario',
            'usuarios.correo',
            'personas.nombres AS docente_nombre',
            'personas.apellidoPaterno AS docente_paterno',
            'personas.apellidoMaterno AS docente_materno',
            'materias.nombreMateria',
            'coordinaciones.nombreCoordinacion',
            'aulas.nombreAula'
        )
            ->leftjoin('usuarios', 'asignaturas.idUsuario', '=', 'usuarios.idUsuario')
            ->join('materias', 'asignaturas.idMateria', '=', 'materias.idMateria')
            ->leftjoin('coordinaciones', 'asignaturas.idCoordinacion', '=', 'coordinaciones.idCoordinacion')
            ->join('aulas', 'asignaturas.idAula', '=', 'aulas.idAula')
            ->join('docentes', 'asignaturas.idDocente', '=', 'docentes.idDocente')
            ->join('personas', 'docentes.idPersona', '=', 'personas.idPersona')
            ->where('asignaturas.estado', '=', 1)
            ->where('materias.estado', '=', 1)
            ->where(function ($query) use ($busqueda) {
                $query->where('usuarios.correo', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('asignaturas.nombreAsignatura', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('asignaturas.nombreCorto', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('coordinaciones.nombreCoordinacion', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('materias.nombreMateria', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('personas.nombres', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('personas.apellidoPaterno', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('personas.apellidoMaterno', 'LIKE', '%' . $busqueda . '%')
                    ->orWhereRaw("CONCAT(personas.nombres, ' ', personas.apellidoPaterno) LIKE ?", ['%' . $busqueda . '%'])
                    ->orWhereRaw("CONCAT(personas.nombres, ' ', personas.apellidoMaterno) LIKE ?", ['%' . $busqueda . '%'])
                    ->orWhereRaw("CONCAT(personas.apellidoPaterno, ' ', personas.nombres) LIKE ?", ['%' . $busqueda . '%'])
                    ->orWhereRaw("CONCAT(personas.apellidoMaterno, ' ', personas.nombres) LIKE ?", ['%' . $busqueda . '%'])
                    ->orWhereRaw("CONCAT(personas.apellidoPaterno, ' ', personas.apellidoMaterno) LIKE ?", ['%' . $busqueda . '%'])
                    ->orWhereRaw("CONCAT(personas.apellidoMaterno, ' ', personas.apellidoPaterno) LIKE ?", ['%' . $busqueda . '%'])
                    ->orWhereRaw("CONCAT(personas.nombres, ' ', personas.apellidoPaterno, ' ', personas.apellidoMaterno) LIKE ?", ['%' . $busqueda . '%'])
                    ->orWhereRaw("CONCAT(personas.apellidoPaterno, ' ', personas.apellidoMaterno, ' ', personas.nombres) LIKE ?", ['%' . $busqueda . '%']);
            })
            ->orderBy('asignaturas.idAsignatura', 'ASC')
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
            /*estudiantes*/
            'estudiantes.idEstudiante',
            'estudiantes.idCurso',
            /*Curso*/
            'cursos.nombreCurso',
            /*personas*/
            'personas.apellidoPaterno',
            'personas.apellidoMaterno',
            'personas.nombres',
            /*usuarios*/
            'usuarios.correo AS correoPersonal'
        )
            ->join('usuarios', 'estudiantes.idPersona', '=', 'usuarios.idPersona')
            ->join('cursos', 'estudiantes.idCurso', '=', 'cursos.idCurso')
            ->join('personas', 'estudiantes.idPersona', '=', 'personas.idPersona')
            ->join('integrantes', 'estudiantes.idEstudiante', '=', 'integrantes.idEstudiante')
            ->where('integrantes.idAsignatura', '=', $idAsignatura)
            ->orderBy('personas.apellidoPaterno', 'ASC')
            ->orderBy('personas.apellidoMaterno', 'ASC')
            ->orderBy('personas.nombres', 'ASC')
            ->get();
        return $queryEstudiantesIntegrantesDeAsignatura;
    }
    

    public function selectAsignatura_UnidadesySilabos($idAsignatura)
    {
        $queryUnidadesySilabosDeAsignatura = Unidad::select( 
            'unidades.idUnidad', 
            'unidades.nombreUnidad', 
            'unidades.posicionOrdinal', 
            'periodos.nombrePeriodo'
        ) 
        ->selectRaw('GROUP_CONCAT(silabos.nombreSilabo ORDER BY silabos.nombreSilabo ASC SEPARATOR "<br>") AS groupConcatSilabos') 
        ->selectRaw('
            (SUM(silabos.estado) / (COUNT(silabos.idSilabo) * 2)) * 100 AS porcentajeAvance
        ')
        ->join('periodos', 'unidades.idPeriodo', '=', 'periodos.idPeriodo') 
        ->leftJoin('silabos', function($join) {
            $join->on('unidades.idUnidad', '=', 'silabos.idUnidad')
            ->where('silabos.estado', '>=', '0');
        }) 
        ->where('unidades.idAsignatura', $idAsignatura)
        ->where('unidades.estado', 1)
        ->groupBy('unidades.idUnidad', 'unidades.nombreUnidad', 'periodos.nombrePeriodo') 
        ->orderBy('periodos.posicionOrdinal', 'ASC') 
        ->orderBy('unidades.posicionOrdinal', 'ASC') 
        ->get();

        return $queryUnidadesySilabosDeAsignatura;
    }

    public function selectAsignatura_horarios($idAsignatura){
        $queryhorariosDeAsignatura = Asignatura::select('horarios.idHorario','horarios.dia','horarios.horaInicio','horarios.horaFin')
        ->leftjoin('horarios', 'asignaturas.idAsignatura', '=', 'horarios.idAsignatura')
        ->where('horarios.idAsignatura', '=', $idAsignatura)
        ->where('horarios.estado', '=', '1')
        ->orderBy('horarios.dia')
        ->orderBy('horarios.horaInicio')
        ->get();
        return $queryhorariosDeAsignatura;
    }

    public function selectAsignatura_Materiales($idAsignatura){
        $querylistasmaterialesDeAsignatura = Asignatura::select(
            'listasmateriales.idAsignatura','listasmateriales.idMaterial','listasmateriales.estado',
            'materiales.nombreMaterial','listasmateriales.cantidad',
            'listasmateriales.observacion','materiales.unidadMedida',
            'listasmateriales.fechaRegistro','listasmateriales.fechaActualizacion')
        ->leftjoin('listasmateriales', 'asignaturas.idAsignatura', '=', 'listasmateriales.idAsignatura')
        ->join('materiales', 'listasmateriales.idMaterial', '=', 'materiales.idMaterial')
        ->where('listasmateriales.idAsignatura', '=', $idAsignatura)
        ->where('listasmateriales.estado', '=', '1')
        ->get();
        return $querylistasmaterialesDeAsignatura;
    }
}
