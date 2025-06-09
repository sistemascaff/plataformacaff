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

    public function selectCountTotalLibrosPrestadosEntreFechas($fechaInicio, $fechaFin)
    {
        $queryCountLibrosPrestados = LibroPrestamo::selectRaw('COUNT(LibrosPrestamosDetalles.idLibro) AS totalLibrosPrestados')
            ->whereBetween('LibrosPrestamos.fechaRegistro', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->join('LibrosPrestamosDetalles', 'LibrosPrestamos.idLibrosPrestamo', '=', 'LibrosPrestamosDetalles.idLibrosPrestamo')
            ->count();
        return $queryCountLibrosPrestados;
    }

    public function selectDetalleLibrosPrestadosEntreFechas($fechaInicio, $fechaFin, $orden)
    {
        $queryDetalleLibrosPrestados = LibroPrestamo::select('LibrosPrestamos.idLibrosPrestamo', 'LibrosPrestamosDetalles.idLibro', 'Libros.codigoLibro', 'Libros.nombreLibro', 'Libros.nombreAutor', 'Libros.nombreEditorial', 'LibrosPrestamos.nombreCurso', 'Personas.nombres', 'Personas.apellidoPaterno', 'Personas.apellidoMaterno', 'Personas.tipoPerfil','LibrosPrestamos.fechaRegistro')
            ->join('LibrosPrestamosDetalles', 'LibrosPrestamos.idLibrosPrestamo', '=', 'LibrosPrestamosDetalles.idLibrosPrestamo')
            ->join('Libros', 'LibrosPrestamosDetalles.idLibro', '=', 'Libros.idLibro')
            ->join('Personas', 'LibrosPrestamos.idPersona', '=', 'Personas.idPersona')
            ->whereBetween('LibrosPrestamos.fechaRegistro', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->orderBy('LibrosPrestamos.idLibrosPrestamo', $orden)
            ->orderBy('Libros.codigoLibro', 'ASC')
            ->get();
        return $queryDetalleLibrosPrestados;
    }

    public function selectLibrosPrestadosAgrupadosPorCursoEntreFechas($fechaInicio, $fechaFin, $curso)
    {
        $queryLibrosPrestados = LibroPrestamo::select('LibrosPrestamos.nombreCurso')
            ->selectRaw('COUNT(LibrosPrestamosDetalles.idLibro) AS totalLibrosPrestados')
            ->join('LibrosPrestamosDetalles', 'LibrosPrestamos.idLibrosPrestamo', '=', 'LibrosPrestamosDetalles.idLibrosPrestamo')
            ->join('Libros', 'LibrosPrestamosDetalles.idLibro', '=', 'Libros.idLibro')
            ->whereBetween('LibrosPrestamos.fechaRegistro', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->where('LibrosPrestamos.nombreCurso', 'LIKE', '%' . $curso . '%')
            ->groupBy('LibrosPrestamos.nombreCurso')
            ->orderByRaw('2 DESC, 1 ASC')
            ->get();
        return $queryLibrosPrestados;
    }

    public function selectLibrosPrestadosAgrupadosPorPersonaEntreFechas($fechaInicio, $fechaFin){
        $queryLibrosPrestados = LibroPrestamo::select('Personas.nombres', 'Personas.apellidoPaterno', 'Personas.apellidoMaterno', 'Personas.tipoPerfil', 'LibrosPrestamos.nombreCurso')
            ->selectRaw('COUNT(LibrosPrestamosDetalles.idLibro) AS totalLibrosPrestados')
            ->join('LibrosPrestamosDetalles', 'LibrosPrestamos.idLibrosPrestamo', '=', 'LibrosPrestamosDetalles.idLibrosPrestamo')
            ->join('Libros', 'LibrosPrestamosDetalles.idLibro', '=', 'Libros.idLibro')
            ->join('Personas', 'LibrosPrestamos.idPersona', '=', 'Personas.idPersona')
            ->whereBetween('LibrosPrestamos.fechaRegistro', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->groupBy('Personas.idPersona')
            ->orderByRaw('totalLibrosPrestados DESC, Personas.apellidoPaterno ASC, Personas.apellidoMaterno ASC, Personas.nombres ASC')
            ->get();
        return $queryLibrosPrestados;
    }

    public function selectLibrosPrestadosAgrupadosPorLibroEntreFechas($fechaInicio, $fechaFin)
    {
        $queryLibrosPrestados = LibroPrestamo::select('Libros.codigoLibro', 'Libros.nombreLibro', 'Libros.nombreAutor', 'Libros.nombreEditorial')
            ->selectRaw('COUNT(LibrosPrestamosDetalles.idLibro) AS totalLibrosPrestados')
            ->join('LibrosPrestamosDetalles', 'LibrosPrestamos.idLibrosPrestamo', '=', 'LibrosPrestamosDetalles.idLibrosPrestamo')
            ->join('Libros', 'LibrosPrestamosDetalles.idLibro', '=', 'Libros.idLibro')
            ->whereBetween('LibrosPrestamos.fechaRegistro', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->groupBy('Libros.idLibro')
            ->orderByRaw('totalLibrosPrestados DESC, Libros.codigoLibro ASC')
            ->get();
        return $queryLibrosPrestados;
    }

    public function selectLibrosPrestadosAgrupadosPorCategoriaEntreFechas($fechaInicio, $fechaFin)
    {
        $queryLibrosPrestados = LibroPrestamo::select('Categorias.nombreCategoria')
            ->selectRaw('COUNT(LibrosPrestamosDetalles.idLibro) AS totalLibrosPrestados')
            ->join('LibrosPrestamosDetalles', 'LibrosPrestamos.idLibrosPrestamo', '=', 'LibrosPrestamosDetalles.idLibrosPrestamo')
            ->join('Libros', 'LibrosPrestamosDetalles.idLibro', '=', 'Libros.idLibro')
            ->join('Categorias', 'Libros.idCategoria', '=', 'Categorias.idCategoria')
            ->whereBetween('LibrosPrestamos.fechaRegistro', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->groupBy('Categorias.nombreCategoria')
            ->orderByRaw('totalLibrosPrestados DESC, Categorias.nombreCategoria ASC')
            ->get();
        return $queryLibrosPrestados;
    }

    public function selectLibrosAdeudadosAgrupadosPorPersona()
    {
        $queryLibrosAdeudados = LibroPrestamo::select('Personas.nombres', 'Personas.apellidoPaterno', 'Personas.apellidoMaterno', 'Personas.tipoPerfil', 'LibrosPrestamos.nombreCurso')
            ->selectRaw('COUNT(LibrosPrestamosDetalles.idLibro) AS totalLibrosAdeudados,
            GROUP_CONCAT("• ", Libros.codigoLibro, " - ", Libros.nombreLibro ORDER BY Librosprestamos.fechaRegistro ASC SEPARATOR "<br>") AS librosAdeudados,
            GROUP_CONCAT("• ", DATE_FORMAT(Librosprestamos.fechaRegistro, "%d/%m/%Y") ORDER BY Librosprestamos.fechaRegistro ASC SEPARATOR "<br>") AS fechasPrestamos,
            GROUP_CONCAT("• ", DATEDIFF(CURRENT_TIMESTAMP(), LibrosPrestamos.fechaDevolucion) ORDER BY Librosprestamos.fechaRegistro ASC SEPARATOR "<br>") AS diasRetraso')
            ->join('LibrosPrestamosDetalles', 'LibrosPrestamos.idLibrosPrestamo', '=', 'LibrosPrestamosDetalles.idLibrosPrestamo')
            ->join('Libros', 'LibrosPrestamosDetalles.idLibro', '=', 'Libros.idLibro')
            ->join('Personas', 'LibrosPrestamos.idPersona', '=', 'Personas.idPersona')
            ->whereNull('LibrosPrestamosDetalles.fechaRetorno')
            ->groupBy('Personas.idPersona')
            ->orderByRaw('totalLibrosAdeudados DESC, LibrosPrestamos.nombreCurso, Personas.apellidoPaterno ASC, Personas.apellidoMaterno ASC, Personas.nombres ASC')
            ->get();
        return $queryLibrosAdeudados;
    }
}
