@extends('welcome')

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
                            <h3 class="mb-0">Formato Historia clínica</h3>
                        </div>
                        <div class="col-4 text-right">
                            <div class="row">
                                <a id="modificarOrdenBtn" class="btn btn-sm btn-primary"
                                    href="javascript:void(0)">Modificar Orden</a>

                                <a id="guardarOrdenBtn" class="btn btn-sm btn-success" style="display: none;"
                                    href="javascript:void(0)">Guardar Orden</a>
                                <a id="nuevaPreguntaBtn" href="{{ route('pregunta.create') }}"
                                    class="btn btn-sm btn-primary">Nuevo pregunta</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                </div>

                <div class="table-responsive px-4">
                    <table id="sortable-table" class="table align-items-center table-flush ">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Tipo</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($preguntas as $pregunta)
                            <tr data-id={{ $pregunta->id }}>
                                <td>{{$pregunta->enunciado}}</td>
                                <td>
                                    @if($pregunta->tipo_check)
                                    Check
                                    @else
                                    @if($pregunta->obligatorio)
                                    Información(obligatorio)
                                    @else
                                    Información
                                    @endif
                                    @endif
                                </td>
                                <td class="text-right">
                                    <div>
                                        
                                        <a>
    <button class="btn btn-icon btn-2 btn-primary" type="button" data-toggle="modal" data-target="#modalEliminar" data-id="ID_DE_LA_SITUACION" onclick="modalEliminar('{{$pregunta -> enunciado}}', '{{ route('pregunta.delete', ['id' => $pregunta->id]) }}')">
        <span class="btn-inner--icon"><i class="fas fa-solid fa-trash"></i></span>
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
<div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Quitar pregunta de Historia clínica</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <p id="modalEliminarEnunciado">Enunciado</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <form id="modalEliminarForm"  method="POST" >
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
     function modalEliminar(enunciado, url) {
                $('#modalEliminarForm').attr("action", url);
                $('#modalEliminarEnunciado').html("Desea que la consulta: <br> - " + enunciado + " <br>ya no sea tomada en cuenta en la toma de historia clínica?");
                $('#modalEliminar').modal('show');
            }


    $(document).ready(function () {
        var reordenamientoHabilitado = false;

        function habilitarReordenamiento() {
            reordenamientoHabilitado = true;
            $("#sortable-table tbody").sortable("enable");
            $("#modificarOrdenBtn").hide();
            $("#nuevaPreguntaBtn").hide();
            $("#guardarOrdenBtn").show();
        }

        function deshabilitarReordenamiento() {
            reordenamientoHabilitado = false;
            $("#sortable-table tbody").sortable("disable");
            $("#guardarOrdenBtn").hide();
            $("#modificarOrdenBtn").show();
            $("#nuevaPreguntaBtn").show();
        }

        $("#sortable-table tbody").sortable({
            disabled: true,
            update: function (event, ui) {
                if (reordenamientoHabilitado) {
                }
            }
        });

        $("#modificarOrdenBtn").click(function () {
            habilitarReordenamiento();
        });

        $("#guardarOrdenBtn").click(function () {

            var nuevoOrden = [];
            console.log(nuevoOrden);
            $("#sortable-table tbody tr").each(function () {
                nuevoOrden.push($(this).data("id"));
            });

            console.log(nuevoOrden);
            $.ajax({
                url: '{{ route("preguntas.ordenar") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    orden: nuevoOrden
                },
                success: function (response) {
                    deshabilitarReordenamiento();
                },
                error: function (xhr, status, error) {

                    alert(status.toString());
                }
            });

        });
    });

</script>


@endpush