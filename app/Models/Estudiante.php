<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Estudiantes';
    /*ID de la tabla*/
    protected $primaryKey = 'idEstudiante';
    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    public function selectDisponibles($busqueda){
        $selectAll = Estudiante::select(
            /*Estudiantes*/
            'Estudiantes.idEstudiante','Estudiantes.idPersona','Estudiantes.idCurso',
            'Estudiantes.saludTipoSangre','Estudiantes.saludAlergias','Estudiantes.saludDatos',
            'Estudiantes.estado','Estudiantes.fechaRegistro','Estudiantes.fechaActualizacion',
            'Estudiantes.idUsuario','Usuarios.correo',
            'Estudiantes.ip','Estudiantes.dispositivo',
            /*Curso*/
            'Cursos.nombreCurso',
            /*Personas*/
            'Personas.apellidoPaterno','Personas.apellidoMaterno','Personas.nombres',
            'Personas.documentoIdentificacion','Personas.documentoComplemento','Personas.documentoExpedido',
            'Personas.fechaNacimiento','Personas.sexo','Personas.idioma',
            'Personas.nivelIE','Personas.celularPersonal','Personas.telefonoPersonal','Personas.tipoPerfil'
            )
        ->leftjoin('Usuarios', 'Estudiantes.idUsuario', '=', 'Usuarios.idUsuario')
        ->join('Cursos', 'Estudiantes.idCurso', '=', 'Cursos.idCurso')
        ->join('Grados', 'Cursos.idGrado', '=', 'Grados.idGrado')
        ->join('Niveles', 'Grados.idNivel', '=', 'Niveles.idNivel')
        ->join('Personas', 'Estudiantes.idPersona', '=', 'Personas.idPersona')
        ->where('Estudiantes.estado', '=', 1)
        ->where('Personas.estado', '=', 1)
        ->where(function($query) use ($busqueda) {
            $query->where('Personas.nombres', 'LIKE', '%'.$busqueda.'%')
                  ->orWhere('Personas.apellidoPaterno', 'LIKE', '%'.$busqueda.'%')
                  ->orWhere('Personas.apellidoMaterno', 'LIKE', '%'.$busqueda.'%')
                  ->orWhereRaw("CONCAT(Personas.nombres, ' ', Personas.apellidoPaterno) LIKE ?", ['%'.$busqueda.'%'])
                  ->orWhereRaw("CONCAT(Personas.nombres, ' ', Personas.apellidoMaterno) LIKE ?", ['%'.$busqueda.'%'])
                  ->orWhereRaw("CONCAT(Personas.apellidoPaterno, ' ', Personas.nombres) LIKE ?", ['%'.$busqueda.'%'])
                  ->orWhereRaw("CONCAT(Personas.apellidoMaterno, ' ', Personas.nombres) LIKE ?", ['%'.$busqueda.'%'])
                  ->orWhereRaw("CONCAT(Personas.apellidoPaterno, ' ', Personas.apellidoMaterno) LIKE ?", ['%'.$busqueda.'%'])
                  ->orWhereRaw("CONCAT(Personas.apellidoMaterno, ' ', Personas.apellidoPaterno) LIKE ?", ['%'.$busqueda.'%'])
                  ->orWhereRaw("CONCAT(Personas.nombres, ' ', Personas.apellidoPaterno, ' ', Personas.apellidoMaterno) LIKE ?", ['%'.$busqueda.'%'])
                  ->orWhereRaw("CONCAT(Personas.apellidoPaterno, ' ', Personas.apellidoMaterno, ' ', Personas.nombres) LIKE ?", ['%'.$busqueda.'%']);
        })
        ->orderBy('Niveles.posicionOrdinal', 'ASC')
        ->orderBy('Grados.posicionOrdinal', 'ASC')
        ->orderBy('Cursos.nombreCurso', 'ASC')
        ->orderBy('Personas.apellidoPaterno', 'ASC')
        ->orderBy('Personas.apellidoMaterno', 'ASC')
        ->orderBy('Personas.nombres', 'ASC')
        ->get();
        return $selectAll;
    }
    

    public function selectEstudiante($idEstudiante){
        $selectEstudiante = Estudiante::find($idEstudiante);
        return $selectEstudiante;
    }

    /*public function selectEstudiante_Materias($idEstudiante){
        $selectMaterias = Estudiante::select('Materias.idMateria','Materias.nombreMateria','Materias.nombreCorto','Materias.fechaRegistro','Materias.fechaActualizacion')
        ->join('Materias', 'Estudiantes.idEstudiante', '=', 'Materias.idEstudiante')
        ->where('Materias.idEstudiante', '=', $idEstudiante)
        ->where('Materias.estado', '=', '1')
        ->orderBy('Materias.nombreMateria', 'ASC')
        ->get();
        return $selectMaterias;
    }*/
}
