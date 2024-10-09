@extends('welcome')

@push('header-js-lista')
    <link href="{{ asset('dataTables') }}/datatables.min.css" rel="stylesheet">
    <script src="{{ asset('dataTables') }}/datatables.min.js"></script>
@endpush

@section('content')

<div class="container-fluid mt--9">

    

    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Listas de Empaque</h3>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-3">

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
                        </div>
                    </div>
                </div>

                <div class="table-responsive  px-4">
                    <table id="tablaListas" class="table align-items-center table-flush table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Lista Empaque</th>
                                <th scope="col">OC/Factura</th>
                                <th scope="col">Proveedor</th>
                                <th scope="col">Fecha Recepción</th>
                                <th scope="col">Cantidad Empaques</th>
                                <th scope="col">Ingreso</th>
                                <th scope="col">Egreso</th>
                                <th scope="col">Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($listas as $lista)
                                <tr>
                                    <td>{{$lista->id}}</td>
                                    <td>{{$lista->codigo}}</td>
                                    <td>{{$lista->factura}}</td>
                                    <td>{{$lista->proveedor_nombre}}</td>
                                    <td>{{ \Carbon\Carbon::parse($lista->fecha_recepcion)->format('d-m-Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($lista->fecha_llegada)->format('d-m-Y') }}</td>

                                    <td>{{$lista->stock_esperado}}</td>
                                    <td>{{$lista->stock_registrado}}</td>
                                    <td>{{$lista->stock_actual}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">

                    </nav>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')

    <script>
            var table = $('#tablaListas').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "(_START_ al _END_) de _TOTAL_ resultados",
                    "infoEmpty": "Mostrando 0 al 0 de 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
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
                lengthMenu: [10, 25, 50, 100], 
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

            function actualizarGraficas(){
                let fecha_inicio = document.getElementById('fecha_inicio').value;
                let fecha_fin = document.getElementById('fecha_fin').value;
                var token = $('meta[name="csrf-token"]').attr('content');

                fetch("{{ route('reporte.listas') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                _token: token,
                                fechaInicio: fecha_inicio, 
                                fechaFin: fecha_fin
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            $('#tablaListas').DataTable().destroy();
                            $('#tablaListas tbody').empty();

                            data.listas.forEach(function(lista) {
                                
                                var newRow = '<tr>' +
                                    '<td>' + lista.id +'</td>' +
                                    '<td>' + lista.codigo  + '</td>' +
                                    '<td>' + lista.factura  + '</td>' +
                                    '<td>' + lista.proveedor_nombre  + '</td>' +
                                    '<td>' + lista.fecha_recepcion  + '</td>' +
                                    '<td>' + lista.stock_esperado  + '</td>' +
                                    '<td>' + lista.stock_registrado  + '</td>' +
                                    '<td>' + lista.stock_registrado -  lista.stock_actual + '</td>' +
                                    '<td>' + lista.stock_actual  + '</td>' +
                                    '</tr>';

                            

                                $('#tablaListas tbody').append(newRow);
                            });

                            $('#tablaListas').DataTable({
                                language: {
                                            "decimal": "",
                                            "emptyTable": "No hay información",
                                            "info": "(_START_ al _END_) de _TOTAL_ resultados",
                                            "infoEmpty": "Mostrando 0 al 0 de 0 Entradas",
                                            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
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
                                lengthMenu: [10, 25, 50, 100], 
                                pageLength: 10
                            });
                        })
                        .catch(error => {
                            console.error('Error en la consulta fetch:', error);
                        });
                }




        


        
    </script>

@endpush