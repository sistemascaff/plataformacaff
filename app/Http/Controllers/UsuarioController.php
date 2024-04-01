<?php

namespace App\Http\Controllers;


use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    
    public function index()
    {
        if(session('idRol') == 1){
            $tableUsuario = (new Usuario())->getAllUsers();
            return view('Usuario.inicio', ['tableUsuario' => $tableUsuario, 'retrocederDirectorioAssets' => 1]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function show($idUsuario)
    {
        $Usuario = (new Usuario())->details($idUsuario);
        return view('Usuario.detalle', [
            'Usuario' => $Usuario,
            'retrocederDirectorioAssets' => 2
        ]);
    }

    public function verify(Request $request)
    {
        $Usuario = (new Usuario())->login($request->correo,$request->contrasenha);
        if($Usuario > 0){
            if(session('tieneAcceso') == 1){
                $Ultimaconexion = (new Usuario())->details(session('idUsuario'));
                $Ultimaconexion->timestamps = false;
                $Ultimaconexion->ultimaConexion = Carbon::now();
                $Ultimaconexion->save();
                return redirect()->route('usuarios.index');
            }
            else{
                return redirect()->route('login');
            }
        }
        else{
            return redirect()->route('login');
        }
    }

    public function signIn()
    {
        return view('login');
    }

    public function signOut()
    {
        (new Usuario())->logout();
        return redirect()->route('login');
    }

    public function new()
    {
        return view('Usuario.create', [
            'Titulos' => "NUEVO USUARIO",
            'retrocederDirectorioAssets' => 2
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
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
