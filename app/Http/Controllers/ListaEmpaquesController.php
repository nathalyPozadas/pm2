<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListaEmpaquesRequest;
use App\Models\Almacen;
use App\Models\Empaque;
use App\Models\Empresa;
use App\Models\ListaEmpaques;
use App\Models\Movimiento;
use App\Models\Proveedor;
use App\Models\UbicacionAlmacen;
use Illuminate\Http\Request;

class ListaEmpaquesController extends Controller
{
    public function index()
    {
        $empresa = Empresa::find(auth()->user()->empresa_id);

        $listas = ListaEmpaques::where('lista_empaques.empresa_id','=',$empresa->id)
        ->join('proveedor', 'lista_empaques.proveedor_id', '=', 'proveedor.id')
        ->select('lista_empaques.*', 'proveedor.nombre as proveedor_nombre')
        ->orderBy('lista_empaques.id', 'desc')
        ->get();

        foreach($listas as $lista){
            $lista->tiene_movimientos = $this->tieneMovimientos($lista->id);
        }
        
        $icono_empresa = $empresa->icono;

        $proveedores = Proveedor::where('empresa_id','=', $empresa->id)
        ->orderBy('nombre')->get();
        
        $almacenes = Almacen::where('almacen.empresa_id', $empresa->id)->orderBy('nombre')->get();

        foreach($almacenes as $almacen){
            $almacen->ubicaciones = UbicacionAlmacen::where('empresa_id', $empresa->id)->where('ubicacion_almacen.almacen_id', $almacen->id)
            ->whereNull('ubicacion_almacen.deleted_at')
            ->get();
        }

        return view("lista_empaques.index", ['listas'=>$listas, 'icono_empresa'=>$icono_empresa, 'proveedores'=>$proveedores , 'almacenes'=>$almacenes ]);
    }

    public function show($id)
    {
        $empresa = Empresa::find(auth()->user()->empresa_id);

        $lista = ListaEmpaques::where('lista_empaques.empresa_id','=', $empresa->id)->where('lista_empaques.id', $id)
        ->join('proveedor', 'lista_empaques.proveedor_id', '=', 'proveedor.id')
        ->select('lista_empaques.*', 'proveedor.nombre as proveedor_nombre')
        ->first(); 

        $lista->empaques =  Empaque::where('empaque.empresa_id', $empresa->id)
            ->where('empaque.lista_empaques_id', $id)
            ->join('lista_empaques', 'empaque.lista_empaques_id', '=', 'lista_empaques.id')
            ->join('ubicacion_almacen', 'empaque.ubicacion_almacen_id', '=', 'ubicacion_almacen.id')
            ->join('almacen', 'ubicacion_almacen.almacen_id', '=', 'almacen.id')
            ->select('empaque.*', 'lista_empaques.codigo as empaque_lista_empaque_codigo', 'almacen.nombre as empaque_almacen_nombre', 'ubicacion_almacen.nombre as empaque_ubicacion_nombre')
            ->orderBy('empaque.id', 'desc')
            ->get();
        
        
        $icono_empresa = $empresa->icono;


        return view("lista_empaques.show", ['lista'=>$lista, 'icono_empresa'=>$icono_empresa  ]);
    }

    public function ver_documento($id){
        $listaEmpaques = ListaEmpaques::find($id);
        $documento_lista = base64_decode($listaEmpaques->documento);
        return response($documento_lista)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="documento_lista_'.strtolower($listaEmpaques->codigo).'.pdf"');
    }
    public function store(ListaEmpaquesRequest $request)
    {
        $listaEmpaques = new ListaEmpaques();
        $listaEmpaques->codigo = $request->codigo;
        $listaEmpaques->canal_aduana = $request->canal_aduana;
        $listaEmpaques->siniestrado  = $request->has('siniestrado') ? true : false;
        $listaEmpaques->transporte = $request->transporte;
        $listaEmpaques->factura = $request->factura;
        $listaEmpaques->proveedor_id =  $request->proveedor_id;
        $listaEmpaques->fecha_recepcion = $request->fecha_recepcion;
        $listaEmpaques->fecha_llegada = $request->fecha_llegada;
        $listaEmpaques->fecha_creacion = now();
        $listaEmpaques->stock_esperado = $request->stock_esperado;
        $listaEmpaques->encargado_id = auth()->user()->trabajador_id;
        $listaEmpaques->empresa_id = auth()->user()->empresa_id;

        if($listaEmpaques->siniestrado){
            $listaEmpaques->observacion = $request->observacion;
        }else{
            $listaEmpaques->observacion = null;
        }

        if( isset($request->documento) ){
            $archivo = $request->file('documento');
            $archivo_base64String = base64_encode(file_get_contents($archivo));
            $listaEmpaques->documento = $archivo_base64String;
        } 

        $listaEmpaques->save();

        return redirect()->route('home');
    }

    public function update($id, ListaEmpaquesRequest $request)
    {
        $empresa = Empresa::find(auth()->user()->empresa_id);

        $listaEmpaques = ListaEmpaques::where('id', $id)
        ->where('empresa_id', $empresa->id)
        ->firstOrFail();
        
        $listaEmpaques->codigo = $request->codigo;
        $listaEmpaques->canal_aduana = $request->canal_aduana;
        $listaEmpaques->siniestrado  = $request->has('siniestrado') ? true : false;
        $listaEmpaques->transporte = $request->transporte;
        $listaEmpaques->factura = $request->input('factura');
        $listaEmpaques->proveedor_id = $request->input('proveedor_id');
        $listaEmpaques->fecha_recepcion = $request->input('fecha_recepcion');
        $listaEmpaques->stock_esperado = $request->input('stock_esperado');

        if($listaEmpaques->siniestrado){
            $listaEmpaques->observacion = $request->observacion;
        }else{
            $listaEmpaques->observacion = null;
        }
        
        if( isset($request->documento) ){
            $archivo = $request->file('documento');
            $archivo_base64String = base64_encode(file_get_contents($archivo));
            $listaEmpaques->documento = $archivo_base64String;
        }elseif ($request->has('documento_eliminado')) {
            $listaEmpaques->documento = null; 
        }
        
        $listaEmpaques->update();

        return redirect()->route('home')->with('success', 'Lista de empaques actualizada exitosamente.');
    }

    public function delete($id)
    {
        $empresa = Empresa::find(auth()->user()->empresa_id);

        $listaEmpaques = Empaque::where('empresa_id', $empresa->id)->where('lista_empaques_id',$id)->get();
        $tiene_movimientos = $this->tieneMovimientos($id);
        if($tiene_movimientos == false){
            foreach ($listaEmpaques as $empaque) {
                $empaque->delete(); 
            }
            $lista = ListaEmpaques::find($id);
            $lista->delete();
        }
        
        return redirect()->route('home')->with('success', 'Lista de empaques eliminada correctamente.');
    }


    private function tieneMovimientos($lista_empaques_id){
        $empresa = Empresa::find(auth()->user()->empresa_id);
        $resultado = false;

        $listaEmpaques = Empaque::where('empresa_id', $empresa->id)->where('lista_empaques_id',$lista_empaques_id)->get();
        foreach ($listaEmpaques as $empaque) {
            $movimientos = Movimiento::where('empaque_id', $empaque->id)->count();
            if($movimientos !== null && $movimientos > 1){
                $resultado = true;
                break;
            }
        }

        return $resultado;
    }
}
