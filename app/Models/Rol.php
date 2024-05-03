<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Roles';
    /*ID de la tabla*/
    protected $primaryKey = 'idRol';
    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    public function selectRol($idRol){
        $selectRol = Rol::find($idRol);
        if($selectRol){
            session(['rol_admin' => $selectRol->admin]);
            session(['rol_subdirector' => $selectRol->subdirector]);
            session(['rol_secretaria' => $selectRol->secretaria]);
            session(['rol_profesor' => $selectRol->profesor]);
            session(['rol_representante' => $selectRol->representante]);
            session(['rol_estudiante' => $selectRol->estudiante]);
        }
        
        return $selectRol;
    }
    public function verificarRoles(Rol $rolesUsuario = null, array $rolesSolicitados){
        if(!$rolesUsuario){
            return 0;
        }
        $intersection = array_intersect_assoc($rolesUsuario->toArray(), $rolesSolicitados);
        return count($intersection) > 0;
    }
}
