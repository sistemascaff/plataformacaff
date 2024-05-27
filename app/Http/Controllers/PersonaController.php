<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonaValidation;
use App\Models\Persona;
use App\Models\Rol;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    public function index()
    {
        if((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )){
            $tablePersona = (new Persona())->getAllUsers();
            return view('Persona.inicio', [
                'headTitle' => 'PERSONAS - INICIO',
                'tablePersona' => $tablePersona
        ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
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
}
