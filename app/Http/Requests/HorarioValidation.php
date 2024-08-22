<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HorarioValidation extends FormRequest
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
            'dia' => ['required','numeric','integer'],
            'horaInicio' => ['required','date_format:H:i'],
            'horaFin' => ['required','date_format:H:i','after:horaInicio'],
            'idAsignatura' => ['required','numeric','integer']
        ];  
    }
}
