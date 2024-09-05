<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LibroValidation extends FormRequest
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
            'nombreLibro' => ['required','min:1','max:200'],
            'codigoLibro' => ['required','min:1','max:5'],
            'costo' => ['required','numeric','min:0','max:99999'],
            'observacion' => ['required'],
            'descripcion' => ['required'],
            'adquisicion' => ['required','numeric','integer','min:1','max:2'],
            'idCategoria' => ['required','numeric','integer'],
            'idAutor' => ['required','numeric','integer'],
            'idPresentacion' => ['required','numeric','integer'],
            'idEditorial' => ['required','numeric','integer'],
        ];
    }
}
