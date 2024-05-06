<?php

namespace App\Http\Controllers;


use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    
    public function index()
    {
        if(session('tieneAcceso')){
            $tableUsuario = (new Usuario())->getAllUsers();
            return view('Usuario.inicio', [
                'headTitle' => 'USUARIOS - INICIO',
                'tableUsuario' => $tableUsuario
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function show($idUsuario)
    {
        $Usuario = (new Usuario())->selectUsuario($idUsuario);
        return view('Usuario.detalle', [
            'headTitle' => $Usuario->correo,
            'Usuario' => $Usuario
        ]);
    }

    public function verify(Request $request)
    {
        $Usuario = (new Usuario())->login($request->correo,$request->contrasenha,$request->ip(),gethostbyaddr($request->ip()));
        if($Usuario){
            if(session('tieneAcceso')){
                $Ultimaconexion = (new Usuario())->selectUsuario(session('idUsuario'));
                $Ultimaconexion->timestamps = false;
                $Ultimaconexion->ultimaConexion = Carbon::now();
                $Ultimaconexion->ultimoDispositivo = session('dispositivo');
                $Ultimaconexion->ultimaIP = session('ip');
                $Ultimaconexion->save();
                return redirect()->route('usuarios.index');
            }
            else{
                return redirect()->route('login')->with('mensaje','USTED NO TIENE ACCESO A LA PLATAFORMA.');
            }
        }
        else{
            return redirect()->route('login')->with('mensaje','USUARIO O CONTRASEÑA INCORRECTA.');
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
            'headTitle' => 'USUARIOS - NUEVO USUARIO',
            'Titulos' => "NUEVO USUARIO"
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
