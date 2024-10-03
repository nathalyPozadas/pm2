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
                                    <h3 class="mb-0">Historias</h3>
                                </div>
                                @if($paciente->activo)
                                    @can('administrar_historia_clinica')
                                        <div class="col-4 text-right">
                                            <a href="{{ route('historia.create',['id'=>$paciente->id]) }}" class="btn btn-sm btn-primary">Nueva
                                                Historia</a>
                                        
                                        </div>
                                    @endcan
                                @endif
                            </div>
                        </div>

                        <div class="col-12">
                        </div>

                        <div class="table-responsive px-4">
                            <table id="tablaHistorias" class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="col-1" >COD</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($historias as $historia)
                                    <tr>
                                        <td>{{$historia->id}}</td>
                                        <td>{{\Carbon\Carbon::parse($historia->fecha)->format('d-m-Y') }}</td>
                                        <td class="text-right">
                                    <div>
                                        <a href=" {{ route('historias.show',['paciente_id'=>$historia->paciente_id,'historia_id'=>$historia->id]) }} ">
                                            <button class="btn btn-icon btn-2 btn-primary" type="button">

                                                <span class="btn-inner--icon"><i class="fas fa-eye"></i></span>
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
         @endsection

        
         @push('js')
<script>
  var table = $('#tablaHistorias').DataTable({
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

</script>
@endpush