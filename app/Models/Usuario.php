<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /*Nombre de la tabla*/
    protected $table = 'Usuarios';
    /*ID de la tabla*/
    protected $primaryKey = 'idUsuario';
    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /*
    Si el ID es una cadena, asignarlo así:
    protected $keyType = 'string';

    Si el ID NO es AutoIncremental:
    public $incrementing = false;
    */

    public function getAllUsers(){
        return Usuario::all()->where('estado','1');
        /*
        return Usuario::select('idUsuario','idPersona','idRol','correo','contrasenha','pinRecuperacion','hashRecuperacion','tieneAcceso','estado','fechaRegistro','fechaActualizacion','ultimaConexion','idUsuarioResponsable')
        ->where('estado', '1')
        ->orderByRaw('idUsuario ASC')
        ->limit(1)
        ->get();
        */
    }
    public function details($idUsuario){
        return Usuario::find($idUsuario);
    }

    public function login($correo, $contrasenha){

        $SessionRow = Usuario::select('idUsuario','idPersona','idRol','correo','tieneAcceso','estado')
        ->where('estado', '1')
        ->limit(1)
        ->get();
        if(count($SessionRow)>0) {
            session(['correo' => $SessionRow->correo]);
        }
        /*
        DB::statement('drop table users')
        $SessionRow = Usuario::select('idUsuario','idPersona','idRol','correo','tieneAcceso','estado')->get();
        if ($SessionRow) {
            //session(['correo' => $correo]);
        }*/
    }
    public function logout(){
        session()->flush();
    }
}