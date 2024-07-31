<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnidadValidation extends FormRequest
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
            'nombreUnidad' => ['required','min:1','max:250'],
            'posicionOrdinal' => ['required','numeric','integer','min:1','max:100'],
            'idAsignatura' => ['required','numeric','integer'],
            'idPeriodo' => ['required','numeric','integer']
        ];
    }
}
