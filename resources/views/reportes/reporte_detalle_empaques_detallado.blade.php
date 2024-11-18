@extends('welcome')

@push('header-js-lista')
    <script src="{{ asset('argon')}}/vendor/jquery-ui/jquery-ui.js"></script>
    <script src="{{ asset('argon')}}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon')}}/vendor/chart.js/dist/chartjs-plugin-datalabels.min.js"></script>
    
    <link href="{{ asset('dataTables') }}/datatables.min.css" rel="stylesheet">
    <script src="{{ asset('dataTables') }}/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>

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
                            <h3 class="mb-0">Reporte Empaques Detallado</h3>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card-body">
                        <form action="{{ route('reporte.empaques_movimiento') }}" method="POST">
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
                            @foreach($listas as $index => $lista)
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

                                <table id="tablaDetalle-{{ $index }}" class="table align-items-center table-flush"></table>
                                    
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
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.js"></script>

    <script>
    var data = @json($listas);
    console.log(data);

    var $table = $('#tablaDetalle');

    $(function () {
        data.forEach(function (item, index) {
            var $table = $(`#tablaDetalle-${index}`);
            buildTable($table, item);
        });
    });

    function buildTable($el, data) {
        var columns = [
           // { field: 'id', title: '#', sortable: true },
            { field: 'lista_empaque_codigo', title: 'Lista de Empaque', sortable: true },
            { field: 'numero', title: 'Numero', sortable: true },
            { field: 'tipo', title: 'Tipo', sortable: true },
            { field: 'descripcion', title: 'Descripcion', sortable: true },
            {
                title: 'Peso', // Título personalizado
                formatter: function (value, row, index) {
                    var peso = row.peso || ''; // Usa cadena vacía si no existe
                    var unidadMedida = row.unidad_medida || ''; // Usa cadena vacía si no existe

                    // Si ambos son vacíos, retorna una cadena vacía
                    if (!peso && !unidadMedida) {
                        return '';
                    }

                    // Concatenar peso y unidad de medida con un espacio
                    return `${peso} ${unidadMedida}`;
                },
                sortable: true // Permitir ordenamiento
            },
            {
                title: 'Ubicación', // Título personalizado
                formatter: function (value, row, index) {
                    var almacen = row.empaque_almacen || ''; // Usa cadena vacía si no existe
                    var ubicacion = row.empaque_ubicacion || ''; // Usa cadena vacía si no existe

                    // Si ambos son vacíos, retorna una cadena vacía
                    if (!almacen && !ubicacion) {
                        return '';
                    }

                    // Concatenar con `>`
                    return `${almacen} > ${ubicacion}`;
                },
                sortable: true // Permitir ordenamiento
            }
        ];


        $el.bootstrapTable({
            columns: columns,
            data: data.contenido || [],
            detailView: true, // Activa el detalle para filas expandibles.
            onExpandRow: function (index, row, $detail) {
                expandTable($detail, row);
            }
        });
    }

    function expandTable($detail, row) {
    // Crea una tabla hija dentro del detalle de la fila
    $detail.html('<table></table>').find('table').bootstrapTable({
        columns: [
            {   field: 'fecha', 
                title: 'Fecha', 
                sortable: true,
                formatter: function (value) {
                    if (!value) return ''; // Si la fecha es nula, retorna vacío
                    // Formatear fecha en día-mes-año
                    const date = new Date(value);
                    const day = date.getDate().toString().padStart(2, '0');
                    const month = (date.getMonth() + 1).toString().padStart(2, '0'); // Meses van de 0 a 11
                    const year = date.getFullYear();
                    return `${day}-${month}-${year}`;
                }

            },
            { field: 'hora', title: 'Hora', sortable: false },
            { field: 'trabajador', title: 'Trabajador', sortable: false },
            {
                title: 'Tipo',
                formatter: function (value, row) {
                    const almacenOrigen = row.almacen_origen_nombre;
                    const almacenDestino = row.almacen_destino_nombre;

                    if (!almacenOrigen && almacenDestino) {
                        return 'Ingreso'; // Almacén Origen es nulo
                    }
                    if (almacenOrigen && almacenDestino) {
                        return 'Mov Interno'; // Ambos tienen valores
                    }
                    if (almacenOrigen && !almacenDestino) {
                        return 'Externo'; // Almacén Origen tiene valor, Almacén Destino no
                    }
                    return ''; // Caso por defecto si ambos son nulos (opcional)
                },
                sortable: false
            },
            {
                title: 'Ubicación Origen',
                formatter: function (value, row, index) {
                    var almacenOrigen = row.almacen_origen_nombre || ''; // Valor o cadena vacía
                    var ubicacionOrigen = row.ubicacion_origen_nombre || ''; // Valor o cadena vacía

                    if (!almacenOrigen && !ubicacionOrigen) {
                        return ''; // Si ambos son nulos, retornar vacío
                    }
                    return `${almacenOrigen} > ${ubicacionOrigen}`; // Concatenar valores
                },
                sortable: false
            },
            {
                title: 'Ubicación Destino',
                formatter: function (value, row, index) {
                    var almacenDestino = row.almacen_destino_nombre || ''; // Valor o cadena vacía
                    var ubicacionDestino = row.ubicacion_destino_nombre || ''; // Valor o cadena vacía

                    if (!almacenDestino && !ubicacionDestino) {
                        return ''; // Si ambos son nulos, retornar vacío
                    }
                    return `${almacenDestino} > ${ubicacionDestino}`; // Concatenar valores
                },
                sortable: false
            }
        ],
        data: row.movimientos || [] // Datos de la subtabla
    });
}

</script>

@endpush
