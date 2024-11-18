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
                            <h3 class="mb-0">Reporte Egresos</h3>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card-body">
                        <form action="{{ route('reporte.egresos') }}" method="POST">
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
                                    <label class="form-control-label">Destino</label>
                                    <select name="destino" id="selectorProveedor" class="form-control form-control-alternative">
                                        <option value="0" {{ $destino == '0' ? 'selected' : '' }}>Todos</option>
                                        @foreach($destinos as $destinoOpcion)
                                            <option value="{{ $destinoOpcion['nombre'] }}" {{ $destinoOpcion['nombre'] == $destino ? 'selected' : '' }}>
                                                {{ $destinoOpcion['nombre'] }}
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

                           <!-- cabecera de datos -->
                           <div class="row mt-4">
                                    <div class="col-lg-6">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex flex-wrap">
                                            <div class="form-group mx-3 mb-3">
                                                <label class="form-control-label" >{{ __('Total Pallet') }}</label>
                                                <br>
                                                <span class="description" >{{$detalleEgresados['cant_pallet']}}</span>
                                            </div>
                                            <div class="form-group mx-3 mb-3">
                                                <label class="form-control-label" >{{ __('Total Bolsa') }}</label>
                                                <br>
                                                <span class="description" >{{$detalleEgresados['cant_bolsa']}}</span>
                                            </div>
                                            <div class="form-group mx-3 mb-3">
                                                <label class="form-control-label" >{{ __('Total Caja') }}</label>
                                                <br>
                                                <span class="description" >{{$detalleEgresados['cant_caja']}}</span>
                                            </div>
                                            <div class="form-group mx-3 mb-3">
                                                <label class="form-control-label" >{{ __('Total Egresados') }}</label>
                                                <br>
                                                <span class="description" >{{$cantEgresados}}</span>
                                            </div>
                                            <div class="form-group mx-3 mb-3">
                                                <label class="form-control-label" >{{ __('Total peso') }}</label>
                                                <br>
                                                <span class="description" >{{$cantEgresados}}</span>
                                            </div>
                                            <div class="form-group mx-3 mb-3">
                                                <label class="form-control-label" >{{ __('Total peso') }}</label>
                                                <br>
                                                <ul>
                                                    @foreach ($detalleEgresados['peso_por_unidad'] as $unidad => $pesoTotal)
                                                        @if($unidad!== '')
                                                        <strong>{{ $unidad }}:</strong> {{ $pesoTotal }} </li><br> <!-- Puedes cambiar el 'kg' si la unidad es diferente -->
                                                        @endif
                                                    @endforeach
                                                </ul>
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
                                                    <th scope="col">Lista de Empaque</th>
                                                    <th scope="col">Numero</th>
                                                    <th scope="col">Tipo</th>
                                                    <th scope="col">Descripcion</th>
                                                    <th scope="col">Cant. cajas</th>
                                                    <th scope="col">Peso</th>
                                                    <th scope="col">Unidad Medida</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($lista as $empaque)
                                                <tr>
                                                    <td>{{$empaque->lista_empaque_codigo}}</td>
                                                    <td>{{$empaque->numero}}</td>
                                                    <td>{{$empaque->tipo}}</td>
                                                    <td>{{$empaque->descripcion}}</td>
                                                    <td>{{$empaque->cantidad_cajas}}</td>
                                                    <td>{{$empaque->peso}}</td>
                                                    <td>{{$empaque->unidad_medida}}</td>
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
document.getElementById('exportarExcel').addEventListener('click', function() {
        var button = this;
        var originalContent = button.innerHTML;

        // Deshabilitar botón y mostrar spinner
        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generando...';
        button.disabled = true;

        // Obtener los valores de las variables de PHP que vinieron con la vista
        var destino = '{{ $destino }}';
        var fechaInicio = '{{ $fecha_inicio }}';
        var fechaFin = '{{ $fecha_fin }}';

        // Realizar solicitud AJAX con Fetch API
        fetch('{{ route("reporte.lista_egresos.excel") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Incluir token CSRF
            },
            body: JSON.stringify({
                destino: destino,
                fechaInicio: fechaInicio,
                fechaFin: fechaFin
            })
        })
        .then(response => {
            if (response.ok) {
                return response.blob(); 
            } else {
                throw new Error('Error al generar el reporte');
            }
        })
        .then(blob => {
            // Crear un enlace temporal para descargar el archivo
            var downloadUrl = window.URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = downloadUrl;
            a.download = 'reporte_egresos' + new Date().toISOString().slice(0, 10) + '.xlsx';
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

$(document).ready(function() {
    $('#tablaDetalle').DataTable({
        "language": {
            "paginate": {
                "previous": "<", // Botón "anterior" como ícono
                "next": ">" // Botón "siguiente" como ícono
            }
        },
        "columnDefs": [
            {
                "targets": [3], // Índice de la columna "Descripción"
                "createdCell": function(td, cellData, rowData, row, col) {
                    $(td).css({
                        "white-space": "normal", // Permite el salto de línea
                        "word-wrap": "break-word", // Permite que las palabras largas se rompan
                        "overflow-wrap": "break-word", // Alternativa moderna
                        "max-width": "300px" // Establece un ancho máximo
                    });
                }
            }
        ]
    });
});
</script>

@endpush
