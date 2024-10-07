<?php

namespace App\Http\Controllers;

use App\Models\Empaque;
use App\Models\ListaEmpaques;
use App\Models\Movimiento;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    public function store(Request $request)
    {
        
        $empaque = Empaque::find($request->empaque_id);

        $movimientoEmpaque = new Movimiento();
        $movimientoEmpaque->empaque_id = $request->empaque_id;
        $movimientoEmpaque->fecha = $request->fecha;
        $movimientoEmpaque->hora = $request->hora;
        $movimientoEmpaque->tipo_movimiento = $request->tipo_movimiento;
        $movimientoEmpaque->encargado_id = auth()->user()->trabajador_id;
        $movimientoEmpaque->empresa_id = auth()->user()->empresa_id;

        if($request->tipo_movimiento == 'interno'){
            $movimientoEmpaque->ubicacion_origen_id = $empaque->ubicacion_almacen_id;
            $movimientoEmpaque->ubicacion_destino_id = $request->ubicacion_almacen_id;
            $empaque->ubicacion_almacen_id = $request->ubicacion_almacen_id;
        }
        if($request->tipo_movimiento == 'externo'){
            $movimientoEmpaque->ubicacion_origen_id = $empaque->ubicacion_almacen_id;
            $movimientoEmpaque->nota = $request->nota;
            $movimientoEmpaque->cliente = $request->cliente;
            $movimientoEmpaque->destino = $request->destino;
            $empaque->ubicacion_almacen_id = null;

            $listaEmpaque = ListaEmpaques::find($empaque->lista_empaques_id);
            $listaEmpaque->stock_actual = $listaEmpaque->stock_actual-1;
            $listaEmpaque->update();
        }
       // dd($movimientoEmpaque);
        $movimientoEmpaque->save();
        $empaque->update();
      
        return redirect()->route('empaque.index');
    }
}
