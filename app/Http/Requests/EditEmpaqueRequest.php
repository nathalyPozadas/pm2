<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditEmpaqueRequest extends FormRequest
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
            'tipo' => 'required',
            'cantidad_cajas' => 'integer|min:0|nullable',
            'peso'=> 'integer|min:0|nullable',
            'unidad_medida' => 'nullable',
            'descripcion' => 'nullable',
            'estado'=> 'required',
            'observacion_estado'=> 'nullable',
            'criterio1'=> 'nullable',
            'criterio2'=> 'nullable',
            'criterio3'=> 'nullable'
        ];
    }
}
