<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfesorValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            /*Validación para la tabla Personas*/
            'apellidoPaterno' => ['nullable','max:50'],
            'apellidoMaterno' => ['nullable','max:50'],
            'nombres' => ['required','min:3','max:50'],
            'documentoIdentificacion' => ['required','min:5','max:15'],
            'documentoComplemento' => ['nullable','max:10'],
            'documentoExpedido' => ['required','max:20'],
            'fechaNacimiento' => ['required','date'],
            'sexo' => ['required','min:1','max:20'],
            'idioma' => ['required','min:2','max:45'],
            'nivelIE' => ['required','min:1','max:10'],
            'celularPersonal' => ['nullable','max:20'],
            'telefonoPersonal' => ['nullable','max:20'],
            /*Validación para la tabla Usuarios*/
            'correo' => ['required','max:60'],
            'contrasenha' => ['required','min:8','max:50'],
            'fotoPerfilURL' => ['sometimes','file','max:2048','mimes:jpg,png,jpeg'],/*Foto opcional, límite de 2 Mb.*/
            'pinRecuperacion' => ['required','min:3','max:50'],
            /*Validación para la tabla Profesores*/
            'especialidad' => ['required','max:45'],
            'gradoEstudios' => ['required','max:45'],
            'direccionDomicilio' => ['required','max:250'],
            'idNivelSubdirector' => ['required','numeric','integer','min:0'],
            'idCoordinacionEncargado' => ['required','numeric','integer','min:0']
        ];
    }
}
