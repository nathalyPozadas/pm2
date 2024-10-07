<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmpaqueRequest;
use App\Models\Almacen;
use App\Models\Empaque;
use App\Models\Empresa;
use App\Models\ListaEmpaques;
use App\Models\UbicacionAlmacen;
use Illuminate\Http\Request;

class EmpaqueController extends Controller
{
    public function index()
    {
        //$empresa_id = obtener_empresa();
        
        $empaques = Empaque::join('lista_empaques', 'empaque.lista_empaques_id', '=', 'lista_empaques.id')
            ->join('ubicacion_almacen', 'empaque.ubicacion_almacen_id', '=', 'ubicacion_almacen.id')
            ->join('almacen', 'ubicacion_almacen.almacen_id', '=', 'almacen.id')
            ->select('empaque.*', 'lista_empaques.codigo as empaque_lista_empaque_codigo', 'almacen.nombre as empaque_almacen_nombre', 'ubicacion_almacen.nombre as empaque_ubicacion_nombre')
            ->orderBy('empaque.id', 'desc')
            ->get();
        
        /*
        $empaques = Empaque::leftJoin('lista_empaques', 'empaque.lista_empaques_id', '=', 'lista_empaques.id')
        ->leftJoin('ubicacion_almacen', 'empaque.ubicacion_almacen_id', '=', 'ubicacion_almacen.id')
        ->leftJoin('almacen', 'ubicacion_almacen.almacen_id', '=', 'almacen.id')
        ->select(
            'empaque.*', 
            'lista_empaques.codigo as empaque_lista_empaque_codigo', 
            'almacen.nombre as empaque_almacen_nombre', 
            'ubicacion_almacen.nombre as empaque_ubicacion_nombre'
        )
        ->orderBy('empaque.id', 'desc')
        ->get();
        */

        $almacenes = Almacen::all();
        foreach ($almacenes as $almacen) {
            $almacen->ubicaciones = UbicacionAlmacen::where('ubicacion_almacen.almacen_id', $almacen->id)
                ->whereNull('ubicacion_almacen.deleted_at')
                ->get();
        }

        $empresa = Empresa::find(1);
        $icono_empresa = $empresa->icono;

        $listas = ListaEmpaques::all();

        return view("empaques.index", ['listas' => $listas, 'empaques' => $empaques, 'icono_empresa' => $icono_empresa, 'almacenes' => $almacenes]);
    }


    public function store(Request $request)
    {

        $cantidadEmpaques = Empaque::where('lista_empaques_id', $request->lista_empaques_id)->count();

        $empaque = new Empaque();
        $empaque->tipo = $request->tipo;
        $empaque->numero = $cantidadEmpaques + 1;
        $empaque->cantidad_cajas = $request->cantidad_cajas;
        $empaque->peso = $request->peso;
        $empaque->unidad_medida = $request->unidad_medida;
        $empaque->descripcion = $request->descripcion;
        $empaque->estado = $request->estado;
        $empaque->observacion_estado = $request->observacion_estado;
        $empaque->lista_empaques_id = $request->lista_empaques_id;
        $empaque->fecha_registro = now();
        $empaque->encargado_id = auth()->user()->trabajador_id;
        $empaque->ubicacion_almacen_id = $request->ubicacion_almacen_id;
        $empaque->criterio1 = $request->has('criterio1') ? true : false;
        $empaque->criterio2 = $request->has('criterio2') ? true : false;
        $empaque->criterio3 = $request->has('criterio3') ? true : false;
        $empaque->empresa_id = auth()->user()->empresa_id;
        $empaque->save();

        $lista_empaques = ListaEmpaques::find($empaque->lista_empaques_id);
        $lista_empaques->stock_registrado = $lista_empaques->stock_registrado + 1;
        $lista_empaques->stock_actual = $lista_empaques->stock_actual + 1;
        $lista_empaques->update();

        if($request->vista == 'vista_empaques'){
            return redirect()->route('empaque.index');
        }
        return redirect()->route('lista_empaques.index');
    }

    public function delete($id)
    {
        
        $empaque = Empaque::findOrFail($id);
        $empaque->delete();

    }
}
