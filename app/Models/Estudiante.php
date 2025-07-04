<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'estudiantes';

    /*ID de la tabla*/
    protected $primaryKey = 'idEstudiante';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'estudiantes' y también permite las siguientes búsquedas: 
     * (Sueltos) Nombres, Apellido Paterno, Apellido Materno,
     * (Combinando 2 atributos) Nombres + Apellido Paterno o Materno, Apellido Materno o Paterno + Nombres, Apellido Paterno + Materno o Viceversa,
     * (Combinando 3 atributos) Nombres + Apellido Paterno + Apellido Materno, Apellido Paterno + Apellido Materno + Nombres.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Estudiante::select(
            /*estudiantes*/
            'estudiantes.idEstudiante','estudiantes.idPersona','estudiantes.idCurso',
            'estudiantes.saludTipoSangre','estudiantes.saludAlergias','estudiantes.saludDatos',
            'estudiantes.estado','estudiantes.fechaRegistro','estudiantes.fechaActualizacion',
            'estudiantes.idUsuario','usuarios.correo',
            'estudiantes.ip','estudiantes.dispositivo',
            /*Curso*/
            'cursos.nombreCurso',
            /*personas*/
            'personas.apellidoPaterno','personas.apellidoMaterno','personas.nombres',
            'personas.documentoIdentificacion','personas.documentoComplemento','personas.documentoExpedido',
            'personas.fechaNacimiento','personas.sexo','personas.idioma',
            'personas.nivelIE','personas.celularPersonal','personas.telefonoPersonal','personas.tipoPerfil',
            /*usuarios*/
            'UsuarioPersonal.correo AS correoPersonal', 'UsuarioPersonal.contrasenha'
            )
        ->leftjoin('usuarios', 'estudiantes.idUsuario', '=', 'usuarios.idUsuario')
        ->join('usuarios AS UsuarioPersonal', 'estudiantes.idPersona', '=', 'UsuarioPersonal.idPersona')
        ->join('cursos', 'estudiantes.idCurso', '=', 'cursos.idCurso')
        ->join('grados', 'cursos.idGrado', '=', 'grados.idGrado')
        ->join('niveles', 'grados.idNivel', '=', 'niveles.idNivel')
        ->join('personas', 'estudiantes.idPersona', '=', 'personas.idPersona')
        ->where('estudiantes.estado', '=', 1)
        ->where('personas.estado', '=', 1)
        ->where(function($query) use ($busqueda) {
            $query->where('personas.nombres', 'LIKE', '%'.$busqueda.'%')
                  ->orWhere('personas.apellidoPaterno', 'LIKE', '%'.$busqueda.'%')
                  ->orWhere('personas.apellidoMaterno', 'LIKE', '%'.$busqueda.'%')
                  ->orWhereRaw("CONCAT(personas.nombres, ' ', personas.apellidoPaterno) LIKE ?", ['%'.$busqueda.'%'])
                  ->orWhereRaw("CONCAT(personas.nombres, ' ', personas.apellidoMaterno) LIKE ?", ['%'.$busqueda.'%'])
                  ->orWhereRaw("CONCAT(personas.apellidoPaterno, ' ', personas.nombres) LIKE ?", ['%'.$busqueda.'%'])
                  ->orWhereRaw("CONCAT(personas.apellidoMaterno, ' ', personas.nombres) LIKE ?", ['%'.$busqueda.'%'])
                  ->orWhereRaw("CONCAT(personas.apellidoPaterno, ' ', personas.apellidoMaterno) LIKE ?", ['%'.$busqueda.'%'])
                  ->orWhereRaw("CONCAT(personas.apellidoMaterno, ' ', personas.apellidoPaterno) LIKE ?", ['%'.$busqueda.'%'])
                  ->orWhereRaw("CONCAT(personas.nombres, ' ', personas.apellidoPaterno, ' ', personas.apellidoMaterno) LIKE ?", ['%'.$busqueda.'%'])
                  ->orWhereRaw("CONCAT(personas.apellidoPaterno, ' ', personas.apellidoMaterno, ' ', personas.nombres) LIKE ?", ['%'.$busqueda.'%']);
        })
        ->orderBy('niveles.posicionOrdinal', 'ASC')
        ->orderBy('grados.posicionOrdinal', 'ASC')
        ->orderBy('cursos.nombreCurso', 'ASC')
        ->orderBy('personas.apellidoPaterno', 'ASC')
        ->orderBy('personas.apellidoMaterno', 'ASC')
        ->orderBy('personas.nombres', 'ASC')
        ->get();
        return $queryActivos;
    }
    
    /**Función que retorna un objeto del modelo Estudiante.*/
    public function selectEstudiante($idEstudiante){
        $estudiante = Estudiante::find($idEstudiante);
        return $estudiante;
    }

    /**Función que retorna un Estudiante mediante un ID de la tabla 'personas'.*/
    public function selectEstudianteConIDPersona($idPersona){ 
        return Estudiante::where('idPersona', $idPersona)->first(); 
    }

    /* AGREGAR A FUTURO UN QUERY PARA VER LAS MATERIAS DEL ESTUDIANTE
    public function selectEstudiante_Materias($idEstudiante){
        $selectMaterias = Estudiante::select('materias.idMateria','materias.nombreMateria','materias.nombreCorto','materias.fechaRegistro','materias.fechaActualizacion')
        ->join('materias', 'estudiantes.idEstudiante', '=', 'materias.idEstudiante')
        ->where('materias.idEstudiante', '=', $idEstudiante)
        ->where('materias.estado', '=', '1')
        ->orderBy('materias.nombreMateria', 'ASC')
        ->get();
        return $selectMaterias;
    }*/
}
