<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'materiales';

    /*ID de la tabla*/
    protected $primaryKey = 'idMaterial';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'materiales' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Áula y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Material::select('materiales.idMaterial','materiales.nombreMaterial','materiales.unidadMedida','materiales.estado','materiales.fechaRegistro','materiales.fechaActualizacion','materiales.idUsuario', 'usuarios.correo')
        ->leftjoin('usuarios', 'materiales.idUsuario', '=', 'usuarios.idUsuario')
        ->where('materiales.estado', '=', 1)
        ->whereAny([
            'materiales.nombreMaterial',
            'usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('materiales.idMaterial')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Material.*/
    public function selectMaterial($idMaterial){
        $aula = Material::find($idMaterial);
        return $aula;
    }
}
