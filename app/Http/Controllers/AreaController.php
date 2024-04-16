<?php

namespace App\Http\Controllers;

use App\Http\Requests\AreaValidation;
use App\Models\Area;
use App\Models\Usuario;
use App\Models\Campo;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        if (session('idRol') == 1) {
            $tableArea = (new Area())->selectDisponibles($request->busqueda);
            return view('Area.inicio', [
                'headTitle' => 'AREAS - INICIO',
                'tableArea' => $tableArea,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('login');
        }        
    }

    public function show($idArea)
    {
        if (session('idRol') == 1) {
            $area = (new Area())->selectArea($idArea);
            $usuario = (new Usuario())->selectUsuario($area->idUsuario);
            $campo = (new Campo())->selectCampo($area->idCampo);
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            return view('Area.detalle', [
                'headTitle' => $area->nombreArea,
                'area' => $area,
                'usuario' => $usuario,
                'campo' => $campo
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function new($idSelect = null){
        if (session('idRol') == 1) {
            $valorAssets = 3;
            $Campos = (new Campo())->selectDisponibles('');
            if(!$idSelect){
                $idSelect = 0;
                $valorAssets = 2;
            }
            return view('Area.create', [
                'headTitle' => 'AREAS - NUEVA AREA',
                'Titulos' => "NUEVA AREA",
                'Campos' => $Campos,
                'idSelect' => $idSelect
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function store(AreaValidation $request)
    {
        if (session('idRol') == 1) {
            $area = new Area();
            $area->nombreArea = strtoupper($request->nombreArea);
            $area->idCampo = $request->idCampo;
            $area->idUsuario = session('idUsuario');
            $area->save();
            return redirect()->route('areas.details', $area);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function edit(Area $area)
    {
        if (session('idRol') == 1) {
            $Campos = (new Campo())->selectDisponibles('');
            return view('Area.update', [
                'headTitle' => 'EDITAR - ' . $area->nombreArea,
                'area' => $area,
                'Campos' => $Campos,
                'Titulos' => "MODIFICAR AREA"
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }
    
    public function update(AreaValidation $request, Area $area)
    {
        if (session('idRol') == 1) {
            $area->nombreArea = strtoupper($request->nombreArea);
            $area->idCampo = $request->idCampo;
            $area->idUsuario = session('idUsuario');
            $area->save();
            return redirect()->route('areas.details', $area);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function delete(Request $request)
    {
        if (session('idRol') == 1) {
            $request->validate([
                'idArea' => ['required','numeric']
            ]);
            $area = (new Area())->selectArea($request->idArea);
            $area->estado = '0';
            $area->idUsuario = session('idUsuario');
            $area->save();
            return redirect()->route('areas.index');
        }
        else{
            return redirect()->route('login');
        }
    }
}
