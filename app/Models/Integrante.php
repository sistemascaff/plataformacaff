<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Integrante extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Integrantes';

    /*ID de la tabla*/
    protected $primaryKey = null;

    /*Modifica los Timestamps por defecto de Eloquent*/
    public $timestamps = false;
}
