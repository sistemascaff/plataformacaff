<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstudianteValidation;
use App\Http\Requests\PersonaValidation;
use App\Models\Estudiante;
use App\Models\Persona;
use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Curso;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function index(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $tableEstudiante = (new Estudiante())->selectDisponibles($request->busqueda);
            return view('Estudiante.inicio', [
                'headTitle' => 'ESTUDIANTES - INICIO',
                'tableEstudiante' => $tableEstudiante,
                'busqueda' => $request->busqueda
        ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    public function show($idEstudiante)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $estudiante = (new Estudiante())->selectEstudiante($idEstudiante);
            $persona = (new Persona())->selectPersona($estudiante->idPersona);
            $persona_usuario = (new Usuario())->selectUsuarioConIDPersona($estudiante->idPersona);
            $curso = (new Curso())->selectCurso($estudiante->idCurso);
            $usuario = (new Usuario())->selectUsuario($estudiante->idUsuario);

            if (!$usuario) {
                $usuario = new Usuario();
                $usuario->correo = '';
            }
            return view('Estudiante.detalle', [
                'headTitle' => $persona->apellidoPaterno . " " . $persona->apellidoMaterno . " " . $persona->nombres,
                'estudiante' => $estudiante,
                'persona' => $persona,
                'persona_usuario' => $persona_usuario,
                'curso' => $curso,
                'usuario' => $usuario,
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    public function new($idSelect = null){
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $Cursos = (new Curso())->selectDisponibles('');
            if(!$idSelect){
                $idSelect = 0;
            }
            return view('Estudiante.create', [
                'headTitle' => 'ESTUDIANTES - NUEVO ESTUDIANTE',
                'Titulos' => "NUEVO ESTUDIANTE",
                'Cursos' => $Cursos,
                'idSelect' => $idSelect
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    public function store(EstudianteValidation $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            /*Se asigna mediante este metodo del controlador demás atributos*/
            $request->merge([
                'tipoPerfil' => 'ESTUDIANTE',
                'telefonoPersonal' => '',
                'celularPersonal' => '',
            ]);
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

            /*Finalmente, se almacena los datos de salud del estudiante a la tabla Estudiantes*/
            $estudiante = new Estudiante();
            $estudiante->idPersona = $persona->idPersona;
            $estudiante->idCurso = $request->idCurso;
            $estudiante->saludTipoSangre = strtoupper($request->saludTipoSangre);
            $estudiante->saludAlergias = strtoupper($request->saludAlergias);
            $estudiante->saludDatos = strtoupper($request->saludDatos);
            $estudiante->idUsuario = session('idUsuario');
            $estudiante->ip = session('ip');
            $estudiante->dispositivo  = session('dispositivo');
            $estudiante->save();
            return redirect()->route('estudiantes.details', $estudiante);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    public function edit(Estudiante $estudiante)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $Cursos = (new Curso())->selectDisponibles('');
            $persona = (new Persona())->selectPersona($estudiante->idPersona);
            $persona_usuario = (new Usuario())->selectUsuarioConIDPersona($estudiante->idPersona);
            return view('Estudiante.update', [
                'headTitle' => 'EDITAR - ' . $persona->apellidoPaterno . " " . $persona->apellidoMaterno . " " . $persona->nombres,
                'estudiante' => $estudiante,
                'persona' => $persona,
                'persona_usuario' => $persona_usuario,
                'Cursos' => $Cursos,
                'Titulos' => "MODIFICAR ESTUDIANTE: " . $persona->apellidoPaterno . " " . $persona->apellidoMaterno . " " . $persona->nombres
            ]);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
    
    public function update(EstudianteValidation $request, Estudiante $estudiante)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            /*Se asigna mediante este metodo del controlador demás atributos*/
            $request->merge([
                'tipoPerfil' => 'ESTUDIANTE',
                'telefonoPersonal' => '',
                'celularPersonal' => '',
            ]);
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
            $persona = (new PersonaController)->update(new PersonaValidation($request->toArray()),$estudiante->idPersona);

            /*Se recupera el ID del Usuario mediante el ID de la Persona*/
            $persona_usuario = (new Usuario())->selectUsuarioConIDPersona($persona->idPersona);

            /*Se modifica los datos de usuario en la tabla Usuarios*/
            (new UsuarioController)->update($request, $persona_usuario->idUsuario);

            /*Finalmente, se almacena los datos de salud del estudiante a la tabla Estudiantes*/
            $estudiante->idCurso = $request->idCurso;
            $estudiante->saludTipoSangre = strtoupper($request->saludTipoSangre);
            $estudiante->saludAlergias = strtoupper($request->saludAlergias);
            $estudiante->saludDatos = strtoupper($request->saludDatos);
            $estudiante->idUsuario = session('idUsuario');
            $estudiante->ip = session('ip');
            $estudiante->dispositivo  = session('dispositivo');
            $estudiante->save();
            return redirect()->route('estudiantes.details', $estudiante);
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }

    public function delete(Request $request)
    {
        if ((new Rol())->verificarRoles( (new Rol())->selectRol(session('idRol')), ['admin' => 1] )) {
            $request->validate([
                'idEstudiante' => ['required','numeric','integer']
            ]);
            $estudiante = (new Estudiante())->selectEstudiante($request->idEstudiante);
            $estudiante->estado = '0';
            $estudiante->idUsuario = session('idUsuario');
            $estudiante->ip = session('ip');
            $estudiante->dispositivo  = session('dispositivo');
            $estudiante->save();
            return redirect()->route('estudiantes.index');
        }
        else{
            return redirect()->route('usuarios.index');
        }
    }
}
