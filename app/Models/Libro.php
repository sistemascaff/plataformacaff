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
        $queryActivos = Libro::select('Libros.idLibro','Libros.nombreLibro','Libros.codigoLibro','Libros.nombreAutor','Libros.nombreEditorial','Libros.costo','Libros.observacion','Libros.descripcion','Libros.adquisicion','Libros.prestadoA','Libros.fechaIngresoCooperativa','Libros.estado','Libros.fechaRegistro','Libros.fechaActualizacion','Libros.idUsuario','Usuarios.correo',
        'Categorias.nombreCategoria','Presentaciones.nombrePresentacion')
        ->leftjoin('Usuarios', 'Libros.idUsuario', '=', 'Usuarios.idUsuario')
        ->join('Categorias', 'Libros.idCategoria', '=', 'Categorias.idCategoria')
        ->join('Presentaciones', 'Libros.idPresentacion', '=', 'Presentaciones.idPresentacion')
        /*->where('Libros.estado', '=', 1)*/
        ->whereAny([
            'Libros.nombreLibro',
            'Categorias.nombreCategoria',
            'Libros.nombreAutor',
            'Presentaciones.nombrePresentacion',
            'Libros.nombreEditorial',
            'Usuarios.correo',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Categorias.nombreCategoria')
        ->orderBy('Libros.codigoLibro')
        ->orderBy('Libros.nombreAutor')
        ->orderBy('Libros.nombreEditorial')
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

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Personas' pertenecientes a un registro de la tabla 'Libros'.*/
    public function selectLibro_Prestamos($idLibro){
        $queryPersonasPertenecientesDeLibro = Libro::select('LibrosPrestamos.idLibrosPrestamo','Personas.nombres','Personas.apellidoPaterno','Personas.apellidoMaterno','Personas.tipoPerfil','LibrosPrestamos.fechaRegistro','LibrosPrestamosDetalles.fechaRetorno')
        ->join('LibrosPrestamosDetalles', 'Libros.idLibro', '=', 'LibrosPrestamosDetalles.idLibro')
        ->join('LibrosPrestamos', 'LibrosPrestamosDetalles.idLibrosPrestamo', '=', 'LibrosPrestamos.idLibrosPrestamo')
        ->join('Personas', 'LibrosPrestamos.idPersona', '=', 'Personas.idPersona')
        ->where('LibrosPrestamosDetalles.idLibro', '=', $idLibro)
        ->orderBy('LibrosPrestamos.idLibrosPrestamo', 'DESC')
        ->get();
        return $queryPersonasPertenecientesDeLibro;
    }

    public function selectAutores($busqueda){
        $queryActivos = Libro::select('nombreAutor')
        ->selectraw('COUNT(Libros.idLibro) AS countLibros')
        ->whereAny([
            'Libros.nombreAutor',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Libros.nombreAutor')
        ->distinct()
        ->groupBy('Libros.nombreAutor')
        ->get();
        return $queryActivos;
    }

    public function selectAutor_Libros($nombreAutor){
        $queryLibrosPertenecientesDeAutor = Libro::select('Libros.idLibro','Libros.nombreLibro','Libros.codigoLibro','Libros.costo','Libros.observacion','Libros.descripcion','Libros.adquisicion','Libros.prestadoA','Libros.estado','Libros.fechaRegistro','Libros.fechaActualizacion')
        ->where('Libros.nombreAutor', '=', $nombreAutor)
        ->orderBy('Libros.codigoLibro')
        ->get();
        return $queryLibrosPertenecientesDeAutor;
    }

    public function selectEditoriales($busqueda){
        $queryActivos = Libro::select('nombreEditorial')
        ->selectraw('COUNT(Libros.idLibro) AS countLibros')
        ->whereAny([
            'Libros.nombreEditorial',
        ], 'LIKE', '%'.$busqueda.'%')
        ->orderBy('Libros.nombreEditorial')
        ->distinct()
        ->groupBy('Libros.nombreEditorial')
        ->get();
        return $queryActivos;
    }

    public function selectEditorial_Libros($nombreEditorial){
        $queryLibrosPertenecientesDeEditorial = Libro::select('Libros.idLibro','Libros.nombreLibro','Libros.codigoLibro','Libros.costo','Libros.observacion','Libros.descripcion','Libros.adquisicion','Libros.prestadoA','Libros.estado','Libros.fechaRegistro','Libros.fechaActualizacion')
        ->where('Libros.nombreEditorial', '=', $nombreEditorial)
        ->orderBy('Libros.codigoLibro')
        ->get();
        return $queryLibrosPertenecientesDeEditorial;
    }
}
