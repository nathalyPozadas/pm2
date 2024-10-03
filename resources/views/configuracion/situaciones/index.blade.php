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
                            <h3 class="mb-0">Diagnósticos</h3>
                        </div>
                        <div class="col-4 text-right">
                        <div class="row">
    <a id="modificarOrdenBtn" class="btn btn-sm btn-primary" href="javascript:void(0)">Modificar Orden</a>
    <a id="guardarOrdenBtn" class="btn btn-sm btn-success" style="display: none;">Guardar Orden</a>
    <a id="nuevaSituacionBtn" href="{{ route('situacion.create') }}" class="btn btn-sm btn-primary">Nuevo
                                        Diagnóstico</a>
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
                            @foreach($situaciones as $situacion)
                            <tr data-id={{ $situacion->id }}>
                                <td>{{$situacion->nombre}}</td>
                                <td>
                                    <img src="data:image/png;base64,{{$situacion->icono}}" alt="Imagen" width="50" height="50" style="background-color: transparent;">
                                </td>
                                <td class="text-right">
                                <div>
                                    <a href="{{ route('situacion.edit',$situacion->id)}}">
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
<script>
    $(document).ready(function() {
    var reordenamientoHabilitado = false;

    function habilitarReordenamiento() {
        reordenamientoHabilitado = true;
        $("#sortable-table tbody").sortable("enable");
        $("#modificarOrdenBtn").hide();
        $("#nuevaSituacionBtn").hide();
        $("#guardarOrdenBtn").show();
    }

    function deshabilitarReordenamiento() {
        reordenamientoHabilitado = false;
        $("#sortable-table tbody").sortable("disable");
        $("#guardarOrdenBtn").hide();
        $("#modificarOrdenBtn").show();
        $("#nuevaSituacionBtn").show();
    }

    // Hacer la tabla ordenable con jQuery UI
    $("#sortable-table tbody").sortable({
        disabled: true,
        update: function(event, ui) {
           
            if (reordenamientoHabilitado) {
                
            }
        }
    });

   
    $("#modificarOrdenBtn").click(function() {
        habilitarReordenamiento();
    });

   
    $("#guardarOrdenBtn").click(function() {
       
        
        var nuevoOrden = [];
        console.log(nuevoOrden);
        
        $("#sortable-table tbody tr").each(function() {
            nuevoOrden.push($(this).data("id"));
        });

        console.log(nuevoOrden);
       
        $.ajax({
            url: '{{ route("situaciones.ordenar") }}', 
            method: 'POST',
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
            data: {
                orden: nuevoOrden 
            },
            success: function(response) {
                deshabilitarReordenamiento(); 
            },
            error: function(xhr, status, error) {
                
                alert(status.toString()); 
            }
        });
        
    });
});

</script>


@endpush