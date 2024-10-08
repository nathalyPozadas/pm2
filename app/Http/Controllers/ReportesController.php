<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\ListaEmpaques;
use Carbon\Carbon;
use Date;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function reporteListas_index()
    {
        $fechaFin = Carbon::today()->toDateString();
        $fechaInicio = Carbon::today()->subMonths(3)->toDateString();

        $listas = $this->obtenerListado($fechaInicio, $fechaFin);

        
        $empresa = Empresa::find(auth()->user()->empresa_id);
        $icono_empresa = $empresa->icono;

       
       
        return view("reportes.reporte_detalle_lista", ['listas'=>$listas, 'icono_empresa'=>$icono_empresa  ,'fecha_inicio'=>$fechaInicio, 'fecha_fin'=>$fechaFin]);
    }

    public function reporteListas(Request $request)
    {
        $fechaInicio = Carbon::parse($request->fecha_inicio);
        $fechaFin = Carbon::parse($request->fecha_fin); 

        $listas = $this->obtenerListado($fechaInicio, $fechaFin);

        
        $empresa = Empresa::find(auth()->user()->empresa_id);
        $icono_empresa = $empresa->icono;

       
        return response()->json(['listas' => $listas],200);
    }
    private function obtenerListado($fechaInicio, $fechaFin)
    {
        $listas = ListaEmpaques::whereBetween('fecha_recepcion', [$fechaInicio, $fechaFin])
        ->join('proveedor', 'lista_empaques.proveedor_id', '=', 'proveedor.id')
        ->select('lista_empaques.*', 'proveedor.nombre as proveedor_nombre')
        ->orderBy('lista_empaques.id', 'desc')
        ->get();

        return $listas;
    }
}
