<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DimensionValidation extends FormRequest
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
            'idPeriodo' => ['required','numeric','integer'],
            'nombreDimension' => ['required','min:1','max:45'],
            'puntajeMaximo' => ['required','numeric','integer','min:1','max:100'],
            'tipoCalculo' => ['required','numeric','integer','min:1','max:2']
        ];
    }
}
