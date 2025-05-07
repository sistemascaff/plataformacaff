<?php

namespace App\Http\Controllers;

use App\Http\Requests\TutorValidation;
use App\Http\Requests\PersonaValidation;
use App\Models\Coordinacion;
use App\Models\Nivel;
use App\Models\Tutor;
use App\Models\Persona;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;

class TutorController extends Controller
{
    /**Muestra la ventana principal para gestionar los registros de la tabla 'Tutores'.*/
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $tableTutor = (new Tutor())->selectDisponibles($request->busqueda);
            return view('Tutor.inicio', [
                'headTitle' => 'TUTORES - INICIO',
                'tableTutor' => $tableTutor,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra la información de un registro específico de la tabla 'Tutores'.*/
    public function show($idTutor)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $tutor = (new Tutor())->selectTutor($idTutor);
            $persona = (new Persona())->selectPersona($tutor->idPersona);
            $persona_usuario = (new Usuario())->selectUsuarioConIDPersona($tutor->idPersona);
            $nivel = (new Nivel())->selectNivel($tutor->idNivelSubdirector);
            $coordinacion = (new Coordinacion())->selectCoordinacion($tutor->idCoordinacionEncargado);
            $usuario = (new Usuario())->selectUsuario($tutor->idUsuario);

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
            return view('Tutor.detalle', [
                'headTitle' => $persona->apellidoPaterno . " " . $persona->apellidoMaterno . " " . $persona->nombres,
                'tutor' => $tutor,
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

    /**Muestra el formulario con los atributos requeridos para CREAR un nuevo registro en la tabla 'Tutores'.*/
    public function new($idSelect = null){
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $Coordinaciones = (new Coordinacion())->selectDisponibles('');
            $Niveles = (new Nivel())->selectDisponibles('');
            if(!$idSelect){
                $idSelect = 0;
            }
            return view('Tutor.create', [
                'headTitle' => 'TUTORES - NUEVO TUTOR',
                'Titulos' => "NUEVO TUTOR",
                'Coordinaciones' => $Coordinaciones,
                'Niveles' => $Niveles,
                'idSelect' => $idSelect
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite almacenar el registro creado de la tabla 'Tutores' y retorna el método show() con el registro.
     * ATENCIÓN: LA CLASE REQUEST (TutorValidation) VALIDA MÁS DE UNA TABLA SIMULTÁNEAMENTE, 
     * POR LO QUE SE RECOMIENDA TENER CUIDADO EN CASO DE MODIFICAR LA VALIDACIÓN.
    */
    public function store(TutorValidation $request)
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
                    'tipoPerfil' => 'TUTOR'
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

            /*Finalmente, se almacena los datos de salud del tutor a la tabla Tutores*/
            $tutor = new Tutor();
            $tutor->idPersona = $persona->idPersona;
            $tutor->especialidad = $request->especialidad;
            $tutor->gradoEstudios = $request->gradoEstudios;
            $tutor->direccionDomicilio = strtoupper($request->direccionDomicilio);
            $tutor->idNivelSubdirector = $request->idNivelSubdirector;
            $tutor->idCoordinacionEncargado = $request->idCoordinacionEncargado;
            $tutor->idUsuario = session('idUsuario');
            $tutor->ip = session('ip');
            $tutor->dispositivo  = session('dispositivo');
            $tutor->save();
            return redirect()->route('tutores.details', $tutor);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Muestra el formulario con los atributos requeridos para ACTUALIZAR un registro existente de la tabla 'Tutores'.*/
    public function edit(Tutor $tutor)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $persona = (new Persona())->selectPersona($tutor->idPersona);
            $persona_usuario = (new Usuario())->selectUsuarioConIDPersona($tutor->idPersona);
            $Coordinaciones = (new Coordinacion())->selectDisponibles('');
            $Niveles = (new Nivel())->selectDisponibles('');
            return view('Tutor.update', [
                'headTitle' => 'EDITAR - ' . $persona->apellidoPaterno . " " . $persona->apellidoMaterno . " " . $persona->nombres,
                'tutor' => $tutor,
                'persona' => $persona,
                'persona_usuario' => $persona_usuario,
                'Coordinaciones' => $Coordinaciones,
                'Niveles' => $Niveles,
                'Titulos' => "MODIFICAR TUTOR: " . $persona->apellidoPaterno . " " . $persona->apellidoMaterno . " " . $persona->nombres
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
    
    /**Método que permite almacenar los cambios actualizados del registro de la tabla 'Tutores' y retorna el método show() con el registro actualizado.
     * ATENCIÓN: LA CLASE REQUEST (TutorValidation) VALIDA MÁS DE UNA TABLA SIMULTÁNEAMENTE,
     * POR LO QUE SE RECOMIENDA TENER CUIDADO EN CASO DE MODIFICAR LA VALIDACIÓN.
    */
    public function update(TutorValidation $request, Tutor $tutor)
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
                    'tipoPerfil' => 'TUTOR'
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
            $persona = (new PersonaController)->update(new PersonaValidation($request->toArray()),$tutor->idPersona);

            /*Se recupera el ID del Usuario mediante el ID de la Persona*/
            $usuarioFromIDPersona = (new Usuario())->selectUsuarioConIDPersona($persona->idPersona);

            /*Se modifica los datos de usuario en la tabla Usuarios*/
            (new UsuarioController)->update($request, $usuarioFromIDPersona->idUsuario);

            /*Se almacena un nuevo registro de Rol con el ID del Usuario*/
            $rolFromIDUsuario = (new Rol)->selectRolConIDUsuario($usuarioFromIDPersona->idUsuario);
            $request->merge(['idUsuario' => $rolFromIDUsuario->idUsuario]);
            (new RolController)->update($request, $rolFromIDUsuario->idRol);

            /*Finalmente, se almacena los datos de salud del tutor a la tabla Tutores*/
            $tutor->especialidad = $request->especialidad;
            $tutor->gradoEstudios = $request->gradoEstudios;
            $tutor->direccionDomicilio = strtoupper($request->direccionDomicilio);
            $tutor->idNivelSubdirector = $request->idNivelSubdirector;
            $tutor->idCoordinacionEncargado = $request->idCoordinacionEncargado;
            $tutor->idUsuario = session('idUsuario');
            $tutor->ip = session('ip');
            $tutor->dispositivo  = session('dispositivo');
            $tutor->save();
            return redirect()->route('tutores.details', $tutor);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    /**Método que permite ELIMINAR (soft delete) un registro de la tabla 'Tutores' y retorna el método index().*/
    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idTutor' => ['required','numeric','integer']
            ]);
            $tutor = (new Tutor())->selectTutor($request->idTutor);
            $tutor->estado = '0';
            $tutor->idUsuario = session('idUsuario');
            $tutor->ip = session('ip');
            $tutor->dispositivo  = session('dispositivo');
            $tutor->save();
            return redirect()->route('tutores.index');
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
}
