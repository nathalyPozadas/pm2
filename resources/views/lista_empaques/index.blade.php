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
                        <div class="col-8 ">
                            <h3 class="mb-0">Lista de empaques</h3>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-3">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#registrarPackingList" onClick="modalRegistrarPackingList()">
                                Nuevo
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                </div>

                <div class="table-responsive  px-4">
                    <table id="tablaListaEmpaques" class="table align-items-center table-flush table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Código de Lista</th>
                                <th scope="col">Proveedor</th>
                                <th scope="col">Stock Llegada</th>
                                <th scope="col">Stock Registrado</th>
                                <th scope="col">Stock Actual</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listas as $lista)
                                <tr>
                                    <td>{{$lista->id}}</td>
                                    <td>{{$lista->codigo}}</td>
                                    <td>{{$lista->proveedor_nombre}}</td>
                                    <td>{{$lista->stock_esperado}}</td>
                                    <td>{{$lista->stock_registrado}}</td>
                                    <td>{{$lista->stock_actual}}</td>
                                    <td>
                                        <a>
                                            <button class="btn btn-icon btn-2 btn-primary" type="button" onclick="modalEditarPackingList(this)" data-lista="{{ json_encode($lista) }}">
                                                <span class="btn-inner--icon"><i class="far fa-edit"></i></span>
                                            </button>
                                        </a>
                                        @if(!$lista->tiene_movimientos)
                                            <a>
                                                <button class="btn btn-icon btn-2 btn-primary" type="button" onclick="modalEliminarPackingList(this)" data-codigo="{{ json_encode($lista) }}">
                                                    <span class="btn-inner--icon"><i class="fas fa-times-circle"></i></span>
                                                </button>
                                            </a>
                                        @endif
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#registrarEmpaque" onClick="modalRegistrarEmpaque({{$lista->id}})">
                    
                                            <span class="btn-inner--icon"><i class="far fa-list-alt"></i></span>
                                        </button>
                                        <a href="{{ route( 'lista_empaques.show',['id'=>$lista->id ]) }}">
                                            <button class="btn btn-icon btn-2 btn-primary" type="button" >
                                                <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
                                            </button>
                                        </a>
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

    <div class="modal fade" id="registrarPackingList" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    </div>

    <div class="modal fade" id="editarPackingList" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    </div>

    <div class="modal fade" id="eliminarPackingList" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    </div>

    <div class="modal fade" id="registrarEmpaque" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    </div>
@endsection

