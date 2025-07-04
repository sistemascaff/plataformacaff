<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibroPrestamo extends Model
{
    use HasFactory;
    /*Nombre de la tabla*/
    protected $table = 'librosprestamos';

    /*ID de la tabla*/
    protected $primaryKey = 'idLibrosPrestamo';

    /*Modifica los Timestamps por defecto de Eloquent*/
    const CREATED_AT = 'fechaRegistro';
    const UPDATED_AT = 'fechaActualizacion';

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'librosprestamos' y también permite búsquedas.
     * Búsquedas soportadas: Nombre de Área, nombre de Categoria, correo del Usuario que haya modificado algún registro.*/
    public function selectHistorial($busqueda)
    {
        $queryHistorial = LibroPrestamo::select(
            'librosprestamos.idLibrosPrestamo',
            'librosprestamos.idPersona',
            'librosprestamos.nombreCurso',
            'librosprestamos.celular',
            'librosprestamos.fechaDevolucion',
            'librosprestamos.estado',
            'librosprestamos.fechaRegistro',
            'librosprestamos.fechaActualizacion',
            'librosprestamos.idUsuario',
            'usuarios.correo',
            'personas.apellidoPaterno',
            'personas.apellidoMaterno',
            'personas.nombres',
            'personas.tipoPerfil'
        )
            ->selectRaw('GROUP_CONCAT(" <span class=\"font-weight-bold ",
        IF(IFNULL(librosprestamosdetalles.fechaRetorno, "-") = "-", "text-info", ""), "\">• (", IF(IFNULL(librosprestamosdetalles.fechaRetorno, "-") = "-", "EN USO", CONCAT("DEVUELTO EL ", DATE_FORMAT(librosprestamosdetalles.fechaRetorno, "%d/%m/%Y %H:%i")) ), ")</span> ",
        libros.codigoLibro, " - ", libros.nombreLibro ORDER BY libros.codigoLibro ASC SEPARATOR "<br>") AS groupConcatLibros,
        GROUP_CONCAT("• ", DATEDIFF(IFNULL(librosprestamosdetalles.fechaRetorno,CURRENT_TIMESTAMP()), librosprestamos.fechaDevolucion), IF(IFNULL(librosprestamosdetalles.fechaRetorno, "-") = "-"," y contando...", "") ORDER BY libros.codigoLibro ASC SEPARATOR "<br>") AS diasRetraso')
            ->leftjoin('usuarios', 'librosprestamos.idUsuario', '=', 'usuarios.idUsuario')
            ->join('personas', 'librosprestamos.idPersona', '=', 'personas.idPersona')
            ->join('librosprestamosdetalles', 'librosprestamos.idLibrosPrestamo', '=', 'librosprestamosdetalles.idLibrosPrestamo')
            ->join('libros', 'librosprestamosdetalles.idLibro', '=', 'libros.idLibro')

            ->where(function ($query) use ($busqueda) {
                $query->where('personas.nombres', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('personas.apellidoPaterno', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('personas.apellidoMaterno', 'LIKE', '%' . $busqueda . '%')
                    ->orWhereRaw("CONCAT(personas.nombres, ' ', personas.apellidoPaterno) LIKE ?", ['%' . $busqueda . '%'])
                    ->orWhereRaw("CONCAT(personas.nombres, ' ', personas.apellidoMaterno) LIKE ?", ['%' . $busqueda . '%'])
                    ->orWhereRaw("CONCAT(personas.apellidoPaterno, ' ', personas.nombres) LIKE ?", ['%' . $busqueda . '%'])
                    ->orWhereRaw("CONCAT(personas.apellidoMaterno, ' ', personas.nombres) LIKE ?", ['%' . $busqueda . '%'])
                    ->orWhereRaw("CONCAT(personas.apellidoPaterno, ' ', personas.apellidoMaterno) LIKE ?", ['%' . $busqueda . '%'])
                    ->orWhereRaw("CONCAT(personas.apellidoMaterno, ' ', personas.apellidoPaterno) LIKE ?", ['%' . $busqueda . '%'])
                    ->orWhereRaw("CONCAT(personas.nombres, ' ', personas.apellidoPaterno, ' ', personas.apellidoMaterno) LIKE ?", ['%' . $busqueda . '%'])
                    ->orWhereRaw("CONCAT(personas.apellidoPaterno, ' ', personas.apellidoMaterno, ' ', personas.nombres) LIKE ?", ['%' . $busqueda . '%']);
            })
            ->orderBy('librosprestamos.idLibrosPrestamo', 'DESC')
            ->groupBy('librosprestamos.idLibrosPrestamo')
            ->get();
        return $queryHistorial;
    }

    /**Función que retorna un objeto del modelo LibroPrestamo.*/
    public function selectLibroPrestamo($idLibrosPrestamo)
    {
        $libro = LibroPrestamo::find($idLibrosPrestamo);
        return $libro;
    }

    /**Función que permite recuperar los registros disponibles o activos de la tabla 'libros' pertenecientes a un registro de la tabla 'areas'.*/
    public function selectLibroPrestamo_Detalles($idLibrosPrestamo)
    {
        $queryDetallesLibroPrestamo = LibroPrestamo::select('libros.idLibro', 'libros.nombreLibro', 'libros.codigoLibro', 'libros.nombreAutor', 'libros.nombreEditorial', 'librosprestamosdetalles.fechaRetorno')
            ->join('librosprestamosdetalles', 'librosprestamos.idLibrosPrestamo', '=', 'librosprestamosdetalles.idLibrosPrestamo')
            ->join('libros', 'librosprestamosdetalles.idLibro', '=', 'libros.idLibro')
            ->where('librosprestamos.idLibrosPrestamo', '=', $idLibrosPrestamo)
            ->orderBy('libros.codigoLibro')
            ->get();
        return $queryDetallesLibroPrestamo;
    }

    public function selectCountTotalLibrosPrestadosEntreFechas($fechaInicio, $fechaFin)
    {
        $queryCountLibrosPrestados = LibroPrestamo::selectRaw('COUNT(librosprestamosdetalles.idLibro) AS totalLibrosPrestados')
            ->whereBetween('librosprestamos.fechaRegistro', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->join('librosprestamosdetalles', 'librosprestamos.idLibrosPrestamo', '=', 'librosprestamosdetalles.idLibrosPrestamo')
            ->count();
        return $queryCountLibrosPrestados;
    }

    public function selectDetalleLibrosPrestadosEntreFechas($fechaInicio, $fechaFin, $orden)
    {
        $queryDetalleLibrosPrestados = LibroPrestamo::select('librosprestamos.idLibrosPrestamo', 'librosprestamosdetalles.idLibro', 'libros.codigoLibro', 'libros.nombreLibro', 'libros.nombreAutor', 'libros.nombreEditorial', 'librosprestamos.nombreCurso', 'personas.nombres', 'personas.apellidoPaterno', 'personas.apellidoMaterno', 'personas.tipoPerfil', 'librosprestamos.fechaRegistro')
            ->join('librosprestamosdetalles', 'librosprestamos.idLibrosPrestamo', '=', 'librosprestamosdetalles.idLibrosPrestamo')
            ->join('libros', 'librosprestamosdetalles.idLibro', '=', 'libros.idLibro')
            ->join('personas', 'librosprestamos.idPersona', '=', 'personas.idPersona')
            ->whereBetween('librosprestamos.fechaRegistro', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->orderBy('librosprestamos.idLibrosPrestamo', $orden)
            ->orderBy('libros.codigoLibro', 'ASC')
            ->get();
        return $queryDetalleLibrosPrestados;
    }

    public function selectLibrosPrestadosAgrupadosPorCursoEntreFechas($fechaInicio, $fechaFin, $curso)
    {
        $queryLibrosPrestados = LibroPrestamo::select('librosprestamos.nombreCurso')
            ->selectRaw('COUNT(librosprestamosdetalles.idLibro) AS totalLibrosPrestados')
            ->join('librosprestamosdetalles', 'librosprestamos.idLibrosPrestamo', '=', 'librosprestamosdetalles.idLibrosPrestamo')
            ->join('libros', 'librosprestamosdetalles.idLibro', '=', 'libros.idLibro')
            ->whereBetween('librosprestamos.fechaRegistro', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->where('librosprestamos.nombreCurso', 'LIKE', '%' . $curso . '%')
            ->groupBy('librosprestamos.nombreCurso')
            ->orderByRaw('2 DESC, 1 ASC')
            ->get();
        return $queryLibrosPrestados;
    }

    public function selectLibrosPrestadosAgrupadosPorPersonaEntreFechas($fechaInicio, $fechaFin)
    {
        $queryLibrosPrestados = LibroPrestamo::select('personas.nombres', 'personas.apellidoPaterno', 'personas.apellidoMaterno', 'personas.tipoPerfil', 'librosprestamos.nombreCurso')
            ->selectRaw('COUNT(librosprestamosdetalles.idLibro) AS totalLibrosPrestados')
            ->join('librosprestamosdetalles', 'librosprestamos.idLibrosPrestamo', '=', 'librosprestamosdetalles.idLibrosPrestamo')
            ->join('libros', 'librosprestamosdetalles.idLibro', '=', 'libros.idLibro')
            ->join('personas', 'librosprestamos.idPersona', '=', 'personas.idPersona')
            ->whereBetween('librosprestamos.fechaRegistro', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->groupBy('personas.idPersona')
            ->orderByRaw('totalLibrosPrestados DESC, personas.apellidoPaterno ASC, personas.apellidoMaterno ASC, personas.nombres ASC')
            ->get();
        return $queryLibrosPrestados;
    }

    public function selectLibrosPrestadosAgrupadosPorLibroEntreFechas($fechaInicio, $fechaFin)
    {
        $queryLibrosPrestados = LibroPrestamo::select('libros.codigoLibro', 'libros.nombreLibro', 'libros.nombreAutor', 'libros.nombreEditorial')
            ->selectRaw('COUNT(librosprestamosdetalles.idLibro) AS totalLibrosPrestados')
            ->join('librosprestamosdetalles', 'librosprestamos.idLibrosPrestamo', '=', 'librosprestamosdetalles.idLibrosPrestamo')
            ->join('libros', 'librosprestamosdetalles.idLibro', '=', 'libros.idLibro')
            ->whereBetween('librosprestamos.fechaRegistro', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->groupBy('libros.idLibro')
            ->orderByRaw('totalLibrosPrestados DESC, libros.codigoLibro ASC')
            ->get();
        return $queryLibrosPrestados;
    }

    public function selectLibrosPrestadosAgrupadosPorCategoriaEntreFechas($fechaInicio, $fechaFin)
    {
        $queryLibrosPrestados = LibroPrestamo::select('categorias.nombreCategoria')
            ->selectRaw('COUNT(librosprestamosdetalles.idLibro) AS totalLibrosPrestados')
            ->join('librosprestamosdetalles', 'librosprestamos.idLibrosPrestamo', '=', 'librosprestamosdetalles.idLibrosPrestamo')
            ->join('libros', 'librosprestamosdetalles.idLibro', '=', 'libros.idLibro')
            ->join('categorias', 'libros.idCategoria', '=', 'categorias.idCategoria')
            ->whereBetween('librosprestamos.fechaRegistro', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->groupBy('categorias.nombreCategoria')
            ->orderByRaw('totalLibrosPrestados DESC, categorias.nombreCategoria ASC')
            ->get();
        return $queryLibrosPrestados;
    }

    public function selectLibrosAdeudadosAgrupadosPorPersona()
    {
        $queryLibrosAdeudados = LibroPrestamo::select('personas.nombres', 'personas.apellidoPaterno', 'personas.apellidoMaterno', 'personas.tipoPerfil', 'librosprestamos.nombreCurso')
            ->selectRaw('COUNT(librosprestamosdetalles.idLibro) AS totalLibrosAdeudados,
            GROUP_CONCAT("• ", libros.codigoLibro, " - ", libros.nombreLibro ORDER BY librosprestamos.fechaRegistro ASC SEPARATOR "<br>") AS librosAdeudados,
            GROUP_CONCAT("• ", DATE_FORMAT(librosprestamos.fechaRegistro, "%d/%m/%Y") ORDER BY librosprestamos.fechaRegistro ASC SEPARATOR "<br>") AS fechasPrestamos,
            GROUP_CONCAT("• ", DATEDIFF(CURRENT_TIMESTAMP(), librosprestamos.fechaDevolucion) ORDER BY librosprestamos.fechaRegistro ASC SEPARATOR "<br>") AS diasRetraso')
            ->join('librosprestamosdetalles', 'librosprestamos.idLibrosPrestamo', '=', 'librosprestamosdetalles.idLibrosPrestamo')
            ->join('libros', 'librosprestamosdetalles.idLibro', '=', 'libros.idLibro')
            ->join('personas', 'librosprestamos.idPersona', '=', 'personas.idPersona')
            ->whereNull('librosprestamosdetalles.fechaRetorno')
            ->groupBy('personas.idPersona')
            ->orderByRaw('totalLibrosAdeudados DESC, librosprestamos.nombreCurso, personas.apellidoPaterno ASC, personas.apellidoMaterno ASC, personas.nombres ASC')
            ->get();
        return $queryLibrosAdeudados;
    }

    /**
     * Función que permite recuperar los registros activos de la tabla 'personas' y la cantidad de libros prestados por persona.
     */
    public function selectEstadisticasPrestamosPorPersona($minimoLibrosPrestados  = null)
    {
        $query = Persona::select(
            'personas.idPersona',
            'personas.apellidoPaterno',
            'personas.apellidoMaterno',
            'personas.nombres',
            'personas.tipoPerfil',
            'librosprestamos.nombreCurso'
        )
            ->selectRaw('COUNT(CASE WHEN lpdAdeudados.fechaRetorno IS NULL THEN lpdAdeudados.idLibro END) AS totalLibrosAdeudados, COUNT(lpdTodos.idLibro) AS totalLibrosPrestados')
            ->leftJoin('librosprestamos', 'librosprestamos.idPersona', '=', 'personas.idPersona')
            ->leftJoin('librosprestamosdetalles AS lpdAdeudados', function ($join) {
                $join->on('lpdAdeudados.idLibrosPrestamo', '=', 'librosprestamos.idLibrosPrestamo')
                    ->whereNull('lpdAdeudados.fechaRetorno');
            })
            ->leftJoin('librosprestamosdetalles AS lpdTodos', 'lpdTodos.idLibrosPrestamo', '=', 'librosprestamos.idLibrosPrestamo')
            ->where('personas.estado', 1)
            ->groupBy('personas.idPersona', 'personas.apellidoPaterno', 'personas.apellidoMaterno', 'personas.nombres', 'personas.tipoPerfil');

        // Aplicar HAVING si se proporciona el parámetro
        if ($minimoLibrosPrestados  !== null) {
            $query->havingRaw('COUNT(lpdTodos.idLibro) >= ?', [$minimoLibrosPrestados ]);
        }

        return $query->orderByRaw('totalLibrosPrestados DESC, totalLibrosAdeudados DESC, personas.apellidoPaterno ASC, personas.apellidoMaterno ASC, personas.nombres ASC')
            ->get();
    }
}
