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
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Empaques</h3>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-3">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#registrarEmpaque" onClick="modalRegistrarEmpaque()">
                                Nuevo
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                </div>

                <div class="table-responsive  px-4">
                    <table id="tablaEmpaques" class="table align-items-center table-flush table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Lista de Empaque</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Almacen</th>
                                <th scope="col">Lugar</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($empaques as $empaque)
                                <tr>
                                    <td><span class="badge badge-dot-lg mr-4">
                                    <i class="@if($empaque->estado == 'dañado') bg-danger @elseif($empaque->estado == 'correcto') bg-success @elseif($empaque->estado == 'mermado') bg-warning @endif"></i>
                                        </span>{{$empaque->id}}</td>
                                    <td>{{$empaque->empaque_lista_empaque_codigo}}</td>
                                    <td style="text-transform: uppercase;">{{$empaque->tipo}}</td>
                                    <td>{{ $empaque->descripcion}}</td>
                                    <td>{{$empaque->empaque_almacen_nombre}}</td>
                                    <td>{{$empaque->empaque_ubicacion_nombre}}</td>
                                    <td>
                                        @if($empaque->ubicacion_almacen_id !== null)
                                            <a>
                                                <button class="btn btn-icon btn-2 btn-primary" type="button" onclick="modalEditarEmpaque({{ json_encode($empaque) }})" >
                                                    <span class="btn-inner--icon"><i class="far fa-edit"></i></span>
                                                </button>
                                            </a>

                                            <a>
                                                @if($empaque->tiene_movimientos== false)
                                                    <button class="btn btn-icon btn-2 btn-primary" type="button" onclick="modalEliminarEmpaque({{ json_encode($empaque) }})">
                                                        <span class="btn-inner--icon"><i class="fas fa-times-circle"></i></span>
                                                    </button>
                                                @endif
                                            </a>


                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#moverEmpaque" onClick="modalMoverEmpaque({{$empaque->id}})" >
                                                    <span class="btn-inner--icon"><i class="fas fa-sign-out-alt"></i></span>
                                            </button>
                                        
                                        @endif
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

    <div class="modal fade" id="registrarEmpaque" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    </div>

    <div class="modal fade" id="editarEmpaque" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    </div>

    <div class="modal fade" id="eliminarEmpaque" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    </div>

    <div class="modal fade" id="moverEmpaque" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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





        function modalRegistrarEmpaque(){
            $('#registrarEmpaque').empty();

            var contenidoModal = 
                `<div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Registrar Empaque</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <form id="formRegistrarEmpaque" method="POST" action="{{ route('empaque.store' ) }}">
                                    @csrf
                                    @method('post')
                            <div class="modal-body">
                                    
                                    <input type="text" name="vista" id="vista" value="vista_empaques" class="form-control form-control-alternative d-none" >

                                    <!-- Lista empaques -->
                                    <div class="form-group">
                                        <label for="input-lista_empaques_id" class="form-control-label">Lista de Empaque</label>
                                        <select name="lista_empaques_id" id="input-lista_empaques_id" class="form-control form-control-alternative" required >
                                            <option value="" selected>Seleccione una lista de empaque</option>
                                             @foreach($listas as $lista)
                                                <option value="{{$lista->id}}">{{$lista->codigo}}</option>
                                             @endforeach  
                                        </select>

                                    </div>
                                    <!-- Tipo de empaque -->
                                    <div class="form-group">
                                        <label for="input-tipo" class="form-control-label">Tipo de empaque</label>
                                        <select name="tipo" id="input-tipo" class="form-control form-control-alternative" required onchange="toggleCantidadCajas()">
                                            <option value="" selected>Seleccione un tipo de empaque</option>
                                            <option value="pallet">Pallet</option>
                                            <option value="bolsa">Bolsa</option>
                                            <option value="caja">Caja</option>
                                        </select>

                                    </div>

                                    <!-- Cantidad de Cajas -->
                                    <div id="cantidad_cajas_form_group" class="form-group"  hide>
                                        <label for="input-cantidad_cajas" class="form-control-label">Cantidad de cajas</label>
                                        <input type="number" name="cantidad_cajas" id="input-cantidad_cajas" class="form-control form-control-alternative" placeholder="0" >
                                    </div>

                                    <!-- Peso -->
                                    <div class="form-group">
                                        <label for="input-peso" class="form-control-label">Peso</label>
                                        <input type="number" name="peso" id="input-peso" class="form-control form-control-alternative" placeholder="0" onchange="toggleUnidadMedida()">
                                        <select name="unidad_medida" id="input-unidad_medida" class="form-control form-control-alternative" >
                                            <option value="" selected >Seleccione unidad medida</option>
                                            <option value="kilo">Kg</option>
                                        </select>
                                    </div>

                                    <!-- Descripcion -->
                                    <div class="form-group">
                                        <label for="input-descripcion" class="form-control-label">Descripción</label>
                                        <input type="text" name="descripcion" id="input-descripcion" class="form-control form-control-alternative" placeholder="" >
                                    </div>

                                    <!-- Estado ingreso -->
                                    <div class="form-group">
                                        <label for="input-estado" class="form-control-label">Estado Ingreso</label>
                                        <select name="estado" id="input-estado" class="form-control form-control-alternative" required>
                                            <option value="" selected >Seleccione un estado</option>
                                            <option value="correcto">Correcto</option>
                                            <option value="mermado">Mermado</option>
                                            <option value="dañado">Dañado</option>
                                        </select>
                                    </div>

                                    <!-- Observacion estado -->
                                    <div class="form-group">
                                        <label for="input-observacion_estado" class="form-control-label">Observación</label>
                                        <input type="text" name="observacion_estado" id="input-observacion_estado" class="form-control form-control-alternative" placeholder="" >
                                    </div>
                                
                                    <!-- Criterio 1 -->
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="criterio1" name="criterio1">
                                        <label class="custom-control-label" for="criterio1">Criterio 1</label>
                                    </div>

                                    <!-- Criterio 1 -->
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="criterio2" name="criterio2">
                                        <label class="custom-control-label" for="criterio2">Criterio 2</label>
                                    </div>

                                    <!-- Criterio 3 -->
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="criterio3" name="criterio3">
                                        <label class="custom-control-label" for="criterio3">Criterio 3</label>
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Aceptar</button>
                            </div>
                        </form>
                    </div>
                </div>
                `;

                $('#registrarEmpaque').html(contenidoModal);

                $('#registrarEmpaque').modal('show');
        }
        function toggleUnidadMedida() {
            var peso = document.getElementById("input-peso").value;
            var unidadMedidaInput = document.getElementById("input-unidad_medida");

            if (peso > 0) {
                unidadMedidaInput.setAttribute("required", "required");
            } else {
                unidadMedidaInput.removeAttribute("required");
                unidadMedidaInput.value = ""; 
            }
        }

        function cargarUbicaciones(select) {
            const ubicacionSelect = document.getElementById('input-ubicacion_almacen_id');
            ubicacionSelect.innerHTML = '<option value="" selected>Seleccione un lugar</option>'; // Opción por defecto

            // Obtener las ubicaciones desde el atributo data-ubicaciones
            const ubicaciones = JSON.parse(select.options[select.selectedIndex].getAttribute('data-ubicaciones'));

            ubicaciones.forEach(ubicacion => {
                const option = document.createElement('option');
                option.value = ubicacion.id; // Asegúrate de que la propiedad de id sea correcta
                option.textContent = ubicacion.nombre; // Asegúrate de que la propiedad de nombre sea correcta
                ubicacionSelect.appendChild(option);
            });
        }

        function toggleCantidadCajas() {
            const tipoSelect = document.getElementById('input-tipo');
            const cantidadCajasGroup = document.getElementById('cantidad_cajas_form_group'); // ID nuevo para el div que contiene el input

            if (tipoSelect.value === 'pallet') {
                cantidadCajasGroup.style.display = 'block'; // Mostrar si es "Pallet"
            } else {
                cantidadCajasGroup.style.display = 'none'; // Ocultar en otros casos
                cantidad_cajas = document.getElementById('input-cantidad_cajas');
                cantidad_cajas.value = '';
            }
        }



        function modalEditarEmpaque(empaque) {
            console.log('empaque___',this.empaque);
            $('#editarEmpaque').empty();

            var contenidoModal = 
                `<div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar Empaque</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <form id="formEditarEmpaque" method="POST" action="/empaque/${empaque.id}/update">
                                    @csrf
                                    @method('post')
                            <div class="modal-body">
                                        <input type="text" name="vista" id="vista" value="vista_empaques" class="form-control form-control-alternative d-none" >

                                    <!-- Tipo de empaque -->
                                    <div class="form-group">
                                        <label for="input-tipo" class="form-control-label">Tipo de empaque</label>
                                        <select name="tipo" id="input-tipo" class="form-control form-control-alternative" required onchange="toggleCantidadCajas()">
                                            <option value="pallet" ${empaque.tipo == 'pallet' ? 'selected' : '' }>Pallet</option>
                                            <option value="bolsa" ${empaque.tipo == 'bolsa' ? 'selected' : '' }>Bolsa</option>
                                            <option value="caja" ${empaque.tipo == 'caja' ? 'selected' : '' }>Caja</option>
                                        </select>

                                    </div>

                                    <!-- Cantidad de Cajas -->
                                    <div id="cantidad_cajas_form_group" class="form-group"  "${empaque.tipo != 'pallet' ? 'hide' : '' }" >
                                        <label for="input-cantidad_cajas" class="form-control-label">Cantidad de cajas</label>
                                        <input type="number" name="cantidad_cajas" id="input-cantidad_cajas" class="form-control form-control-alternative" placeholder="0" value=${empaque.cantidad_cajas} >
                                    </div>

                                    <!-- Peso -->
                                    <div class="form-group" "${empaque.tipo == 'pallet' ? 'hide' : '' }">
                                        <label for="input-peso" class="form-control-label">Peso</label>
                                        <input type="number" name="peso" id="input-peso" class="form-control form-control-alternative" placeholder="0" onchange="toggleUnidadMedida()" value=${empaque.peso}>
                                        <select name="unidad_medida" id="input-unidad_medida" class="form-control form-control-alternative" >
                                            <option value="" selected >Seleccione</option>
                                            <option value="kilo" ${empaque.unidad_medida=='kilo'? 'selected': ''}>Kg</option>
                                        </select>
                                    </div>

                                    <!-- Descripcion -->
                                    <div class="form-group">
                                        <label for="input-descripcion" class="form-control-label">Descripción</label>
                                        <input type="text" name="descripcion" id="input-descripcion" class="form-control form-control-alternative" placeholder="" value="${empaque.descripcion?empaque.descripcion : ''}" >
                                    </div>

                                    <!-- Estado ingreso -->
                                    <div class="form-group">
                                        <label for="input-estado" class="form-control-label">Estado Ingreso</label>
                                        <select name="estado" id="input-estado" class="form-control form-control-alternative" required>
                                            <option value="correcto" ${empaque.estado == 'correcto' ? 'selected' : '' } >Correcto</option>
                                            <option value="mermado" ${empaque.estado == 'mermado' ? 'selected' : '' } >Mermado</option>
                                            <option value="dañado" ${empaque.estado == 'dañado' ? 'selected' : '' }>Dañado</option>
                                        </select>
                                    </div>

                                    <!-- Observacion -->
                                    <div class="form-group">
                                        <label for="input-observacion" class="form-control-label">Observación</label>
                                        <input type="text" name="observacion_estado" id="input-observacion" class="form-control form-control-alternative" placeholder="" value=${empaque.observacion_estado ? empaque.observacion_estado: ''}>
                                    </div>
                            
                                    <!-- Criterio 1 -->
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="criterio1" name="criterio1" 
                                            ${empaque.criterio1 ? 'checked' : '' }>
                                        <label class="custom-control-label" for="criterio1">Criterio 1</label>
                                    </div>


                                    <!-- Criterio 2 -->
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="criterio2" name="criterio2"
                                            ${empaque.criterio2 ? 'checked' : '' }>
                                        <label class="custom-control-label" for="criterio2">Criterio 2</label>
                                    </div>

                                    <!-- Criterio 3 -->
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="criterio3" name="criterio3"
                                            ${empaque.criterio3 ? 'checked' : '' } >
                                        <label class="custom-control-label" for="criterio3">Criterio 3</label>
                                    </div>
                                 
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                </div>`;

                // Agregar el contenido generado al modal de edición
                $('#editarEmpaque').html(contenidoModal);

                // Mostrar el modal
                $('#editarEmpaque').modal('show');
        }

        function modalEliminarEmpaque(empaque) {
            $('#eliminarEmpaque').empty();
            var contenidoModal = 
                `<div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Eliminar Empaque</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>¿Está seguro de que desea eliminar el empaque NRO. ${empaque.numero} de la lista de empaque ${empaque.empaque_lista_empaque_codigo}?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <form method="POST" action="/empaque/${empaque.id}/delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>`;
            
            $('#eliminarEmpaque').html(contenidoModal);
            $('#eliminarEmpaque').modal('show');
        }

        function modalMoverEmpaque(empaque_id){
            $('#moverEmpaque').empty();

            var contenidoModal = 
                `<div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Movimiento de Empaque</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <form id="formMovimientoEmpaque" method="POST" action="{{ route('movimiento.store' ) }}">
                                @csrf
                                @method('post')
                            <div class="modal-body">
                                
                                <input type="number" name="empaque_id" id="empaque_id" value=${empaque_id} class="form-control form-control-alternative d-none" required >
                                
                                <!-- Fecha movimiento -->
                                <div class="form-group">
                                    <label for="input-fecha_movimiento" class="form-control-label">Fecha movimiento</label>
                                    <input type="date" name="fecha" id="input-fecha_movimiento" class="form-control form-control-alternative" required>
                                    <span id="error-message-fecha" style="color: red; display: none;">Fecha inválida. Asegúrate de ingresar una fecha correcta.</span>
                                </div>

                                <!-- Hora -->
                                <div class="form-group">
                                    <label for="input-hora" class="form-control-label">Hora</label>
                                    <input type="time" name="hora" value="" id="input-hora" class="form-control form-control-alternative" required>
                                    <span id="error-message-hora" style="color: red; display: none;">Hora inválida. Asegúrate de ingresar una hora correcta.</span>
                                </div>


                                <!-- Tipo de movimiento [ingreso/salida , egreso] -->
                                <div class="form-group">
                                    <label for="input-tipo_movimiento" class="form-control-label">Movimiento</label>
                                    <select name="tipo_movimiento" id="input-tipo_movimiento" class="form-control form-control-alternative" required>
                                        <option value="" selected >Seleccionar</option>
                                        <option value="interno">Ingreso/Salida</option>
                                        <option value="externo">Externo</option>
                                    </select>
                                </div>

                                <!-- Seccion habilitada cuando movimiento es tipo ingreso/salida -->
                                <div id="section_mov_interno" style="display:none;">
                                    <!-- Almacen -->
                                    <div class="form-group">
                                        <label for="input-almacen_id" class="form-control-label">Almacen</label>
                                        <select name="almacen_id" id="input-almacen_id" class="form-control form-control-alternative" onchange="cargarUbicaciones(this)">
                                            <option value="" selected >Seleccione un almacen</option>
                                            @foreach($almacenes as $almacen)
                                                <option value="{{$almacen->id}}" data-ubicaciones='@json($almacen->ubicaciones)'>{{$almacen->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Lugar -->
                                    <div class="form-group">
                                        <label for="input-ubicacion_almacen_id" class="form-control-label">Lugar</label>
                                        <select name="ubicacion_almacen_id" id="input-ubicacion_almacen_id" class="form-control form-control-alternative" >
                                        </select>
                                    </div>
                                </div>

                                <!-- Seccion habilitada cuando movimiento es tipo egreso -->
                                <div id="section_mov_externo" style="display:none;">
                                    <!-- Nota -->
                                    <div class="form-group">
                                        <label for="input-nota" class="form-control-label">Nota</label>
                                        <input type="text" name="nota" id="input-nota" class="form-control form-control-alternative" placeholder="">
                                    </div>

                                    <!-- Cliente -->
                                    <div class="form-group">
                                        <label for="input-cliente" class="form-control-label">Cliente</label>
                                        <input type="text" name="cliente" id="input-cliente" class="form-control form-control-alternative" placeholder="">
                                    </div>

                                    <!-- Destino -->
                                    <div class="form-group">
                                        <label for="input-destino" class="form-control-label">Destino</label>
                                        <select name="destino" id="input-destino" class="form-control form-control-alternative" >
                                                <option value="" selected >Seleccione un destino</option>
                                                <option value="Centro Distribución Montecristo">Centro Distribución Montecristo</option>
                                                <option value="Tienda Ñuflo de Chavez">Tienda Ñuflo de Chavez</option>
                                                <option value="Tienda Cristobal de Mendoza">Tienda Cristobal de Mendoza</option>
                                                <option value="Tienda Grigota">Tienda Grigota</option>
                                                <option value="Tienda Mutualista">Tienda Mutualista</option>
                                                <option value="Venta Directa">Venta Directa</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Aceptar</button>
                            </div>
                        </form>
                    </div>
                </div>`;

            $('#moverEmpaque').html(contenidoModal);

            $('#moverEmpaque').modal('show');

    const inputFechaMovimiento = document.getElementById('input-fecha_movimiento');
    const errorMessageFecha = document.getElementById('error-message-fecha');
    const inputHora = document.getElementById('input-hora');
    const errorMessageHora = document.getElementById('error-message-hora');
    const form = document.getElementById('formMovimientoEmpaque');
    let isValidFechaMovimiento = false;  
    let isValidHoraMovimiento = false;  

    // Función para validar la fecha
    function validarFecha(fechaInput) {
        const fecha = new Date(fechaInput);
        const anio = fecha.getFullYear();
        
        if (anio >= 1900 && anio <= 2099 && !isNaN(fecha.getTime())) {
            return true;
        }
        return false;
    }

    // Función para validar la hora
    function validarHora(horaInput) {
        const hora = horaInput.split(':');
        const horas = parseInt(hora[0]);
        const minutos = parseInt(hora[1]);
        return (horas >= 0 && horas < 24) && (minutos >= 0 && minutos < 60);
    }

    // Validar Fecha Movimiento
    inputFechaMovimiento.addEventListener('input', function() {
        const fechaIngresada = this.value;

        if (validarFecha(fechaIngresada)) {
            errorMessageFecha.style.display = 'none';
            isValidFechaMovimiento = true;
        } else {
            errorMessageFecha.style.display = 'block';
            isValidFechaMovimiento = false;
        }
    });

    inputHora.addEventListener('input', function() {
        const horaIngresada = this.value;

        if (validarHora(horaIngresada)) {
            errorMessageHora.style.display = 'none';
            isValidHoraMovimiento = true;
        } else {
            errorMessageHora.style.display = 'block';
            isValidHoraMovimiento = false;
        }
    });

    form.addEventListener('submit', function(event) {
        if (!isValidFechaMovimiento || !isValidHoraMovimiento) {
            event.preventDefault();
        }
    });





            $('#input-tipo_movimiento').change(function () {
                var tipoMovimiento = $(this).val();

                if (tipoMovimiento === 'interno') {
                    $('#input-almacen_id').val('');
                    $('#input-ubicacion_almacen_id').val('');   

                    $('#input-almacen_id').prop('required', true);
                    $('#input-ubicacion_almacen_id').prop('required', true);

                    $('#input-nota').prop('required', false);
                    $('#input-cliente').prop('required', false);
                    $('#input-destino').prop('required', false);

                    $('#section_mov_interno').show();
                    $('#section_mov_externo').hide();
                } else if (tipoMovimiento === 'externo') {
                    $('#input-nota').val('');
                    $('#input-cliente').val('');
                    $('#input-destino').val('');

                    $('#input-almacen_id').prop('required', false);
                    $('#input-ubicacion_almacen_id').prop('required', false);

                    $('#input-nota').prop('required', true);
                    $('#input-cliente').prop('required', true);
                    $('#input-destino').prop('required', true);

                    $('#section_mov_interno').hide();
                    $('#section_mov_externo').show();
                } else {
                    $('#section_mov_interno').hide();
                    $('#section_mov_externo').hide();
                }
            });
        }


        
    </script>

@endpush