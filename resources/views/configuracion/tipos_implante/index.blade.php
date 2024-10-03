@extends('welcome')

@push('header-js-lista')
   
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
                            <h3 class="mb-0">Tipo de Implante</h3>
                        </div>
                        <div class="col-4 text-right">
                        <div class="row">
    <a id="nuevaSituacionBtn" href="{{ route('tipoImplante.create') }}" class="btn btn-sm btn-primary">Nuevo Tipo de Implante</a>
</div>
</div>
                    </div>
                </div>

                <div class="col-12">
                </div>

                <div class="table-responsive">
                    <table id="sortable-table" class="table align-items-center table-flush " >
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Icono</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tiposImplante as $implante)
                            <tr data-id={{ $implante->id }}>
                                <td>{{$implante->nombre}}</td>
                                <td>
                                    <img src="data:image/png;base64,{{$implante->icono}}" alt="Imagen" width="50" height="50" style="background-color: transparent;">
                                </td>
                                <td class="text-right">
                                <div>
                                    <a href="{{ route('tipoImplante.edit',$implante->id)}}">
                    <button class="btn btn-icon btn-2 btn-primary" type="button">
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

@endpush