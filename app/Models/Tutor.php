<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Tutores';

    /*ID de la tabla*/
    protected $primaryKey = 'idTutor';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Tutores' y también permite las siguientes búsquedas: 
     * (Sueltos) Nombres, Apellido Paterno, Apellido Materno,
     * (Combinando 2 atributos) Nombres + Apellido Paterno o Materno, Apellido Materno o Paterno + Nombres, Apellido Paterno + Materno o Viceversa,
     * (Combinando 3 atributos) Nombres + Apellido Paterno + Apellido Materno, Apellido Paterno + Apellido Materno + Nombres.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Tutor::select(
            /*Tutores : ID's y relacion de empleado o empleador.*/
            'Tutores.idTutor','Tutores.idPersona',
            'Tutores.gradoInstruccion','Tutores.empleoNombreEmpresa','Tutores.empleoOcupacionLaboral',
            'Tutores.empleoDireccion','Tutores.empleoCorreo','Tutores.empleoTelefono','Tutores.empleoCelular',
            /*Tutores : ID's y relacion con el o los estudiantes y datos de RUDE.*/
            'Tutores.relacionEstudiante',
            'Tutores.rudeDepartamento','Tutores.rudeProvincia','Tutores.rudeSeccionOMunicipio',
            'Tutores.rudeLocalidadOComunidad','Tutores.rudeZonaOVilla','Tutores.rudeAvenidaOCalle',
            'Tutores.rudeNumeroVivienda','Tutores.rudePuntoReferencia',
            /*Tutores : Datos de Socio. y Datos de auditoría.*/
            'Tutores.codigoSocio','Tutores.facturacionRazonSocial','Tutores.facturacionNITCI',
            'Tutores.estado','Tutores.fechaRegistro','Tutores.fechaActualizacion',
            'Tutores.idUsuario','Usuarios.correo',
            'Tutores.ip','Tutores.dispositivo',

            /*Personas*/
            'Personas.apellidoPaterno','Personas.apellidoMaterno','Personas.nombres',
            'Personas.documentoIdentificacion','Personas.documentoComplemento','Personas.documentoExpedido',
            'Personas.fechaNacimiento','Personas.sexo','Personas.idioma', 'Personas.celularPersonal','Personas.telefonoPersonal','Personas.tipoPerfil',
            )
        ->leftjoin('Usuarios', 'Tutores.idUsuario', '=', 'Usuarios.idUsuario')
        ->join('Personas', 'Tutores.idPersona', '=', 'Personas.idPersona')
        ->where('Tutores.estado', '=', 1)
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

    /**Función que retorna un objeto del modelo Tutor.*/
    public function selectTutor($idTutor){
        $tutor = Tutor::find($idTutor);
        return $tutor;
    }
}
