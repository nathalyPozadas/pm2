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
        //return false;
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
            'codigo' => 'required',
            'factura' => 'required',
            'proveedor_id' => 'required|exists:proveedor,id',
            'fecha_recepcion' => 'required|date',
            'fecha_llegada' => 'required|date',
            'stock_esperado' => 'required|integer|min:0',
            'almacen_id' => 'required|exists:almacen,id',
        ];
    }
}
