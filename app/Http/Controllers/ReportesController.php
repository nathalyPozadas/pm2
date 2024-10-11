<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Empresa;
use App\Models\ListaEmpaques;
use App\Models\Proveedor;
use Carbon\Carbon;
use Date;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function reporteListas_index()
    {
        $fechaFin = Carbon::today()->toDateString();
        $fechaInicio = Carbon::today()->subMonths(1)->toDateString();

        $totalStockEsperado = 0;
        $totalStockRegistrado = 0;
        $totalStockSaldo = 0;
        $totalStockEgresado = 0;

        $listas = $this->obtenerListado($fechaInicio, $fechaFin, '0', $totalStockEsperado, $totalStockRegistrado , $totalStockSaldo, $totalStockEgresado);

        
        $empresa = Empresa::find(auth()->user()->empresa_id);
        $icono_empresa = $empresa->icono;

        $proveedores = Proveedor::where('empresa_id',$empresa->id)->get();
        $almacenes = Almacen::where('empresa_id',$empresa->id)->get();
       
        return view("reportes.reporte_detalle_lista", ['listas'=>$listas, 'icono_empresa'=>$icono_empresa  ,'fecha_inicio'=>$fechaInicio, 'fecha_fin'=>$fechaFin, 'proveedores'=> $proveedores, 'almacenes'=>$almacenes,

            'totalStockEsperado'=>$totalStockEsperado ,
            'totalStockRegistrado'=>$totalStockRegistrado,
            'totalStockSaldo'=>$totalStockSaldo,
            'totalStockEgresado'=>$totalStockEgresado
            ]);

    }

    public function reporteListas(Request $request)
    {
        $fechaInicio = $request->fechaInicio;
        $fechaFin = $request->fechaFin;

        $totalStockEsperado = 0;
        $totalStockRegistrado = 0;
        $totalStockSaldo = 0;
        $totalStockEgresado = 0;

        $listas = $this->obtenerListado($fechaInicio, $fechaFin, $request->proveedor_id,  $totalStockEsperado, $totalStockRegistrado , $totalStockSaldo, $totalStockEgresado);

        
        $empresa = Empresa::find(auth()->user()->empresa_id);
        $icono_empresa = $empresa->icono;

        $proveedores = Proveedor::where('empresa_id',$empresa->id)->get();
        $almacenes = Almacen::where('empresa_id',$empresa->id)->get();
       
        return response()->json(['listas' => $listas, 'proveedores'=> $proveedores, 'almacenes'=>$almacenes,
                            'totalStockEsperado'=>$totalStockEsperado ,
                            'totalStockRegistrado'=>$totalStockRegistrado,
                            'totalStockSaldo'=>$totalStockSaldo,
                            'totalStockEgresado'=>$totalStockEgresado
                             ],200);
    }
    private function obtenerListado($fechaInicio, $fechaFin, $proveedor_id, &$totalStockEsperado, &$totalStockRegistrado , &$totalStockSaldo, &$totalStockEgresado)
    {
        
        $listas = ListaEmpaques::whereBetween('fecha_recepcion', [$fechaInicio, $fechaFin])
        //->join('empaque','lista_empaques.id','=','empaque.lista_empaques_id')
        ->when($proveedor_id !== '0', function ($query) use ($proveedor_id) {
            return $query->where('lista_empaques.proveedor_id', $proveedor_id);
        })
        ->where('lista_empaques.empresa_id', auth()->user()->empresa_id)
        ->join('proveedor', 'lista_empaques.proveedor_id', '=', 'proveedor.id')
        ->select('lista_empaques.*', 'proveedor.nombre as proveedor_nombre')
        ->orderBy('lista_empaques.id', 'desc')
        ->get();

        $totalStockEsperado = $listas->sum('stock_esperado');
        $totalStockRegistrado = $listas->sum('stock_registrado');
        $totalStockSaldo = $listas->sum('stock_actual');
        $totalStockEgresado = $totalStockRegistrado - $totalStockSaldo;

        return $listas;
    }


    public function reporteEmpaques(Request $request)
    {
        
        if(count($request->request) == 0){
            $fechaInicio = Carbon::today()->subMonths(1)->toDateString();
            $fechaFin = Carbon::today()->toDateString();
            $proveedor_id='0';
            $almacen_id = '0';
        }else{

            $fechaInicio = $request->fecha_inicio;
            $fechaFin = $request->fecha_fin;
            $proveedor_id = $request->proveedor_id;
            $almacen_id = $request->almacen_id;
        }

        
        $listas = $this->obtenerListado_empaques($fechaInicio, $fechaFin, $proveedor_id, $almacen_id);
        
        $empresa = Empresa::find(auth()->user()->empresa_id);
        $icono_empresa = $empresa->icono;

        $proveedores = Proveedor::where('empresa_id',$empresa->id)->get();
        $almacenes = Almacen::where('empresa_id',$empresa->id)->get();

        return view("reportes.reporte_detalle_empaques", ['listas'=>$listas, 'icono_empresa'=>$icono_empresa, 'fecha_inicio'=>$fechaInicio, 'fecha_fin'=>$fechaFin,'proveedor_id'=>$proveedor_id,'almacen_id'=>$almacen_id,'proveedores'=> $proveedores, 'almacenes'=>$almacenes]);
    }



    private function obtenerListado_empaques($fechaInicio, $fechaFin, $proveedor_id, $almacen_id)
    {
        $listas = ListaEmpaques::whereBetween('fecha_recepcion', [$fechaInicio, $fechaFin])
        ->when($proveedor_id !== '0', function ($query) use ($proveedor_id) {
            return $query->where('lista_empaques.proveedor_id', $proveedor_id);
        })
        ->where('lista_empaques.empresa_id', auth()->user()->empresa_id)
        ->join('proveedor', 'lista_empaques.proveedor_id', '=', 'proveedor.id')
        ->select('lista_empaques.*', 'proveedor.nombre as proveedor_nombre')
        ->orderBy('lista_empaques.id', 'desc')
        ->get();

        foreach($listas as $lista){
            $empaques = ListaEmpaques::where('lista_empaques.id',$lista->id)
            ->join('empaque','lista_empaques.id','=','empaque.lista_empaques_id')
            ->join('proveedor', 'lista_empaques.proveedor_id', '=', 'proveedor.id')
            ->join('ubicacion_almacen','empaque.ubicacion_almacen_id','ubicacion_almacen.id')
            ->join('almacen','ubicacion_almacen.almacen_id','almacen.id')
            ->when($almacen_id !== '0', function ($query) use ($almacen_id) {
                return $query->where('almacen.id', $almacen_id);
            })
            ->select('lista_empaques.codigo as lista_empaque_codigo','empaque.*', 'proveedor.nombre as proveedor_nombre', 'ubicacion_almacen.nombre as empaque_ubicacion','almacen.nombre as empaque_almacen')
            ->orderBy('lista_empaques.id', 'desc')
            ->get();

            $lista->contenido = $empaques;
        }

        return $listas;
    }
}
