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
                <div class="card-header border-0" >

                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="mb-0">Reporte Listas</h3>
                        </div>
                    </div>

                </div>

                <div class="col-12">
                    <div class="card-body">
                    <form action="{{ route('reporte.listas') }}" method="POST">
                    @csrf
                        <div class="row">
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
                            <div class="col-md-1">
                                <label class="form-control-label"></label>
                                <button type="submit" id="btn-actualizar-graficas"  class=" form-control btn btn-primary">
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
                                <!-- cabecera de datos -->
                                <div class="row mt-4">
                                    <div class="col-lg-6">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex flex-wrap">
                                            <div class="form-group mx-3 mb-3">
                                                <label class="form-control-label" for="input-email">{{ __('Total Esperado ') }}</label>
                                                <br>
                                                <span class="description" id="resultado-totalStockEsperado">{{$totalStockEsperado}}</span>
                                            </div>
                                            <div class="form-group mx-3 mb-3">
                                                <label class="form-control-label" for="input-email">{{ __('Total Registrado') }}</label>
                                                <br>
                                                <span class="description" id="resultado-totalStockRegistrado">{{$totalStockRegistrado}}</span>
                                            </div>
                                            <div class="form-group mx-3 mb-3">
                                                <label class="form-control-label" for="input-email">{{ __('Total Egresados') }}</label>
                                                <br>
                                                <span class="description" id="resultado-totalStockEgresado">{{$totalStockEgresado}}</span>
                                            </div>
                                            <div class="form-group mx-3 mb-3">
                                                <label class="form-control-label" for="input-email">{{ __('Total Saldo Actual') }}</label>
                                                <br>
                                                <span class="description" id="resultado-totalStockSaldo">{{$totalStockSaldo}}</span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                </div>
                                <!-- fin cabecera de datos -->
                        <div class="">
                           
                            
                            <div class="row">

                                <div class="col-12 ">

                                    <div class="table-responsive px-4">
                                        <table id="tablaDetalle" class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Lista de Empaque</th>
                                                    <th scope="col">OC/Factura</th>
                                                    <th scope="col">Proveedor</th>
                                                    <th scope="col">Fecha recepción</th>
                                                    <th scope="col">Stock esperado</th>
                                                    <th scope="col">Stock Registrado</th>
                                                    <th scope="col">Stock Egresado</th>
                                                    <th scope="col">Stock Actual</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($listas as $lista)
                                                <tr>
                                                    <td></td>
                                                    <td>{{$lista->codigo}}</td>
                                                    <td>{{$lista->factura}}</td>
                                                    <td>{{$lista->proveedor_nombre}}</td>
                                                    <td>{{\Carbon\Carbon::parse($lista->fecha_recepcion)->format('d-m-Y')}}</td>
                                                    <td>{{$lista->stock_esperado}}</td>
                                                    <td>{{$lista->stock_registrado}}</td>
                                                    <td>{{$lista->stock_registrado-$lista->stock_actual}}</td>
                                                    <td>{{$lista->stock_actual}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>


                                </div>

                                
                            
                                
                            </div>
                            
                        </div>
                    </div>
                </div>

                
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">

                    </nav>
                </div>
            </div>
        </div>
    </div>

</div>
<br>
@endsection


@push('js')
<script>



       

//datatables 
        
var tablaDetalle = $('#tablaDetalle').DataTable({
        searching: false, // Desactivar la función de búsqueda
        ordering: true ,
    language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "(_START_ al _END_) de _TOTAL_ resultados",
        "infoEmpty": "No se encontraron resultados",
        "infoFiltered": "(Filtrado de _MAX_ total resultados)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Resultados",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": ">",
            "previous": "<"
        }
    },
    dom: 'lfrtip',
        lengthMenu: [10, 25, 50, 100], // Opciones del selector de longitud de la página
        pageLength: 10,
    });
  

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

        // Realizar solicitud AJAX con Fetch API
        fetch('{{ route("reporte.listas.excel") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Incluir token CSRF
            },
            body: JSON.stringify({
                proveedor_id: proveedor_id,
                fechaInicio: fechaInicio,
                fechaFin: fechaFin
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