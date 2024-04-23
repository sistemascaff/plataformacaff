<?php

namespace App\Http\Controllers;

use App\Http\Requests\GestionValidation;
use App\Models\Gestion;
use App\Models\Usuario;
use Illuminate\Http\Request;

class GestionController extends Controller
{
    public function index(Request $request)
    {
        if (session('idRol') == 1) {
            $tableGestion = (new Gestion())->selectDisponibles($request->busqueda);
            return view('Gestion.inicio', [
                'headTitle' => 'GESTIONES - INICIO',
                'tableGestion' => $tableGestion,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('login');
        }        
    }

    public function show($idGestion)
    {
        if (session('idRol') == 1) {
            $gestion = (new Gestion())->selectGestion($idGestion);
            $usuario = (new Usuario())->selectUsuario($gestion->idUsuario);
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            $Periodos = (new Gestion())->selectGestion_Periodos($idGestion);
            return view('Gestion.detalle', [
                'headTitle' => $gestion->anhoGestion,
                'gestion' => $gestion,
                'usuario' => $usuario,
                'Periodos' => $Periodos
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function new(){
        if (session('idRol') == 1) {
            return view('Gestion.create', [
                'headTitle' => 'GESTIONES - NUEVO GESTION',
                'Titulos' => "NUEVO GESTION"
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function store(GestionValidation $request)
    {
        if (session('idRol') == 1) {
            $gestion = new Gestion();
            $gestion->anhoGestion = strtoupper($request->anhoGestion);
            $gestion->idUsuario = session('idUsuario');
            $gestion->save();
            return redirect()->route('gestiones.details', $gestion);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function edit(Gestion $gestion)
    {
        if (session('idRol') == 1) {
            return view('Gestion.update', [
                'headTitle' => 'EDITAR - ' . $gestion->anhoGestion,
                'gestion' => $gestion,
                'Titulos' => "MODIFICAR GESTION"
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }
    
    public function update(GestionValidation $request, Gestion $gestion)
    {
        if (session('idRol') == 1) {
            $gestion->anhoGestion = strtoupper($request->anhoGestion);
            $gestion->idUsuario = session('idUsuario');
            $gestion->save();
            return redirect()->route('gestiones.details', $gestion);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function delete(Request $request)
    {
        if (session('idRol') == 1) {
            $request->validate([
                'idGestion' => ['required','numeric','integer']
            ]);
            $gestion = (new Gestion())->selectGestion($request->idGestion);
            $gestion->estado = '0';
            $gestion->idUsuario = session('idUsuario');
            $gestion->save();
            return redirect()->route('gestiones.index');
        }
        else{
            return redirect()->route('login');
        }
    }
}
