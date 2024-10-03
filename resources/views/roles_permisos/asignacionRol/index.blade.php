@extends('welcome')

@push('header-js-lista')
   <link href="{{ asset('dataTables') }}/datatables.min.css" rel="stylesheet">
   <script src="{{ asset('dataTables') }}/datatables.min.js"></script>
@endpush

@push('header-js-lista')
<script src="{{ asset('argon')}}/vendor/jquery-ui/jquery-ui.js"></script>


@endpush

@section('content')
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Asignación de roles</h3>
                        </div>
                        
                    </div>
                </div>

                <div class="col-12">
                </div>

                <div class="table-responsive px-4">
                    <table id="tabla_empleado_rol" class="table align-items-center table-flush " >
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Cargo</th>
                                <th scope="col">Rol</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($empleados as $empleado)
                            <tr >
                                <td>{{$empleado->apellidos.' '.$empleado->nombres}}</td>
                                <td>{{$empleado->tipo}}</td>
                                <td>{{$empleado->rol}}</td>
                                <td class="text-right">
                                                <div>
                                                    <a href="{{route( 'asignacion_rol.edit',['id'=>$empleado->id] )}}">
                                                        <button class="btn btn-icon btn-2 btn-primary" type="button" >
                                                            
                                                            <span class="btn-inner--icon"><i class="fas fa-edit"></i></span>
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

</div>
<br>

@endsection


@push('js')

<script>
    var table = $('#tabla_empleado_rol').DataTable({
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
                    doc.content[0].text = 'Empleados-Roles';
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