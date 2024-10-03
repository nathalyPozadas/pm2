@extends('welcome')

@push('header-js-lista')
   <link href="{{ asset('dataTables') }}/datatables.min.css" rel="stylesheet">
   <script src="{{ asset('dataTables') }}/datatables.min.js"></script>
@endpush

@section('content')
    

<div class="container-fluid mt--7">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Pacientes</h3>
                                </div>
                                <div class="col-4 text-right">
                                    @can('administrar_pacientes')
                                    <a href="{{ route('paciente.create') }}" class="btn btn-sm btn-primary">Nuevo
                                        Paciente</a>
                                    @endcan    
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                        </div>

                        <div class="table-responsive  px-4">
                                <table id="tablaPacientes" class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Código</th>
                                            <th scope="col">Nombre Completo</th>
                                            <th scope="col">CI</th>
                                            <th scope="col">Edad</th>
                                            <th scope="col">Estado</th>
                                            <th scope="col">Saldo (Bs.)</th>
                                            <th scope="col">Tratamientos en ejecución</th>
                                            <th scope="col">Celular</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pacientes as $paciente)
                                        <tr>
                                            <td>{{$paciente->codigo}}</td>
                                            <td>{{$paciente->apellidos.' '.$paciente->nombres}}</td>
                                            <td>{{$paciente->ci}}</td>
                                        @php
                                        $diferencia = now()->diff($paciente->fecha_nacimiento);
                                        $años = $diferencia->y;
                                        @endphp
                                        <td>
                                        {{ $años }} 
                                        </td>

                                            <td>@if($paciente->activo)
                                                    Activo
                                                @else
                                                    Inactivo
                                                @endif
                                            </td>
                                            <td>{{$paciente->deuda}}</td>
                                            <td>{{$paciente->tratamientos}}</td>
                                            <td>{{$paciente->celular}}</td>
                                            <td class="text-right">
                                                <div>
                    
                                                    <a href="{{ route('paciente.show',['id' => $paciente->id])}}">
                                                        <button class="btn btn-icon btn-2 btn-primary" type="button" >
                                                            
                                                            <span class="btn-inner--icon"><i class="fas fa-eye"></i></span>
                                                        </button>
                                                    </a>
                                                    <a href="whatsapp://send?phone=591{{$paciente->celular}}" >
                                                        <button class="btn btn-icon btn-2 btn-primary" type="button">
                                                            <span class="btn-inner--icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                    fill="currentColor" class="bi bi-whatsapp"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                                                </svg></span>
                                                        </button>
                                                    </a>
                                                </div>
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

                
@endsection

@push('js')

<script>
    var table = $('#tablaPacientes').DataTable({
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
            },
            "columns": [
                { "orderable": false },
                null,
                null,
                null,
                null
            ]
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
                    doc.content[0].text = 'Pacientes';
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
        pageLength: 10, // Valor inicial del selector de longitud de la página
    });
</script>

@endpush