@extends('welcome')
@push('header-js-lista')
<link rel="stylesheet" href="{{ asset('assets') }}/vendor/dropzone/dist/min/dropzone.min.css">
   <script src="{{ asset('assets') }}/vendor/dropzone/dist/min/dropzone.min.js"></script>
   <style>
    	.dropzoneDragArea {
		    background-color: #fbfdff;
		    border: 1px dashed #c0ccda;
		    border-radius: 6px;
		    padding: 60px;
		    text-align: center;
		    margin-bottom: 15px;
		    cursor: pointer;
		}


    </style>

    <style>
       .implant-container {
        width: 100%;
        height: 100px; /* Ajusta esta altura según tus necesidades */
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .implant-image {
        max-width: 100%;
        max-height: 100%;
        cursor: pointer;
      }

      .implant-image.selected {
        border: 2px solid blue;
      }
    </style>
@endpush
@section('content')

@include('users.partials.headerPaciente')
<div class="container-fluid mt--7">
  <div class="row">
    <div class="col-xl-12 order-xl-1">
      <div class="card bg-secondary shadow">
        <div class="card-header bg-white border-0">
          <div id="div_header"class="row align-items-center">
            <div>
              <h3 class="col mb-0">{{ __('Implantes') }}
              </h3>
            </div>
            <div class="col-1">
              <a class="btn btn-secondary btn-sm" href="{{ route('implantesPDF', ['paciente_id'=>$paciente->id]) }}" target="_blank" >Imprimir</a>
            </div>
            <div class="col-4">
            </div>
            
          </div>
          
          
        </div>
        <div class="col-12"> </div>
        <div class="card-body bg-white">

          <input type="hidden" name="paciente_id" value=""> 

          <div class="pl-lg-12">
            <div class="row">
          <div class="col-lg-9 mb-5 mt-2">
            <div class=" justify-content-center align-items-center">
              
              <div class="row container-odontograma justify-content-center">
                @php
                $start = 18;
                $end = 11;
                @endphp

                @for ($i = $start; $i >= $end; $i--)
                <div class="item-odontograma item-odontograma-hover" type="button" data-toggle="modal" 
                  onclick="modalAgregarSituacion('{{$i}}')">{{$i}}
                  <img id="pieza-{{$i}}" src="{{ asset('argon')}}/img/iconos-implantes/{{$i}}A.png" style="  height: 60%;
                  width: 100%;">
                </div>
                @endfor

                @php
                $start = 21;
                $end = 28;
                @endphp

                @for ($i = $start; $i <= $end; $i++) 
                <div class=" item-odontograma item-odontograma-hover" type="button" data-toggle="modal"
                  onclick="modalAgregarSituacion('{{$i}}')">{{$i}}
                  <img id="pieza-{{$i}}" src="{{ asset('argon')}}/img/iconos-implantes/{{$i}}A.png" style="  height: 60%;
                  width: 100%;">
              </div>
              @endfor
            </div>
         
            <div class="row container-odontograma justify-content-center">
            @php
            $start = 48;
            $end = 41;
            @endphp

            @for ($i = $start; $i >= $end; $i--)
            <div class=" item-odontograma item-odontograma-hover" type="button" data-toggle="modal" 
                onclick="modalAgregarSituacion('{{$i}}')">
                <img id="pieza-{{$i}}" src="{{ asset('argon')}}/img/iconos-implantes/{{$i}}A.png" style="  height: 60%;
                    width: 100%;">{{$i}}
            </div>
            @endfor
            @php
            $start = 31;
            $end = 38;
            @endphp

            @for ($i = $start; $i <= $end; $i++) 
            <div class="item-odontograma item-odontograma-hover" type="button" data-toggle="modal"
                onclick="modalAgregarSituacion('{{$i}}')">
                <img id="pieza-{{$i}}" src="{{ asset('argon')}}/img/iconos-implantes/{{$i}}A.png" style="  height: 60%;
                    width: 100%;">{{$i}}
            </div>
            @endfor
        </div>
      
</div>
</div>
        <div class="col-lg-3">
              <div class="card card-stats mb-1 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h2 class="card-title text-uppercase text-muted mb-0">Pagos</h2>
                      <span id="presupuesto_total" class="h2 font-weight-bold mb-0"></span>
                    </div>
                  
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <h2 id="pago_realizado_implantes" >A Cuenta: 0</h2>
                    <h2 id="pago_pendiente_implantes"  >Saldo: 0</h2>
                  </p>
                </div>
              </div>
        </div>
     
  </div>
  <div class="row">
  
    <div class="table-responsive">
        <table id="tablaImplantes" class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Pieza</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Medida</th>
                    <th scope="col">Costo</th>
                    <th scope="col">A cuenta</th>
                    <th scope="col">Saldo</th>
                    <th scope="col">Pagos</th>
                    <th scope="col">Acciones</th>
                    <th scope="col">Estado</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
  </div>
  <h6 class="heading-small text-muted mb-4">{{ __('Implantes Finalizados') }}</h6>
  <div class="row">
    <div class="table-responsive">
        <table id="tablaImplantesFinalizados" class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Pieza</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Medida</th>
                    <th scope="col">Costo</th>
                    <th scope="col">Pagos</th>
                    <th scope="col">Acciones</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
  </div>

</div>
</div>
</div>
</div>


</div>
<br>

<!-- Modal Agregar Situacion -->
<div class="modal fade" id="modalAgregarSituacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="modalEliminarEnunciado"></p>
        <input name="pieza" id="input-piezaDental" hidden>

        <input type="hidden" name="implante_id" id="implante_id" value="">

        <div class="form-group">
            <label class="form-control-label" for="input-fecha_realizacion_implante">{{ __('Fecha') }}</label>
            <input type="date" name="fecha" id="input-fecha_realizacion_implante" class="form-control form-control-alternative " value="{{ now()->format('Y-m-d') }}">
                                      
          @if ($errors->has('fecha'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('fecha') }}</strong>
          </span>
          @endif
        </div>

        <!-- Nueva sección para mostrar las imágenes -->
        <div class="form-group">
          <div class="image-selection mb-4">
            <label class="form-control-label" for="input-marca">{{ __('Tipo de Implante') }}</label>
            <div class="row">
              <?php foreach ($implantes as $implante): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                  <div class="implant-container">
                    <img src="data:image/png;base64,{{$implante->icono}}" class="img-thumbnail implant-image" alt="Implante" data-id="<?php echo $implante['id']; ?>" onclick="seleccionarImplante(this)">
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="form-control-label" for="input-marca">{{ __('Marca') }}</label>
          <input type="text" name="marca" id="input-marca"
              class="form-control form-control-alternative {{ $errors->has('marca') ? ' is-invalid' : '' }}"
              placeholder="{{ __('Marca') }}"
               autofocus>
          @if ($errors->has('marca'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('marca') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group">
          <label class="form-control-label" for="input-medida">{{ __('Medida') }}</label>
          <input type="text" name="medida" id="input-medida"
              class="form-control form-control-alternative {{ $errors->has('medida') ? ' is-invalid' : '' }}"
              placeholder="{{ __('Medida') }}"
               autofocus>
          @if ($errors->has('medida'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('medida') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group">
          <label class="form-control-label" for="input-costo">{{ __('Costo') }}</label>
          <input type="text" name="costo" id="input-costo"
              class="form-control form-control-alternative {{ $errors->has('costo') ? ' is-invalid' : '' }}"
              placeholder="{{ __('0') }}"
               autofocus>
          @if ($errors->has('costo'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('costo') }}</strong>
          </span>
          @endif
        </div>

        


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Aceptar</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Agregar Accion-->
<div id="modalAgregarAccionImplante" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby=""
  aria-hidden="true" data-target=".bd-example-modal-lg">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_agregar_accion_titulo"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="center">
        <a id="btnMarcarFinalizado"  class="btn  btn-primary center mb-4 " style="transform: none !important;" href="javascript:void(0)" >Marcar Tratamiento como FINALIZADO</a>
        </div>
        <div class="table-responsive">
      <table id="tablaAcciones" class="table align-items-center table-flush">
        <thead class="thead-light col-lg-12">
          <tr>
            <th scope="col" class="col-lg-1">Fecha</th>
            <th scope="col" class="col-lg-10">Accion</th>
            <th scope="col" class="col-lg-1"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
          </tr>
        </tbody>
      </table>
    </div>


      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalModificarPrecio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  
</div>

<div class="modal fade" id="modalPagosImplante" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  
</div>

<div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  
</div>

<div class="modal fade" id="modalBajaAccionImplante" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  
</div>
<div class="modal fade" id="modalBajaPagoImplante" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  
</div>


<!-- Modal Eliminar -->
<div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby=""
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id=""></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id=""></p>
        <input name="odontograma" value="" hidden>
        <input name="paciente_id" value="" hidden>
        <input name="pieza" id="input-piezaDental" hidden>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Aceptar</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('js')

<script>

$(document).ready(function() {
    redibujarTabla();
});

  function modalAgregarSituacion(nombre) {
    $('#input-piezaDental').val(nombre);
    $('#modalAgregarSituacion').modal('show');
  }

  $(document).ready(function () {
    $('#modalAgregarSituacion').modal('hide');

   
    
  });

  $('#modalAgregarSituacion .btn-primary').on('click', function () {
    
  });

  function seleccionarImplante(img) {

    const images = document.querySelectorAll('.implant-image');
    images.forEach(image => image.classList.remove('selected'));
    img.classList.add('selected');


    const implanteId = img.getAttribute('data-id');
    

    document.getElementById('implante_id').value = implanteId;
  }

  $('#modalAgregarSituacion .btn-primary').on('click', function () {
    var token = $('meta[name="csrf-token"]').attr('content');

    var paciente_id = {{$paciente->id}};
    var fecha = $('#input-fecha_realizacion_implante').val();
    var pieza = $('input[name="pieza"]').val();
    var marca = $('#input-marca').val();
    var medida = $('#input-medida').val();
    var costo = $('#input-costo').val();
    var implante_id = $('#implante_id').val(); 
    var datos = {
        fecha: fecha,
        paciente_id: paciente_id,
        pieza: pieza,
        marca: marca,
        medida: medida,
        costo: costo,
        implante_id: implante_id, 
        _token: token
    };

    $.ajax({
        url: "{{ route('implantes.store') }}",
        method: 'POST',
        data: datos,
        success: function (response) {
            console.log('Solicitud exitosa:', response);
            redibujarTabla();
        },
        error: function (error) {
            console.error('Error en la solicitud AJAX:', error);
        }
    });
    $('#modalAgregarSituacion').modal('hide');
});

function redibujarTabla() {
  var monto_pago_pendiente=0;
  var monto_pago_realizado=0;
    var ruta = "{{ route('implantes.getImplantesNoFinalizados', ['id'=>$paciente->id ] ) }}"; 
    $.ajax({
        url: ruta,
        method: 'GET',
        success: function(response) {
            var implantes = response.implantes;
            $('#tablaImplantes tbody').empty(); 

            implantes.forEach(function(implante) {
                var btnEliminarImplante = "";
                if(implante.estado == 'sin iniciar' && implante.costo_pagado ==0){
                  btnEliminarImplante = `<button class="btn btn-icon btn-2 btn-primary" type="button" onClick="eliminarImplante(${implante.id})">
                                          <span class="btn-inner--icon"><i class="fas fa-solid fa-trash"></i></span>
                                        </button>`;
                                        
                }
                var nuevaFila = `<tr>
                                    <td>${implante.id}</td>
                                    <td>${implante.pieza}</td>
                                    <td>${new Date(implante.fecha).toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' }).replace(/\//g, '-')}</td>
                                    <td>${implante.marca}</td>
                                    <td>${implante.medida}</td>
                                    <td>${implante.costo}</td>
                                    <td>${implante.costo_pagado}</td>
                                    <td>${implante.costo - implante.costo_pagado}</td>
                                    <td>
                                        
                                        <button class="btn btn-primary" onClick="modalAgregarPagoImplante(${implante.id})">
                                          <span class="btn-inner--icon"><i class="ni ni-bullet-list-67"></i></span>
                                        </button>
                                    </td>
                                    <td>
                                      
                                        <button class="btn btn-primary" onClick="modalAgregarAccionImplante(${implante.id})">
                                          <span class="btn-inner--icon"><i class="ni ni-bullet-list-67"></i></span>
                                        </button>
                                    </td>
                                    <td>${implante.estado}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ url('implantePDF') }}/${implante.id}" target="_blank" >
                                            <span class="btn-inner--icon"><i class="fa fa-solid fa-print"></i></span>
                                        </a>
                                        ${btnEliminarImplante}
                                    </td>
                                </tr>`;
                $('#tablaImplantes tbody').append(nuevaFila);
                monto_pago_realizado += implante.costo_pagado;
                monto_pago_pendiente += implante.costo-implante.costo_pagado; 
                $('#pago_realizado_implantes').text('A Cuenta: '+monto_pago_realizado);
                $('#pago_pendiente_implantes').text('Saldo: '+monto_pago_pendiente);  
            });
        },
        error: function(error) {
            console.error('Error al obtener los datos de la tabla:', error);
        }
    });

    var ruta = "{{ route('implantes.getImplantesFinalizados', ['id'=>$paciente->id ] ) }}"; 
    $.ajax({
        url: ruta,
        method: 'GET',
        success: function(response) {
            var implantes = response.implantes;
            $('#tablaImplantesFinalizados tbody').empty(); 

            implantes.forEach(function(implante) {
                
                var nuevaFila = `<tr>
                                    <td>${implante.id}</td>
                                    <td>${implante.pieza}</td>
                                    <td>${new Date(implante.fecha).toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' }).replace(/\//g, '-')}</td>
                                    <td>${implante.marca}</td>
                                    <td>${implante.medida}</td>
                                    <td>${implante.costo}</td>
                                    <td>
                                        <!-- Agregar aquí los botones de acciones -->
                                        <button class="btn btn-primary" onClick="modalAgregarPagoImplante(${implante.id})">
                                          <span class="btn-inner--icon"><i class="ni ni-bullet-list-67"></i></span>
                                        </button>
                                    </td>
                                    <td>
                                        <!-- Agregar aquí los botones de acciones -->
                                        <button class="btn btn-primary" onClick="modalAgregarAccionImplante(${implante.id})">
                                          <span class="btn-inner--icon"><i class="ni ni-bullet-list-67"></i></span>
                                        </button>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ url('implantePDF') }}/${implante.id}" target="_blank" >
                                            <span class="btn-inner--icon"><i class="fa fa-solid fa-print"></i></span>
                                        </a>
                                    </td>
                                </tr>`;
                $('#tablaImplantesFinalizados tbody').append(nuevaFila);
            });
        },
        error: function(error) {
            console.error('Error al obtener los datos de la tabla:', error);
        }
    });
}

function toggleInputFechaPago() {
        var checkbox = document.getElementById("input-fecha_pago-check");
        var input = document.getElementById("input-fecha_pago");
        input.disabled = !checkbox.checked;
}
function toggleInputFechaAccion() {
        var checkbox = document.getElementById("input-fecha_accion-check");
        var input = document.getElementById("input-fecha_accion");
        input.disabled = !checkbox.checked;
}

function modalAgregarPagoImplante(implante_id){
    $('#modalPagosImplante').empty();
    var token = $('meta[name="csrf-token"]').attr('content');
    var fechaActual = "{{ \Carbon\Carbon::now()->format('d-m-Y') }}";
    var data = {
      implante_id : implante_id,
      _token : token
    }

    $.ajax({
    url: "/implantes/obtenerPagosImplante", 
    method: 'POST',
    data: data,
    success: function (response) {

      $('#tablaPagosImplante tbody').empty();
      var pagos = response.pagos;
        var contenidoModal = 
      `
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p id=""></p>
            
            <div class="table-responsive">
              <table id="tablaPagosImplante" class="table align-items-center table-flush">
                <thead class="thead-light col-lg-10">
                  <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col" class="col-lg-5">Pago</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                  </tr>
                </tbody>
              </table>

            </div>


            </div>
      
          </div>
          
        </div>
      </div>
      `;

      
      $('#modalPagosImplante').append(contenidoModal);
      var lineaPagos="";
      
      pagos.forEach(function (pago) {
        var fechaFormateada = moment(pago.fecha).format('DD-MM-YYYY');
        if(pago.activo){
        lineaPagos +=`<tr id=${pago.id}>
                          <td>
                            ${fechaFormateada}
                          </td>
                          <td>
                            ${pago.monto_pagado}
                          </td>
                          <td>
                            
                          <button onClick="mostrarModalBajaPagoImplante(${implante_id},${pago.id})" class="btn btn-icon btn-2 btn-primary" type="button" >
                                              <span class="btn-inner--icon"><i class="fas fa-solid fa-trash"></i></span>
                                          </button>
                       

                          </td>
                      </tr>`;
        }else{
             lineaPagos += `
                          <tr id=${pago.id} class="table-active" >
                          <td>${fechaFormateada}</td>
                          <td>${pago.monto_pagado}</td>
                          <td></td>
                          <tr class="table-active"><td style="padding-top:0; border-top:0; " colspan="3">Fecha Baja: ${pago.baja_pago_implante.fecha} <br>Motivo: ${pago.baja_pago_implante.motivo} <br>Realizado por: ${pago.baja_pago_implante.nombres} ${pago.baja_pago_implante.apellidos} </td></tr>;`
        }
      });
      $('#tablaPagosImplante tbody').append(lineaPagos);
      if(response.monto_deuda>0){
      var lineaInput = `
                        <tr id="linea-input-pago">
                          
                        <td>
                        <label for="input-fecha_pago-check">Fecha Editable </label>
                        <input type="checkbox" id="input-fecha_pago-check" name="input-fecha_pago-check" onchange="toggleInputFechaPago()" />
                        <input type="date" name="fecha_pago" id="input-fecha_pago"
                                                class="form-control form-control-alternative "
                                                value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                disabled >
                        </td>
                        <td>
                        <div class="pb-4"></div>
                        <input type="number" name="monto_pagado" id="input-monto-pagado"
                                                class="form-control form-control-alternative "
                                                placeholder="{{ __('0') }}"
                                                >
                        </td>
                        <td>
                        <div class="pb-4"></div>
                        
                          <button class="btn btn-icon btn-2 btn-primary" type="button" onClick="agregarPagoImplante(${implante_id})">
                            <span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
                          </button>
                        
                        </td>
                        </tr>`;
      $('#tablaPagosImplante tbody').append(lineaInput);
      }
      $('#input-monto-pagado').on('input', function() {
        var valorIngresado = $(this).val();

        if (isNaN(valorIngresado) || valorIngresado < 0 || valorIngresado > response.monto_deuda) {
            // Restablecer a 0 si no está dentro del rango
            $(this).val(0);
        }
    });
    redibujarTabla();
      $('#modalPagosImplante').modal('show');
    },
    error: function (error) {
      console.error('Error en la solicitud AJAX:', error);
  }
});
  
}

function agregarPagoImplante(implante_id){
  $('#modalError').empty();

  var token = $('meta[name="csrf-token"]').attr('content');
  var fecha_pagado = document.getElementById('input-fecha_pago').value;
  var monto_pagado = document.getElementById('input-monto-pagado').value;
    
    var datos = {
      implante_id : implante_id,
      monto_pagado: monto_pagado,
      fecha: fecha_pagado,
      _token: token
    }

    $.ajax({
    url: "/implantes/agregarPagoImplante", 
    method: 'POST',
    data: datos,
    success: function (response) {
      console.log('luego de agregar pago');
      console.log(response);
      modalAgregarPagoImplante(implante_id);
      redibujarTabla();

    },
    error: function (error) {
    console.error('Error en la solicitud AJAX:', error);

    var mensajeError = "Ha ocurrido un error al procesar el pago. Por favor, inténtalo de nuevo.";

    if (error.responseJSON && error.responseJSON.mensaje) {
        mensajeError = error.responseJSON.mensaje;
    }

    var contenidoModal =
        `<div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalErrorLabel">Error al procesar el pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ${mensajeError}
                </div>
                
            </div>
        </div>`;
    $('#modalError').append(contenidoModal);
    $('#modalError').modal('show');
    }
  });
}

function mostrarModalBajaPagoImplante(implante_id, pago_id){
  $('#modalPagosImplante').modal('hide');
  var contenido = `
                   <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel"></h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <div class="col-lg-12 form-group">
                                            <label class="form-control-label" for="motivoBajaPagoImplante">{{
                                                __('Motivo')}}*</label>
                                            <input type="text" name="motivoBajaPagoImplante" id="motivoBajaPagoImplante" class="form-control form-control-alternative" autofocus>

                                </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="cancelarBaja(implante_id)" >Cancelar</button>
                              <button type="submit" class="btn btn-primary" onClick="eliminarPagoImplante(${implante_id},${pago_id})">Aceptar</button>
                            </div>
                          </div>
                        </div>
                  `;
  $('#modalBajaPagoImplante').empty();
  $('#modalBajaPagoImplante').append(contenido);
  $('#modalBajaPagoImplante').modal('show');
}

function eliminarPagoImplante(implante_id, pago_implante_id){
  $('#modalBajaPagoImplante').modal('hide');
  var token = $('meta[name="csrf-token"]').attr('content');
  var motivo =$('#motivoBajaPagoImplante').val();
  $.ajax({
        url: "{{ route('pago_implante.delete') }}", 
        method: 'POST',  
        data: {
            pago_implante_id : pago_implante_id,
            motivo : motivo,
            _token: token
        },
        success: function (respuesta) {
          modalAgregarPagoImplante(implante_id);
          redibujarTabla();
        },
        error: function (error) {
            console.error('Error eliminar pago implante', error);
        }
    });
    
}


function modalAgregarAccionImplante(implante_id) {
    dibujarTablaAcciones(implante_id);
    //$('#modalAgregarAccion').modal('show');
  }

  function dibujarTablaAcciones(implante_id){
    var token = $('meta[name="csrf-token"]').attr('content');
    var fechaActual = "{{ \Carbon\Carbon::now()->format('d-m-Y') }}";
    var data = {
      implante_id: implante_id,
      _token : token
    }
    
    ruta = "/implantes/obtenerAccionesImplante";

    $.ajax({
      url: ruta,
      method: 'POST',
      data: data,
      success: function (response) {
        console.log('respuesta obtener acciones:',response);
        $('#tablaAcciones tbody').empty();
        
        var acciones = response.acciones;
        var estado = response.implante_estado;
        console.log(acciones.length);
        if(estado == 'finalizado'){
          $('#btnMarcarFinalizado').hide();
        }else{
          if(acciones.length >0){
            $('#btnMarcarFinalizado').on('click', function () {
              finalizar_implante(implante_id);
            });
            $('#btnMarcarFinalizado').show();
          }else{
            $('#btnMarcarFinalizado').hide();
          }
        }
        acciones.forEach(function (accion) {
          var fechaFormateada = moment(accion.fecha).format('DD-MM-YYYY');
          if(accion.activo){
                var nuevaFila = `
                          <tr id=${accion.id} >
                          <td>${fechaFormateada}</td>
                              <td>${accion.accion}</td>
                              <td>`;
              if(estado !== 'finalizado'){
              nuevaFila += `
                          
                              <button onClick="mostrarModalBajaAccionImplante(${implante_id},${accion.id})" class="btn btn-icon btn-2 btn-primary" type="button" >
                                              <span class="btn-inner--icon"><i class="fas fa-solid fa-trash"></i></span>
                                          </button>
                            
                                          `;
                                          }
              nuevaFila += `</td></tr>`;
          }else{
            var nuevaFila = `
                          <tr id=${accion.id} class="table-active" >
                          <td>${fechaFormateada}</td>
                              <td>${accion.accion}</td>
                              <td>`;
              nuevaFila += `</td>`;
              nuevaFila +=`<tr class="table-active"><td style="padding-top:0; border-top:0; " colspan="3">Fecha Baja: ${accion.baja_accion_implante.fecha} Motivo: ${accion.baja_accion_implante.motivo} Realizado por: ${accion.baja_accion_implante.nombres} ${accion.baja_accion_implante.apellidos} </td></tr>;`
          }
         

        $('#tablaAcciones tbody').append(nuevaFila);

      });
      
      if(estado !== 'finalizado'){
        var nuevaFila = `<tr id="linea-input-accion">
                          <td>
                            <label for="input-fecha_accion-check">Fecha Editable </label>
                            <input type="checkbox" id="input-fecha_accion-check" name="input-fecha_accion-check" onchange="toggleInputFechaAccion()" />
                            <input type="date" name="fecha_accion" id="input-fecha_accion"
                                                    class="form-control form-control-alternative "
                                                    value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                    disabled >
                          </td>
                          <td>
                          <div class="pb-4"></div>
                          <input type="text" name="accion" id="input-accion"
                                                  class="form-control form-control-alternative "
                                                  placeholder="{{ __('Accion') }}"
                                                  >
                          </td>
                          <td>
                          <div class="pb-4"></div>
                          
                            <button class="btn btn-icon btn-2 btn-primary" type="button" onClick="agregarAccionImplante(${implante_id})">
                              <span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
                            </button>
                          
                          </td>
                          </tr>`;

      $('#tablaAcciones tbody').append(nuevaFila);
      }
      $('#modalAgregarAccionImplante').modal('show');
  },
  error: function (error) {
    // Manejo de errores en la llamada AJAX
    console.error('Error al redibujar la tabla', error);
  }
    });

  }

function agregarAccionImplante(implante_id){
    var token = $('meta[name="csrf-token"]').attr('content');
    var accion = document.getElementById('input-accion').value;
    var fecha_atencion = document.getElementById('input-fecha_accion').value;

    var datos = {
      implante_id: implante_id,
      accion: accion,
      fecha_atencion: fecha_atencion,
      _token: token
    }
    $.ajax({
    url: "/implantes/agregar_accion_implante", 
    method: 'POST',
    data: datos,
    success: function (response) {
      // Manejar la respuesta exitosa del servidor
      console.log('Solicitud exitosa:', response);
      dibujarTablaAcciones(implante_id);
      redibujarTabla();
      },
      error: function (error) {
      // Manejar errores en la solicitud AJAX
      console.error('Error en la solicitud AJAX:', error);
      }
    });

  }

  function mostrarModalBajaAccionImplante(implante_id, accion_id){
  $('#modalAgregarAccionImplante').modal('hide');
  var contenido = `
                    <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel"></h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <div class="col-lg-12 form-group">
                                            <label class="form-control-label" for="motivoBajaAccionImplante">{{
                                                __('Motivo')}}*</label>
                                            <input type="text" name="motivoBajaAccionImplante" id="motivoBajaAccionImplante" class="form-control form-control-alternative" autofocus>

                                </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="cancelarBaja(tratamiento_aplicado_id)" >Cancelar</button>
                              <button type="submit" class="btn btn-primary" onClick="eliminarAccionImplante(${implante_id},${accion_id})">Aceptar</button>
                            </div>
                          </div>
                        </div>
                  `;
  $('#modalBajaAccionImplante').empty();
  $('#modalBajaAccionImplante').append(contenido);
  $('#modalBajaAccionImplante').modal('show');
}

function eliminarAccionImplante(implante_id, accion_id){
  $('#modalBajaAccionImplante').modal('hide');
  var token = $('meta[name="csrf-token"]').attr('content');
  var motivo =$('#motivoBajaAccionImplante').val();
  $.ajax({
        url: "{{ route('accion_implante.delete') }}", 
        method: 'POST',  
        data: {
            accion_implante_id : accion_id,
            motivo : motivo,
            _token: token
        },
        success: function (respuesta) {
          dibujarTablaAcciones(implante_id, 'en ejecucion');
        },
        error: function (error) {
            // Manejar errores en la llamada Ajax
            console.error('Error al eliminar Accion Implante:', error);
        }
    });
}

function finalizar_implante(implante_id){
    ruta = "/implantes/finalizar_implante/" + implante_id;
    $.ajax({
      url: ruta,
      method: 'GET',
      success: function (response) {
        redibujarTabla();
        dibujarTablaAcciones(implante_id,'finalizado');
      },
      error: function (error) {
      console.error('Error al finalizar acciones del implante', error);
      }
    });
}

function eliminarImplante(implante_id){
  ruta = "/eliminarImplante/" + implante_id;
    $.ajax({
      url: ruta,
      method: 'GET',
      success: function (response) {
        redibujarTabla();
      },
      error: function (error) {
      console.error('Error al eliminar el implante', error);
      }
    });
}

</script>



@endpush