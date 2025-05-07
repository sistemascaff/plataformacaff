<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaMaterial extends Model
{
    use HasFactory;

    protected $table = 'ListasMateriales';
    protected $primaryKey = ['idAsignatura', 'idMaterial']; // Clave compuesta
    public $incrementing = false;
    public $timestamps = false;
    
    /**Función que permite recuperar los registros disponibles o activos de la tabla 'ListasMateriales' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de ListasMateriales y correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $query = ListaMaterial::select('Asignaturas.nombreAsignatura','Materiales.nombreMaterial','Materiales.unidadMedida','ListasMateriales.idAsignatura','ListasMateriales.idMaterial',
            'ListasMateriales.cantidad','ListasMateriales.observacion','ListasMateriales.fechaRegistro','ListasMateriales.fechaActualizacion',
            'ListasMateriales.idUsuario','ListasMateriales.estado', 'Usuarios.correo',
            'Personas.nombres','Personas.apellidoPaterno','Personas.apellidoMaterno')
        ->leftjoin('Usuarios', 'ListasMateriales.idUsuario', '=', 'Usuarios.idUsuario')
        ->join('Asignaturas', 'ListasMateriales.idAsignatura', '=', 'Asignaturas.idAsignatura')
        ->join('Materiales', 'ListasMateriales.idMaterial', '=', 'Materiales.idMaterial')
        ->join('Docentes', 'Asignaturas.idDocente', '=', 'Docentes.idDocente')
        ->join('Personas', 'Docentes.idPersona', '=', 'Personas.idPersona')
        ->whereAny([
            'Asignaturas.nombreAsignatura',
            'Materiales.nombreMaterial',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Asignaturas.nombreAsignatura')
        ->get();
        return $query;
    }

    /**Función que retorna un objeto del modelo ListasMateriales.*/
    public function selectListasMateriales($idAsignatura,$idMaterial){
        return ListaMaterial::where('idAsignatura', $idAsignatura)->where('idMaterial', $idMaterial)->first();
    }
}
