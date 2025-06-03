<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\LibroPrestamo;
use App\Models\Persona;
use App\Models\Libro;
use App\Models\LibroPrestamoDetalle;
use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Curso;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LibroPrestamoController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'LibrosPrestamos'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1])) {
            $tableLibroPrestamo = (new LibroPrestamo())->selectHistorial($request->busqueda);
            return view('LibroPrestamo.inicio', [
                'headTitle' => 'PRÉSTAMOS DE LIBROS - INICIO',
                'tableLibroPrestamo' => $tableLibroPrestamo,
                'busqueda' => $request->busqueda
            ]);
        } else {
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra la información de un registro específico de la tabla 'LibrosPrestamos'.*/
    public function show($idLibrosPrestamo)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1])) {
            $libroprestamo = (new LibroPrestamo())->selectLibroPrestamo($idLibrosPrestamo);
            $usuario = (new Usuario())->selectUsuario($libroprestamo->idUsuario);
            $persona = (new Persona())->selectPersona($libroprestamo->idPersona);
            $Libros = (new LibroPrestamo())->selectLibroPrestamo_Detalles($libroprestamo->idLibrosPrestamo);

            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            return view('LibroPrestamo.detalle', [
                'headTitle' => 'PRÉSTAMO DE LIBROS N° ' . $libroprestamo->idLibrosPrestamo,
                'libroprestamo' => $libroprestamo,
                'usuario' => $usuario,
                'persona' => $persona,
                'Libros' => $Libros
            ]);
        } else {
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para CREAR un nuevo registro en la tabla 'LibrosPrestamos'.*/
    public function new($idSelect = null)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1])) {
            $Personas = (new Persona())->selectDisponibles('');
            $Libros = (new Libro())->selectDisponibles('');
            if (!$idSelect) {
                $idSelect = 0;
            }
            return view('LibroPrestamo.create', [
                'headTitle' => 'NUEVO PRÉSTAMO DE LIBRO/S',
                'Titulos' => "NUEVO PRÉSTAMO DE LIBRO/S",
                'Personas' => $Personas,
                'Libros' => $Libros,
                'idSelect' => $idSelect
            ]);
        } else {
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar el registro creado de la tabla 'LibrosPrestamos' y retorna el método show() con el registro.*/
    public function store(Request $request)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1])) {
            $redireccion = null;
            $esLibroNoDisponible = false;
            foreach ($request->idLibro as $row) {
                $libro = (new Libro())->selectLibro($row);
                if ($libro->estado != 1) {
                    $esLibroNoDisponible = true;
                    $nombreLibro = $libro->codigoLibro . " - " . $libro->nombreLibro;
                    break;
                }
            }
            if ($esLibroNoDisponible) {
                $message = 'EL LIBRO "' . $nombreLibro . '" NO SE ENCUENTRA DISPONIBLE PARA REALIZAR EL PRÉSTAMO, POR FAVOR VUELVA A CARGAR LA PÁGINA';
            } else {
                DB::beginTransaction();
                try {
                    $libroprestamo = new LibroPrestamo();
                    $persona = (new Persona())->selectPersona($request->idPersona);

                    $libroprestamo->idPersona = $request->idPersona;
                    if ($persona->tipoPerfil == 'ESTUDIANTE') {
                        $estudiante = (new Estudiante())->selectEstudianteConIDPersona($persona->idPersona);
                        $curso = (new Curso())->selectCurso($estudiante->idCurso);
                        $libroprestamo->nombreCurso = $curso->nombreCurso;
                    }
                    else{
                        $libroprestamo->nombreCurso = '-';
                    }
                    if(!$request->celular){
                        $libroprestamo->celular = '-';
                    }
                    else{
                        $libroprestamo->celular = $request->celular;
                    }
                    $libroprestamo->fechaDevolucion = $request->fechaDevolucion;
                    $libroprestamo->idUsuario = session('idUsuario');
                    $libroprestamo->ip = session('ip');
                    $libroprestamo->dispositivo  = session('dispositivo');
                    $libroprestamo->save();
                    foreach ($request->idLibro as $row) {
                        $detalle = null;
                        $detalle = new LibroPrestamoDetalle();
                        $detalle->idLibrosPrestamo = $libroprestamo->idLibrosPrestamo;
                        $detalle->idLibro = $row;
                        $detalle->save();

                        $libro = (new Libro())->selectLibro($row);
                        $libro->estado = 2;
                        $libro->prestadoA = trim("(" . $persona->tipoPerfil . ") " . $persona->apellidoPaterno . " " . $persona->apellidoMaterno . " " . $persona->nombres);
                        $libro->save();
                    }
                    DB::commit();
                    $message = "¡Préstamo de libro/s realizado exitosamente!";
                    $redireccion = route('librosprestamos.details', $libroprestamo);
                } catch (\Exception $e) {
                    DB::rollback();
                    $message = $e->getMessage();
                }
            }
            return response()->json([
                'message' => $message,
                'redireccion' => $redireccion
            ]);
        } else {
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para ACTUALIZAR un registro existente de la tabla 'LibrosPrestamos'.*/
    public function edit(LibroPrestamo $libroprestamo)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1])) {
            $Personas = (new Persona())->selectDisponibles('');
            $Libros = (new Libro())->selectDisponibles('');
            return view('LibroPrestamo.update', [
                'headTitle' => 'EDITAR PRÉSTAMO DE LIBROS N° ' . $libroprestamo->idLibrosPrestamo,
                'libroprestamo' => $libroprestamo,
                'Personas' => $Personas,
                'Libros' => $Libros,
                'Titulos' => "MODIFICAR PRÉSTAMO DE LIBRO/S"
            ]);
        } else {
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'LibrosPrestamos' y retorna el método show() con el registro actualizado.*/
    public function update(Request $request, LibroPrestamo $libroprestamo)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1])) {
            $request->validate([
                'idPersona' => ['required', 'numeric', 'integer'],
                'celular' => ['max:20'],
                'fechaDevolucion' => ['date'],
                'idLibro' => ['required', 'numeric', 'integer']
            ]);
            $libroprestamo->idPersona = $request->idPersona;
            $persona = (new Persona())->selectPersona($request->idPersona);
            if ($persona->tipoPerfil == 'ESTUDIANTE') {
                $estudiante = (new Estudiante())->selectEstudianteConIDPersona($persona->idPersona);
                $curso = (new Curso())->selectCurso($estudiante->idCurso);
                $libroprestamo->nombreCurso = $curso->nombreCurso;
            }
            else{
                $libroprestamo->nombreCurso = '-';
            }
            if(!$request->celular){
                $libroprestamo->celular = '-';
            }
            else{
                $libroprestamo->celular = $request->celular;
            }
            $libroprestamo->fechaDevolucion = $request->fechaDevolucion;
            $libroprestamo->idUsuario = session('idUsuario');
            $libroprestamo->ip = session('ip');
            $libroprestamo->dispositivo  = session('dispositivo');
            $libroprestamo->save();

            //Primero se verifica si el usuario ha seleccionado un libro para agregarlo al préstamo.
            if($request->idLibro > 0)
            {
                $libro = (new Libro())->selectLibro($request->idLibro);
                //Si el libro está disponible para préstamo, se procede a revisar si ya existe en la lista de libros prestados.
                if($libro->estado == 1)
                {
                    $Libros = (new LibroPrestamo())->selectLibroPrestamo_Detalles($libroprestamo->idLibrosPrestamo);
                    $libroNoExisteEnElDetalle = true;
                    foreach ($Libros as $row) {
                        if ($row->idLibro == $request->idLibro) {
                            $libroNoExisteEnElDetalle = false;
                            break;
                        }
                    }
                    //Si el libro no existe en la lista de libros prestados, se procede a agregarlo.
                    if ($libroNoExisteEnElDetalle) {
                        $detalle = new LibroPrestamoDetalle();
                        $detalle->idLibrosPrestamo = $libroprestamo->idLibrosPrestamo;
                        $detalle->idLibro = $request->idLibro;
                        $detalle->save();
                        $libro->estado = 2;
                        $libro->prestadoA = trim("(" . $persona->tipoPerfil . ") " . $persona->apellidoPaterno . " " . $persona->apellidoMaterno . " " . $persona->nombres);
                        $libro->save();
                    }
                    else{
                        return redirect()->route('librosprestamos.edit', $libroprestamo)->with([
                            'mensaje' => 'EL LIBRO SELECCIONADO (' . $libro->codigoLibro . ' - ' . $libro->nombreLibro .') YA EXISTE EN ÉSTE PRÉSTAMO.',
                        ]);
                    }
                }
                else{
                        return redirect()->route('librosprestamos.edit', $libroprestamo)->with([
                        'mensaje' => 'EL LIBRO SELECCIONADO (' . $libro->codigoLibro . ' - ' . $libro->nombreLibro .') NO ESTÁ DISPONIBLE PARA SU PRÉSTAMO PORQUE ESTÁ EN USO O ELIMINADO, POR FAVOR VUELVA A CARGAR LA PÁGINA.',
                    ]);
                }
            }
            return redirect()->route('librosprestamos.details', $libroprestamo);
        } else {
            return redirect()->route('usuarios.index');
        }
    }

    public function actualizarFechaRetorno(Request $request)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1])) {
            $request->validate([
                'idLibro' => ['required', 'numeric', 'integer']
            ]);
            $detalle = (new LibroPrestamoDetalle())->selectLibrosPrestamosDetalles($request->idLibrosPrestamo, $request->idLibro);
            if ($detalle->fechaRetorno == null) {
                DB::table('librosprestamosdetalles')->where('idLibrosPrestamo', $request->idLibrosPrestamo)->where('idLibro', $request->idLibro)
                    ->update(['fechaRetorno' => Carbon::now()]);
                DB::table('libros')->where('idLibro', $request->idLibro)
                    ->update(['prestadoA' => '-','estado' => 1]);
            }
            else{
                DB::table('librosprestamosdetalles')->where('idLibrosPrestamo', $request->idLibrosPrestamo)->where('idLibro', $request->idLibro)
                    ->update(['fechaRetorno' => null]);
                DB::table('libros')->where('idLibro', $request->idLibro)
                    ->update(['prestadoA' => $request->nombrePersona,'estado' => 2]);
            }
            DB::table('librosprestamos')->where('idLibrosPrestamo', $request->idLibrosPrestamo)
                ->update([
                    'idUsuario' => session('idUsuario'),
                    'ip' => session('ip'),
                    'dispositivo' => session('dispositivo'),
                    'fechaActualizacion' => Carbon::now()
                ]);
            return redirect()->back()->with('mensaje', 'OK.');
        } else {
            return redirect()->route('usuarios.index');
        }
    }

    public function imprimirComprobante($idLibrosPrestamo){
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1])) {
            $libroprestamo = (new LibroPrestamo())->selectLibroPrestamo($idLibrosPrestamo);
            $detalles = (new LibroPrestamo())->selectLibroPrestamo_Detalles($idLibrosPrestamo);
            $persona = (new Persona())->selectPersona($libroprestamo->idPersona);
            $pdf = Pdf::loadView('LibroPrestamo.comprobante', compact('libroprestamo','detalles','persona'));
            return $pdf->stream('COMPROBANTE PRÉSTAMO DE LIBROS N°' . $idLibrosPrestamo . '.pdf');
        } else {
            return redirect()->route('usuarios.index');
        }
    }

    public function reports(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1] )) {
            $fechaInicio = $request->fechaInicio ? $request->fechaInicio : date('Y-m-d', strtotime('-3 months'));
            $fechaFin = $request->fechaFin ? $request->fechaFin : date('Y-m-d');
            if ($fechaInicio > $fechaFin) {
                return redirect()->route('librosprestamos.reports')->withErrors(['error' => 'La fecha de inicio ingresada (' . date('d/m/Y', strtotime($fechaInicio)) . ') no puede ser mayor a la fecha de fin (' . date('d/m/Y', strtotime($fechaFin)) . ').']);
            }
            $countLibrosPrestados = (new LibroPrestamo())->selectCountTotalLibrosPrestadosEntreFechas($fechaInicio, $fechaFin);
            $LibrosPrestadosDetalle = (new LibroPrestamo())->selectDetalleLibrosPrestadosEntreFechas($fechaInicio, $fechaFin, 'DESC');
            $LibrosPrestadosCantidadGeneral = (new LibroPrestamo())->selectLibrosPrestadosAgrupadosPorCursoEntreFechas($fechaInicio, $fechaFin, '');
            $LibrosPrestadosCantidadNivelPrimaria = (new LibroPrestamo())->selectLibrosPrestadosAgrupadosPorCursoEntreFechas($fechaInicio, $fechaFin, 'PRIMARIA');
            $LibrosPrestadosCantidadNivelSecundaria = (new LibroPrestamo())->selectLibrosPrestadosAgrupadosPorCursoEntreFechas($fechaInicio, $fechaFin, 'SECUNDARIA');
            $LibrosPrestadosCantidadPorOtros = (new LibroPrestamo())->selectLibrosPrestadosAgrupadosPorCursoEntreFechas($fechaInicio, $fechaFin, '-');
            $LibrosPrestadosAgrupadosPorPersona = (new LibroPrestamo())->selectLibrosPrestadosAgrupadosPorPersonaEntreFechas($fechaInicio, $fechaFin);
            $LibrosPrestadosAgrupadosPorLibro = (new LibroPrestamo())->selectLibrosPrestadosAgrupadosPorLibroEntreFechas($fechaInicio, $fechaFin);
            return view('LibroPrestamo.reporte', [
                'headTitle' => 'REPORTES (BIBLIOTECA) - INICIO',
                'fechaInicio' => $fechaInicio,
                'fechaFin' => $fechaFin,
                'countLibrosPrestados' => $countLibrosPrestados,
                'LibrosPrestadosDetalle' => $LibrosPrestadosDetalle,
                'LibrosPrestadosCantidadGeneral' => $LibrosPrestadosCantidadGeneral,
                'LibrosPrestadosCantidadNivelPrimaria' => $LibrosPrestadosCantidadNivelPrimaria,
                'LibrosPrestadosCantidadNivelSecundaria' => $LibrosPrestadosCantidadNivelSecundaria,
                'LibrosPrestadosCantidadPorOtros' => $LibrosPrestadosCantidadPorOtros,
                'LibrosPrestadosAgrupadosPorPersona' => $LibrosPrestadosAgrupadosPorPersona,
                'LibrosPrestadosAgrupadosPorLibro' => $LibrosPrestadosAgrupadosPorLibro
        ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }        
    }

    public function imprimirReporte(Request $request)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1,'bibliotecario' => 1])) {
            $fechaInicio = $request->fechaInicio ? $request->fechaInicio : date('Y-m-d', strtotime('-3 months'));
            $fechaFin = $request->fechaFin ? $request->fechaFin : date('Y-m-d');
            if ($fechaInicio > $fechaFin) {
                return redirect()->route('librosprestamos.reports')->withErrors(['error' => 'La fecha de inicio ingresada (' . date('d/m/Y', strtotime($fechaInicio)) . ') no puede ser mayor a la fecha de fin (' . date('d/m/Y', strtotime($fechaFin)) . ').']);
            }
            
            $countLibrosPrestados = (new LibroPrestamo())->selectCountTotalLibrosPrestadosEntreFechas($fechaInicio, $fechaFin);
            $LibrosPrestadosDetalle = (new LibroPrestamo())->selectDetalleLibrosPrestadosEntreFechas($fechaInicio, $fechaFin, 'ASC');
            $LibrosPrestadosCantidadGeneral = (new LibroPrestamo())->selectLibrosPrestadosAgrupadosPorCursoEntreFechas($fechaInicio, $fechaFin, '');
            $LibrosPrestadosCantidadNivelPrimaria = (new LibroPrestamo())->selectLibrosPrestadosAgrupadosPorCursoEntreFechas($fechaInicio, $fechaFin, 'PRIMARIA');
            $LibrosPrestadosCantidadNivelSecundaria = (new LibroPrestamo())->selectLibrosPrestadosAgrupadosPorCursoEntreFechas($fechaInicio, $fechaFin, 'SECUNDARIA');
            $LibrosPrestadosCantidadPorOtros = (new LibroPrestamo())->selectLibrosPrestadosAgrupadosPorCursoEntreFechas($fechaInicio, $fechaFin, '-');
            $LibrosPrestadosAgrupadosPorPersona = (new LibroPrestamo())->selectLibrosPrestadosAgrupadosPorPersonaEntreFechas($fechaInicio, $fechaFin);
            $LibrosPrestadosAgrupadosPorLibro = (new LibroPrestamo())->selectLibrosPrestadosAgrupadosPorLibroEntreFechas($fechaInicio, $fechaFin);


            $pdf = Pdf::loadView('LibroPrestamo.reporteImpreso', compact('LibrosPrestadosDetalle', 'fechaInicio', 'fechaFin', 'countLibrosPrestados', 'LibrosPrestadosCantidadGeneral', 'LibrosPrestadosCantidadNivelPrimaria', 'LibrosPrestadosCantidadNivelSecundaria', 'LibrosPrestadosCantidadPorOtros', 'LibrosPrestadosAgrupadosPorPersona', 'LibrosPrestadosAgrupadosPorLibro'));
            $pdf->setOption("isPhpEnabled", true);
            return $pdf->stream('REPORTE DE PRÉSTAMOS DE LIBROS ENTRE ' . date('d/m/Y', strtotime($fechaInicio)) . ' Y ' . date('d/m/Y', strtotime($fechaFin)) . '.pdf');
        } else {
            return redirect()->route('usuarios.index');
        }
    }
}
