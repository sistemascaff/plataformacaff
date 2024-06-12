<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeriodoValidation;
use App\Models\Dimension;
use App\Models\Periodo;
use App\Models\Usuario;
use App\Models\Gestion;
use App\Models\Rol;
use Illuminate\Http\Request;

class PeriodoController extends Controller
{
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $tablePeriodo = (new Periodo())->selectDisponibles($request->busqueda);
            return view('Periodo.inicio', [
                'headTitle' => 'PERIODOS - INICIO',
                'tablePeriodo' => $tablePeriodo,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }        
    }

    public function show($idPeriodo)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $periodo = (new Periodo())->selectPeriodo($idPeriodo);
            $usuario = (new Usuario())->selectUsuario($periodo->idUsuario);
            $gestion = (new Gestion())->selectGestion($periodo->idGestion);
            $Dimensiones = (new Periodo())->selectPeriodo_Dimensiones($idPeriodo);
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            return view('Periodo.detalle', [
                'headTitle' => $periodo->nombrePeriodo,
                'periodo' => $periodo,
                'usuario' => $usuario,
                'gestion' => $gestion,
                'Dimensiones' => $Dimensiones
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    public function new($idSelect = null){
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $Gestiones = (new Gestion())->selectDisponibles('');
            if(!$idSelect){
                $idSelect = 0;
            }
            return view('Periodo.create', [
                'headTitle' => 'PERIODOS - NUEVO PERIODO',
                'Titulos' => "NUEVO PERIODO",
                'Gestiones' => $Gestiones,
                'idSelect' => $idSelect
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    public function store(PeriodoValidation $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $periodo = new Periodo();
            $periodo->nombrePeriodo = strtoupper($request->nombrePeriodo);
            $periodo->posicionOrdinal = $request->posicionOrdinal;
            $periodo->idGestion = $request->idGestion;
            $periodo->idUsuario = session('idUsuario');
            $periodo->ip = session('ip');
            $periodo->dispositivo = session('dispositivo');
            $periodo->save();
            return redirect()->route('periodos.details', $periodo);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    public function edit(Periodo $periodo)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $Gestiones = (new Gestion())->selectDisponibles('');
            return view('Periodo.update', [
                'headTitle' => 'EDITAR - ' . $periodo->nombrePeriodo,
                'periodo' => $periodo,
                'Gestiones' => $Gestiones,
                'Titulos' => "MODIFICAR AREA"
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
    
    public function update(PeriodoValidation $request, Periodo $periodo)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $periodo->nombrePeriodo = strtoupper($request->nombrePeriodo);
            $periodo->posicionOrdinal = $request->posicionOrdinal;
            $periodo->idGestion = $request->idGestion;
            $periodo->idUsuario = session('idUsuario');
            $periodo->ip = session('ip');
            $periodo->dispositivo = session('dispositivo');
            $periodo->save();
            return redirect()->route('periodos.details', $periodo);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idPeriodo' => ['required','numeric','integer']
            ]);
            $periodo = (new Periodo())->selectPeriodo($request->idPeriodo);
            $periodo->estado = '0';
            $periodo->idUsuario = session('idUsuario');
            $periodo->ip = session('ip');
            $periodo->dispositivo = session('dispositivo');
            $periodo->save();
            return redirect()->route('periodos.index');
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
}
