<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'libros';

    /*ID de la tabla*/
    protected $primaryKey = 'idLibro';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'libros' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Área, nombre de Categoria, correo del Usuario que haya modificado algún registro.*/
    public function selectDisponibles($busqueda){
        $queryActivos = Libro::select('libros.idLibro','libros.nombreLibro','libros.codigoLibro','libros.nombreAutor','libros.nombreEditorial','libros.anhoLibro','libros.costo','libros.observacion','libros.descripcion','libros.adquisicion','libros.prestadoA','libros.fechaIngresoCooperativa','libros.estado','libros.fechaRegistro','libros.fechaActualizacion','libros.idUsuario','usuarios.correo',
        'categorias.nombreCategoria','presentaciones.nombrePresentacion')
        ->selectraw('COUNT(librosprestamosdetalles.idLibro) AS countLibrosPrestamos')
        ->leftjoin('usuarios', 'libros.idUsuario', '=', 'usuarios.idUsuario')
        ->leftjoin('librosprestamosdetalles', 'libros.idLibro', '=', 'librosprestamosdetalles.idLibro')
        ->join('categorias', 'libros.idCategoria', '=', 'categorias.idCategoria')
        ->join('presentaciones', 'libros.idPresentacion', '=', 'presentaciones.idPresentacion')
        /*->where('libros.estado', '=', 1)*/
        ->whereAny([
            'libros.nombreLibro',
            'categorias.nombreCategoria',
            'libros.nombreAutor',
            'presentaciones.nombrePresentacion',
            'libros.nombreEditorial',
            'usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->groupBy('libros.idLibro')
        ->orderBy('categorias.nombreCategoria')
        ->orderBy('libros.codigoLibro')
        ->orderBy('libros.nombreAutor')
        ->orderBy('libros.nombreEditorial')
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

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'personas' pertenecientes a un registro de la tabla 'libros'.*/
    public function selectLibro_Prestamos($idLibro){
        $queryPersonasPertenecientesDeLibro = Libro::select('librosprestamos.idLibrosPrestamo','personas.nombres','personas.apellidoPaterno','personas.apellidoMaterno','personas.tipoPerfil','librosprestamos.fechaRegistro','librosprestamosdetalles.fechaRetorno')
        ->join('librosprestamosdetalles', 'libros.idLibro', '=', 'librosprestamosdetalles.idLibro')
        ->join('librosprestamos', 'librosprestamosdetalles.idLibrosPrestamo', '=', 'librosprestamos.idLibrosPrestamo')
        ->join('personas', 'librosprestamos.idPersona', '=', 'personas.idPersona')
        ->where('librosprestamosdetalles.idLibro', '=', $idLibro)
        ->orderBy('librosprestamos.idLibrosPrestamo', 'DESC')
        ->get();
        return $queryPersonasPertenecientesDeLibro;
    }

    public function selectAutores($busqueda){
        $queryActivos = Libro::select('nombreAutor')
        ->selectraw('COUNT(libros.idLibro) AS countLibros')
        ->whereAny([
            'libros.nombreAutor',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('libros.nombreAutor')
        ->distinct()
        ->groupBy('libros.nombreAutor')
        ->get();
        return $queryActivos;
    }

    public function selectAutor_Libros($nombreAutor){
        $queryLibrosPertenecientesDeAutor = Libro::select('libros.idLibro','libros.nombreLibro','libros.codigoLibro','libros.costo','libros.observacion','libros.descripcion','libros.adquisicion','libros.prestadoA','libros.estado','libros.fechaRegistro','libros.fechaActualizacion')
        ->where('libros.nombreAutor', '=', $nombreAutor)
        ->orderBy('libros.codigoLibro')
        ->get();
        return $queryLibrosPertenecientesDeAutor;
    }

    public function selectEditoriales($busqueda){
        $queryActivos = Libro::select('nombreEditorial')
        ->selectraw('COUNT(libros.idLibro) AS countLibros')
        ->whereAny([
            'libros.nombreEditorial',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('libros.nombreEditorial')
        ->distinct()
        ->groupBy('libros.nombreEditorial')
        ->get();
        return $queryActivos;
    }

    public function selectEditorial_Libros($nombreEditorial){
        $queryLibrosPertenecientesDeEditorial = Libro::select('libros.idLibro','libros.nombreLibro','libros.codigoLibro','libros.costo','libros.observacion','libros.descripcion','libros.adquisicion','libros.prestadoA','libros.estado','libros.fechaRegistro','libros.fechaActualizacion')
        ->where('libros.nombreEditorial', '=', $nombreEditorial)
        ->orderBy('libros.codigoLibro')
        ->get();
        return $queryLibrosPertenecientesDeEditorial;
    }
}
