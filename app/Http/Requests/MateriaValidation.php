<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MateriaValidation extends FormRequest
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
            'nombreMateria' => ['required','min:3','max:60'],
            'nombreCorto' => ['required','min:1','max:5'],
            'posicionOrdinal' => ['required','numeric','min:0','max:100','integer'],
            'idArea' => ['required','numeric','integer']
        ];
    }
}
