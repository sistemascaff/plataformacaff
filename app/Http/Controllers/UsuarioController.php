<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioValidation;
use App\Models\Usuario;
use App\Models\Rol;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**Método que redirige al usuario a la vista del panel de administración,
     * en caso de que el usuario tenga acceso al sistema, 
     * de lo contrario, se le redirigirá a la vista para iniciar sesión.
     */
    public function dashboard()
    {
        if(session('tieneAcceso')){
            return view('Panel.admin', [
                'headTitle' => 'PANEL DE INICIO'
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }
    /**Método que redirige al usuario en caso de que el rol requerido para acceder a una vista o realizar una operación, 
     * además, en caso de que no haya iniciado sesión o directamente no tenga acceso al sistema se le redirigirá a la vista para iniciar sesión.
    */
    public function index()
    {
        if(session('tieneAcceso')){
            (new Rol())->selectRol(session('idRol'));//Refresh de los Roles.
            return view('Usuario.inicio', [
                'headTitle' => 'USUARIOS - INICIO'
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }

    /**Método utilizado para el inicio de sesión y verifica si existe algún registro que coincida con el correo y la contraseña ingresados.*/
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
                (new Rol())->selectRol(session('idRol'));
                return redirect()->route('dashboard');
            }
            else{
                return redirect()->route('login')->with([
                    'mensaje' => 'USTED NO TIENE ACCESO A LA PLATAFORMA.',
                    'loginCorreo' => $request->correo,
                    'loginContrasenha' => $request->contrasenha,
                ]);
            }
        }
        else{
            return redirect()->route('login')->with([
                'mensaje' => 'USUARIO O CONTRASEÑA INCORRECTA.',
                'loginCorreo' => $request->correo,
                'loginContrasenha' => $request->contrasenha,
            ]);
        }
    }

    /**Muestra la ventana para iniciar sesión.*/
    public function signIn()
    {
        return view('login');
    }

    /**Método que permite cerrar sesión y redirigir al usuario a la ventana para iniciar sesión.*/
    public function signOut()
    {
        (new Usuario())->logout();
        return redirect()->route('login');
    }

    /**Método que permite almacenar el registro creado de la tabla 'Usuarios' y retorna el objeto de la clase Usuario.*/
    public function store(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $usuario = new Usuario();
            $usuario->idPersona = $request->idPersona;
            $usuario->correo = $request->correo;
            $usuario->contrasenha = helper_encrypt($request->contrasenha);

            /*----Lógica de subida de archivos----*/
            if($request->hasFile('fotoPerfilURL')){
                $archivo = $request->file('fotoPerfilURL');
                $nombreArchivo = 'perfil_' . md5($usuario->idPersona) . '.' . $archivo->getClientOriginalExtension();
                $archivo->move(public_path('img/perfiles'), $nombreArchivo);
                $usuario->fotoPerfilURL = url('/') . '/public/img/perfiles/' . $nombreArchivo;
            }
            /*----/Lógica de subida de archivos----*/
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
            return redirect()->route('dashboard');
        }
    }

    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'Usuarios' y retorna el objeto de la clase Usuario con el registro actualizado.*/
    public function update(Request $request, $idUsuario)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $usuario = (new Usuario())->selectUsuario($idUsuario);
            $usuario->correo = $request->correo;
            $usuario->contrasenha = helper_encrypt($request->contrasenha);

            /*----Lógica de subida de archivos----*/
            if($request->hasFile('fotoPerfilURL')){
                $archivo = $request->file('fotoPerfilURL');
                $nombreArchivo = 'perfil_' . md5($usuario->idPersona) . '.' . $archivo->getClientOriginalExtension();
                $archivo->move(public_path('img/perfiles'), $nombreArchivo);
                $usuario->fotoPerfilURL = url('/') . '/public/img/perfiles/' . $nombreArchivo;
            }
            /*----/Lógica de subida de archivos----*/

            $usuario->pinRecuperacion = $request->pinRecuperacion;
            $usuario->idUsuarioResponsable = session('idUsuario');
            $usuario->ip = session('ip');
            $usuario->dispositivo = session('dispositivo');
            $usuario->save();
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'Usuarios' y retorna el objeto de la clase Usuario con el atributo 'estado' actualizado.*/
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
            return redirect()->route('dashboard');
        }
    }
}
