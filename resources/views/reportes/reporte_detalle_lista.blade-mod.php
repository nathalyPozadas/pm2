@extends('welcome')

@push('header-js-lista')

    <script src="{{ asset('argon')}}/vendor/jquery-ui/jquery-ui.js"></script>
  <script src="{{ asset('argon')}}/vendor/chart.js/dist/Chart.min.js"></script>
  <script src="{{ asset('argon')}}/vendor/chart.js/dist/chartjs-plugin-datalabels.min.js"></script>

  
    

  <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.css">





@endpush
@section('content')
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
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
                                <button type="submit" id="btn-actualizar-graficas" class=" form-control btn btn-primary">
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

                    <!-- Tabla Principal -->
                    <div class="table-responsive px-4">
                    <div id="table"></div>


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.js"></script>

    <script>
    var data = @json($listas); // Asume que $listas contiene datos de ejemplo.
    console.log(data);

    var $table = $('#table');

    $(function () {
        buildTable($table, data);
    });

    function buildTable($el, data) {
        var columns = [
            { field: 'id', title: '#', sortable: true },
            { field: 'codigo', title: 'Lista de Empaque', sortable: true },
            { field: 'factura', title: 'OC/Factura', sortable: true },
            { field: 'proveedor_nombre', title: 'Proveedor', sortable: true },
            { field: 'fecha_recepcion', title: 'Fecha recepción', sortable: true },
            { field: 'stock_esperado', title: 'Stock esperado', sortable: true },
            { field: 'stock_registrado', title: 'Stock Registrado', sortable: true },
            { field: 'stock_egresado', title: 'Stock Egresado', sortable: true },
            { field: 'stock_actual', title: 'Stock Actual', sortable: true },
        ];

        $el.bootstrapTable({
            columns: columns,
            data: data,
            detailView: true, // Activa el detalle para filas expandibles.
            onExpandRow: function (index, row, $detail) {
                expandTable($detail, row);
            }
        });
    }

    function expandTable($detail, row) {
        // Crea una tabla hija dentro del detalle de la fila.
        $detail.html('<table></table>').find('table').bootstrapTable({
            columns: [
                { field: 'id_h', title: 'ID H', sortable: true },
                { field: 'codigo_h', title: 'Código H', sortable: true },
                { field: 'factura_h', title: 'Factura H', sortable: true }
            ],
            data: [
                { id_h: 1, codigo_h: 'ABC123', factura_h: '12345' } // Ejemplo de datos para la tabla hija.
            ]
        });
    }
</script>





@endpush