@push('js')

    <script>
        var table = $('#tablaListaEmpaques').DataTable({
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









        function modalRegistrarPackingList(){
            $('#registrarPackingList').empty();

            var contenidoModal = 
                `<div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Registrar Lista de empaques</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <form id="formRegistrarListaEmpaque" method="POST" action="{{ route('lista_empaques.store') }}">
                                    @csrf
                                    @method('post')
                            <div class="modal-body">
                                
                                    <!-- Codigo Lista de Empaque -->
                                    <div class="form-group">
                                        <label for="input-lista-empaque" class="form-control-label">Lista de empaque</label>
                                        <input type="text" name="codigo" id="input-lista-empaque" class="form-control form-control-alternative" placeholder="0" required>
                                    </div>

                                    <!-- OC/Factura -->
                                    <div class="form-group">
                                        <label for="input-factura" class="form-control-label">OC/Factura</label>
                                        <input type="text" name="factura" id="input-factura" class="form-control form-control-alternative" placeholder="0" required>
                                    </div>

                                    <!-- Transporte -->
                                    <div class="form-group">
                                        <label for="input-transporte" class="form-control-label">Transporte</label>
                                        <input type="text" name="transporte" id="input-transporte" class="form-control form-control-alternative" placeholder="">
                                    </div>

                                    <!-- Aduana - Canal de ingreso -->
                                    <div class="form-group">
                                        <label for="input-transporte" class="form-control-label">Aduana - Canal de ingreso</label>
                                        <div class="row pl-2">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadioInline1" name="canal_aduana" value="verde" class="custom-control-input" required>
                                                <label class="custom-control-label" for="customRadioInline1">Canal Verde</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadioInline2" name="canal_aduana" value="rojo" class="custom-control-input" required>
                                                <label class="custom-control-label" for="customRadioInline2">Canal Rojo</label>
                                            </div>
                                            <div class="invalid-feedback">Por favor, selecciona un canal.</div>
                                        </div>   
                                    </div>

                                    <!-- ProveedorId -->
                                    <div class="form-group">
                                        <label for="input-proveedor" class="form-control-label">Proveedor</label>
                                        <select name="proveedor_id" id="input-proveedor" class="form-control form-control-alternative" required>
                                            <option value="">Seleccione un proveedor</option>
                                            @foreach($proveedores as $proveedor)
                                                <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                            @endforeach
                                            <!-- Añade más proveedores si es necesario -->
                                        </select>
                                    </div>

                                    <!-- Fecha recepción -->
                                    <div class="form-group">
                                        <label for="input-fecha-recepcion" class="form-control-label">Fecha recepción</label>
                                        <input type="date" name="fecha_recepcion" id="input-fecha-recepcion" class="form-control form-control-alternative" required>
                                    </div>

                                    <!-- Fecha llegada -->
                                    <div class="form-group">
                                        <label for="input-fecha_llegada" class="form-control-label">Fecha Llegada</label>
                                        <input type="date" name="fecha_llegada" id="input-fecha_llegada" class="form-control form-control-alternative" required>
                                    </div>

                                    <!-- Stock de empaques que se espera -->
                                    <div class="form-group">
                                        <label for="input-stock-llegada" class="form-control-label">Stock empaques esperados</label>
                                        <input type="number" name="stock_esperado" id="input-stock-llegada" class="form-control form-control-alternative" placeholder="0" required>
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

                $('#registrarPackingList').html(contenidoModal);

                $('#registrarPackingList').modal('show');
        }

        function modalEditarPackingList(elemento) {
            
            $('#editarPackingList').empty();

            var lista = $(elemento).data('lista');
            console.log('itemID::::', lista.canal_aduana);
            var contenidoModal = 
                `<div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar Lista de empaques</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <form id="formEditarListaEmpaque" method="POST" action="/lista_empaques/${lista.id}/update">
                                @csrf
                                @method('POST')
                                <div class="modal-body">
                                
                                    <input type="text" name="codigo" id="input-lista-empaque" class="form-control form-control-alternative" value="${lista.codigo}" required hidden>
                          

                                    <!-- OC/Factura -->
                                    <div class="form-group">
                                        <label for="input-factura" class="form-control-label">OC/Factura</label>
                                        <input type="text" name="factura" id="input-factura" class="form-control form-control-alternative" value="${lista.factura}" required>
                                    </div>

                                    <!-- Transporte -->
                                    <div class="form-group">
                                        <label for="input-transporte" class="form-control-label">Transporte</label>
                                        <input type="text" name="transporte" id="input-transporte" class="form-control form-control-alternative" value="${lista.transporte?? '' }" placeholder="">
                                    </div>

                                    <!-- Aduana - Canal de ingreso -->
                                    <div class="form-group">
                                        <label for="input-transporte" class="form-control-label">Aduana - Canal de ingreso</label>
                                        <div class="row pl-2">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="canalVerde" name="canal_aduana" value="verde" class="custom-control-input" ${lista.canal_aduana == "verde" ? 'checked' : '' }>
                                                <label class="custom-control-label" for="canalVerde">Canal Verde</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="canalRojo" name="canal_aduana" value="rojo" class="custom-control-input"  ${lista.canal_aduana == "rojo" ? "checked" : '' }>
                                                <label class="custom-control-label" for="canalRojo">Canal Rojo</label>
                                            </div>
                                            <div class="invalid-feedback">Por favor, selecciona un canal.</div>
                                        </div>
                                    </div>



                                    <!-- Proveedor -->
                                    <div class="form-group">
                                        <label for="input-proveedor" class="form-control-label">Proveedor</label>
                                        <select name="proveedor_id" id="input-proveedor" class="form-control form-control-alternative" required>
                                            <option value="">Seleccione un proveedor</option>
                                            @foreach($proveedores as $proveedor)
                                                <option value="{{ $proveedor->id }}" ${lista.proveedor_id == {{ $proveedor->id }} ? 'selected' : ''}>{{ $proveedor->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Fecha recepción -->
                                    <div class="form-group">
                                        <label for="input-fecha-recepcion" class="form-control-label">Fecha recepción</label>
                                        <input type="date" name="fecha_recepcion" id="input-fecha-recepcion" class="form-control form-control-alternative" value="${lista.fecha_recepcion}" required>
                                    </div>

                                    <!-- Fecha llegada -->
                                    <div class="form-group">
                                        <label for="input-fecha_llegada" class="form-control-label">Fecha llegada</label>
                                        <input type="date" name="fecha_llegada" id="input-fecha_llegada" class="form-control form-control-alternative" value="${lista.fecha_recepcion}" required>
                                    </div>

                                    <!-- Stock empaques llegada -->
                                    <div class="form-group">
                                        <label for="input-stock-llegada" class="form-control-label">Stock empaques esperados</label>
                                        <input type="number" name="stock_esperado" id="input-stock-llegada" class="form-control form-control-alternative" value="${lista.stock_esperado}" required>
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
                $('#editarPackingList').html(contenidoModal);

                // Mostrar el modal
                $('#editarPackingList').modal('show');
        }

        function modalEliminarPackingList(elemento) {
            $('#eliminarPackingList').empty();

            var lista = $(elemento).data('codigo');

            var contenidoModal = 
                `<div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Eliminar Lista de Empaques</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>¿Está seguro de que desea eliminar la lista de empaques con código ${lista.codigo}? <br> Esta lista cuenta con ${lista.stock_registrado} empaques registrados, estos tambien serán eliminados.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <form method="POST" action="/lista_empaques/${lista.id}/delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>`;

            $('#eliminarPackingList').html(contenidoModal);
            $('#eliminarPackingList').modal('show');
        }


        function modalRegistrarEmpaque(lista_empaques_id){
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
                                    
                                    <!-- Lista empaques ID -->
                                     <input type="number" name="lista_empaques_id" value=${lista_empaques_id} id="input-lista_empaques_id" class="form-control form-control-alternative d-none">
                                    
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
                                    <div class="form-group ">
                                        <label for="input-peso" class="form-control-label">Peso</label>
                                        <div class="row">
                                            <input type="number" name="peso" id="input-peso" class="form-control form-control-alternative col-3" placeholder="0" onchange="toggleUnidadMedida()">
                                            <select name="unidad_medida" id="input-unidad_medida" class="form-control form-control-alternative col-3" >
                                                <option value="" selected >Seleccione</option>
                                                <option value="kilo">Kg</option>
                                            </select>
                                        </div>    
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

                                    <!-- Observacion -->
                                    <div class="form-group">
                                        <label for="input-observacion" class="form-control-label">Observación</label>
                                        <input type="text" name="observacion" id="input-observacion" class="form-control form-control-alternative" placeholder="" >
                                    </div>
                            
                                    <!-- Almacen -->
                                    <div class="form-group">
                                        <label for="input-almacen_id" class="form-control-label">Almacen</label>
                                        <select name="almacen_id" id="input-almacen_id" class="form-control form-control-alternative" required onchange="cargarUbicaciones(this)">
                                            <option value="" selected >Seleccione un almacen</option>
                                            @foreach($almacenes as $almacen)
                                                <option value="{{$almacen->id}}" data-ubicaciones='@json($almacen->ubicaciones)'>{{$almacen->nombre}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <!-- Lugar -->
                                    <div class="form-group">
                                        <label for="input-ubicacion_almacen_id" class="form-control-label">Lugar</label>
                                        <select name="ubicacion_almacen_id" id="input-ubicacion_almacen_id" class="form-control form-control-alternative" required>
                                        </select>
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
                                        <label class="custom-control-label" for="criterio3">Criterio 2</label>
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
            }
        }
    </script>

@endpush