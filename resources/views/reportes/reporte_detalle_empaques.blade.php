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
                                                <label class="form-control-label">Lista de Empaque</label>
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
                                            <th>Lista de Empaque</th>
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

    // Deshabilitar botón y mostrar spinner
    button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generando...';
    button.disabled = true;

    // Obtener los valores de las variables de PHP que vinieron con la vista
    var proveedor_id = '{{ $proveedor_id }}';
    var fechaInicio = '{{ $fecha_inicio }}';
    var fechaFin = '{{ $fecha_fin }}';
    var almacen_id = '{{ $almacen_id }}'; // Si también estás manejando almacén

    // Realizar solicitud AJAX con Fetch API
    fetch('{{ route("reporte.empaques.excel") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Incluir token CSRF
        },
        body: JSON.stringify({
            proveedor_id: proveedor_id,
            fechaInicio: fechaInicio,
            fechaFin: fechaFin,
            almacen_id: almacen_id
        })
    })
    .then(response => {
        // Verificar si la respuesta es exitosa
        if (response.ok) {
            return response.blob(); // Convertir la respuesta en un objeto Blob (archivo)
        } else {
            throw new Error('Error al generar el reporte');
        }
    })
    .then(blob => {
        // Crear un enlace temporal para descargar el archivo
        var downloadUrl = window.URL.createObjectURL(blob);
        var a = document.createElement('a');
        a.href = downloadUrl;
        a.download = 'reporte_empaques_' + new Date().toISOString().slice(0, 10) + '.xlsx';
        document.body.appendChild(a);
        a.click();
        a.remove();
        
        // Restaurar el botón
        button.innerHTML = originalContent;
        button.disabled = false;
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un problema al generar el reporte.');

        // Restaurar el botón en caso de error
        button.innerHTML = originalContent;
        button.disabled = false;
    });
});

</script>
@endpush
