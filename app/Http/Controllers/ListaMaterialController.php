<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListaMaterialValidation;
use App\Models\ListaMaterial;
use App\Models\Usuario;
use App\Models\Asignatura;
use App\Models\Material;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ListaMaterialController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'ListasMateriales'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $tableListaMaterial = (new ListaMaterial())->selectDisponibles($request->busqueda);
            $Asignaturas = (new Asignatura())->selectDisponibles('');
            return view('ListaMaterial.inicio', [
                'headTitle' => 'LISTAS DE MATERIALES - INICIO',
                'tableListaMaterial' => $tableListaMaterial,
                'Asignaturas' => $Asignaturas,
                'busqueda' => $request->busqueda
            ]);
        } else {
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra la información de un registro específico de la tabla 'ListasMateriales'.*/
    public function show(Request $request)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $listamaterial = (new ListaMaterial())->selectListasMateriales($request->idAsignatura, $request->idMaterial);
            $usuario = (new Usuario())->selectUsuario($listamaterial->idUsuario);
            $asignatura = (new Asignatura())->selectAsignatura($listamaterial->idAsignatura);
            $material = (new Material())->selectMaterial($listamaterial->idMaterial);
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            return view('ListaMaterial.detalle', [
                'headTitle' => 'MATERIAL DE ' . $asignatura->nombreAsignatura,
                'listamaterial' => $listamaterial,
                'usuario' => $usuario,
                'asignatura' => $asignatura,
                'material' => $material
            ]);
        } else {
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para CREAR un nuevo registro en la tabla 'ListasMateriales'.*/
    public function new(Request $request)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $Asignaturas = (new Asignatura())->selectDisponibles('');
            $Materiales = (new Material())->selectDisponibles('');
            if (!$request->idAsignatura) {
                $idSelect = 0;
            } else {
                $idSelect = $request->idAsignatura;
            }
            return view('ListaMaterial.create', [
                'headTitle' => 'LISTAS DE MATERIALES - NUEVO MATERIAL DE ASIGNATURA',
                'Titulos' => "NUEVO HORARIO",
                'Asignaturas' => $Asignaturas,
                'Materiales' => $Materiales,
                'idSelect' => $idSelect
            ]);
        } else {
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar el registro creado de la tabla 'ListasMateriales' y retorna el método show() con el registro.*/
    public function store(ListaMaterialValidation $request)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $registroExistente = (new ListaMaterial())->selectListasMateriales($request->idAsignatura, $request->idMaterial);

            /*Si el registro no existe, se procede a crearlo, caso contrario, se informa al usuario que el registro con esa asignatura y material ya existe.*/

            if (!$registroExistente) {
                $listamaterial = new ListaMaterial();
                $listamaterial->idAsignatura = $request->idAsignatura;
                $listamaterial->idMaterial = $request->idMaterial;
                $listamaterial->cantidad = $request->cantidad;
                $listamaterial->observacion = strtoupper($request->observacion);
                $listamaterial->idUsuario = session('idUsuario');
                $listamaterial->ip = session('ip');
                $listamaterial->dispositivo  = session('dispositivo');
                $listamaterial->save();
                return redirect()->route('listasmateriales.index');
            } elseif ($registroExistente && $registroExistente->estado != '1') {
                DB::table('listasmateriales')->where('idAsignatura', $request->idAsignatura)->where('idMaterial', $request->idMaterial)
                    ->update([
                        'cantidad' => $request->cantidad,
                        'observacion' => strtoupper($request->observacion),
                        'estado' => '1',
                        'idUsuario' => session('idUsuario'),
                        'ip' => session('ip'),
                        'dispositivo' => session('dispositivo'),
                        'fechaActualizacion' => Carbon::now()
                    ]);
                return redirect()->route('listasmateriales.index');
            } else {
                return redirect()->route('listasmateriales.create')->with([
                    'mensaje' => '¡EL REGISTRO QUE TRATA DE CREAR CON LA RELACIÓN ASIGNATURA - MATERIAL SELECCIONADOS YA EXISTE Y ESTÁ ACTIVO! SE RECOMIENDA EDITAR EL REGISTRO EXISTENTE.',
                    'existenciaIdAsignatura' => $request->idAsignatura,
                    'existenciaIdMaterial' => $request->idMaterial
                ]);
            }
        } else {
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para ACTUALIZAR un registro existente de la tabla 'ListasMateriales'.*/
    public function edit(Request $request)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $listamaterial = (new ListaMaterial())->selectListasMateriales($request->idAsignatura, $request->idMaterial);
            if ($listamaterial) {
                $asignatura = (new Asignatura())->selectAsignatura($listamaterial->idAsignatura);
                $material = (new Material())->selectMaterial($listamaterial->idMaterial);
                return view('ListaMaterial.update', [
                    'headTitle' => 'MATERIAL DE ASIGNATURA - EDITAR',
                    'listamaterial' => $listamaterial,
                    'asignatura' => $asignatura,
                    'material' => $material,
                    'Titulos' => "MODIFICAR DATOS DEL MATERIAL DE ASIGNATURA"
                ]);
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'ListasMateriales' y retorna el método show() con el registro actualizado.*/
    public function update(ListaMaterialValidation $request)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $listamaterial = (new ListaMaterial())->selectListasMateriales($request->idAsignatura, $request->idMaterial);
            if ($listamaterial) {
                DB::table('listasmateriales')->where('idAsignatura', $request->idAsignatura)->where('idMaterial', $request->idMaterial)
                    ->update([
                        'cantidad' => $request->cantidad,
                        'observacion' => strtoupper($request->observacion),
                        'idUsuario' => session('idUsuario'),
                        'ip' => session('ip'),
                        'dispositivo' => session('dispositivo'),
                        'fechaActualizacion' => Carbon::now()
                    ]);
            }
            return redirect()->route('listasmateriales.index');
        } else {
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'ListasMateriales' y retorna el método index().*/
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles((new Rol())->selectRol(session('idRol')), ['admin' => 1])) {
            $request->validate([
                'idAsignatura' => ['required', 'numeric', 'integer'],
                'idMaterial' => ['required', 'numeric', 'integer']
            ]);
            $listamaterial = (new ListaMaterial())->selectListasMateriales($request->idAsignatura, $request->idMaterial);
            if ($listamaterial) {
                if ($listamaterial->estado) {
                    DB::table('listasmateriales')->where('idAsignatura', $request->idAsignatura)->where('idMaterial', $request->idMaterial)
                        ->update([
                            'estado' => '0',
                            'idUsuario' => session('idUsuario'),
                            'ip' => session('ip'),
                            'dispositivo' => session('dispositivo'),
                            'fechaActualizacion' => Carbon::now()
                        ]);
                } else {
                    DB::table('listasmateriales')->where('idAsignatura', $request->idAsignatura)->where('idMaterial', $request->idMaterial)
                        ->update([
                            'estado' => '1',
                            'idUsuario' => session('idUsuario'),
                            'ip' => session('ip'),
                            'dispositivo' => session('dispositivo'),
                            'fechaActualizacion' => Carbon::now()
                        ]);
                }
            }
            return redirect()->route('listasmateriales.index');
        } else {
            return redirect()->route('usuarios.index');
        }
    }
}
