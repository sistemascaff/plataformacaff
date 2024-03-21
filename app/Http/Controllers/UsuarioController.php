<?php

namespace App\Http\Controllers;


use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableUsuario = (new Usuario())->getAllUsers();
        return view('Usuario.inicio', ['tableUsuario' => $tableUsuario, 'retrocederDirectorioAssets' => 1]);
    }
    public function show($idUsuario)
    {
        $Usuario = (new Usuario())->details($idUsuario);
        return view('Usuario.detalle', ['Usuario' => $Usuario,'retrocederDirectorioAssets' => 2]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usuario $usuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuario $usuario)
    {
        //
    }
}
