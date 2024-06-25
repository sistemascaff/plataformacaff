<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonaValidation;
use App\Models\Estudiante;
use App\Models\Persona;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    /**Método que permite almacenar el registro creado de la tabla 'Personas' y retorna el objeto de la clase Persona.*/
    public function store(PersonaValidation $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $persona = new Persona();
            $persona->idColegio = session('idColegio');
            $persona->apellidoPaterno = ucwords(strtolower($request->apellidoPaterno));
            $persona->apellidoMaterno = ucwords(strtolower($request->apellidoMaterno));
            $persona->nombres = ucwords(strtolower($request->nombres));
            $persona->documentoIdentificacion = $request->documentoIdentificacion;
            $persona->documentoComplemento = $request->documentoComplemento;
            $persona->documentoExpedido = $request->documentoExpedido;
            $persona->fechaNacimiento = $request->fechaNacimiento;
            $persona->sexo = $request->sexo;
            $persona->idioma = $request->idioma;
            $persona->nivelIE = $request->nivelIE;
            $persona->celularPersonal = $request->celularPersonal;
            $persona->telefonoPersonal = $request->telefonoPersonal;
            $persona->tipoPerfil = $request->tipoPerfil;
            $persona->idUsuario = session('idUsuario');
            $persona->ip = session('ip');
            $persona->dispositivo = session('dispositivo');
            $persona->save();
            return $persona;
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'Personas' y retorna el objeto de la clase Persona con el registro actualizado.*/
    public function update(PersonaValidation $request, $idPersona)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $persona = (new Persona)->selectPersona($idPersona);
            $persona->apellidoPaterno = ucwords(strtolower($request->apellidoPaterno));
            $persona->apellidoMaterno = ucwords(strtolower($request->apellidoMaterno));
            $persona->nombres = ucwords(strtolower($request->nombres));
            $persona->documentoIdentificacion = $request->documentoIdentificacion;
            $persona->documentoComplemento = $request->documentoComplemento;
            $persona->documentoExpedido = $request->documentoExpedido;
            $persona->fechaNacimiento = $request->fechaNacimiento;
            $persona->sexo = $request->sexo;
            $persona->idioma = $request->idioma;
            $persona->nivelIE = $request->nivelIE;
            $persona->celularPersonal = $request->celularPersonal;
            $persona->telefonoPersonal = $request->telefonoPersonal;
            $persona->tipoPerfil = $request->tipoPerfil;
            $persona->idUsuario = session('idUsuario');
            $persona->ip = session('ip');
            $persona->dispositivo = session('dispositivo');
            $persona->save();
            return $persona;
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'Personas' y retorna el objeto de la clase Persona con el atributo estado actualizado.*/
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idPersona' => ['required','numeric','integer']
            ]);
            $persona = (new Persona())->selectPersona($request->idPersona);
            $persona->estado = '0';
            $persona->idUsuario = session('idUsuario');
            $persona->ip = session('ip');
            $persona->dispositivo = session('dispositivo');
            $persona->save();
            return $persona;
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra la información del usuario de la sesión actual.*/
    public function information(){
        if(session('tieneAcceso')){
            $persona = (new Persona())->selectPersona(session('idPersona'));
            $persona_usuario = (new Usuario())->selectUsuarioConIDPersona(session('idPersona'));
            $usuario = (new Usuario())->selectUsuario($persona->idUsuario);
            $estudiante = (new Estudiante())->selectEstudianteConIDPersona(session('idPersona'));
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            return view('Persona.perfil', [
                'headTitle' => 'MI PERFIL',
                'persona' => $persona,
                'persona_usuario' => $persona_usuario,
                'usuario' => $usuario,
                'estudiante' => $estudiante,
            ]);
        }
        else{
            return redirect()->route('login');
        }
    }
}
