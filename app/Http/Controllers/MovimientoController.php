<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovimientoRequest;
use App\Models\Bitacora;
use App\Models\Empaque;
use App\Models\Empresa;
use App\Models\ListaEmpaques;
use App\Models\Movimiento;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    public function store(MovimientoRequest $request)
    {
        try{
            $empresa = Empresa::find(auth()->user()->empresa_id);
            
            $empaque = Empaque::where('empresa_id', $empresa->id)
                    ->where('id', $request->empaque_id)
                    ->firstOrFail();

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

            Bitacora::create([
                'user_id' => auth()->user()->id,
                'evento' => 'Movimiento Externo',
                'descripcion' => 'Movimiento '.$request->tipo_movimiento.' del empaque ID: ' . $request->empaque_id,
                'empresa_id' => auth()->user()->empresa_id,
                'tipo_evento' => 'info'
            ]);

            $movimientoEmpaque->save();
            $empaque->update();
        
            return redirect()->route('empaque.index');
        } catch (\Exception $e) {
            // Registro de error en la Bitácora
            Bitacora::create([
                'user_id' => auth()->user()->id,
                'evento' => 'Error al registrar movimiento',
                'descripcion' => 'Error al registrar el movimiento para el empaque ID: ' . $request->empaque_id . '. Detalles: ' . $e->getMessage(),
                'empresa_id' => auth()->user()->empresa_id,
                'tipo_evento' => 'error'
            ]);
    
            return redirect()->back()->withErrors('Hubo un problema al registrar el movimiento.');
        }
    }
}
