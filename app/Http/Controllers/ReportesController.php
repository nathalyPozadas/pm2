<?php

namespace App\Http\Controllers;

use App\Exports\ReporteEmpaques;
use App\Exports\ReporteListas;
use App\Models\Almacen;
use App\Models\Empresa;
use App\Models\ListaEmpaques;
use App\Models\Proveedor;
use Carbon\Carbon;
use Date;
use Illuminate\Http\Request;
//use Maatwebsite\Excel\Excel;
//use MiExport;


use App\Exports\MiExport;
use Maatwebsite\Excel\Facades\Excel;
class ReportesController extends Controller
{
    public function reporteListas(Request $request)
    {

        if(count($request->request) == 0){
            $fechaInicio = Carbon::today()->subMonths(1)->toDateString();
            $fechaFin = Carbon::today()->toDateString();
            $proveedor_id='0';
        }else{
            $fechaInicio = $request->fecha_inicio;
            $fechaFin = $request->fecha_fin;
            $proveedor_id = $request->proveedor_id;
        }

        $totalStockEsperado = 0;
        $totalStockRegistrado = 0;
        $totalStockSaldo = 0;
        $totalStockEgresado = 0;

        $listas = $this->obtenerListado($fechaInicio, $fechaFin, $proveedor_id, $totalStockEsperado, $totalStockRegistrado , $totalStockSaldo, $totalStockEgresado);

        $empresa = Empresa::find(auth()->user()->empresa_id);
        $icono_empresa = $empresa->icono;

        $proveedores = Proveedor::where('empresa_id',$empresa->id)->get();
        $almacenes = Almacen::where('empresa_id',$empresa->id)->get();
       
        return view("reportes.reporte_detalle_lista", 
        [
            'icono_empresa'=>$icono_empresa,
            'listas'=>$listas, 
            'fecha_inicio'=>$fechaInicio, 
            'fecha_fin'=>$fechaFin, 
            'proveedor_id'=>$proveedor_id,
            'proveedores'=> $proveedores, 
            'almacenes'=>$almacenes,
            'totalStockEsperado'=>$totalStockEsperado ,
            'totalStockRegistrado'=>$totalStockRegistrado,
            'totalStockSaldo'=>$totalStockSaldo,
            'totalStockEgresado'=>$totalStockEgresado
            ]);
    }

    private function obtenerListado($fechaInicio, $fechaFin, $proveedor_id, &$totalStockEsperado, &$totalStockRegistrado , &$totalStockSaldo, &$totalStockEgresado)
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

        $totalStockEsperado = $listas->sum('stock_esperado');
        $totalStockRegistrado = $listas->sum('stock_registrado');
        $totalStockSaldo = $listas->sum('stock_actual');
        $totalStockEgresado = $totalStockRegistrado - $totalStockSaldo;

        return $listas;
    }
    public function reporteListasExcel(Request $request)
    {
        $totalStockEsperado = 0;
        $totalStockRegistrado = 0;
        $totalStockSaldo = 0;
        $totalStockEgresado = 0;
        
        $fechaInicio = $request->fechaInicio;
        $fechaFin = $request->fechaFin;
        $proveedor_id = $request->proveedor_id;

        $listas = $this->obtenerListado($fechaInicio, $fechaFin, $proveedor_id, $totalStockEsperado, $totalStockRegistrado , $totalStockSaldo, $totalStockEgresado);

        if($proveedor_id == '0'){
            $proveedorSeleccionado = 'TODOS';
        }else{
            $proveedor = Proveedor::find($proveedor_id);
            $proveedorSeleccionado = $proveedor->nombre;
        }

        $filtros = [
            'fechaInicio' => Carbon::parse($fechaInicio)->format('d-m-Y'),
            'fechaFin' => Carbon::parse($fechaFin)->format('d-m-Y'),
            'proveedorSeleccionado' => $proveedorSeleccionado
        ];

        $hoyText = Carbon::now()->format('d-m-Y');
        $nombreReporte = 'reporte_listas_'.$hoyText.'.xlsx';

        return Excel::download(new ReporteListas($listas,$filtros, $hoyText), $nombreReporte);
    }

    //--------------- REPORTE EMPAQUES -----------------------------------------------------------------------------
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

        return view("reportes.reporte_detalle_empaques", 
        ['listas'=>$listas, 
                'icono_empresa'=>$icono_empresa, 
                'fecha_inicio'=>$fechaInicio,
                'fecha_fin'=>$fechaFin,
                'proveedor_id'=>$proveedor_id,
                'almacen_id'=>$almacen_id,
                'proveedores'=> $proveedores, 
                'almacenes'=>$almacenes]);
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
            ->where('empaque.deleted_at','=',null)
            ->select('lista_empaques.codigo as lista_empaque_codigo','empaque.*', 'proveedor.nombre as proveedor_nombre', 'ubicacion_almacen.nombre as empaque_ubicacion','almacen.nombre as empaque_almacen')
            ->orderBy('lista_empaques.id', 'desc')
            ->get();

            $lista->contenido = $empaques;
        }

        return $listas;
    }

    public function reporteEmpaquesExcel(Request $request)
    {
        $fechaInicio = $request->fechaInicio;
        $fechaFin = $request->fechaFin;
        $proveedor_id = $request->proveedor_id;
        $almacen_id = $request->almacen_id;

        $listas = $this->obtenerListado_empaques($fechaInicio,  $fechaFin, $proveedor_id, $almacen_id);

        if($proveedor_id == '0'){
            $proveedorSeleccionado = 'TODOS';
        }else{
            $proveedor = Proveedor::find($proveedor_id);
            $proveedorSeleccionado = $proveedor->nombre;
        }

        if($almacen_id == '0'){
            $almacenSeleccionado = 'TODOS';
        }else{
            $proveedor = Almacen::find($almacen_id);
            $almacenSeleccionado = $proveedor->nombre;
        }

        $filtros = [
            'fechaInicio' => Carbon::parse($fechaInicio)->format('d-m-Y'),
            'fechaFin' => Carbon::parse($fechaFin)->format('d-m-Y'),
            'proveedorSeleccionado' => $proveedorSeleccionado,
            'almacenSeleccionado' => $almacenSeleccionado
        ];

        $hoyText = Carbon::now()->format('d-m-Y');
        $nombreReporte = 'reporte_empaques_'.$hoyText .'.xlsx';

        return Excel::download(new ReporteEmpaques($listas,$filtros, $hoyText), $nombreReporte);
    }


   
}
