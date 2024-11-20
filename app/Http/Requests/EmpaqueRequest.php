<?php

namespace App\Http\Requests;

use App\Models\Empaque;
use App\Models\ListaEmpaques;
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
            'lista_empaques_id'=> 'required|exists:lista_empaques,id',
            'criterio1'=> 'nullable',
            'criterio2'=> 'nullable',
            'criterio3'=> 'nullable',
            'numero' => 'required'
        ];
    }
/*
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $numero = $this->input('numero');
            $listaEmpaqueId = $this->input('lista_empaques_id');

            if ($numero && $listaEmpaqueId) {
                $exists = Empaque::where('numero','=', $numero)
                    ->where('lista_empaques_id', '=',$listaEmpaqueId)
                    ->exists();

                if ($exists) {
                    $validator->errors()->add('numero', 'El número de empaque debe ser único dentro de la lista de empaque.');
                }
            }
        });
    }
        */
}
