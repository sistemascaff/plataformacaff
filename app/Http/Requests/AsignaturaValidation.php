<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AsignaturaValidation extends FormRequest
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
            'idMateria' => ['required','numeric','integer'],
            'idCoordinacion' => ['required','numeric','integer'],
            'idAula' => ['required','numeric','integer'],
            'idProfesor' => ['required','numeric','integer'],
            'nombreAsignatura' => ['required','min:3','max:100'],
            'nombreCorto' => ['required','min:1','max:5'],
            'tipoCalificacion' => ['required','numeric','integer','min:1','max:2'],
            'tipoBloque' => ['required','numeric','integer','min:1','max:2'],
            'tipoAsignatura' => ['required','numeric','integer','min:1','max:2']
        ];
    }
}
