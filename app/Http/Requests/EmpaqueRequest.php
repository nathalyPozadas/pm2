<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpaqueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'tipo' => 'required',
            'cantidad_cajas' => 'integer|min:0|nullable',
            'peso'=> 'integer|min:0|nullable',
            'unidad_medida' => 'nullable',
            'descripcion' => 'nullable',
            'estado'=> 'required',
            'observacion_estado'=> 'nullable',
            'lista_empaques_id'=> 'required|exists:lista_empaques,id',
            'ubicacion_almacen_id'=> 'required|exists:ubicacion_almacen,id',
            'criterio1'=> 'nullable',
            'criterio2'=> 'nullable',
            'criterio3'=> 'nullable'
        ];
    }
}
