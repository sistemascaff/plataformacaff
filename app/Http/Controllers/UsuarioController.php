<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioValidation;
use App\Models\Usuario;
use App\Models\Rol;
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

    public function store(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $usuario = new Usuario();
            $usuario->idPersona = $request->idPersona;
            $usuario->correo = $request->correo;
            $usuario->contrasenha = $request->contrasenha;
            if($request->hasFile('fotoPerfilURL')){
                $archivo = $request->file('fotoPerfilURL');
                $nombreArchivo = 'perfil_' . md5($usuario->idPersona) . '.' . $archivo->getClientOriginalExtension();
                $archivo->move(public_path('img/perfiles'), $nombreArchivo);
                $usuario->fotoPerfilURL = url('/') . '/img/perfiles/' . $nombreArchivo;
            }
            else{
                $usuario->fotoPerfilURL = url('/') . '/img/user.png';
            }
            $usuario->pinRecuperacion = $request->pinRecuperacion;
            $usuario->idUsuarioResponsable = session('idUsuario');
            $usuario->ip = session('ip');
            $usuario->dispositivo = session('dispositivo');
            $usuario->save();
            return $usuario;
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
    public function update(Request $request, $idUsuario)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $usuario = (new Usuario())->selectUsuario($idUsuario);
            $usuario->correo = $request->correo;
            $usuario->contrasenha = $request->contrasenha;
            if($request->hasFile('fotoPerfilURL')){
                $archivo = $request->file('fotoPerfilURL');
                $nombreArchivo = 'perfil_' . md5($usuario->idPersona) . '.' . $archivo->getClientOriginalExtension();
                $archivo->move(public_path('img/perfiles'), $nombreArchivo);
                $usuario->fotoPerfilURL = url('/') . '/img/perfiles/' . $nombreArchivo;
            }
            $usuario->pinRecuperacion = $request->pinRecuperacion;
            $usuario->idUsuarioResponsable = session('idUsuario');
            $usuario->ip = session('ip');
            $usuario->dispositivo = session('dispositivo');
            $usuario->save();
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idUsuario' => ['required','numeric','integer']
            ]);
            $usuario = (new Usuario())->selectUsuario($request->idUsuario);
            $usuario->estado = '0';
            $usuario->tieneAcceso = '0';
            $usuario->idUsuario = session('idUsuario');
            $usuario->ip = session('ip');
            $usuario->dispositivo = session('dispositivo');
            $usuario->save();
            return $usuario;
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
}
