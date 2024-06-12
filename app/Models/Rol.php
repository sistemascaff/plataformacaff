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

    /**Método que se utiliza para llamar continuamente los roles de un usuario en el método verificarRoles() y también pensado en caso de actualizar
     * los permisos de un Usuario, dicho Usuario pueda ver los cambios efectuados en tiempo real refrescando su vista.*/
    public function selectRol($idRol){
        $selectRol = Rol::find($idRol);
        if($selectRol){
            session(['rol_admin' => $selectRol->admin]);
            session(['rol_subdirector' => $selectRol->subdirector]);
            session(['rol_coordinador' => $selectRol->coordinador]);
            session(['rol_secretaria' => $selectRol->secretaria]);
            session(['rol_profesor' => $selectRol->profesor]);
            session(['rol_representante' => $selectRol->representante]);
            session(['rol_estudiante' => $selectRol->estudiante]);
        }
        
        return $selectRol;
    }

    /**Método para obtener un objeto Rol mediante un ID de la tabla 'Usuarios'*/
    public function selectRolConIDUsuario($idUsuario){ 
        return Rol::where('idUsuario', $idUsuario)->first(); 
    }
    
    /**Método para verificar si el Usuario cumple con el/los Rol/es Requerido/s para acceder a la Vista solicitada,
     * en caso de cumplir con uno o más roles, se le permitirá al usuario cargar la vista.*/
    public function verificarRoles(Rol $rolesUsuario = null, array $rolesSolicitados){
        if(!$rolesUsuario){
            return 0;
        }
        $intersection = array_intersect_assoc($rolesUsuario->toArray(), $rolesSolicitados);
        return count($intersection) > 0;
    }
}
