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
                                <select id="selectorProveedor" class="form-control form-control-alternative">
                                    <option value="0" >Todos</option>
                                    @foreach($proveedores as $proveedor)
                                        <option value='{{$proveedor->id}}'>{{$proveedor->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label class="form-control-label"></label>
                                <button id="btn-actualizar-graficas" onClick="actualizarGraficas()" class=" form-control btn btn-primary">
                                    <span class="btn-inner--icon"><i class="fas fa-check"></i></span>
                                </button>
                            </div>
                            <div class="col-md-1">
                                <label class="form-control-label"></label>
                                <button id="quitarFiltro" class=" form-control btn btn-primary">
                                    <span class="btn-inner--icon"><i class="fas fa-times"></i></span>
                                </button>
                            </div>
                            <div class="col-md-2">
                                <label class="form-control-label"></label>
                                <button id="btn-exportar-excel" class="form-control btn btn-success" onClick="exportarExcel()">
                                    <span class="btn-inner--icon"><i class="fas fa-file-excel"></i></span> Descargar Excel
                                </button>
                            </div>

                        </div>
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
                                                    <th scope="col">Código</th>
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
  

    let btn_actualizar_graficas = document.getElementById('btn-actualizar-graficas');

    btn_actualizar_graficas.addEventListener('click', function() {
        actualizarGraficas();
    });

    let quitarFiltro = document.getElementById('quitarFiltro');

    quitarFiltro.addEventListener('click', function() {
        window.location.href = '{{ route('reporte.listas') }}';
    });

    var proveedorSeleccionado = 'TODOS';
    var fechaSeleccionadaDesde = '{{ $fecha_inicio }}';
    var fechaSeleccionadaHasta = '{{ $fecha_fin }}';
    var tiene_resultados = {{ count($listas) > 0 ? 'true' : 'false' }};


    function actualizarDatosSelectorExcel(){
        proveedorSeleccionado = $( "#selectorProveedor option:selected" ).text();
        fechaSeleccionadaDesde = document.getElementById('fecha_inicio').value;
        fechaSeleccionadaHasta = document.getElementById('fecha_fin').value;
        console.log('proveedor seleccionado::'+proveedorSeleccionado);
    }

    function actualizarGraficas(){
        actualizarDatosSelectorExcel();
        let fecha_inicio = document.getElementById('fecha_inicio').value;
        let fecha_fin = document.getElementById('fecha_fin').value;
        let proveedor_id = document.getElementById('selectorProveedor').value;

        var token = $('meta[name="csrf-token"]').attr('content');

        fetch("{{ route('reporte.listas') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        _token: token,
                        fechaInicio: fecha_inicio, 
                        fechaFin: fecha_fin,
                        proveedor_id: proveedor_id
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);

                    document.getElementById('resultado-totalStockEsperado').innerText = data.totalStockEsperado;
                    document.getElementById('resultado-totalStockRegistrado').innerText = data.totalStockRegistrado;
                    document.getElementById('resultado-totalStockSaldo').innerText = data.totalStockSaldo;
                    document.getElementById('resultado-totalStockEgresado').innerText = data.totalStockEgresado;

                    $('#tablaDetalle').DataTable().destroy();
                    $('#tablaDetalle tbody').empty();
                    
                    tiene_resultados = data.listas && data.listas.length > 0;

                    data.listas.forEach(function(lista) {
                        console.log(lista);
                        var fechaFormateada = formatearFecha(lista.fecha_recepcion);
                        var newRow = '<tr>' +
                            '<td>' + '</td>' +
                            '<td>' + lista.codigo + '</td>' +
                            '<td>' + lista.factura + '</td>' +
                            '<td>' + lista.proveedor_nombre + '</td>' +
                            '<td>' + fechaFormateada + '</td>' +
                            '<td>' + lista.stock_esperado + '</td>' +
                            '<td>' + lista.stock_registrado + '</td>' +
                            '<td>' + (lista.stock_registrado-lista.stock_actual) + '</td>' +
                            '<td>' + lista.stock_actual + '</td>' +
                            '</tr>';

                        $('#tablaDetalle tbody').append(newRow);
                    });

                    // Vuelve a inicializar la tabla con los nuevos datos
                    $('#tablaDetalle').DataTable({
                        searching: false, // Desactivar la función de búsqueda
                        ordering: false ,
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

                })
                .catch(error => {
                    console.error('Error en la consulta fetch:', error);
                });
    }

    function formatearFecha(fechaString){

        var partesFecha = fechaString.split("-");


        var fechaFormateada = partesFecha[2] + "-" + partesFecha[1] + "-" + partesFecha[0];
        return fechaFormateada;
    }

    function exportarExcel() {
    var tabla = document.getElementById('tablaDetalle');
    var filas = tabla.getElementsByTagName('tr');
    var datos = [];
    
    var hoy = new Date();
    var fechaHoraFormateada = hoy.getDate().toString().padStart(2, '0') + '-' + 
                      (hoy.getMonth() + 1).toString().padStart(2, '0') + '-' + 
                      hoy.getFullYear() + ' ' + 
                      hoy.getHours().toString().padStart(2, '0') + ':' + 
                      hoy.getMinutes().toString().padStart(2, '0');
        
   
    var bordes = {
        top: { style: "thin" },
        bottom: { style: "thin" },
        left: { style: "thin" },
        right: { style: "thin" }
    };

    datos.push(['','REPORTE DETALLE DE LISTA DE EMPAQUE']);
    datos.push(['']);
    datos.push(['',,'','','','','','Fecha reporte:',fechaHoraFormateada]);
    datos.push(['']);
    datos.push(['Proveedor:', proveedorSeleccionado, '', 'Fecha recepción:', fechaSeleccionadaDesde + ' hasta '+fechaSeleccionadaHasta]);
    datos.push(['']);
    var cabecera = ["","Lista empaque", "OC/Factura", "Proveedor", "Fecha Recepción", "Cant Empaques", "Ingreso", "Egresado", "Saldo"];
    datos.push(cabecera);


    var totalCantLista = 0, totalRegistrado = 0, totalEgresado = 0, totalStock = 0;
    if(tiene_resultados){
        for (var i = 1; i < filas.length; i++) {
            var tds = filas[i].getElementsByTagName('td');
            var filaDatos = [];
            for (var j = 0; j < tds.length; j++) {
                filaDatos.push(tds[j].innerText);
            }
            // Sumar totales
            totalCantLista += parseFloat(tds[5].innerText) || 0;
            totalRegistrado += parseFloat(tds[6].innerText) || 0;
            totalEgresado += parseFloat(tds[7].innerText) || 0;
            totalStock += parseFloat(tds[8].innerText) || 0;

            datos.push(filaDatos);
        }
    }

    var filaTotales = [
        '', '', '', '', 'Total', 
        totalCantLista, 
        totalRegistrado, 
        totalEgresado, 
        totalStock
    ];
    datos.push(filaTotales);

     var ws = XLSX.utils.aoa_to_sheet(datos);

const colWidths = datos[0].map((_, colIndex) => {
    const maxWidth = Math.max(...datos.map(row => row[colIndex] ? row[colIndex].toString().length : 0));
    return { width: maxWidth + 2 }; 
});


// Crear el libro y agregar la hoja de cálculo
var wb = XLSX.utils.book_new();
XLSX.utils.book_append_sheet(wb, ws, 'Reporte listas');

XLSX.writeFile(wb, 'Reporte_Detalle_Lista_'+fechaHoraFormateada+'.xlsx');
}








    
</script>
@endpush