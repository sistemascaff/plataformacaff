<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Docentes';

    /*ID de la tabla*/
    protected $primaryKey = 'idDocente';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Docentes' y también permite las siguientes búsquedas: 
     * (Sueltos) Nombres, Apellido Paterno, Apellido Materno,
     * (Combinando 2 atributos) Nombres + Apellido Paterno o Materno, Apellido Materno o Paterno + Nombres, Apellido Paterno + Materno o Viceversa,
     * (Combinando 3 atributos) Nombres + Apellido Paterno + Apellido Materno, Apellido Paterno + Apellido Materno + Nombres.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Docente::select(
            /*Docentes*/
            'Docentes.idDocente','Docentes.idPersona','Docentes.idNivelSubdirector','Docentes.idCoordinacionEncargado',
            'Docentes.especialidad','Docentes.gradoEstudios','Docentes.direccionDomicilio',
            'Docentes.estado','Docentes.fechaRegistro','Docentes.fechaActualizacion',
            'Docentes.idUsuario','Usuarios.correo',
            'Docentes.ip','Docentes.dispositivo',
            /*Personas*/
            'Personas.apellidoPaterno','Personas.apellidoMaterno','Personas.nombres',
            'Personas.documentoIdentificacion','Personas.documentoComplemento','Personas.documentoExpedido',
            'Personas.fechaNacimiento','Personas.sexo','Personas.idioma',
            'Personas.nivelIE','Personas.celularPersonal','Personas.telefonoPersonal','Personas.tipoPerfil',
            /*Usuarios*/
            'UsuarioPersonal.correo AS correoPersonal', 'UsuarioPersonal.contrasenha'
            )
        ->leftjoin('Usuarios', 'Docentes.idUsuario', '=', 'Usuarios.idUsuario')
        ->join('Usuarios AS UsuarioPersonal', 'Docentes.idPersona', '=', 'UsuarioPersonal.idPersona')
        ->join('Personas', 'Docentes.idPersona', '=', 'Personas.idPersona')
        ->where('Docentes.estado', '=', 1)
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
        return $queryActivos;
    }    

    /**Función que retorna un objeto del modelo Docente.*/
    public function selectDocente($idDocente){
        $docente = Docente::find($idDocente);
        return $docente;
    }

    /* AL TERMINAR EL CRUD Y MVC DE LA TABLA ASIGNATURAS, IMPLEMENTAR UN MÉTODO PARA DESPLEGAR LAS ASIGNATURAS DEL DOCENTE.
    public function selectDocente_Materias($idDocente){
        $selectMaterias = Docente::select('Materias.idMateria','Materias.nombreMateria','Materias.nombreCorto','Materias.fechaRegistro','Materias.fechaActualizacion')
        ->join('Materias', 'Docentes.idDocente', '=', 'Materias.idDocente')
        ->where('Materias.idDocente', '=', $idDocente)
        ->where('Materias.estado', '=', '1')
        ->orderBy('Materias.nombreMateria', 'ASC')
        ->get();
        return $selectMaterias;
    }*/
}
