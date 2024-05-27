<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioValidation extends FormRequest
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
            /*Solo para referencia, no retornará errores en las vistas de Estudiantes, Docentes, Tutores.*/
            'idPersona' => ['required','numeric','integer'],
            'correo' => ['required','max:60'],
            'contrasenha' => ['required','min:8','max:50'],
            'fotoPerfilURL' => ['sometimes','image','max:2048','mimes:jpg,png,jpeg,gif,svg'],/*Foto opcional, límite de 2 Mb.*/
            'pinRecuperacion' => ['required','min:3','max:50']
        ];
    }
}
