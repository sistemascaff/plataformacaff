<?php

namespace App\Http\Controllers;

use App\Models\Paralelo;
use App\Models\Usuario;
use App\Models\Curso;
use App\Models\Grado;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Can;

class ParaleloController extends Controller
{
    public function index(Request $request)
    {
        if (session('idRol') == 1) {
            $tableParalelo = (new Paralelo())->selectDisponibles($request->busqueda);
            return view('Paralelo.inicio', [
                'tableParalelo' => $tableParalelo,
                'retrocederDirectorioAssets' => 1,
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
                'paralelo' => $paralelo,
                'usuario' => $usuario,
                'Cursos' => $Cursos,
                'Grados' => $Grados,
                'retrocederDirectorioAssets' => 2
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function new(){
        if (session('idRol') == 1) {
            return view('Paralelo.create', [
                'Titulos' => "NUEVO PARALELO",
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
                'paralelo' => $paralelo,
                'Titulos' => "MODIFICAR PARALELO",
                'retrocederDirectorioAssets' => 3
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }
    
    public function update(Request $request, Paralelo $paralelo)
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
