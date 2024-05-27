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

    public function selectUsuario($idUsuario){
        return Usuario::find($idUsuario);
    }
    public function selectUsuarioConIDPersona($idPersona){ 
        return Usuario::where('idPersona', $idPersona)->first(); 
    }

    public function login($correo, $contrasenha, $ip, $dispositivo){
        
        $sessionRow = Usuario::select('Usuarios.idUsuario','Usuarios.idPersona','Usuarios.correo','Usuarios.tieneAcceso','Usuarios.estado','Roles.idRol')
        ->whereRaw('correo = ' . helper_encapsular($correo) . ' AND contrasenha = ' . helper_encapsular($contrasenha))
        ->join('Roles', 'Usuarios.idUsuario', '=', 'Roles.idUsuario')
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
    
    public function logout(){
        session()->flush();
    }
}