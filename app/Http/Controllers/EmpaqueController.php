<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditEmpaqueRequest;
use App\Http\Requests\EmpaqueRequest;
use App\Models\Almacen;
use App\Models\Configuracion;
use App\Models\Empaque;
use App\Models\Empresa;
use App\Models\ListaEmpaques;
use App\Models\Movimiento;
use App\Models\UbicacionAlmacen;
use DB;
use Illuminate\Http\Request;

class EmpaqueController extends Controller
{
    public function index()
    {
        //$empresa_id = obtener_empresa();
        $empresa = Empresa::find(auth()->user()->empresa_id);

        $empaques = Empaque::where('empaque.empresa_id','=', $empresa->id)
            ->join('lista_empaques', 'empaque.lista_empaques_id', '=', 'lista_empaques.id')
            ->join('ubicacion_almacen', 'empaque.ubicacion_almacen_id', '=', 'ubicacion_almacen.id')
            ->join('almacen', 'ubicacion_almacen.almacen_id', '=', 'almacen.id')
            ->select('empaque.*', 'lista_empaques.codigo as empaque_lista_empaque_codigo', 'almacen.nombre as empaque_almacen_nombre', 'ubicacion_almacen.nombre as empaque_ubicacion_nombre')
            ->orderBy('empaque.id', 'desc')
            ->get();
        
        foreach($empaques as $empaque){
            $movimientos = Movimiento::where('empaque_id', $empaque->id)->count();
            if($movimientos !== null && $movimientos > 1){
                $empaque->tiene_movimientos = true;
            }else{
                $empaque->tiene_movimientos = false;
            }
        }
        
        

        $almacenes = Almacen::where('empresa_id', $empresa->id)->get();
        foreach ($almacenes as $almacen) {
            $almacen->ubicaciones = UbicacionAlmacen::where('ubicacion_almacen.almacen_id', $almacen->id)
                ->whereNull('ubicacion_almacen.deleted_at')
                ->get();
        }

        
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
        $empaque->criterio1 = $request->has('criterio1') ? true : false;
        $empaque->criterio2 = $request->has('criterio2') ? true : false;
        $empaque->criterio3 = $request->has('criterio3') ? true : false;
        $empaque->empresa_id = auth()->user()->empresa_id;
        $empaque->save();

        $lista_empaques = ListaEmpaques::find($empaque->lista_empaques_id);
        $lista_empaques->stock_registrado = $lista_empaques->stock_registrado + 1;
        $lista_empaques->stock_actual = $lista_empaques->stock_actual + 1;
        $lista_empaques->update();

        $configuracion = Configuracion::where('empresa_id',auth()->user()->empresa_id)->first();
        $movimiento = new Movimiento();
        $movimiento->empaque_id = $empaque->id;
        $movimiento->fecha = now();
        $movimiento->hora = date('H:i:s');
        $movimiento->tipo_movimiento = 'interno';
        $movimiento->ubicacion_destino_id = $configuracion->ubicacion_default;
        $movimiento->encargado_id = auth()->user()->trabajador_id;
        $movimiento->empresa_id = auth()->user()->empresa_id;
        $movimiento->save();

        $empaque->ubicacion_almacen_id =  $movimiento->ubicacion_destino_id ;
        $empaque->update();
        
        if($request->vista == 'vista_empaques'){
            return redirect()->route('empaque.index');
        }
        return redirect()->route('lista_empaques.index');
    }

    public function update($id, EditEmpaqueRequest $request)
    {
        $empaque = Empaque::findOrFail($id);
        
        $empaque->tipo = $request->tipo;
        $empaque->cantidad_cajas = $request->cantidad_cajas;
        $empaque->peso = $request->peso;
        $empaque->unidad_medida = $request->unidad_medida;
        $empaque->descripcion = $request->descripcion;
        $empaque->estado = $request->estado;
        $empaque->observacion_estado = $request->observacion_estado;
        $empaque->criterio1 = $request->has('criterio1') ? true : false;
        $empaque->criterio2 = $request->has('criterio2') ? true : false;
        $empaque->criterio3 = $request->has('criterio3') ? true : false;
        $empaque->update();

        return redirect()->route('empaque.index')->with('success', 'Lista de empaques actualizada exitosamente.');
    }

    public function delete($id)
    {
        $cantMovimientos = Movimiento::where('empaque_id',$id)->count();
        if($cantMovimientos == null || $cantMovimientos <2){
            $empaque = Empaque::findOrFail($id);
                        $empaque->delete();
                        $listaEmpaque = ListaEmpaques::find($empaque->lista_empaques_id);
                        $listaEmpaque->stock_registrado = $listaEmpaque->stock_registrado-1;
                        $listaEmpaque->stock_actual = $listaEmpaque->stock_actual-1;
                        $listaEmpaque->update();
        }
        return redirect()->route('empaque.index');
    }
}
