@extends('welcome')

@push('header-js-lista')
    <script src="{{ asset('argon')}}/vendor/jquery-ui/jquery-ui.js"></script>
    <script src="{{ asset('argon')}}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon')}}/vendor/chart.js/dist/chartjs-plugin-datalabels.min.js"></script>
    
    <link href="{{ asset('dataTables') }}/datatables.min.css" rel="stylesheet">
    <script src="{{ asset('dataTables') }}/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
@endpush

@section('content')
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="mb-0">Reporte Empaques</h3>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card-body">
                        <form action="{{ route('reporte.empaques') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Fechas y filtros -->
                                <div class="col-md-2">
                                    <label class="form-control-label">Desde</label>
                                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control form-control-alternative" value="{{$fecha_inicio}}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-control-label">Hasta</label>
                                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control form-control-alternative" value="{{$fecha_fin}}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-control-label">Proveedor</label>
                                    <select name="proveedor_id" id="selectorProveedor" class="form-control form-control-alternative">
                                    <option value="0" {{ $proveedor_id == '0' ? 'selected' : '' }}>Todos</option>
                                    @foreach($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}" {{ $proveedor->id == $proveedor_id ? 'selected' : '' }}>
                                            {{ $proveedor->nombre }}
                                        </option>
                                    @endforeach

                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-control-label">Almacenes</label>
                                    <select name="almacen_id" id="selectorAlmacen" class="form-control form-control-alternative">
                                        <option value="0" {{ $almacen_id == '0' ? 'selected' : '' }}>Todos</option>
                                        @foreach($almacenes as $almacen)
                                            <option value="{{ $almacen->id }}" {{ $almacen->id == $almacen_id ? 'selected' : '' }}>
                                                {{ $almacen->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-control-label"></label>
                                    <button type="submit" class="form-control btn btn-primary">
                                        <span class="btn-inner--icon"><i class="fas fa-check"></i></span>
                                    </button>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-control-label"></label>
                                    <button id="exportarExcel" class="form-control btn btn-success">
                                        <span class="btn-inner--icon"><i class="fas fa-file-excel"></i></span> Descargar Excel
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Tablas -->
                        <div class="table-responsive px-4">
                            @foreach($listas as $lista)
                                <div class="row mt-4">
                                    <div class="col-lg-9">
                                        <div class="d-flex flex-wrap">
                                            <div class="form-group mx-3 mb-3">
                                                <label class="form-control-label">Código Lista Empaque</label>
                                                <br>
                                                <span class="description">{{$lista->codigo}}</span>
                                            </div>
                                            <div class="form-group mx-3 mb-3">
                                                <label class="form-control-label">Total Actual</label>
                                                <br>
                                                <span class="description">{{$lista->stock_actual}}</span>
                                            </div>
                                            <div class="form-group mx-3 mb-3">
                                                <label class="form-control-label">Fecha Recepción</label>
                                                <br>
                                                <span class="description">{{ \Carbon\Carbon::parse($lista->fecha_recepcion)->format('d-m-Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <table id="tablaDetalle" class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Código lista Empaque</th>
                                            <th>No Empaque</th>
                                            <th>Tipo de empaque</th>
                                            <th>Descripción</th>
                                            <th>Peso</th>
                                            <th>U.M.</th>
                                            <th>Almacén</th>
                                            <th>Ubicación</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($lista->contenido as $empaque)
                                            <tr>
                                                <td>{{$empaque->id}}</td>
                                                <td>{{$empaque->lista_empaque_codigo}}</td>
                                                <td>{{$empaque->numero}}</td>
                                                <td>{{$empaque->tipo}}</td>
                                                <td>{{$empaque->descripcion}}</td>
                                                <td>{{$empaque->peso}}</td>
                                                <td>{{$empaque->unidad_medida}}</td>
                                                <td>{{$empaque->empaque_almacen}}</td>
                                                <td>{{$empaque->empaque_ubicacion}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="..."></nav>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
@endsection

@push('js')
<script>
document.getElementById('exportarExcel').addEventListener('click', function() {
    var button = this;
    var originalContent = button.innerHTML;
    
    button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generando...';
    button.disabled = true;

    setTimeout(function() {


        var wb = XLSX.utils.book_new(); 
        var ws_data = [];
        var hoy = new Date();
        var fechaHoraFormateada = hoy.getDate().toString().padStart(2, '0') + '-' + 
                      (hoy.getMonth() + 1).toString().padStart(2, '0') + '-' + 
                      hoy.getFullYear() + ' ' + 
                      hoy.getHours().toString().padStart(2, '0') + ':' + 
                      hoy.getMinutes().toString().padStart(2, '0');

        ws_data.push([
            '', 
            'REPORTE DETALLE TOTAL DE EMPAQUES POR LISTA DE EMPAQUE'
        ]);
        ws_data.push(['']);
        ws_data.push(['', '', '', '', '', 'Fecha reporte', fechaHoraFormateada]);
         ws_data.push(['']);
        @foreach($listas as $lista)
            ws_data.push([
                'Código de Lista:', '{{$lista->codigo}}', 
                'Stock Actual:', '{{$lista->stock_actual}}',
                'Fecha Recepción:', '{{$lista->fecha_recepcion}}'
            ]);

            ws_data.push([
                'Código lista Empaque', 
                'No Empaque', 
                'Tipo de empaque', 
                'Descripción', 
                'Peso', 
                'U.M.', 
                'Almacén', 
                'Ubicación'
            ]);

            @foreach($lista->contenido as $empaque)
                ws_data.push([
                    '{{$empaque->lista_empaque_codigo}}',
                    '{{$empaque->numero}}',
                    '{{$empaque->tipo}}',
                    '{{$empaque->descripcion}}',
                    '{{$empaque->peso}}',
                    '{{$empaque->unidad_medida}}',
                    '{{$empaque->empaque_almacen}}',
                    '{{$empaque->empaque_ubicacion}}'
                ]);
            @endforeach

            ws_data.push([]);
        @endforeach

        var ws = XLSX.utils.aoa_to_sheet(ws_data);
        XLSX.utils.book_append_sheet(wb, ws, 'Reporte Empaques');
        XLSX.writeFile(wb, 'Reporte_Detalle_Empaque_'+fechaHoraFormateada+'.xlsx');
        
        button.innerHTML = originalContent;
        button.disabled = false;
    }, 1500);
});
</script>
@endpush
