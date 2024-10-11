<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Materiales';

    /*ID de la tabla*/
    protected $primaryKey = 'idMaterial';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Materiales' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Áula y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Material::select('Materiales.idMaterial','Materiales.nombreMaterial','Materiales.unidadMedida','Materiales.estado','Materiales.fechaRegistro','Materiales.fechaActualizacion','Materiales.idUsuario', 'Usuarios.correo')
        ->leftjoin('Usuarios', 'Materiales.idUsuario', '=', 'Usuarios.idUsuario')
        ->where('Materiales.estado', '=', 1)
        ->whereAny([
            'Materiales.nombreMaterial',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Materiales.idMaterial')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo Material.*/
    public function selectMaterial($idMaterial){
        $aula = Material::find($idMaterial);
        return $aula;
    }
}
