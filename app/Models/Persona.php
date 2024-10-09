<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    /*Nombre de la tabla*/
    protected $table = 'Personas';

    /*ID de la tabla*/
    protected $primaryKey = 'idPersona';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función en desuso hasta la fecha, se usó para testear las tablas en las primeras versiones.*/
    public function selectDisponibles(){
        return Persona::all()->where('estado','1');
    }

    /**Función que retorna un objeto del modelo Persona.*/
    public function selectPersona($idPersona){
        $persona = Persona::find($idPersona);
        return $persona;
    }
}
