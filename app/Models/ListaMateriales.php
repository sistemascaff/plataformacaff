<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaMateriales extends Model
{
    use HasFactory;

    protected $table = 'ListaMateriales';
    protected $primaryKey = ['idAsignatura', 'idMaterial']; // Clave compuesta
    public $incrementing = false;
    public $timestamps = false;
    
    /**Función que permite recuperar los registros disponibles o activos de la tabla 'ListaMateriales' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de ListaMateriales y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = ListaMateriales::select('ListaMateriales.idListaMateriales','ListaMateriales.nombreListaMateriales','ListaMateriales.fechaRegistro','ListaMateriales.fechaActualizacion','ListaMateriales.idUsuario','ListaMateriales.estado', 'Usuarios.correo')
        ->leftjoin('Usuarios', 'ListaMateriales.idUsuario', '=', 'Usuarios.idUsuario')
        ->where('ListaMateriales.estado', '=', 1)
        ->whereAny([
            'ListaMateriales.nombreListaMateriales',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('ListaMateriales.idListaMateriales')
        ->get();
        return $queryActivos;
    }

    /**Función que retorna un objeto del modelo ListaMateriales.*/
    public function selectListaMateriales($idAsignatura,$idMaterial){
        $listamaterial = ListaMateriales::find([$idAsignatura,$idMaterial]);
        return $listamaterial;
    }
}
