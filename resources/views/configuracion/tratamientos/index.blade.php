@extends('welcome')

@push('header-js-lista')
@endpush

@section('content')

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Tratamientos</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('tratamiento.create') }}" class="btn btn-sm btn-primary">Nueva
                                Tratamiento</a>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                </div>

                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Precio (Bs.)</th>
                                <th scope="col">Costo (Bs.)</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tratamientos as $tratamiento)
                            <tr>
                                <td>{{$tratamiento->nombre}}</td>
                                <td>{{$tratamiento->precio}}</td>
                                <td>{{$tratamiento->costo}}</td>
                                <td class="text-right">
                                    <div>
                                        <a href="{{ route('tratamiento.edit',$tratamiento->id)}}">
                                            <button class="btn btn-icon btn-2 btn-primary" type="button">
                                                <span class="btn-inner--icon"><i class="fas fa-edit"></i></span>
                                            </button>
                                        </a>

                                        <a>
                                            <button class="btn btn-icon btn-2 btn-primary" type="button"
                                                data-toggle="modal" data-target="#modalEliminar"
                                                data-id="ID_DE_LA_SITUACION"
                                                onclick="modalEliminar('{{$tratamiento -> nombre}}', '{{ route('tratamiento.delete', ['id' => $tratamiento->id]) }}')">
                                                <span class="btn-inner--icon"><i
                                                        class="fas fa-solid fa-trash"></i></span>
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


<!-- Modal -->
<div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Dar de baja Tratamiento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="modalEliminarEnunciado">Enunciado</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <form id="modalEliminarForm" method="POST">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

<script>

    function modalEliminar(nombre, url) {
        $('#modalEliminarForm').attr("action", url);
        $('#modalEliminarEnunciado').html("Realmente desea quitar el tratamiento: " + nombre + "?");
        $('#modalEliminar').modal('show');
    }

</script>

@endpush