<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Profesores';
    /*ID de la tabla*/
    protected $primaryKey = 'idProfesor';
    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    public function selectDisponibles($busqueda){
        $selectAll = Profesor::select(
            /*Profesores*/
            'Profesores.idProfesor','Profesores.idPersona','Profesores.idNivelSubdirector','Profesores.idCoordinacionEncargado',
            'Profesores.especialidad','Profesores.gradoEstudios','Profesores.direccionDomicilio',
            'Profesores.estado','Profesores.fechaRegistro','Profesores.fechaActualizacion',
            'Profesores.idUsuario','Usuarios.correo',
            'Profesores.ip','Profesores.dispositivo',
            /*Personas*/
            'Personas.apellidoPaterno','Personas.apellidoMaterno','Personas.nombres',
            'Personas.documentoIdentificacion','Personas.documentoComplemento','Personas.documentoExpedido',
            'Personas.fechaNacimiento','Personas.sexo','Personas.idioma',
            'Personas.nivelIE','Personas.celularPersonal','Personas.telefonoPersonal','Personas.tipoPerfil',
            /*Usuarios*/
            'UsuarioPersonal.correo AS correoPersonal', 'UsuarioPersonal.contrasenha'
            )
        ->leftjoin('Usuarios', 'Profesores.idUsuario', '=', 'Usuarios.idUsuario')
        ->join('Usuarios AS UsuarioPersonal', 'Profesores.idPersona', '=', 'UsuarioPersonal.idPersona')
        ->join('Personas', 'Profesores.idPersona', '=', 'Personas.idPersona')
        ->where('Profesores.estado', '=', 1)
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
        ->orderBy('Personas.apellidoPaterno', 'ASC')
        ->orderBy('Personas.apellidoMaterno', 'ASC')
        ->orderBy('Personas.nombres', 'ASC')
        ->get();
        return $selectAll;
    }    

    public function selectProfesor($idProfesor){
        $selectProfesor = Profesor::find($idProfesor);
        return $selectProfesor;
    }

    /*public function selectProfesor_Materias($idProfesor){
        $selectMaterias = Profesor::select('Materias.idMateria','Materias.nombreMateria','Materias.nombreCorto','Materias.fechaRegistro','Materias.fechaActualizacion')
        ->join('Materias', 'Profesores.idProfesor', '=', 'Materias.idProfesor')
        ->where('Materias.idProfesor', '=', $idProfesor)
        ->where('Materias.estado', '=', '1')
        ->orderBy('Materias.nombreMateria', 'ASC')
        ->get();
        return $selectMaterias;
    }*/
}
