<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfesorValidation;
use App\Http\Requests\PersonaValidation;
use App\Models\Coordinacion;
use App\Models\Nivel;
use App\Models\Profesor;
use App\Models\Persona;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;

class ProfesorController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'Profesores'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $tableProfesor = (new Profesor())->selectDisponibles($request->busqueda);
            return view('Profesor.inicio', [
                'headTitle' => 'PROFESORES - INICIO',
                'tableProfesor' => $tableProfesor,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra la información de un registro específico de la tabla 'Profesores'.*/
    public function show($idProfesor)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $profesor = (new Profesor())->selectProfesor($idProfesor);
            $persona = (new Persona())->selectPersona($profesor->idPersona);
            $persona_usuario = (new Usuario())->selectUsuarioConIDPersona($profesor->idPersona);
            $nivel = (new Nivel())->selectNivel($profesor->idNivelSubdirector);
            $coordinacion = (new Coordinacion())->selectCoordinacion($profesor->idCoordinacionEncargado);
            $usuario = (new Usuario())->selectUsuario($profesor->idUsuario);

            if (!$nivel) {
                $nivel = new Nivel();
                $nivel->idNivel = 0;
                $nivel->nombreNivel = 'NO';
            }
            if (!$coordinacion) {
                $coordinacion = new Coordinacion();
                $coordinacion->idCoordinacion = 0;
                $coordinacion->nombreCoordinacion = 'NO';
            }
            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            return view('Profesor.detalle', [
                'headTitle' => $persona->apellidoPaterno . " " . $persona->apellidoMaterno . " " . $persona->nombres,
                'profesor' => $profesor,
                'persona' => $persona,
                'persona_usuario' => $persona_usuario,
                'nivel' => $nivel,
                'coordinacion' => $coordinacion,
                'usuario' => $usuario,
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para CREAR un nuevo registro en la tabla 'Profesores'.*/
    public function new($idSelect = null){
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $Coordinaciones = (new Coordinacion())->selectDisponibles('');
            $Niveles = (new Nivel())->selectDisponibles('');
            if(!$idSelect){
                $idSelect = 0;
            }
            return view('Profesor.create', [
                'headTitle' => 'PROFESORES - NUEVO PROFESOR',
                'Titulos' => "NUEVO PROFESOR",
                'Coordinaciones' => $Coordinaciones,
                'Niveles' => $Niveles,
                'idSelect' => $idSelect
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar el registro creado de la tabla 'Profesores' y retorna el método show() con el registro.
     * ATENCIÓN: LA CLASE REQUEST (ProfesorValidation) VALIDA MÁS DE UNA TABLA SIMULTÁNEAMENTE, 
     * POR LO QUE SE RECOMIENDA TENER CUIDADO EN CASO DE MODIFICAR LA VALIDACIÓN.
    */
    public function store(ProfesorValidation $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            /*Mediante este método se asigna y adiciona al request el tipo de perfil según la situación.*/
            if($request->idNivelSubdirector){
                $request->merge([
                    'tipoPerfil' => 'SUBDIRECTOR',
                    /*Si ya se asignó un idNivelSubdirector queda anulado la asignación de idCoordinacionEncargado*/
                    'idCoordinacionEncargado' => '0'
                ]);
            }
            elseif($request->idCoordinacionEncargado){
                $request->merge([
                    'tipoPerfil' => 'COORDINADOR'
                ]);
            }else{
                $request->merge([
                    'tipoPerfil' => 'PROFESOR'
                ]);
            }
            $data = $request->all();

            /*Recorremos los datos y reemplazamos los valores null por cadenas vacías*/
            foreach ($data as $key => $value) {
                if ($value === null) {
                    $data[$key] = '';
                }
            }
            
            /*Reemplazamos los datos del objeto $request con los nuevos datos modificados*/
            $request->replace($data);
            
            /*Se almacena los datos personales a la tabla Personas*/
            $persona = (new PersonaController)->store(new PersonaValidation($request->toArray()));

            /*Se une a la variable $request el ID de la persona*/
            $request->merge(['idPersona' => $persona->idPersona]);

            /*Se almacena los datos de usuario a la tabla Usuarios*/
            $usuario = (new UsuarioController)->store($request);

            /*Se une a la variable $request el ID del Usuario*/
            $request->merge(['idUsuario' => $usuario->idUsuario]);

            /*Se almacena un nuevo registro de Rol con el ID del Usuario*/
            (new RolController)->store($request);

            /*Finalmente, se almacena los datos de salud del profesor a la tabla Profesores*/
            $profesor = new Profesor();
            $profesor->idPersona = $persona->idPersona;
            $profesor->especialidad = $request->especialidad;
            $profesor->gradoEstudios = $request->gradoEstudios;
            $profesor->direccionDomicilio = strtoupper($request->direccionDomicilio);
            $profesor->idNivelSubdirector = $request->idNivelSubdirector;
            $profesor->idCoordinacionEncargado = $request->idCoordinacionEncargado;
            $profesor->idUsuario = session('idUsuario');
            $profesor->ip = session('ip');
            $profesor->dispositivo  = session('dispositivo');
            $profesor->save();
            return redirect()->route('profesores.details', $profesor);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para ACTUALIZAR un registro existente de la tabla 'Profesores'.*/
    public function edit(Profesor $profesor)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $persona = (new Persona())->selectPersona($profesor->idPersona);
            $persona_usuario = (new Usuario())->selectUsuarioConIDPersona($profesor->idPersona);
            $Coordinaciones = (new Coordinacion())->selectDisponibles('');
            $Niveles = (new Nivel())->selectDisponibles('');
            return view('Profesor.update', [
                'headTitle' => 'EDITAR - ' . $persona->apellidoPaterno . " " . $persona->apellidoMaterno . " " . $persona->nombres,
                'profesor' => $profesor,
                'persona' => $persona,
                'persona_usuario' => $persona_usuario,
                'Coordinaciones' => $Coordinaciones,
                'Niveles' => $Niveles,
                'Titulos' => "MODIFICAR PROFESOR: " . $persona->apellidoPaterno . " " . $persona->apellidoMaterno . " " . $persona->nombres
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
    
    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'Profesores' y retorna el método show() con el registro actualizado.
     * ATENCIÓN: LA CLASE REQUEST (ProfesorValidation) VALIDA MÁS DE UNA TABLA SIMULTÁNEAMENTE,
     * POR LO QUE SE RECOMIENDA TENER CUIDADO EN CASO DE MODIFICAR LA VALIDACIÓN.
    */
    public function update(ProfesorValidation $request, Profesor $profesor)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            /*Mediante este método se asigna y adiciona al request el tipo de perfil según la situación.*/
            if($request->idNivelSubdirector){
                $request->merge([
                    'tipoPerfil' => 'SUBDIRECTOR',
                    /*Si ya se asignó un idNivelSubdirector queda anulado la asignación de idCoordinacionEncargado*/
                    'idCoordinacionEncargado' => '0'
                ]);
            }
            elseif($request->idCoordinacionEncargado){
                $request->merge([
                    'tipoPerfil' => 'COORDINADOR'
                ]);
            }else{
                $request->merge([
                    'tipoPerfil' => 'PROFESOR'
                ]);
            }
            $data = $request->all();

            /*Recorremos los datos y reemplazamos los valores null por cadenas vacías*/
            foreach ($data as $key => $value) {
                if ($value === null) {
                    $data[$key] = '';
                }
            }
            
            /*Reemplazamos los datos del objeto $request con los nuevos datos modificados*/
            $request->replace($data);
            
            /*Se modifica los datos personales en la tabla Personas*/
            $persona = (new PersonaController)->update(new PersonaValidation($request->toArray()),$profesor->idPersona);

            /*Se recupera el ID del Usuario mediante el ID de la Persona*/
            $usuarioFromIDPersona = (new Usuario())->selectUsuarioConIDPersona($persona->idPersona);

            /*Se modifica los datos de usuario en la tabla Usuarios*/
            (new UsuarioController)->update($request, $usuarioFromIDPersona->idUsuario);

            /*Se almacena un nuevo registro de Rol con el ID del Usuario*/
            $rolFromIDUsuario = (new Rol)->selectRolConIDUsuario($usuarioFromIDPersona->idUsuario);
            $request->merge(['idUsuario' => $rolFromIDUsuario->idUsuario]);
            (new RolController)->update($request, $rolFromIDUsuario->idRol);

            /*Finalmente, se almacena los datos de salud del profesor a la tabla Profesores*/
            $profesor->especialidad = $request->especialidad;
            $profesor->gradoEstudios = $request->gradoEstudios;
            $profesor->direccionDomicilio = strtoupper($request->direccionDomicilio);
            $profesor->idNivelSubdirector = $request->idNivelSubdirector;
            $profesor->idCoordinacionEncargado = $request->idCoordinacionEncargado;
            $profesor->idUsuario = session('idUsuario');
            $profesor->ip = session('ip');
            $profesor->dispositivo  = session('dispositivo');
            $profesor->save();
            return redirect()->route('profesores.details', $profesor);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'Profesores' y retorna el método index().*/
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idProfesor' => ['required','numeric','integer']
            ]);
            $profesor = (new Profesor())->selectProfesor($request->idProfesor);
            $profesor->estado = '0';
            $profesor->idUsuario = session('idUsuario');
            $profesor->ip = session('ip');
            $profesor->dispositivo  = session('dispositivo');
            $profesor->save();
            return redirect()->route('profesores.index');
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
}
