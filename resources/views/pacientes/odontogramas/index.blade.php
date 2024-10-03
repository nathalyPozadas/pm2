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
                                <div class="col-1">
                                    <h3 class="mb-0">Odontogramas</h3>
                                </div>
                                <div class="col-1">
                                    <a target="_blank" class="btn btn-secondary btn-sm" id="printButton">Imprimir</a>
                                </div>
                                @can('administrar_odontograma')
                                    @if($paciente->activo)
                                    <div class="col-4 text-right">
                                        <a onClick="modalFechaOdontograma()" class="btn btn-sm btn-primary">Nuevo Odontograma</a>
                                    </div>
                                    @endif
                                @endcan
                            </div>
                        </div>

                        <div class="col-12">
                        </div>

                        <div class="table-responsive px-4">
                            <table id="tablaOdontogramas" class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th > COD </th>
                                        <th scope="col">Fecha creación</th>
                                        <th scope="col-1">Doctor registro</th>
                                        <th scope="col-1">Estado</th>
                                        <th scope="col">Saldo (Bs.)</th>
                                        <th scope="col">Tratamientos</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($odontogramas as  $odontograma)
                                    <tr>
                                        <td><input type="checkbox" class="item-checkbox" value="{{ $odontograma->id }}"></td>
                                        <td>{{$odontograma->id}}</td>
                                        <td>{{\Carbon\Carbon::parse($odontograma->fecha)->format('d-m-Y') }}</td>
                                        <td>{{$odontograma->encargado_nombre.' '.$odontograma->encargado_apellido}}</td>
                                        @if($odontograma->estado=='fase1')
                                        <td><span class="badge-lg  badge-success badge-custom-width">INICIO REVISION</span></td>
                                        @endif
                                        @if($odontograma->estado=='fase2')
                                        <td><span class="badge-lg badge-info badge-custom-width">REVISION FINALIZADA</span></td>
                                        @endif
                                        @if($odontograma->estado=='fase3')
                                        <td><span class="badge-lg  badge-light badge-custom-width">ODONTOGRAMA FINALIZADO</span></td>
                                        @endif
                                        <td>{{$odontograma->deuda}}</td>
                                        <td>{{$odontograma->cantidad_tratamientos}}</td>
                                        <td class="text-right">
                                            <a href="{{ route('odontograma.show',['id'=>$paciente->id,'odontograma_id'=>$odontograma->id]) }}">
                                                <button class="btn btn-icon btn-2 btn-primary" type="button" >
                                                    
                                                    <span class="btn-inner--icon"><i class="fas fa-eye"></i></span>
                                                </button>
                                            </a>
                                            
                                            @can('administrar_odontograma')
                                            @if($paciente->activo == true)
                                            <a href="{{ route('odontograma.edit',['id'=>$paciente->id,'odontograma_id'=>$odontograma->id]) }}">
                                                <button class="btn btn-icon btn-2 btn-primary" type="button" >
                                                    
                                                    <span class="btn-inner--icon"><i class="fas fa-edit"></i></span>
                                                </button>
                                            </a>
                                            @endif
                                            @endcan
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
<div class="modal fade" id="modalFechaRealizada" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  
</div>
@endsection

@push('js')
<script>
  var table = $('#tablaOdontogramas').DataTable({
    searching: false, // Desactivar la función de búsqueda
    ordering: false,  
    pageLength:10,
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
    }
    });

    function modalFechaOdontograma(){
        var contenido = `
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <form method="POST" action=" {{ route('odontograma.create', ['id'=>$paciente->id]) }} ">
                            @csrf
                            @method('post')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="">Nuevo Odontograma</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                

                                    <div class="row">
                                        <div class="col col-6">
                                            <label class="form-control-label" for="input-fecha_toma">{{ __('Fecha realizada') }}</label>
                                            <input type="date" name="fecha" id="input-fecha_toma" class="form-control form-control-alternative " value="{{ now()->format('Y-m-d') }}">
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" onClick="createOdontograma(document.getElementById('input-fecha_toma').value)" class="btn btn-primary">Aceptar</button>
                                </div>
                                </form>
                                </div>
                            </div>`;
        $('#modalFechaRealizada').append(contenido);
        $('#modalFechaRealizada').modal('show');
    }

    $(document).ready(function() {
    // Handle "Select All" checkbox
     // Handle "Select All" checkbox for all pages
     $('#selectAll').click(function() {
        var isChecked = this.checked;
        table.rows().nodes().to$().find('.item-checkbox').prop('checked', isChecked);
    });

    // Handle individual item checkboxes
    $('#tablaOdontogramas').on('change', '.item-checkbox', function() {
        var allChecked = table.rows().nodes().to$().find('.item-checkbox').length === table.rows().nodes().to$().find('.item-checkbox:checked').length;
        $('#selectAll').prop('checked', allChecked);
    });

    $('#printButton').click(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var selectedIds = table.rows().nodes().to$().find('.item-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            alert('Por favor, seleccione al menos un odontograma para imprimir.');
            return;
        }

        // Create a form dynamically
        var form = $('<form>', {
            method: 'POST',
            action: "{{ route('imprimirOdontogramasSeleccionados') }}",
            target: '_blank' // Open the response in a new tab
        });

        // Add CSRF token to the form
        form.append($('<input>', {
            type: 'hidden',
            name: '_token',
            value: csrfToken
        }));

        // Add the selected IDs as hidden inputs to the form
        selectedIds.forEach(function(id) {
            form.append($('<input>', {
                type: 'hidden',
                name: 'ids[]',
                value: id
            }));
        });

        // Append the form to the body, submit it, and then remove it
        form.appendTo('body').submit().remove();
    });
});




   
</script> 
@endpush
