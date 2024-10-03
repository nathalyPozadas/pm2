@extends('welcome')

@push('header-js-lista')
   <link href="{{ asset('dataTables') }}/datatables.min.css" rel="stylesheet">
   <script src="{{ asset('dataTables') }}/datatables.min.js"></script>
@endpush

@section('content')

@include('users.partials.headerPaciente') 
        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Historial</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                        </div>

                        <div class="table-responsive px-4">
                            <table id="tablaHistorial" class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="col-2">Fecha</th>
                                        <th scope="col" class="col-10"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($sucesosPorFecha as $fecha => $sucesos)
                                    <tr>
                                            <td>{{\Carbon\Carbon::parse($fecha)->format('d-m-Y') }}</td>
                                            <td>
                                                @foreach ($sucesos as $suceso)
                                                    @if($suceso->tipo == 'historia')
                                                    <h4><i class="fas fa-list mr-2"></i> {{ $suceso->descripcion }}<br></h4>
                                                    @endif
                                                    @if($suceso->tipo == 'cita')
                                                    <h4><i class="ni ni-calendar-grid-58 mr-2"></i>{{ $suceso->descripcion }}<br></h4>
                                                    @endif
                                                    @if($suceso->tipo == 'pago_tratamiento_aplicado' || $suceso->tipo == 'baja_pago_tratamiento_aplicado')
                                                    <h4><i class="fa fa-dollar-sign mr-2"></i>{{ $suceso->descripcion }}<br></h4>
                                                    @endif
                                                    @if($suceso->tipo == 'accion_tratamiento_aplicado' || $suceso->tipo == 'baja_accion_tratamiento_aplicado')
                                                    <h4><i class="fa fa-check mr-2"></i>{{ $suceso->descripcion }}<br></h4>
                                                    @endif
                                                    @if($suceso->tipo == 'odontograma')
                                                    <h4><i class="fa fa-plus mr-2"></i>{{ $suceso->descripcion }}<br></h4>
                                                    @endif
                                                    @if($suceso->tipo == 'pago_implante' || $suceso->tipo == 'baja_pago_implante')
                                                    <h4><i class="fa fa-dollar-sign mr-2"></i>{{ $suceso->descripcion }}<br></h4>
                                                    @endif
                                                    @if($suceso->tipo == 'accion_implante'|| $suceso->tipo == 'baja_accion_implante')
                                                    <h4><i class="fa fa-check mr-2"></i>{{ $suceso->descripcion }}<br></h4>
                                                    @endif
                                                    @if($suceso->tipo == 'odontopediatria-examen_clinico'|| $suceso->tipo == 'odontopediatria-analisis_oclusion'|| $suceso->tipo == 'odontopediatria-evaluacion_tb')
                                                    <h4><i class="ni ni-book-bookmark mr-2"></i>{{ $suceso->descripcion }}<br></h4>
                                                    @endif
                                                    @if($suceso->tipo == 'odontopediatria-actualizacion_examen_clinico'|| $suceso->tipo == 'odontopediatria-actualizacion_analisis_oclusion'|| $suceso->tipo == 'odontopediatria-actualizacion_evaluacion_tb')
                                                    <h4><i class="ni ni-book-bookmark mr-2"></i>{{ $suceso->descripcion }}<br></h4>
                                                    @endif
                                                @endforeach
                                            </td>
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

        </div>
        @endsection

@push('js')
<script>
    
  var table = $('#tablaHistorial').DataTable({
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
    dom: 'Blfrtip',
        buttons: [
            {
                extend: 'copy',
                exportOptions: {
                    modifier: {
                        page: 'all'
                    }
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    modifier: {
                        page: 'all'
                    }
                }
            },
            {
                extend: 'excel',
                exportOptions: {
                    modifier: {
                        page: 'all'
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    modifier: {
                        page: 'all'
                    }
                },
                customize: function(doc) {
                    // Agrega un título al documento PDF
                    doc.content[0].text = 'Historial';
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    modifier: {
                        page: 'all'
                    }
                }
            }
        ],
        lengthMenu: [10, 25, 50, 100], // Opciones del selector de longitud de la página
        pageLength: 10,
        ordering: false
    });


</script>
@endpush