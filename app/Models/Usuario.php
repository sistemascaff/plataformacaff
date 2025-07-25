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
    protected $table = 'usuarios';

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

    /**Método en desuso, utilizado en las primeras versiones para pruebas. */
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

    /**Función que retorna un objeto del modelo Usuario.*/
    public function selectUsuario($idUsuario){
        $usuario = Usuario::find($idUsuario);
        return $usuario;
    }

    /**Función que retorna un Usuario mediante un ID de la tabla 'personas'.*/
    public function selectUsuarioConIDPersona($idPersona){ 
        return Usuario::where('idPersona', $idPersona)->first(); 
    }

    /**Función utilizada para verificar y crear la sesión del Usuario.*/
    public function login($correo, $contrasenha, $ip, $dispositivo){
        $sessionRow = Usuario::select('usuarios.idUsuario','usuarios.idPersona','usuarios.correo','usuarios.tieneAcceso','usuarios.estado','roles.idRol')
        ->where('usuarios.correo', '=', $correo)
        ->where('usuarios.contrasenha', '=', helper_encrypt($contrasenha))
        ->join('roles', 'usuarios.idUsuario', '=', 'roles.idUsuario')
        ->limit(1)
        ->get();
        if($sessionRow) {
            foreach($sessionRow as $row){
                session(['idColegio' => 1]);
                session(['idUsuario' => $row->idUsuario]);
                session(['idPersona' => $row->idPersona]);
                session(['correo' => $row->correo]);
                session(['tieneAcceso' => $row->tieneAcceso]);
                session(['estado' => $row->estado]);
                session(['idRol' => $row->idRol]);
                session(['ip' => $ip]);
                session(['dispositivo' => $dispositivo]);
            }
        }
        return count($sessionRow);
    }

    /**Función para destruir y cerrar la sesión.*/
    public function logout(){
        session()->flush();
    }
}