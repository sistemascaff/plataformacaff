<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaMaterial extends Model
{
    use HasFactory;

    protected $table = 'listasmateriales';
    protected $primaryKey = ['idAsignatura', 'idMaterial']; // Clave compuesta
    public $incrementing = false;
    public $timestamps = false;
    
    /**Función que permite recuperar los registros disponibles o activos de la tabla 'listasmateriales' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de listasmateriales y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $query = ListaMaterial::select('asignaturas.nombreAsignatura','materiales.nombreMaterial','materiales.unidadMedida','listasmateriales.idAsignatura','listasmateriales.idMaterial',
            'listasmateriales.cantidad','listasmateriales.observacion','listasmateriales.fechaRegistro','listasmateriales.fechaActualizacion',
            'listasmateriales.idUsuario','listasmateriales.estado', 'usuarios.correo',
            'personas.nombres','personas.apellidoPaterno','personas.apellidoMaterno')
        ->leftjoin('usuarios', 'listasmateriales.idUsuario', '=', 'usuarios.idUsuario')
        ->join('asignaturas', 'listasmateriales.idAsignatura', '=', 'asignaturas.idAsignatura')
        ->join('materiales', 'listasmateriales.idMaterial', '=', 'materiales.idMaterial')
        ->join('docentes', 'asignaturas.idDocente', '=', 'docentes.idDocente')
        ->join('personas', 'docentes.idPersona', '=', 'personas.idPersona')
        ->whereAny([
            'asignaturas.nombreAsignatura',
            'materiales.nombreMaterial',
            'usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('asignaturas.nombreAsignatura')
        ->get();
        return $query;
    }

    /**Función que retorna un objeto del modelo listasmateriales.*/
    public function selectlistasmateriales($idAsignatura,$idMaterial){
        return ListaMaterial::where('idAsignatura', $idAsignatura)->where('idMaterial', $idMaterial)->first();
    }
}
