<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Usuario;
use App\Models\Campo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Can;

class AreaController extends Controller
{
    public function index()
    {
        if (session('idRol') == 1) {
            $tableArea = (new Area())->selectDisponibles();
            return view('Area.inicio', ['tableArea' => $tableArea, 'retrocederDirectorioAssets' => 1]);
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
                'area' => $area,
                'usuario' => $usuario,
                'campo' => $campo,
                'retrocederDirectorioAssets' => 2
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function new(){
        if (session('idRol') == 1) {
            $Campos = (new Campo())->selectDisponibles();
            return view('Area.create', [
                'Titulos' => "NUEVA AREA",
                'Campos' => $Campos,
                'retrocederDirectorioAssets' => 2
            ]);
        }
        else{
            return redirect()->route('login');
        } 
        
    }

    public function store(Request $request)
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
            $Campos = (new Campo())->selectDisponibles();
            return view('Area.update', [
                'area' => $area,
                'Campos' => $Campos,
                'Titulos' => "MODIFICAR AREA",
                'retrocederDirectorioAssets' => 3
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }
    
    public function update(Request $request, Area $area)
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
