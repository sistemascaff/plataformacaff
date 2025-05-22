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
            'nombreAutor' => ['required','min:1','max:100'],
            'nombreEditorial' => ['required','min:1','max:100'],
            'codigoLibro' => ['required','min:1','max:5'],
            'anhoLibro' => ['required','numeric','min:0','max:2050','integer'],
            'costo' => ['required','numeric','min:0','max:99999'],
            'observacion' => ['required'],
            'descripcion' => ['required'],
            'adquisicion' => ['required','numeric','integer','min:1','max:2'],
            'idCategoria' => ['required','numeric','integer'],
            'idPresentacion' => ['required','numeric','integer'],
            'fechaIngresoCooperativa' => ['required','date'],
        ];
    }
}
