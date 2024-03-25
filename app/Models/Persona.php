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

    public function getAllUsers(){
        return Persona::all()->where('estado','1');
    }
}
