<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListaEmpaquesRequest;
use App\Models\Almacen;
use App\Models\Bitacora;
use App\Models\Empaque;
use App\Models\Empresa;
use App\Models\ListaEmpaques;
use App\Models\Movimiento;
use App\Models\Proveedor;
use App\Models\UbicacionAlmacen;
use DB;
use Illuminate\Http\Request;

class ListaEmpaquesController extends Controller
{
    public function index()
    {
        $empresa = Empresa::find(auth()->user()->empresa_id);

        $listas = ListaEmpaques::where('lista_empaques.empresa_id', '=', $empresa->id)
        ->whereNot(function ($query) {
            $query->where('lista_empaques.stock_esperado', '=', DB::raw('lista_empaques.stock_registrado'))
                ->where('lista_empaques.stock_actual', '=', 0);
        })
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
        try{
            $listaEmpaques = new ListaEmpaques();
            $listaEmpaques->codigo = strtoupper($request->codigo);
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

            $subioArchivo = false;
            if( isset($request->documento) ){
                $archivo = $request->file('documento');
                $archivo_base64String = base64_encode(file_get_contents($archivo));
                $listaEmpaques->documento = $archivo_base64String;
                $subioArchivo = true; 
            } 

            $listaEmpaques->save();

            Bitacora::create([
                'user_id' => auth()->user()->id,
                'evento' => 'Creación de Lista de Empaques',
                'descripcion' => 'ListaEmpaque: '.$listaEmpaques->id.'Código: ' . $listaEmpaques->codigo . ' registrado correctamente. ' . ($subioArchivo ? 'Archivo adjunto.' : 'Sin archivo.'),
                'empresa_id' => auth()->user()->empresa_id,
                'tipo_evento' => 'info'
            ]);

            return redirect()->route('home');
        }catch (\Exception $e) {
            // Registro de error en la Bitácora
            Bitacora::create([
                'user_id' => auth()->user()->id,
                'evento' => 'Error al registrar Lista de Empaques',
                'descripcion' => 'Error: ' . $e->getMessage(),
                'empresa_id' => auth()->user()->empresa_id,
                'tipo_evento' => 'error'
            ]);
    
            // Retornar con un error a la vista o manejar el error
            return redirect()->back()->withErrors('Hubo un problema al registrar el ListaEmpaques.');
        }
    }

    public function update($id, ListaEmpaquesRequest $request)
    {
        try {
            $empresa = Empresa::find(auth()->user()->empresa_id);

            $listaEmpaques = ListaEmpaques::where('id', $id)
            ->where('empresa_id', $empresa->id)
            ->firstOrFail();
            
            $listaEmpaques->codigo = strtoupper($request->codigo);
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

            $subioArchivo = false;
            $eliminoArchivo = false;
            
            if( isset($request->documento) ){
                $archivo = $request->file('documento');
                $archivo_base64String = base64_encode(file_get_contents($archivo));
                $listaEmpaques->documento = $archivo_base64String;
                $subioArchivo = true;

            }elseif ($request->has('documento_eliminado')) {
                $listaEmpaques->documento = null; 
                $eliminoArchivo = true;
            }
            
            $listaEmpaques->update();

            Bitacora::create([
                'user_id' => auth()->user()->id,
                'evento' => 'Actualización de Lista de Empaques',
                'descripcion' => 'Se actualizó la Lista de Empaques con ID: ' . $listaEmpaques->id
                    . ($subioArchivo ? ' con archivo subido.' : ($eliminoArchivo ? ' con archivo eliminado.' : ' sin cambios en el archivo.')),
                'empresa_id' => auth()->user()->empresa_id,
                'tipo_evento' => 'info'
            ]);

            return redirect()->route('home')->with('success', 'Lista de empaques actualizada exitosamente.');
        
        } catch (\Exception $e) {

            Bitacora::create([
                'user_id' => auth()->user()->id,
                'evento' => 'Error al actualizar Lista de Empaques',
                'descripcion' => 'Error: ' . $e->getMessage(),
                'empresa_id' => auth()->user()->empresa_id,
                'tipo_evento' => 'error'
            ]);
    
            // Manejo del error
            return redirect()->back()->withErrors('Hubo un problema al actualizar la ListaEmpaques.');
        }
    }

    public function delete($id)
    {
        try {
            $empresa = Empresa::find(auth()->user()->empresa_id);

            $listaEmpaques = Empaque::where('empresa_id', $empresa->id)->where('lista_empaques_id',$id)->get();
            $tiene_movimientos = $this->tieneMovimientos($id);
            if($tiene_movimientos == false){
                foreach ($listaEmpaques as $empaque) {
                    $empaque->delete(); 
                }
                $lista = ListaEmpaques::find($id);
                $lista->delete();

                Bitacora::create([
                    'user_id' => auth()->user()->id,
                    'evento' => 'Eliminación de Lista de Empaques',
                    'descripcion' => 'Se eliminó la Lista de Empaques con ID: ' . $id,
                    'empresa_id' => auth()->user()->empresa_id,
                    'tipo_evento' => 'info'
                ]);
            }
            
            return redirect()->route('home')->with('success', 'Lista de empaques eliminada correctamente.');
            
        } catch (\Exception $e) {
            // Registro de error en la Bitácora
            Bitacora::create([
                'user_id' => auth()->user()->id,
                'evento' => 'Error al eliminar Lista de Empaques',
                'descripcion' => 'Error al eliminar la Lista de Empaques con ID: ' . $id . ' - Error: ' . $e->getMessage(),
                'empresa_id' => auth()->user()->empresa_id,
                'tipo_evento' => 'error'
            ]);
    
            // Manejo del error
            return redirect()->back()->withErrors('Hubo un problema al eliminar la Lista de Empaques.');
        }
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
