<?php

namespace App\Http\Controllers;

use App\Exports\ReporteEgresados;
use App\Exports\ReporteEmpaques;
use App\Exports\ReporteListas;
use App\Models\Almacen;
use App\Models\Empresa;
use App\Models\ListaEmpaques;
use App\Models\Movimiento;
use App\Models\Proveedor;
use App\Models\UbicacionAlmacen;
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
        ->select(  'lista_empaques.id',
                            'lista_empaques.codigo',
                            'lista_empaques.factura',
                            'lista_empaques.canal_aduana',
                            'lista_empaques.siniestrado',
                            'lista_empaques.observacion',
                            'lista_empaques.proveedor_id',
                            'lista_empaques.stock_esperado',
                            'lista_empaques.stock_registrado',
                            'lista_empaques.stock_actual',
                            'lista_empaques.fecha_recepcion',
                            'lista_empaques.fecha_llegada',
                            'lista_empaques.transporte',
                            'proveedor.nombre as proveedor_nombre')
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
        ->select(   'lista_empaques.id',
                            'lista_empaques.codigo',
                            'lista_empaques.factura',
                            'lista_empaques.canal_aduana',
                            'lista_empaques.siniestrado',
                            'lista_empaques.observacion',
                            'lista_empaques.proveedor_id',
                            'lista_empaques.stock_esperado',
                            'lista_empaques.stock_registrado',
                            'lista_empaques.stock_actual',
                            'lista_empaques.fecha_recepcion',
                            'lista_empaques.fecha_llegada',
                            'lista_empaques.transporte',
                            'proveedor.nombre as proveedor_nombre')
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

            foreach($empaques as $empaque){
                $ultimoMovimiento = Movimiento::where('empaque_id', $empaque->id)
                ->orderBy('fecha', 'desc')
                ->orderBy('hora', 'desc')
                ->first();

                if($ultimoMovimiento->tipo_movimiento == "interno"){
                    $ub_anterior = "";
                    if($ultimoMovimiento->ubicacion_origen_id != null){
                        $ubicacion = UbicacionAlmacen::where("ubicacion_almacen.id",'=', $ultimoMovimiento->ubicacion_origen_id)
                        ->join('almacen','ubicacion_almacen.almacen_id','=','almacen.id')
                        ->select('ubicacion_almacen.nombre as ubicacion_almacen_nombre',
                                          'almacen.nombre as almacen_nombre')
                        ->first();
                        
                        $ub_anterior = $ubicacion->almacen_nombre ." > ". $ubicacion->ubicacion_almacen_nombre;
                    }
                    $empaque->ub_anterior = $ub_anterior;
                }
            }
            
            $lista->contenido = $empaques;
        }

        return $listas;
    }


