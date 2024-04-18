<?php

namespace App\Http\Controllers;

use App\Http\Requests\MateriaValidation;
use App\Models\Materia;
use App\Models\Usuario;
use App\Models\Area;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index(Request $request)
    {
        if (session('idRol') == 1) {
            $tableMateria = (new Materia())->selectDisponibles($request->busqueda);
            return view('Materia.inicio', [
                'headTitle' => 'MATERIAS - INICIO',
                'tableMateria' => $tableMateria,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('login');
        }        
    }

    public function show($idMateria)
    {
        if (session('idRol') == 1) {
            $materia = (new Materia())->selectMateria($idMateria);
            $usuario = (new Usuario())->selectUsuario($materia->idUsuario);
            $area = (new Area())->selectArea($materia->idArea);

            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            return view('Materia.detalle', [
                'headTitle' => $materia->nombreMateria,
                'materia' => $materia,
                'usuario' => $usuario,
                'area' => $area
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function new($idSelect = null){
        if (session('idRol') == 1) {
            $Areas = (new Area())->selectDisponibles('');
            if(!$idSelect){
                $idSelect = 0;
            }
            return view('Materia.create', [
                'headTitle' => 'MATERIAS - NUEVA MATERIA',
                'Titulos' => "NUEVA MATERIA",
                'Areas' => $Areas,
                'idSelect' => $idSelect
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function store(MateriaValidation $request)
    {
        if (session('idRol') == 1) {
            $materia = new Materia();
            $materia->nombreMateria = strtoupper($request->nombreMateria);
            $materia->nombreCorto = strtoupper($request->nombreCorto);
            $materia->tipoMateria = strtoupper($request->tipoMateria);
            $materia->idArea = $request->idArea;
            $materia->idUsuario = session('idUsuario');
            $materia->save();
            return redirect()->route('materias.details', $materia);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function edit(Materia $materia)
    {
        if (session('idRol') == 1) {
            $Areas = (new Area())->selectDisponibles('');
            return view('Materia.update', [
                'headTitle' => 'EDITAR - ' . $materia->nombreMateria,
                'materia' => $materia,
                'Areas' => $Areas,
                'Titulos' => "MODIFICAR MATERIA"
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }
    
    public function update(MateriaValidation $request, Materia $materia)
    {
        if (session('idRol') == 1) {
            $materia->nombreMateria = strtoupper($request->nombreMateria);
            $materia->nombreCorto = strtoupper($request->nombreCorto);
            $materia->tipoMateria = strtoupper($request->tipoMateria);
            $materia->idArea = $request->idArea;
            $materia->idUsuario = session('idUsuario');
            $materia->save();
            return redirect()->route('materias.details', $materia);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function delete(Request $request)
    {
        if (session('idRol') == 1) {
            $request->validate([
                'idMateria' => ['required','numeric']
            ]);
            $materia = (new Materia())->selectMateria($request->idMateria);
            $materia->estado = '0';
            $materia->idUsuario = session('idUsuario');
            $materia->save();
            return redirect()->route('materias.index');
        }
        else{
            return redirect()->route('login');
        }
    }
}
