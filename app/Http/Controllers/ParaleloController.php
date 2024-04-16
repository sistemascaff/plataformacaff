<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParaleloValidation;
use App\Models\Paralelo;
use App\Models\Usuario;
use App\Models\Grado;
use Illuminate\Http\Request;

class ParaleloController extends Controller
{
    public function index(Request $request)
    {
        if (session('idRol') == 1) {
            $tableParalelo = (new Paralelo())->selectDisponibles($request->busqueda);
            return view('Paralelo.inicio', [
                'headTitle' => 'PARALELOS - INICIO',
                'tableParalelo' => $tableParalelo,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('login');
        }        
    }

    public function show($idParalelo)
    {
        if (session('idRol') == 1) {
            $paralelo = (new Paralelo())->selectParalelo($idParalelo);
            $usuario = (new Usuario())->selectUsuario($paralelo->idUsuario);
            $Grados = (new Grado())->selectDisponibles('');
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            $Cursos = (new Paralelo())->selectParalelo_Cursos($idParalelo);
            return view('Paralelo.detalle', [
                'headTitle' => $paralelo->nombreParalelo,
                'paralelo' => $paralelo,
                'usuario' => $usuario,
                'Cursos' => $Cursos,
                'Grados' => $Grados
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function new(){
        if (session('idRol') == 1) {
            return view('Paralelo.create', [
                'headTitle' => 'PARALELOS - NUEVO PARALELO',
                'Titulos' => "NUEVO PARALELO"
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function store(ParaleloValidation $request)
    {
        if (session('idRol') == 1) {
            $paralelo = new Paralelo();
            $paralelo->nombreParalelo = strtoupper($request->nombreParalelo);
            $paralelo->idUsuario = session('idUsuario');
            $paralelo->save();
            return redirect()->route('paralelos.details', $paralelo);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function edit(Paralelo $paralelo)
    {
        if (session('idRol') == 1) {
            return view('Paralelo.update', [
                'headTitle' => 'EDITAR - ' . $paralelo->nombreParalelo,
                'paralelo' => $paralelo,
                'Titulos' => "MODIFICAR PARALELO"
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }
    
    public function update(ParaleloValidation $request, Paralelo $paralelo)
    {
        if (session('idRol') == 1) {
            $paralelo->nombreParalelo = strtoupper($request->nombreParalelo);
            $paralelo->idUsuario = session('idUsuario');
            $paralelo->save();
            return redirect()->route('paralelos.details', $paralelo);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function delete(Request $request)
    {
        if (session('idRol') == 1) {
            $request->validate([
                'idParalelo' => ['required','numeric']
            ]);
            $paralelo = (new Paralelo())->selectParalelo($request->idParalelo);
            $paralelo->estado = '0';
            $paralelo->idUsuario = session('idUsuario');
            $paralelo->save();
            return redirect()->route('paralelos.index');
        }
        else{
            return redirect()->route('login');
        }
    }
}
