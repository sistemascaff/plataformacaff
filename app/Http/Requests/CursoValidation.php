<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CursoValidation extends FormRequest
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
            'nombreCurso' => ['required','min:3','max:45'],
            'idGrado' => ['required','numeric','integer'],
            'idParalelo' => ['required','numeric','integer']
        ];
    }
}
