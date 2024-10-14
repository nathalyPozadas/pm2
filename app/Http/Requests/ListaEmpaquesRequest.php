<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListaEmpaquesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        //return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'codigo' => 'required',
            'canal_aduana' => 'required',
            'transporte' => 'nullable|string',
            'factura' => 'required',
            'proveedor_id' => 'required|exists:proveedor,id',
            'fecha_recepcion' => ['required', 'date', function ($attribute, $value, $fail) {
                $this->validateYear($value, $fail);
            }],
            'fecha_llegada' => ['required', 'date', function ($attribute, $value, $fail) {
                $this->validateYear($value, $fail);
            }],
            'stock_esperado' => 'required|integer|min:0',
            'siniestrado' => 'nullable', // Asegúrate de validar este campo si es necesario
            'observacion' => 'nullable|string' . ($this->has('siniestrado')? '|required' : ''),
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
