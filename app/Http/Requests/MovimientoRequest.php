<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovimientoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'tipo_movimiento' => 'required',
            'fecha' => ['required', 'date', function ($attribute, $value, $fail) {
                $this->validateYear($value, $fail);
            }]
        ];
    }
    private function validateYear($value, $fail)
    {
        $fecha = \Carbon\Carbon::createFromFormat('Y-m-d', $value);
        $anio = $fecha->year;
        
        if ($anio < 1900 || $anio > 2099) {
            $fail('El campo :attribute tiene un año fuera del rango permitido (1900-2099).');
        }
    }
}