public function reporteEmpaquesDetallado(Request $request)
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

        $listas = $this->obtenerListado_empaques_detallado($fechaInicio, $fechaFin, $proveedor_id, $almacen_id);
        
        $empresa = Empresa::find(auth()->user()->empresa_id);
        $icono_empresa = $empresa->icono;

        $proveedores = Proveedor::where('empresa_id',$empresa->id)->get();
        $almacenes = Almacen::where('empresa_id',$empresa->id)->get();

        return view("reportes.reporte_detalle_empaques_detallado", 
        ['listas'=>$listas, 
                'icono_empresa'=>$icono_empresa, 
                'fecha_inicio'=>$fechaInicio,
                'fecha_fin'=>$fechaFin,
                'proveedor_id'=>$proveedor_id,
                'almacen_id'=>$almacen_id,
                'proveedores'=> $proveedores, 
                'almacenes'=>$almacenes]);
    }
    private function obtenerListado_empaques_detallado($fechaInicio, $fechaFin, $proveedor_id, $almacen_id)
    {
        $listas = ListaEmpaques::whereBetween('fecha_recepcion', [$fechaInicio, $fechaFin])
        ->when($proveedor_id !== '0', function ($query) use ($proveedor_id) {
            return $query->where('lista_empaques.proveedor_id', $proveedor_id);
        })
        ->where('lista_empaques.empresa_id', auth()->user()->empresa_id)
        ->join('proveedor', 'lista_empaques.proveedor_id', '=', 'proveedor.id')
        ->select(   'lista_empaques.id',
                            'lista_empaques.codigo',
                            'lista_empaques.factura',
                            'lista_empaques.canal_aduana',
                            'lista_empaques.siniestrado',
                            'lista_empaques.observacion',
                            'lista_empaques.proveedor_id',
                            'lista_empaques.stock_esperado',
                            'lista_empaques.stock_registrado',
                            'lista_empaques.stock_actual',
                            'lista_empaques.fecha_recepcion',
                            'lista_empaques.fecha_llegada',
                            'lista_empaques.transporte',
                            'proveedor.nombre as proveedor_nombre')
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

            foreach($empaques as $empaque){
                $movimientos = Movimiento::where('empaque_id', $empaque->id)
                ->with([
                    'ubicacionOrigen.almacen', 
                    'ubicacionDestino.almacen',
                    'trabajador' 
                ])
                ->orderBy('fecha', 'asc')
                ->orderBy('hora', 'asc')
                ->get();

                $movimientos = $movimientos->map(function ($movimiento) {
                    
                    return [
                        'id' => $movimiento->id,
                        'fecha' => $movimiento->fecha,
                        'hora' => $movimiento->hora,
                        'trabajador'=> $movimiento->trabajador->apellidos.' '.$movimiento->trabajador->nombres,
                        'ubicacion_origen_nombre' => $movimiento->ubicacionOrigen->nombre ?? null,
                        'almacen_origen_nombre' => $movimiento->ubicacionOrigen->almacen->nombre ?? null,
                        'ubicacion_destino_nombre' => $movimiento->ubicacionDestino->nombre ?? null,
                        'almacen_destino_nombre' => $movimiento->ubicacionDestino->almacen->nombre ?? null,
                    ];
                });
                $empaque->movimientos = $movimientos;
            }
            
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

    public function reporteEgresados(Request $request)
    {
        $destino = $request->destino;
        if(count($request->request) == 0){
            $fechaInicio = Carbon::today()->subMonths(1)->toDateString();
            $fechaFin = Carbon::today()->toDateString();
            $destino='0';
        }else{
            $fechaInicio = $request->fecha_inicio;
            $fechaFin = $request->fecha_fin;
            $destino = $request->destino;
        }

        $lista = $this->obtenerListadoEgresos($fechaInicio, $fechaFin, $destino, $cantEgresados, $detalleEgresados);
        
        $empresa = Empresa::find(auth()->user()->empresa_id);
        $icono_empresa = $empresa->icono;

        $proveedores = Proveedor::where('empresa_id',$empresa->id)->get();
        $almacenes = Almacen::where('empresa_id',$empresa->id)->get();
        $destinos = [
            ['nombre' => 'Centro Distribución Montecristo'],
            ['nombre' => 'Tienda Ñuflo de Chavez'],
            ['nombre' => 'Tienda Cristobal de Mendoza'],
            ['nombre' => 'Tienda Grigota'],
            ['nombre' => 'Tienda Mutualista'],
            ['nombre' => 'Venta Directa']
        ];

        return view("reportes.reporte_egresos", 
        ['lista'=>$lista, 
                'icono_empresa'=>$icono_empresa, 
                'fecha_inicio'=>$fechaInicio,
                'fecha_fin'=>$fechaFin,
                'destino'=>$destino,
                'destinos'=> $destinos, 
                'cantEgresados'=>$cantEgresados,
                'detalleEgresados'=> $detalleEgresados
            ]);
    }
    
    private function obtenerListadoEgresos($fechaInicio, $fechaFin, $destino, &$cantEgresados, &$detalleEgresados)
    {
        $empaques = ListaEmpaques::join('empaque', 'lista_empaques.id', '=', 'empaque.lista_empaques_id')
        ->join('movimiento', 'empaque.id', '=', 'movimiento.empaque_id')
        ->where('movimiento.tipo_movimiento', '=', 'externo') // Filtra por tipo externo
        ->whereBetween('movimiento.fecha', [$fechaInicio, $fechaFin]) // Filtra por fecha entre $fechaInicio y $fechaFin
        ->when($destino !== '0', function($query) use ($destino) {
            return $query->where('movimiento.destino', '=', $destino); // Filtra por destino si $destino no es 0
        })
        ->select('lista_empaques.codigo as lista_empaque_codigo', 'empaque.*', 'movimiento.*') // Especifica las columnas que deseas obtener
        ->get();

        $cantEgresados = $empaques->count();

        $detalleEgresados = [
            'cant_pallet' => $empaques->filter(function($empaque) {
                return $empaque->tipo === 'pallet'; 
            })->count(),
            
            'cant_bolsa' => $empaques->filter(function($empaque) {
                return $empaque->bolsa === 'bolsa'; 
            })->count(),
            'cant_caja' => $empaques->filter(function($empaque) {
                return $empaque->bolsa === 'caja';
            })->count(),
        ];
        $detalleEgresados['peso_por_unidad'] = $empaques->groupBy('unidad_medida')->map(function ($group) {
            return $group->sum('peso');
        });
        

        return $empaques;
    }

    public function reporteEgresadosExcel(Request $request)
    {
        $cantEgresados = 0;
        $detalleEgresados = [];
        
        $fechaInicio = $request->fechaInicio;
        $fechaFin = $request->fechaFin;
        $destinoSeleccionado = $request->destino;

        $lista = $this->obtenerListadoEgresos($fechaInicio, $fechaFin, $destinoSeleccionado, $cantEgresados, $detalleEgresados );

        if($destinoSeleccionado == '0'){
            $destinoSeleccionado = 'TODOS';
        }

        $filtros = [
            'fechaInicio' => Carbon::parse($fechaInicio)->format('d-m-Y'),
            'fechaFin' => Carbon::parse($fechaFin)->format('d-m-Y'),
            'destino' => $destinoSeleccionado
        ];

        $hoyText = Carbon::now()->format('d-m-Y');
        $nombreReporte = 'reporte_listas_'.$hoyText.'.xlsx';

        return Excel::download(new ReporteEgresados($lista,$filtros, $cantEgresados,$detalleEgresados,$hoyText), $nombreReporte);
    }

}
