<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'docentes';

    /*ID de la tabla*/
    protected $primaryKey = 'idDocente';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'docentes' y también permite las siguientes búsquedas: 
     * (Sueltos) Nombres, Apellido Paterno, Apellido Materno,
     * (Combinando 2 atributos) Nombres + Apellido Paterno o Materno, Apellido Materno o Paterno + Nombres, Apellido Paterno + Materno o Viceversa,
     * (Combinando 3 atributos) Nombres + Apellido Paterno + Apellido Materno, Apellido Paterno + Apellido Materno + Nombres.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Docente::select(
            /*docentes*/
            'docentes.idDocente','docentes.idPersona','docentes.idNivelSubdirector','docentes.idCoordinacionEncargado',
            'docentes.especialidad','docentes.gradoEstudios','docentes.direccionDomicilio',
            'docentes.estado','docentes.fechaRegistro','docentes.fechaActualizacion',
            'docentes.idUsuario','usuarios.correo',
            'docentes.ip','docentes.dispositivo',
            /*personas*/
            'personas.apellidoPaterno','personas.apellidoMaterno','personas.nombres',
            'personas.documentoIdentificacion','personas.documentoComplemento','personas.documentoExpedido',
            'personas.fechaNacimiento','personas.sexo','personas.idioma',
            'personas.nivelIE','personas.celularPersonal','personas.telefonoPersonal','personas.tipoPerfil',
            /*usuarios*/
            'UsuarioPersonal.correo AS correoPersonal', 'UsuarioPersonal.contrasenha'
            )
        ->leftjoin('usuarios', 'docentes.idUsuario', '=', 'usuarios.idUsuario')
        ->join('usuarios AS UsuarioPersonal', 'docentes.idPersona', '=', 'UsuarioPersonal.idPersona')
        ->join('personas', 'docentes.idPersona', '=', 'personas.idPersona')
        ->where('docentes.estado', '=', 1)
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
        ->orderBy('personas.apellidoPaterno', 'ASC')
        ->orderBy('personas.apellidoMaterno', 'ASC')
        ->orderBy('personas.nombres', 'ASC')
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
        $selectMaterias = Docente::select('materias.idMateria','materias.nombreMateria','materias.nombreCorto','materias.fechaRegistro','materias.fechaActualizacion')
        ->join('materias', 'docentes.idDocente', '=', 'materias.idDocente')
        ->where('materias.idDocente', '=', $idDocente)
        ->where('materias.estado', '=', '1')
        ->orderBy('materias.nombreMateria', 'ASC')
        ->get();
        return $selectMaterias;
    }*/
}
