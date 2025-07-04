<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'tutores';

    /*ID de la tabla*/
    protected $primaryKey = 'idTutor';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'tutores' y también permite las siguientes búsquedas: 
     * (Sueltos) Nombres, Apellido Paterno, Apellido Materno,
     * (Combinando 2 atributos) Nombres + Apellido Paterno o Materno, Apellido Materno o Paterno + Nombres, Apellido Paterno + Materno o Viceversa,
     * (Combinando 3 atributos) Nombres + Apellido Paterno + Apellido Materno, Apellido Paterno + Apellido Materno + Nombres.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Tutor::select(
            /*tutores : ID's y relacion de empleado o empleador.*/
            'tutores.idTutor','tutores.idPersona',
            'tutores.gradoInstruccion','tutores.empleoNombreEmpresa','tutores.empleoOcupacionLaboral',
            'tutores.empleoDireccion','tutores.empleoCorreo','tutores.empleoTelefono','tutores.empleoCelular',
            /*tutores : ID's y relacion con el o los estudiantes y datos de RUDE.*/
            'tutores.relacionEstudiante',
            'tutores.rudeDepartamento','tutores.rudeProvincia','tutores.rudeSeccionOMunicipio',
            'tutores.rudeLocalidadOComunidad','tutores.rudeZonaOVilla','tutores.rudeAvenidaOCalle',
            'tutores.rudeNumeroVivienda','tutores.rudePuntoReferencia',
            /*tutores : Datos de Socio. y Datos de auditoría.*/
            'tutores.codigoSocio','tutores.facturacionRazonSocial','tutores.facturacionNITCI',
            'tutores.estado','tutores.fechaRegistro','tutores.fechaActualizacion',
            'tutores.idUsuario','usuarios.correo',
            'tutores.ip','tutores.dispositivo',

            /*personas*/
            'personas.apellidoPaterno','personas.apellidoMaterno','personas.nombres',
            'personas.documentoIdentificacion','personas.documentoComplemento','personas.documentoExpedido',
            'personas.fechaNacimiento','personas.sexo','personas.idioma', 'personas.celularPersonal','personas.telefonoPersonal','personas.tipoPerfil',
            )
        ->leftjoin('usuarios', 'tutores.idUsuario', '=', 'usuarios.idUsuario')
        ->join('personas', 'tutores.idPersona', '=', 'personas.idPersona')
        ->where('tutores.estado', '=', 1)
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

    /**Función que retorna un objeto del modelo Tutor.*/
    public function selectTutor($idTutor){
        $tutor = Tutor::find($idTutor);
        return $tutor;
    }
}
