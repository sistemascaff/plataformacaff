<?php

namespace App\Http\Controllers;

use App\Http\Requests\AulaValidation;
use App\Models\Aula;
use App\Models\Usuario;
use Illuminate\Http\Request;

class AulaController extends Controller
{
    public function index(Request $request)
    {
        if (session('idRol') == 1) {
            $tableAula = (new Aula())->selectDisponibles($request->busqueda);
            return view('Aula.inicio', [
                'headTitle' => 'AULAS - INICIO',
                'tableAula' => $tableAula,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('login');
        }        
    }

    public function show($idAula)
    {
        if (session('idRol') == 1) {
            $aula = (new Aula())->selectAula($idAula);
            $usuario = (new Usuario())->selectUsuario($aula->idUsuario);
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            $Asignaturas = (new Aula())->selectAula_Asignaturas($idAula);
            return view('Aula.detalle', [
                'headTitle' => $aula->nombreAula,
                'aula' => $aula,
                'usuario' => $usuario,
                'Asignaturas' => $Asignaturas
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function new(){
        if (session('idRol') == 1) {
            return view('Aula.create', [
                'headTitle' => 'AULAS - NUEVO AULA',
                'Titulos' => "NUEVO AULA"
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function store(AulaValidation $request)
    {
        if (session('idRol') == 1) {
            $aula = new Aula();
            $aula->nombreAula = strtoupper($request->nombreAula);
            $aula->idUsuario = session('idUsuario');
            $aula->save();
            return redirect()->route('aulas.details', $aula);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function edit(Aula $aula)
    {
        if (session('idRol') == 1) {
            return view('Aula.update', [
                'headTitle' => 'EDITAR - ' . $aula->nombreAula,
                'aula' => $aula,
                'Titulos' => "MODIFICAR AULA"
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }
    
    public function update(AulaValidation $request, Aula $aula)
    {
        if (session('idRol') == 1) {
            $aula->nombreAula = strtoupper($request->nombreAula);
            $aula->idUsuario = session('idUsuario');
            $aula->save();
            return redirect()->route('aulas.details', $aula);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function delete(Request $request)
    {
        if (session('idRol') == 1) {
            $request->validate([
                'idAula' => ['required','numeric','integer']
            ]);
            $aula = (new Aula())->selectAula($request->idAula);
            $aula->estado = '0';
            $aula->idUsuario = session('idUsuario');
            $aula->save();
            return redirect()->route('aulas.index');
        }
        else{
            return redirect()->route('login');
        }
    }
}
