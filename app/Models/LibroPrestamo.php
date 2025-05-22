<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibroPrestamo extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'LibrosPrestamos';

    /*ID de la tabla*/
    protected $primaryKey = 'idLibrosPrestamo';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'LibrosPrestamos' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Área, nombre de Categoria, correo del Usuario que haya modificado algún registro.*/
    public function selectHistorial($busqueda){
        $queryHistorial = LibroPrestamo::select('LibrosPrestamos.idLibrosPrestamo','LibrosPrestamos.idPersona','LibrosPrestamos.nombreCurso','LibrosPrestamos.celular','LibrosPrestamos.fechaDevolucion','LibrosPrestamos.estado','LibrosPrestamos.fechaRegistro','LibrosPrestamos.fechaActualizacion','LibrosPrestamos.idUsuario','Usuarios.correo',
        'Personas.apellidoPaterno','Personas.apellidoMaterno','Personas.nombres','Personas.tipoPerfil')
        ->selectRaw('GROUP_CONCAT(" <span class=\"font-weight-bold ",
        IF(IFNULL(LibrosPrestamosDetalles.fechaRetorno, "-") = "-", "text-info", ""), "\">• (", IF(IFNULL(LibrosPrestamosDetalles.fechaRetorno, "-") = "-", "EN USO", CONCAT("DEVUELTO EL ", DATE_FORMAT(LibrosPrestamosDetalles.fechaRetorno, "%d/%m/%Y %H:%i")) ), ")</span> ",
        Libros.codigoLibro, " - ", Libros.nombreLibro ORDER BY Libros.codigoLibro ASC SEPARATOR "<br>") AS groupConcatLibros,
        GROUP_CONCAT("• ", DATEDIFF(IFNULL(LibrosPrestamosDetalles.fechaRetorno,CURRENT_TIMESTAMP()), LibrosPrestamos.fechaDevolucion), IF(IFNULL(LibrosPrestamosDetalles.fechaRetorno, "-") = "-"," y contando...", "") ORDER BY Libros.codigoLibro ASC SEPARATOR "<br>") AS diasRetraso')
        ->leftjoin('Usuarios', 'LibrosPrestamos.idUsuario', '=', 'Usuarios.idUsuario')
        ->join('Personas', 'LibrosPrestamos.idPersona', '=', 'Personas.idPersona')
        ->join('LibrosPrestamosDetalles', 'LibrosPrestamos.idLibrosPrestamo', '=', 'LibrosPrestamosDetalles.idLibrosPrestamo')
        ->join('Libros', 'LibrosPrestamosDetalles.idLibro', '=', 'Libros.idLibro')

        ->where(function($query) use ($busqueda) {
            $query->where('Personas.nombres', 'LIKE', '%'.$busqueda.'%')
                  ->orWhere('Personas.apellidoPaterno', 'LIKE', '%'.$busqueda.'%')
                  ->orWhere('Personas.apellidoMaterno', 'LIKE', '%'.$busqueda.'%')
                  ->orWhereRaw("CONCAT(Personas.nombres, ' ', Personas.apellidoPaterno) LIKE ?", ['%'.$busqueda.'%'])
                  ->orWhereRaw("CONCAT(Personas.nombres, ' ', Personas.apellidoMaterno) LIKE ?", ['%'.$busqueda.'%'])
                  ->orWhereRaw("CONCAT(Personas.apellidoPaterno, ' ', Personas.nombres) LIKE ?", ['%'.$busqueda.'%'])
                  ->orWhereRaw("CONCAT(Personas.apellidoMaterno, ' ', Personas.nombres) LIKE ?", ['%'.$busqueda.'%'])
                  ->orWhereRaw("CONCAT(Personas.apellidoPaterno, ' ', Personas.apellidoMaterno) LIKE ?", ['%'.$busqueda.'%'])
                  ->orWhereRaw("CONCAT(Personas.apellidoMaterno, ' ', Personas.apellidoPaterno) LIKE ?", ['%'.$busqueda.'%'])
                  ->orWhereRaw("CONCAT(Personas.nombres, ' ', Personas.apellidoPaterno, ' ', Personas.apellidoMaterno) LIKE ?", ['%'.$busqueda.'%'])
                  ->orWhereRaw("CONCAT(Personas.apellidoPaterno, ' ', Personas.apellidoMaterno, ' ', Personas.nombres) LIKE ?", ['%'.$busqueda.'%']);
        })
        ->orderBy('LibrosPrestamos.idLibrosPrestamo', 'DESC')
        ->groupBy('LibrosPrestamos.idLibrosPrestamo')
        ->get();
        return $queryHistorial;
    }

    /**Función que retorna un objeto del modelo LibroPrestamo.*/
    public function selectLibroPrestamo($idLibrosPrestamo){
        $libro = LibroPrestamo::find($idLibrosPrestamo);
        return $libro;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'Libros' pertenecientes a un registro de la tabla 'Areas'.*/
    public function selectLibroPrestamo_Detalles($idLibrosPrestamo){
        $queryDetallesLibroPrestamo = LibroPrestamo::select('Libros.idLibro','Libros.nombreLibro','Libros.codigoLibro','Libros.nombreAutor','Libros.nombreEditorial','LibrosPrestamosDetalles.fechaRetorno')
        ->join('LibrosPrestamosDetalles', 'LibrosPrestamos.idLibrosPrestamo', '=', 'LibrosPrestamosDetalles.idLibrosPrestamo')
        ->join('Libros', 'LibrosPrestamosDetalles.idLibro', '=', 'Libros.idLibro')
        ->where('LibrosPrestamos.idLibrosPrestamo', '=', $idLibrosPrestamo)
        ->orderBy('Libros.codigoLibro')
        ->get();
        return $queryDetallesLibroPrestamo;
    }
}
