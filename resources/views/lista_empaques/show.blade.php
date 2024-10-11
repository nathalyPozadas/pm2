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
                <div class="card-header bg-transparent ">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Lista de empaque {{$lista->codigo}}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-white">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="d-flex flex-wrap">
                                <div class="form-group mx-3 mb-3">
                                    <label class="form-control-label" for="input-email">{{ __('Proveedor') }}</label>
                                    <br>
                                    <span class="description">{{ $lista->proveedor_nombre }}</span>
                                </div>
                                <div class="form-group mx-3 mb-3">
                                    <label class="form-control-label" for="input-email">{{ __('Canal Aduana') }}</label>
                                    <br>
                                    <span class="description">{{ $lista->canal_aduana }}</span>
                                </div>
                                <div class="form-group mx-3 mb-3">
                                    <label class="form-control-label" for="input-email">{{ __('Transporte') }}</label>
                                    <br>
                                    <span class="description">{{ $lista->transporte }}</span>
                                </div>
                                <div class="form-group mx-3 mb-3">
                                    <label class="form-control-label"
                                        for="input-email">{{ __('Fecha de recepción') }}</label>
                                    <br>
                                    <span class="description">{{ $lista->fecha_recepcion }}</span>
                                </div>
                                <div class="form-group mx-3 mb-3">
                                    <label class="form-control-label" for="input-email">{{ __('OC/Factura') }}</label>
                                    <br>
                                    <span class="description">{{ $lista->factura }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="card card-stats mb-1 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h4 class="card-title text-uppercase text-muted mb-0">Stock</h4>
                                        </div>

                                    </div>
                                    <p class="mt-3 mb-0 text-muted text-sm">
                                    <h5>Esperado: {{$lista->stock_esperado}}</h5>
                                    <h5>Registrado: {{$lista->stock_registrado}}</h5>
                                    <h5>Egresado: {{$lista->stock_registrado - $lista->stock_actual}}</h5>
                                    <h5>Actual: {{$lista->stock_actual}}</h5>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="table-responsive  px-4">
                    <table id="tablaEmpaques" class="table align-items-center table-flush table-striped text-wrap">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Almacen</th>
                                <th scope="col">Lugar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lista->empaques as $empaque)
                                <tr>
                                    <td><span class="badge badge-dot-lg mr-4">
                                            <i
                                                class="@if($empaque->estado == 'dañado') bg-danger @elseif($empaque->estado == 'correcto') bg-success @elseif($empaque->estado == 'mermado') bg-warning @endif"></i>
                                        </span>{{$empaque->id}}</td>
                                    <td style="text-transform: uppercase;">{{$empaque->tipo}}</td>
                                    <td>{{ $empaque->descripcion}}</td>
                                    <td>{{$empaque->empaque_almacen_nombre}}</td>
                                    <td>{{$empaque->empaque_ubicacion_nombre}}</td>
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
            var table = $('#tablaEmpaques').DataTable({
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
                lengthMenu: [10, 25, 50, 100], // Opciones del selector de longitud de la página
                pageLength: 10, // Valor inicial del selector de longitud de la página
            });

        </script>

    @endpush