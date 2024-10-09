<?php

namespace App\Http\Controllers;

use App\Http\Requests\LibroValidation;
use App\Models\LibroPrestamo;
use App\Models\Persona;
use App\Models\Libro;
use App\Models\LibroPrestamoDetalle;
use App\Models\Usuario;
use App\Models\Rol;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LibroPrestamoController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'LibrosPrestamos'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
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
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
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
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
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
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
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
                    $libroprestamo->idPersona = $request->idPersona;
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
                    $persona = (new Persona())->selectPersona($request->idPersona);
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
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $Personas = (new Persona())->selectDisponibles('');
            return view('LibroPrestamo.update', [
                'headTitle' => 'EDITAR PRÉSTAMO DE LIBROS N° ' . $libroprestamo->idLibrosPrestamo,
                'libroprestamo' => $libroprestamo,
                'Personas' => $Personas,
                'Titulos' => "MODIFICAR PRÉSTAMO DE LIBRO/S"
            ]);
        } else {
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'LibrosPrestamos' y retorna el método show() con el registro actualizado.*/
    public function update(Request $request, LibroPrestamo $libroprestamo)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $request->validate([
                'idPersona' => ['required', 'numeric', 'integer'],
                'celular' => ['max:20'],
                'fechaDevolucion' => ['date']
            ]);
            $libroprestamo->idPersona = $request->idPersona;
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
            return redirect()->route('librosprestamos.details', $libroprestamo);
        } else {
            return redirect()->route('usuarios.index');
        }
    }

    public function actualizarFechaRetorno(Request $request)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
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
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $libroprestamo = (new LibroPrestamo())->selectLibroPrestamo($idLibrosPrestamo);
            $detalles = (new LibroPrestamo())->selectLibroPrestamo_Detalles($idLibrosPrestamo);
            $persona = (new Persona())->selectPersona($libroprestamo->idPersona);
            $pdf = Pdf::loadView('LibroPrestamo.comprobante', compact('libroprestamo','detalles','persona'));
            return $pdf->stream('COMPROBANTE PRÉSTAMO DE LIBROS N°' . $idLibrosPrestamo . '.pdf');
        } else {
            return redirect()->route('usuarios.index');
        }
    }
}
