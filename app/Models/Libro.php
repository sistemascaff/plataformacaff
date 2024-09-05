<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'Libros';

    /*ID de la tabla*/
    protected $primaryKey = 'idLibro';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Libros' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Área, nombre de Categoria, correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Libro::select('Libros.idLibro','Libros.nombreLibro','Libros.codigoLibro','Libros.costo','Libros.observacion','Libros.descripcion','Libros.adquisicion','Libros.prestadoA','Libros.estado','Libros.fechaRegistro','Libros.fechaActualizacion','Libros.idUsuario','Usuarios.correo',
        'Categorias.nombreCategoria','Autores.nombreAutor','Presentaciones.nombrePresentacion','Editoriales.nombreEditorial')
        ->leftjoin('Usuarios', 'Libros.idUsuario', '=', 'Usuarios.idUsuario')
        ->join('Categorias', 'Libros.idCategoria', '=', 'Categorias.idCategoria')
        ->join('Autores', 'Libros.idAutor', '=', 'Autores.idAutor')
        ->join('Presentaciones', 'Libros.idPresentacion', '=', 'Presentaciones.idPresentacion')
        ->join('Editoriales', 'Libros.idEditorial', '=', 'Editoriales.idEditorial')
        /*->where('Libros.estado', '=', 1)*/
        ->whereAny([
            'Libros.nombreLibro',
            'Categorias.nombreCategoria',
            'Autores.nombreAutor',
            'Presentaciones.nombrePresentacion',
            'Editoriales.nombreEditorial',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Categorias.nombreCategoria')
        ->orderBy('Libros.codigoLibro')
        ->orderBy('Autores.nombreAutor')
        ->orderBy('Editoriales.nombreEditorial')
        ->get();
        return $queryActivos;
    }

    public function selectFormatoCodigoLibro(){
        $formatoCodigo = Libro::selectRaw('CONCAT(RIGHT(YEAR(CURRENT_TIMESTAMP()),2),LPAD(COUNT(*) + 1, 3, "0")) AS codigo')
        ->whereRaw('YEAR(fechaRegistro) = ?', date("Y"))
        ->first();
        return $formatoCodigo;
    }

    /**Función que retorna un objeto del modelo Libro.*/
    public function selectLibro($idLibro){
        $libro = Libro::find($idLibro);
        return $libro;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Materias' pertenecientes a un registro de la tabla 'Libros'.*/
    /*
    public function selectLibro_Materias($idLibro){
        $queryMateriasPertenecientesDeLibro = Libro::select('Materias.idMateria','Materias.nombreMateria','Materias.nombreCorto','Materias.fechaRegistro','Materias.fechaActualizacion')
        ->join('Materias', 'Libros.idLibro', '=', 'Materias.idLibro')
        ->where('Materias.idLibro', '=', $idLibro)
        ->where('Materias.estado', '=', '1')
        ->orderBy('Materias.nombreMateria', 'ASC')
        ->get();
        return $queryMateriasPertenecientesDeLibro;
    }*/
}
