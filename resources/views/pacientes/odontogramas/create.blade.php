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
              <h3 class="col mb-0">{{ __('Odontograma') }}#{{$odontograma->id}}
              @if($odontograma->estado == 'fase1')
              <span id="leyenda-odontograma" class="badge badge-pill badge-success">INICIO REVISION</span>
              @endif
              @if($odontograma->estado == 'fase2')
              <span id="leyenda-odontograma" class="badge badge-pill badge-info">REVISION FINALIZADA</span>
              @endif
              @if($odontograma->estado == 'fase3')
              <span id="leyenda-odontograma" class="badge badge-pill badge-light">ODONTOGRAMA FINALIZADO</span>
              @endif
              </h3>
            </div>
            <div class="col-1">
              <a target="_blank" class="btn btn-secondary btn-sm" href="{{ route('odontogramaPDF', ['odontograma_id'=>$odontograma->id]) }}" >Imprimir</a>
            </div>
            @if($carpeta == null)
            <div class="col-1">
                <button onClick=abrirModalRegistro() class="btn btn-sm btn-primary">Adjuntar Doc</button>
            </div>
            @else
            <div class="col-1">
                <button onClick="abrirModalEdicion({{$carpeta}})" class="btn btn-sm btn-primary">Adjuntar Doc</button>
            </div>
            @endif    
            <div class="col-1 ">
              @if($carpeta !== null)
                <a href="{{ route('documentos.listar_archivos',['id' => $paciente->id , 'carpeta_id' => $carpeta->id ]) }}">
                  <button  class="btn btn-sm btn-primary">Ver Docs</button>
                </a>
              
              @endif
            </div>
            <div class="col-4">
            </div>
            @if($odontograma->estado == "fase1")
            <div id="btn_finalizar_revision" class="col text-right " >
                <button class="btn btn-sm btn btn-success" onClick="finalizar_revision({{$odontograma->id}})">Finalizar Revision</button>
            </div>
            <div id="btn_finalizar_odontograma" class="col text-right" >
                <button  class="btn btn-sm btn btn-info" onClick="finalizar_odontograma({{$odontograma->id}})">Finalizar Odontograma</button>
            </div>
            @endif
            @if($odontograma->estado == "fase2")
            <div id="btn_finalizar_odontograma" class="col text-right" >
                <button  class="btn btn-sm btn-info" onClick="finalizar_odontograma({{$odontograma->id}})" >Finalizar Odontograma</button>
            </div>
            @endif
            
          </div>
          
          
        </div>
        <div class="col-12"> </div>
        <div class="card-body bg-white">

          <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">

          @if (session('status'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif


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
                  <img id="pieza-{{$i}}" src="{{ asset('argon')}}/img/iconos-odontograma/diente-base.svg" style="  height: 60%;
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
                  <img id="pieza-{{$i}}" src="{{ asset('argon')}}/img/iconos-odontograma/diente-base.svg" style="  height: 60%;
                  width: 100%;">
              </div>
              @endfor
            </div>
            <div class="row container-odontograma justify-content-center">
              @php
              $start = 55;
              $end = 51;
              @endphp

              @for ($i = $start; $i >= $end; $i--)
              <div class=" item-odontograma item-odontograma-hover" type="button" data-toggle="modal"
                onclick="modalAgregarSituacion('{{$i}}')">{{$i}}
                <img id="pieza-{{$i}}" src="{{ asset('argon')}}/img/iconos-odontograma/diente-base.svg" style="  height: 60%;
                  width: 100%;">
              </div>
              @endfor
              @php
              $start = 61;
              $end = 65;
              @endphp

              @for ($i = $start; $i <= $end; $i++)
               <div  class=" item-odontograma item-odontograma-hover" type="button" data-toggle="modal"
                onclick="modalAgregarSituacion('{{$i}}')">{{$i}}
                <img id="pieza-{{$i}}" src="{{ asset('argon')}}/img/iconos-odontograma/diente-base.svg" style="  height: 60%;
                  width: 100%;">
            </div>
            @endfor
          </div>
          </div>
          <div class="row container-odontograma justify-content-center">
            @php
            $start = 85;
            $end = 81;
            @endphp

            @for ($i = $start; $i >= $end; $i--)
            <div  class=" item-odontograma item-odontograma-hover" type="button" data-toggle="modal"
              onclick="modalAgregarSituacion('{{$i}}')">
              <img id="pieza-{{$i}}" src="{{ asset('argon')}}/img/iconos-odontograma/diente-base.svg" style="  height: 60%;
                  width: 100%;">{{$i}}
            </div>
            @endfor
            @php
            $start = 71;
            $end = 75;
            @endphp

            @for ($i = $start; $i <= $end; $i++)
             <div  class=" item-odontograma item-odontograma-hover" type="button" data-toggle="modal"
              onclick="modalAgregarSituacion('{{$i}}')">
              <img id="pieza-{{$i}}" src="{{ asset('argon')}}/img/iconos-odontograma/diente-base.svg" style="  height: 60%;
                  width: 100%;">{{$i}}
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
            <img id="pieza-{{$i}}" src="{{ asset('argon')}}/img/iconos-odontograma/diente-base.svg" style="  height: 60%;
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
            <img id="pieza-{{$i}}" src="{{ asset('argon')}}/img/iconos-odontograma/diente-base.svg" style="  height: 60%;
                  width: 100%;">{{$i}}
        </div>
        @endfor
      </div>
      
</div>
      <div class="col-lg-3">
        <div class="card card-stats mb-1 mb-xl-0">
            <div class="card-body">
            <div class="row">
            <div class="col">
            <h2 class="card-title text-uppercase text-muted mb-0">Presupuesto TOTAL</h2>
            <span id="presupuesto_total" class="h2 font-weight-bold mb-0">BS. 0</span>
            </div>
            
            </div>
            <p class="mt-3 mb-0 text-muted text-sm">
            <h2 id="pago_realizado" >A Cuenta: 0</h2>
            <h2 id="pago_pendiente"  >Saldo: 0</h2>
            </p>
            </div>
            </div>
      </div>
    </div>

    <div class="table-responsive">
      <table id="tablaDientes" class="table align-items-center table-flush">
        <thead class="thead-light">
          
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
        <input name="odontograma" value="{{$odontograma->id}}" hidden>
        <input name="paciente_id" value="{{$paciente->id}}" hidden>
        <input name="pieza" id="input-piezaDental" hidden>


        <div class=" form-group">
          <label class="form-control-label" for="input-situacion">{{ __('Diagnóstico') }}</label>
          <select class="form-control  form-control-alternative" name="situacion" id="input-situacion">
            @foreach($situaciones as $situacion)
            <option value="{{ $situacion->id}}">{{ $situacion->nombre}}
            </option>
            @endforeach
          </select>
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
<div id="modalAgregarAccion" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby=""
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

<div class="modal fade" id="modalPagosTratamiento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  
</div>

<div class="modal fade" id="modalErrorFinalizarOdontograma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  
</div>

<div class="modal fade" id="modalBajaAccionTratamiento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  
</div>
<div class="modal fade" id="modalBajaPagoTratamiento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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

<div class="modal fade " id="modalRegistrarFolder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
</div>

@endsection

@push('js')

<script>
  var  myDropzone= null;

  var preciosPorTratamiento = {
    '0': '0',
    @foreach($tratamientos as $tratamiento)
  '{{ $tratamiento->id }}': '{{ $tratamiento->precio }}',
    @endforeach
    };

  function modalAgregarSituacion(nombre) {
    $('#input-piezaDental').val(nombre);
    $('#modalAgregarSituacion').modal('show');
  }

  $(document).ready(function () {
    $('#modalAgregarSituacion').modal('hide');
    redibujarTabla({{ $odontograma-> id}});
    if('{{$odontograma->estado}}' == 'fase1'){
      $('#btn_finalizar_odontograma').hide();

    }else{
      $(".item-odontograma").removeClass("item-odontograma-hover");
      $(".item-odontograma").prop("onclick", null);
    }
    
  });

  $('#modalAgregarSituacion .btn-primary').on('click', function () {
    var token = $('meta[name="csrf-token"]').attr('content');
    // Obtener los valores de los inputs del modal
    var odontograma_id = $('input[name="odontograma"]').val();
    var paciente_id = $('input[name="paciente_id"]').val();
    var pieza = $('input[name="pieza"]').val();
    var situacion = $('#input-situacion').val();
    console.log(situacion);
    // Datos a enviar al servidor (puedes modificarlos según tus necesidades)
    var datos = {
      odontograma_id: odontograma_id,
      paciente_id: paciente_id,
      pieza: pieza,
      situacion: situacion,
      _token: token
    };

    $.ajax({
      url: "{{ route('odontograma.diente.create') }}", 
      method: 'POST',
      data: datos,
      success: function (response) {
        // Manejar la respuesta exitosa del servidor
        console.log('Solicitud exitosa:', response);
        redibujarTabla(odontograma_id);
      },
      error: function (error) {
        // Manejar errores en la solicitud AJAX
        console.error('Error en la solicitud AJAX:', error);
      }
    });
    $('#modalAgregarSituacion').modal('hide');
  });

  function redibujarTabla(odontograma_id) {
    var monto_presupuesto_total=0;
    var monto_pago_pendiente=0;
    var monto_pago_realizado=0;
    ruta = "/odontograma/obtenerTablaDientes/" + odontograma_id;
    $.ajax({
      url: ruta,
      method: 'GET',
      success: function (response) {
        var estado_odontograma = response.estado_odontograma;
        var dientes = response.dientes;
        console.log(response);
        console.log(dientes);
        console.log('estado:::');
        console.log(estado_odontograma);

        $('#tablaDientes tbody').empty();
        $("#tablaDientes thead").empty();
        if(estado_odontograma == "fase1"){
        var nuevaFila = `<tr>
                          <th scope="col">Pieza</th>
                          <th scope="col">Diagnóstico</th>
                          <th scope="col">Tratamiento</th>
                          <th scope="col">Precio</th>
                          <th scope="col"></th>
                        </tr>`;
        $("#tablaDientes thead").append(nuevaFila);  
        }else{
          var nuevaFila = `<tr>
                            <th scope="col">Pieza</th>
                            <th scope="col">Diagnóstico</th>
                            <th scope="col">Tratamiento</th>
                            <th scope="col">Precio</th>
                            <th scope="col">A Cuenta</th>
                            <th scope= "col">Saldo</th>
                            <th scope="col">Pagos</th>
                            <th scope="col">Seguimiento</th>
                            <th scope="col">Estado</th>
                          </tr>`;
            $("#tablaDientes thead").append(nuevaFila); 
        }
        

        $('[id^="pieza-"]').attr("src", "{{ asset('argon')}}/img/iconos-odontograma/diente-base.svg");
       var  nuevaFila ="";
        dientes.forEach(function (diente) {
          $('#pieza-'+diente.pieza).attr("src", "data:image/png;base64,"+diente.icono);
          if(estado_odontograma == 'fase1'){

          
           nuevaFila += `<tr id=${diente.id}>
                              <td>${diente.pieza}</td>
                              <td>${diente.situacion}</td>
                              <td> 
                              <select class="form-control  form-control-alternative" name="" id="input-tratamiento" onchange="actualizarCampo(this,'${diente.id}')">
                                                <option value="0">Sin solicitud de tratamiento</option>`;
                                                @foreach($tratamientos as $tratamiento)
                                                nuevaFila += `<option value="{{ $tratamiento->id }}" `;
                                                if (diente.tratamiento !== null && diente.tratamiento.tratamiento_id == {{ $tratamiento -> id }}){
                                                   nuevaFila += ` selected `;
                                                }
                                                   nuevaFila += `>
                                                {{ $tratamiento->nombre }}
                                                </option>`;
                                                @endforeach
                 nuevaFila += `</select>
                              </td>`;
                              if (diente.tratamiento !== null) {
                                nuevaFila += `<td onClick="modificarPrecio(${diente.tratamiento.id})"> ${diente.tratamiento.precio}
                                              </td>`;
                                monto_presupuesto_total += diente.tratamiento.precio;
                              }else{
                                nuevaFila += `<td></td>`;
                              }
              
                              if(estado_odontograma == "fase1" ){
              nuevaFila +=    `<td>
                                 <div>
                                    <button class="btn btn-icon btn-2 btn-primary" type="button" onClick="eliminarDiente(${diente.id})">
                                        <span class="btn-inner--icon"><i class="fas fa-solid fa-trash"></i></span>
                                    </button>
                                 </div>
                               </td>`;
                                }
              nuevaFila +=     `</tr>`;
            }else{
              nuevaFila += `<tr id=${diente.id}>
                              <td>${diente.pieza}</td>
                              <td>${diente.situacion}</td>
                              <td>`;
                                if(estado_odontograma == "fase2"  &&(diente.tratamiento==null|| diente.tratamiento.estado == 'sin iniciar' && diente.tratamiento.pago_realizado==0)){
                                  nuevaFila += `<select class="form-control  form-control-alternative" name="" id="input-tratamiento" onchange="actualizarCampo(this,'${diente.id}')">
                                                <option value="0">Sin solicitud de tratamiento</option>`;
                                                @foreach($tratamientos as $tratamiento)
                                                nuevaFila += `<option value="{{ $tratamiento->id }}" `;
                                                if (diente.tratamiento !== null && diente.tratamiento.tratamiento_id == {{ $tratamiento -> id }}){
                                                   nuevaFila += ` selected `;
                                                }
                                                   nuevaFila += `>
                                                {{ $tratamiento->nombre }}
                                                </option>`;
                                                @endforeach
                                  nuevaFila += `</select>`;
                                }else{
                                  if(estado_odontograma == "fase3" && diente.tratamiento==null){
                                  nuevaFila += 'Sin solicitud de tratamiento';
                                  }else{
                                    if(diente.tratamiento!==null && (diente.tratamiento.estado != 'sin iniciar' || diente.tratamiento.pago_realizado>0 )){
                                    nuevaFila += `${diente.tratamiento.nombre}`;
                                    }
                                  }
                                }
              nuevaFila +=    `</td>`;
                              if (diente.tratamiento !== null) {
                                nuevaFila += `<td`;
                                if(estado_odontograma !="fase3" && diente.tratamiento.pago_realizado==0 && diente.tratamiento.estado == 'sin iniciar' ){
                                nuevaFila += ` onClick="modificarPrecio(${diente.tratamiento.id})"`;
                                }
                                nuevaFila += `>`;
                      
                                
                                nuevaFila += diente.tratamiento.precio;
                                nuevaFila += `</td>`;
                                monto_presupuesto_total += diente.tratamiento.precio;
                              }else{
                                nuevaFila += `<td></td>`;
                              }
              nuevaFila +=    `<td>`;
                              if (diente.tratamiento !== null) {
                                nuevaFila += diente.tratamiento.pago_realizado;
                                monto_pago_realizado += diente.tratamiento.pago_realizado;
                              }
              nuevaFila +=    `</td>`;
                            if (diente.tratamiento !== null) {
              nuevaFila +=    `<td>${diente.tratamiento.precio-diente.tratamiento.pago_realizado}</td>`;       
                              }else{
              nuevaFila +=    `<td></td>`;                     
                              }
              nuevaFila +=    `<td>`;
                              if (diente.tratamiento !== null) {
              nuevaFila +=     `<a >
                                    <button class="btn btn-icon btn-2 btn-primary" type="button"  onClick="modalAgregarPago(${diente.tratamiento.id})">
                                        <span class="btn-inner--icon"><i class="ni ni-bullet-list-67"></i></span>
                                    </button>
                                 </a>`;
                               }
              nuevaFila +=    `</td>
                              <td>`;
                              if (diente.tratamiento !== null) {
              nuevaFila +=     `<a >
                                    <button class="btn btn-icon btn-2 btn-primary" type="button"  onClick="modalAgregarAccion(${diente.tratamiento.id},${diente.pieza},'${diente.tratamiento.nombre}','${diente.tratamiento.estado}')">
                                        <span class="btn-inner--icon"><i class="ni ni-bullet-list-67"></i></span>
                                    </button>
                                 </a>`;
                               }
              nuevaFila +=    `</td>
                               <td>`;
                                if (diente.tratamiento !== null) {
                                  nuevaFila += diente.tratamiento.estado;
                                }
              nuevaFila +=    `</td>`;
                              
              nuevaFila +=     `</tr>`;
            }                  
                          
      });
      $('#tablaDientes tbody').append(nuevaFila);
        monto_pago_pendiente = monto_presupuesto_total-monto_pago_realizado;        
        $('#presupuesto_total').text('BS. '+monto_presupuesto_total);//BS. 400
        $('#pago_pendiente').text('Saldo: '+monto_pago_pendiente);
        $('#pago_realizado').text('A Cuenta: '+monto_pago_realizado);  
  },
  error: function (error) {
    // Manejo de errores en la llamada AJAX
    console.error('Error al redibujar la tabla', error);
  }
    });

  }

  function actualizarCampo(select, dienteId) {
    var token = $('meta[name="csrf-token"]').attr('content');

    var fila = select.closest('tr'); // Obtener la fila actual
    var tratamientoSeleccionado = select.value;
    console.log(tratamientoSeleccionado);
    
    var datos = {
      odontograma_id: {{ $odontograma-> id
  }},
  paciente_id: {{ $paciente -> id }},
  diente_id: dienteId,
    tratamiento_id: tratamientoSeleccionado,
      _token: token
    };
  $.ajax({
    url: "{{ route('odontograma.tratamiento_aplicado.create') }}", 
    method: 'POST',
    data: datos,
    success: function (response) {
      // Manejar la respuesta exitosa del servidor
      console.log('Solicitud exitosa:', response);
      redibujarTabla({{ $odontograma-> id}});
      },
  error: function (error) {
    // Manejar errores en la solicitud AJAX
    console.error('Error en la solicitud AJAX:', error);
  }
    });
  }

  function modalAgregarAccion(tratamiento_aplicado_id, piezaDental, nombre_tratamiento, estado_tratamiento) {
    $('#modal_agregar_accion_titulo').text('Tratamiento: '+nombre_tratamiento+' - Pieza dental:'+piezaDental);
    dibujarTablaAcciones(tratamiento_aplicado_id,estado_tratamiento);
    //$('#modalAgregarAccion').modal('show');
  }

  function modalEliminar() {
    $('#modalEliminar').modal('show');
  }

  function dibujarTablaAcciones(tratamiento_aplicado_id, estado_tratamiento){
    var token = $('meta[name="csrf-token"]').attr('content');
    var fechaActual = "{{ \Carbon\Carbon::now()->format('d-m-Y') }}";
    var data = {
      tratamiento_aplicado_id: tratamiento_aplicado_id,
      odontograma_id : {{$odontograma->id}},
      _token : token
    }
    console.log('en dibujartablaacciones',tratamiento_aplicado_id);
    
    ruta = "/odontograma/tratamiento_aplicado";

    $.ajax({
      url: ruta,
      method: 'POST',
      data: data,
      success: function (response) {
        console.log('respuesta obtener acciones:',response);
        $('#tablaAcciones tbody').empty();
        
        var acciones = response.acciones;
        var estado_odontograma = response.estado_odontograma;
        console.log(acciones.length);
        if(estado_tratamiento == 'finalizado'){
          $('#btnMarcarFinalizado').hide();
        }else{
          if(acciones.length >0){
            $('#btnMarcarFinalizado').on('click', function () {
              finalizar_tratamiento_aplicado(tratamiento_aplicado_id);
            });
            $('#btnMarcarFinalizado').show();
          }else{
            $('#btnMarcarFinalizado').hide();
          }
        }
        acciones.forEach(function (accion) {
          var fechaFormateada = moment(accion.fecha_atencion).format('DD-MM-YYYY');
          if(accion.activo){
                var nuevaFila = `
                          <tr id=${accion.id} >
                          <td>${fechaFormateada}</td>
                              <td>${accion.accion}</td>
                              <td>`;
              if(estado_odontograma !== 'fase3' && estado_tratamiento !== 'finalizado'){
              nuevaFila += `
                            @can('administrar_odontograma')
                              <button onClick="mostrarModalBajaAccion(${tratamiento_aplicado_id},${accion.id})" class="btn btn-icon btn-2 btn-primary" type="button" >
                                              <span class="btn-inner--icon"><i class="fas fa-solid fa-trash"></i></span>
                                          </button>
                            @endcan
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
              nuevaFila +=`<tr class="table-active"><td style="padding-top:0; border-top:0; " colspan="3">Fecha Baja: ${accion.baja_tratamiento.fecha} Motivo: ${accion.baja_tratamiento.motivo} Realizado por: ${accion.baja_tratamiento.nombres} ${accion.baja_tratamiento.apellidos} </td></tr>;`
          }
         

        $('#tablaAcciones tbody').append(nuevaFila);

      });
      if(estado_odontograma !== 'fase3' && estado_tratamiento !== 'finalizado'){
      
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
                          @can('administrar_odontograma')
                            <button class="btn btn-icon btn-2 btn-primary" type="button" onClick="agregarAccionTratamiento(${tratamiento_aplicado_id})">
                              <span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
                            </button>
                          @endcan
                          </td>
                          </tr>`;

      $('#tablaAcciones tbody').append(nuevaFila);
      }
      $('#modalAgregarAccion').modal('show');
  },
  error: function (error) {
    // Manejo de errores en la llamada AJAX
    console.error('Error al redibujar la tabla', error);
  }
    });

  }

  

  
  function agregarAccionTratamiento(tratamiento_aplicado_id){
    var token = $('meta[name="csrf-token"]').attr('content');
    var accion = document.getElementById('input-accion').value;
    var fecha_atencion = document.getElementById('input-fecha_accion').value;

    var datos = {
      odontograma_id:{{$odontograma->id}},
      tratamiento_aplicado_id: tratamiento_aplicado_id,
      accion: accion,
      fecha_atencion: fecha_atencion,
      _token: token
    }
    $.ajax({
    url: "/odontograma/agregar_accion_tratamiento", 
    method: 'POST',
    data: datos,
    success: function (response) {
      // Manejar la respuesta exitosa del servidor
      console.log('Solicitud exitosa:', response);
      dibujarTablaAcciones(tratamiento_aplicado_id);
      redibujarTabla({{$odontograma->id}});
      },
      error: function (error) {
      // Manejar errores en la solicitud AJAX
      console.error('Error en la solicitud AJAX:', error);
      }
    });

  }

  //el usuario ya no podrá agregar situaciones
  function finalizar_revision(odontograma_id){
    var token = $('meta[name="csrf-token"]').attr('content');
    var datos = {
      odontograma_id: odontograma_id,
      _token: token
    };
    $.ajax({
    url: "/odontograma/finalizar_revision", 
    method: 'POST',
    data: datos,
    success: function (response) {
      //ocultar boton de edicion y mostrar el de finalizar odontograma
      //ya no se debe poder interactuar con la tabla de dientes ni modificar las situaciones
      $(".item-odontograma").removeClass("item-odontograma-hover");
      $(".item-odontograma").prop("onclick", null);
      $('#btn_finalizar_revision').remove();
      $('#btn_finalizar_odontograma').show();
      $("#leyenda-odontograma").text("REVISION FINALIZADA");
      $("#leyenda-odontograma").removeClass("badge-success").addClass("badge-info");
     redibujarTabla(odontograma_id);
      },
      error: function (error) {
      console.error('Error en la solicitud AJAX:', error);
      }
    });
  }

  //ya no se podrá cambiar nada del odontograma
  function finalizar_odontograma(odontograma_id){
    var token = $('meta[name="csrf-token"]').attr('content');
    var datos = {
      odontograma_id: odontograma_id,
      _token: token
    };
    $.ajax({
    url: "/odontograma/finalizar_odontograma", 
    method: 'POST',
    data: datos,
    success: function (response) {
      $('#btn_finalizar_odontograma').hide();
      //ya no se puede agregar acciones al odontograma
      $("#leyenda-odontograma").text("ODONTOGRAMA FINALIZADO");
      $("#leyenda-odontograma").removeClass("badge-info").addClass("badge-light");
      redibujarTabla(odontograma_id);
      },
      error: function (error) {
        console.log(error.responseJSON.mensaje);
      $('#modalErrorFinalizarOdontograma').empty();
      var contenido = `<div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">No se ha podido finalizar el odontrograma</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                ${error.responseJSON.mensaje}
                            </div>        
                          </div>
                        </div>`;
      $('#modalErrorFinalizarOdontograma').append(contenido);
      $('#modalErrorFinalizarOdontograma').modal('show');
      }
    });
  }

  function eliminarDiente(diente_id){
    var token = $('meta[name="csrf-token"]').attr('content');
    console.log('se va eliminar:'+diente_id);
    data = {
      diente_id: diente_id,
      odontograma_id: {{$odontograma->id}},
      _token: token
    };

    $.ajax({
    url: "/eliminarDiente",
    method: 'POST',
    data: data,
    
    success: function (response) {
      redibujarTabla({{$odontograma->id}});
      },
  error: function (error) {
    // Manejar errores en la solicitud AJAX
    console.error('Error en la solicitud AJAX:', error);
  }
    });
  }

  function finalizar_tratamiento_aplicado(tratamiento_aplicado_id){
    console.log('terminar tratamiento aplicado'+tratamiento_aplicado_id);
    ruta = "/odontograma/finalizar_tratamiento_aplicado/" + tratamiento_aplicado_id;
    $.ajax({
      url: ruta,
      method: 'GET',
      success: function (response) {
        console.log(response);
        redibujarTabla({{$odontograma->id}});
        dibujarTablaAcciones(tratamiento_aplicado_id,'finalizado');
      },
      error: function (error) {
      console.error('Error en la solicitud AJAX:', error);
      }
    });
  }

  function modificarPrecio(tratamiento_aplicado_id){
    $('#modalModificarPrecio').empty();
    console.log("tratamiento_aplicado_id:::");
    console.log(tratamiento_aplicado_id);

    var token = $('meta[name="csrf-token"]').attr('content');
    
    var datos = {
      tratamiento_aplicado_id: tratamiento_aplicado_id,
      _token: token
    }

    $.ajax({
    url: "/odontograma/obtenerDatosPrecio", 
    method: 'POST',
    data: datos,
    success: function (response) {
      // Manejar la respuesta exitosa del servidor
      console.log('Solicitud exitosa:', response);
        var precio_establecido = response.tratamiento_aplicado.precio;
        var precio_regular = response.precioRegular;
        var descuento_parcial = response.tratamiento_aplicado.descuento_parcial;
        var monto_descuento =0;
        if(descuento_parcial!=null && descuento_parcial>0){
          monto_descuento = (precio_regular / 100) * descuento_parcial;
          monto_descuento = monto_descuento.toFixed(2);
        }
        var contenidoModal = 
      `
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
            <div   class="col-lg-6 form-group">
              <label class="form-control-label" for="input-precio_regular" >{{ __('Precio Regular Tratamiento')
                  }}</label>
                  ${precio_regular}
            </div>
            <div   class="col-lg-6 form-group">
              <label class="form-control-label" for="input-precio_establecido" >{{ __('Precio Establecido')
                  }}</label>
              <input type="text" name="precio_establecido" id="input-precio_establecido" class="form-control form-control-alternative "
                  placeholder="${precio_regular}" value="${precio_establecido}" >
            </div>
            <div   class="col-lg-6 form-group">
              <label class="form-control-label" for="input-descuento_parcial" >{{ __('Porcentaje Descuento')
                  }}</label>
              <input type="text" name="descuento_parcial" id="input-descuento_parcial" class="form-control form-control-alternative "
                  placeholder="0" value="${descuento_parcial}" >
            </div>
            <div   class="col-lg-6 form-group">
              <label class="form-control-label" for="input-monto_descuento" >{{ __('Monto descuento')
                  }}</label>
              <input type="text" name="apellidos" id="input-monto_descuento" class="form-control form-control-alternative "
                  placeholder="0" value="${monto_descuento}" >
            </div>
            <div id="alerta-costo-bajo">
              
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button onClick="actualizarPrecioTratamientoAplicado(${tratamiento_aplicado_id})" type="submit" class="btn btn-primary">Aceptar</button>
          </div>
          
        </div>
      </div>
      `;

      $('#modalModificarPrecio').append(contenidoModal);
     // Obtener referencias a los elementos del DOM
      const descuentoParcialInput = document.getElementById('input-descuento_parcial');
      const montoDescuentoInput = document.getElementById('input-monto_descuento');
      const precioEstablecidoInput = document.getElementById('input-precio_establecido');

      // Agregar un evento de entrada al input de descuento_parcial
      descuentoParcialInput.addEventListener('input', function() {
          // Obtener el valor del porcentaje de descuento
          const porcentajeDescuento = parseFloat(descuentoParcialInput.value) || 0; // Si es NaN, establecer a 0

          // Calcular el monto de descuento
          const montoDescuento = (precio_regular / 100) * porcentajeDescuento;

          // Calcular el precio establecido restando el monto de descuento al precio regular
          const precioEstablecido = precio_regular - montoDescuento;

          // Actualizar los valores de los inputs
          montoDescuentoInput.value = montoDescuento.toFixed(2); // Redondear a dos decimales
          precioEstablecidoInput.value = precioEstablecido.toFixed(2); // Redondear a dos decimales
          if (precioEstablecidoInput.value < response.costo_tratamiento) {
              $('#alerta-costo-bajo').empty();
              var alerta = `<div class="alert alert-danger" role="alert">
                  El precio establecido es menor al costo del tratamiento.
              </div>`;
              $('#alerta-costo-bajo').append(alerta);
          } else {
              $('#alerta-costo-bajo').empty();
          }
      });

      // Agregar un evento de entrada al input de monto_descuento
      montoDescuentoInput.addEventListener('input', function() {
          // Obtener el valor del monto de descuento
          const montoDescuento = parseFloat(montoDescuentoInput.value) || 0; // Si es NaN, establecer a 0

          // Calcular el nuevo porcentaje de descuento
          const nuevoPorcentajeDescuento = (montoDescuento / precio_regular) * 100 || 0; // Si es NaN, establecer a 0

          // Calcular el nuevo precio establecido restando el monto de descuento al precio regular
          const nuevoPrecioEstablecido = precio_regular - montoDescuento;

          // Actualizar los valores de los inputs
          descuentoParcialInput.value = nuevoPorcentajeDescuento.toFixed(2); // Redondear a dos decimales
          precioEstablecidoInput.value = nuevoPrecioEstablecido.toFixed(2); // Redondear a dos decimales
          if (precioEstablecidoInput.value < response.costo_tratamiento) {
              $('#alerta-costo-bajo').empty();
              var alerta = `<div class="alert alert-danger" role="alert">
                  El precio establecido es menor al costo del tratamiento.
              </div>`;
              $('#alerta-costo-bajo').append(alerta);
          } else {
              $('#alerta-costo-bajo').empty();
          }
          
      });
      precioEstablecidoInput.addEventListener('input', function() {
    // Obtener el nuevo valor del precio establecido
    const nuevoPrecioEstablecido = parseFloat(precioEstablecidoInput.value) || 0; // Si es NaN, establecer a 0

    // Calcular el nuevo monto de descuento
    const nuevoMontoDescuento = precio_regular - nuevoPrecioEstablecido;

    // Calcular el nuevo porcentaje de descuento
    const nuevoPorcentajeDescuento = (nuevoMontoDescuento / precio_regular) * 100 || 0; // Si es NaN, establecer a 0

    // Actualizar los valores de los inputs
    montoDescuentoInput.value = nuevoMontoDescuento.toFixed(2); // Redondear a dos decimales
    descuentoParcialInput.value = nuevoPorcentajeDescuento.toFixed(2); // Redondear a dos decimales

    // Verificar si el nuevo precio establecido es menor al costo del tratamiento
    if (nuevoPrecioEstablecido < response.costo_tratamiento) {
        $('#alerta-costo-bajo').empty();
        var alerta = `<div class="alert alert-danger" role="alert">
            El precio establecido es menor al costo del tratamiento.
        </div>`;
        $('#alerta-costo-bajo').append(alerta);
    } else {
        $('#alerta-costo-bajo').empty();
    }
});


      $('#modalModificarPrecio').modal('show');
      

      redibujarTabla({{$odontograma->id}});
      },
      error: function (error) {
      // Manejar errores en la solicitud AJAX
      console.error('Error en la solicitud AJAX:', error);
      }
    });

    
  
  }

  function modalAgregarPago(tratamiento_aplicado_id){
    $('#modalPagosTratamiento').empty();
    var token = $('meta[name="csrf-token"]').attr('content');
    var fechaActual = "{{ \Carbon\Carbon::now()->format('d-m-Y') }}";
    var data = {
      tratamiento_aplicado_id: tratamiento_aplicado_id,
      odontograma_id : {{$odontograma->id}},
      _token : token
    }

    console.log('en modalAgregarPago',tratamiento_aplicado_id);

    $.ajax({
    url: "/odontograma/obtenerPagosTratamiento", 
    method: 'POST',
    data: data,
    success: function (response) {

      console.log('Solicitud exitosa:', response);
      $('#tablaPagosTratamiento tbody').empty();
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
              <table id="tablaPagosTratamiento" class="table align-items-center table-flush">
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

      
      $('#modalPagosTratamiento').append(contenidoModal);
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
                            
                        @can('administrar_odontograma')
                          <button onClick="mostrarModalBajaPagoTratamiento(${tratamiento_aplicado_id},${pago.id})" class="btn btn-icon btn-2 btn-primary" type="button" >
                                              <span class="btn-inner--icon"><i class="fas fa-solid fa-trash"></i></span>
                                          </button>
                        @endcan

                          </td>
                      </tr>`;
        }else{
             lineaPagos += `
                          <tr id=${pago.id} class="table-active" >
                          <td>${fechaFormateada}</td>
                          <td>${pago.monto_pagado}</td>
                          <td></td>
                          <tr class="table-active"><td style="padding-top:0; border-top:0; " colspan="3">Fecha Baja: ${pago.baja_pago_tratamiento.fecha} <br>Motivo: ${pago.baja_pago_tratamiento.motivo} <br>Realizado por: ${pago.baja_pago_tratamiento.nombres} ${pago.baja_pago_tratamiento.apellidos} </td></tr>;`
        }
      });
      $('#tablaPagosTratamiento tbody').append(lineaPagos);
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
                        @can('administrar_odontograma')
                          <button class="btn btn-icon btn-2 btn-primary" type="button" onClick="agregarPagoTratamiento(${tratamiento_aplicado_id})">
                            <span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
                          </button>
                        @endcan
                        </td>
                        </tr>`;
      $('#tablaPagosTratamiento tbody').append(lineaInput);
      }
      $('#input-monto-pagado').on('input', function() {
        var valorIngresado = $(this).val();

        if (isNaN(valorIngresado) || valorIngresado < 0 || valorIngresado > response.monto_deuda) {
            // Restablecer a 0 si no está dentro del rango
            $(this).val(0);
        }
    });
    redibujarTabla({{$odontograma->id}});
      $('#modalPagosTratamiento').modal('show');
    },
    error: function (error) {
      console.error('Error en la solicitud AJAX:', error);
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

function agregarPagoTratamiento(tratamiento_aplicado_id){
  $('#modalErrorFinalizarOdontograma').empty();

  var token = $('meta[name="csrf-token"]').attr('content');
  var fecha_pagado = document.getElementById('input-fecha_pago').value;
    var monto_pagado = document.getElementById('input-monto-pagado').value;
    
    var datos = {
      odontograma_id :{{$odontograma->id}},
      tratamiento_aplicado_id: tratamiento_aplicado_id,
      monto_pagado: monto_pagado,
      fecha: fecha_pagado,
      _token: token

    }

    $.ajax({
    url: "/odontograma/agregarPagoTratamiento", 
    method: 'POST',
    data: datos,
    success: function (response) {
      console.log('luego de agregar pago');
      console.log(response);
    modalAgregarPago(tratamiento_aplicado_id);
    redibujarTabla({{$odontograma->id}});

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
                    <h5 class="modal-title" id="modalErrorFinalizarOdontogramaLabel">Error al procesar el pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ${mensajeError}
                </div>
                
            </div>
        </div>`;
    $('#modalErrorFinalizarOdontograma').append(contenidoModal);
    $('#modalErrorFinalizarOdontograma').modal('show');
}


  });
}

function actualizarPrecioTratamientoAplicado(tratamiento_aplicado_id){
  const descuento_parcial = $('#input-descuento_parcial').val();
  const monto_descuento = $('#input-monto_descuento').val();
  const precio_establecido = $('#input-precio_establecido').val();
  const odontograma_id = {{$odontograma->id}};
  var token = $('meta[name="csrf-token"]').attr('content');

  $.ajax({
        url: '/odontograma/actualizarPrecioTratamientoAplicado',  // Reemplaza con la URL correcta
        method: 'POST',         // O el método HTTP que estés utilizando
        data: {
            tratamiento_aplicado_id : tratamiento_aplicado_id,
            precio_establecido: precio_establecido,
            descuento_parcial: descuento_parcial,
            monto_descuento: monto_descuento,
            odontograma_id : odontograma_id,
            _token: token
        },
        success: function (respuesta) {
          
            redibujarTabla({{$odontograma->id}});
            $('#modalModificarPrecio').modal('hide');
        },
        error: function (error) {
            // Manejar errores en la llamada Ajax
            console.error('Error en la llamada Ajax123456:', error);
        }
    });
}

function mostrarModalBajaAccion(tratamiento_aplicado_id, accion_id){
  $('#modalAgregarAccion').modal('hide');
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
                                            <label class="form-control-label" for="motivoBajaAccion">{{
                                                __('Motivo')}}*</label>
                                            <input type="text" name="motivoBajaAccion" id="motivoBajaAccion" class="form-control form-control-alternative" autofocus>

                                </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="cancelarBaja(tratamiento_aplicado_id)" >Cancelar</button>
                              <button type="submit" class="btn btn-primary" onClick="eliminarAccion(${tratamiento_aplicado_id},${accion_id})">Aceptar</button>
                            </div>
                          </div>
                        </div>
                  `;
  $('#modalBajaAccionTratamiento').empty();
  $('#modalBajaAccionTratamiento').append(contenido);
  $('#modalBajaAccionTratamiento').modal('show');
}

function mostrarModalBajaPagoTratamiento(tratamiento_aplicado_id, pago_id){
  $('#modalPagosTratamiento').modal('hide');
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
                                            <label class="form-control-label" for="motivoBajaPagoTratamiento">{{
                                                __('Motivo')}}*</label>
                                            <input type="text" name="motivoBajaPagoTratamiento" id="motivoBajaPagoTratamiento" class="form-control form-control-alternative" autofocus>

                                </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="cancelarBaja(tratamiento_aplicado_id)" >Cancelar</button>
                              <button type="submit" class="btn btn-primary" onClick="eliminarPagoTratamiento(${tratamiento_aplicado_id},${pago_id})">Aceptar</button>
                            </div>
                          </div>
                        </div>
                  `;
  $('#modalBajaPagoTratamiento').empty();
  $('#modalBajaPagoTratamiento').append(contenido);
  $('#modalBajaPagoTratamiento').modal('show');
}

function eliminarAccion(tratamiento_aplicado_id, accion_id){
  const odontograma_id = {{$odontograma->id}};
  $('#modalBajaAccionTratamiento').modal('hide');
  var token = $('meta[name="csrf-token"]').attr('content');
  var motivo =$('#motivoBajaAccion').val();
  $.ajax({
        url: "{{ route('accion.delete') }}", 
        method: 'POST',  
        data: {
            odontograma_id: odontograma_id,
            accion_tratamiento_id : accion_id,
            motivo : motivo,
            _token: token
        },
        success: function (respuesta) {
          dibujarTablaAcciones(tratamiento_aplicado_id, 'en proceso');
        },
        error: function (error) {
            // Manejar errores en la llamada Ajax
            console.error('Error en la llamada Ajax123456:', error);
        }
    });
}

function eliminarPagoTratamiento(tratamiento_aplicado_id, pago_tratamiento_id){
  $('#modalBajaPagoTratamiento').modal('hide');
  var token = $('meta[name="csrf-token"]').attr('content');
  var motivo =$('#motivoBajaPagoTratamiento').val();
  const odontograma_id = {{$odontograma->id}};
  $.ajax({
        url: "{{ route('pago_tratamiento.delete') }}", 
        method: 'POST',  
        data: {
            odontograma_id : odontograma_id,
            pago_tratamiento_id : pago_tratamiento_id,
            tratamiento_aplicado_id : tratamiento_aplicado_id,
            motivo : motivo,
            _token: token
        },
        success: function (respuesta) {
          modalAgregarPago(tratamiento_aplicado_id);
          redibujarTabla(odontograma_id);
        },
        error: function (error) {
            console.error('Error en la llamada Ajax123456:', error);
        }
    });
    
}



async function abrirModalRegistro() {
    try {
        $('#modalRegistrarFolder').empty();
        var contenido = `<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Folder</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form  name="demoform" id="demoform" method="POST" class="dropzone" enctype="multipart/form-data">
                                @csrf     
                                <input id="input-paciente_id" name="folderpacienteid" value="{{$paciente->id}}" type="hidden">
                                    <div   class="col-lg-12 form-group">
                                        <label class="form-control-label" for="input-nombre">{{ __('Nombre') }}</label>
                                        <input type="text" name="foldernombre" id="input-nombre" class="form-control form-control-alternative" value="Docs. Odontograma#{{$odontograma->id}}" readonly >
                                    </div>
                                    <div   class="col-lg-12 form-group">
                                        <label class="form-control-label" for="input-descripcion">{{ __('Descripcion') }}</label>
                                        <input type="text" name="folderdescripcion" id="input-descripcion" class="form-control form-control-alternative" value="Documentos pertenecientes al odontograma#{{$odontograma->id}}" readonly>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <div id="dropzoneDragArea" class="dz-default dz-message dropzoneDragArea">
                                            <span>Upload file</span>
                                        </div>
                                        <div class="dropzone-previews"></div>
                                    </div>
                                    <div id="errorFaltaArchivo">
                                    </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button  type="submit" class="btn btn-primary" >Aceptar</button>
                                </div>
                            </form>
                        </div>
                    </div>`;

        $('#modalRegistrarFolder').append(contenido);
        $('#modalRegistrarFolder').modal('show');

        Dropzone.autoDiscover = false;
        let token = $('meta[name="csrf-token"]').attr('content');
        $(function() {
            myDropzone = new Dropzone("div#dropzoneDragArea", { 
            paramName: "file",
            url: "{{ route('documentos.store') }}",
            previewsContainer: 'div.dropzone-previews',
            addRemoveLinks: true,
            autoProcessQueue: false,
            maxFilesize: 16,
            uploadMultiple: true,
            parallelUploads: 20,
            maxFiles: 20,
            params: {
                _token: token
            },
            

            init: function() {
	    var myDropzone = this;
	    //form submission code goes here
	    $("form[name='demoform']").submit(function(event) {
	    	//Make sure that the form isn't actully being sent.
            enviarDatos();
	    	event.preventDefault();
			event.stopPropagation();

			myDropzone.processQueue();
			
	    });

	    //Gets triggered when we submit the image.
	    this.on('sending', function(file, xhr, formData){
	    //fetch the user id from hidden input field and send that userid with our image
	     // let userid = document.getElementById('userid').value;
		 //  formData.append('userid', userid);

		   //let nombre = document.getElementById('name').value;
		  // formData.append('nombre', name);
		  console.log('entro a sending');
		});
		
	    this.on("success", function (file, response) {
  
        });

        this.on("queuecomplete", function () {
		
        });
		
        // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
	    // of the sending event because uploadMultiple is set to true.
	    this.on("sendingmultiple", function(file, xhr, formData) {
	      // Gets triggered when the form is actually being sent.
	      // Hide the success button or the complete form.
            formData.append('paciente_id', $('#input-paciente_id').val());
            formData.append('nombre', $('#input-nombre').val());
            formData.append('descripcion', $('#input-descripcion').val());
            formData.append('odontograma_id', {{$odontograma->id}});
                    
            
		  console.log('entro a sendingmultiple');
	    });
		
	    this.on("successmultiple", function(files, response) {
	      // Gets triggered when the files have successfully been sent.
	      // Redirect user or notify of success.
          window.location.href = '{{ route("odontograma.edit",["odontograma_id"=>$odontograma->id,"id"=>$paciente->id]) }}';
          
	    });
		
	    this.on("errormultiple", function(files, response) {
	      // Gets triggered when there was an error sending the files.
	      // Maybe show form again, and notify user of error
	    });
	}

            });
        });
    }catch (error) {
        console.error('Error al obtener la lista de doctores:', error);
    }
}

function enviarDatos(){
    if (myDropzone.files.length === 0) {
        $('#errorFaltaArchivo').empty();
        $('#errorFaltaArchivo').append(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Debe agregar al menos un archivo
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>`);
        
    } 
    
    
}

async function abrirModalEdicion(carpeta) {
    try {
      $('#modalRegistrarFolder').empty();


      var contenido = `<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Editar Folder</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <form  name="demoform" id="demoform" method="POST" class="dropzone" enctype="multipart/form-data">
                              @csrf     
                              <input id="input-paciente_id" name="folderpacienteid" value="{{$paciente->id}}" type="hidden">
                                  <div   class="col-lg-12 form-group">
                                      <label class="form-control-label" for="input-nombre">{{ __('Nombre') }}</label>
                                      <input type="text" name="foldernombre" id="input-nombre" class="form-control form-control-alternative" placeholder="Nombre" value="${carpeta.nombre}" readonly>
                                  </div>
                                  <div   class="col-lg-12 form-group">
                                      <label class="form-control-label" for="input-descripcion">{{ __('Descripcion') }}</label>
                                      <input type="text" name="folderdescripcion" id="input-descripcion" class="form-control form-control-alternative" value="${carpeta.descripcion}" readonly>
                                  </div>
                                  <div class="col-lg-12 form-group">
                                      <div id="dropzoneDragArea" class="dz-default dz-message dropzoneDragArea">
                                          <span>Upload file</span>
                                      </div>
                                      <div class="dropzone-previews"></div>
                                  </div>
                                  <div id="errorFaltaArchivo"></div>
                              
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                  <button  type="submit" class="btn btn-primary">Aceptar</button>
                              </div>
                          </form>
                      </div>
                  </div>`;

      $('#modalRegistrarFolder').append(contenido);
      $('#modalRegistrarFolder').modal('show');

      Dropzone.autoDiscover = false;
      // Dropzone.options.demoform = false;	
      let token = $('meta[name="csrf-token"]').attr('content');
      $(function() {
      myDropzone = new Dropzone("div#dropzoneDragArea", { 
          paramName: "file",
          url: "{{ route('documentos.update') }}",
          previewsContainer: 'div.dropzone-previews',
          addRemoveLinks: true,
          autoProcessQueue: false,
          uploadMultiple: true,
          parallelUploads: 20,
          maxFiles: 20,
          dictRemoveFile: "Eliminar" ,
          params: {
              _token: token
          },
          
          

          init: function() {

              var myDropzone = this;
              //form submission code goes here
              
              $("form[name='demoform']").submit(function(event) {
                  //Make sure that the form isn't actully being sent.
                  enviarDatos();
                  event.preventDefault();
                  event.stopPropagation();

                  myDropzone.processQueue();
                  
              });
              

              this.on("addedfile", function (file) {
                  // Asegúrate de que estás añadiendo la miniatura aquí
                  if (file.dataURL) {
                      //file.previewElement.classList.add("dz-success");
                      //file.previewElement.querySelector("img").src = file.dataURL;
                  }

                  var nombreArchivo = document.createElement("div");
                  nombreArchivo.className = "dz-file-name";
                  nombreArchivo.innerHTML = file.name;
                  file.previewElement.appendChild(nombreArchivo);
              });

              //Gets triggered when we submit the image.
              this.on('sending', function(file, xhr, formData){
              //fetch the user id from hidden input field and send that userid with our image
              // let userid = document.getElementById('userid').value;
              //  formData.append('userid', userid);

              //let nombre = document.getElementById('name').value;
              // formData.append('nombre', name);
              console.log('entro a sending');
              });
              
              this.on("success", function (file, response) {
      
              });

              this.on("queuecomplete", function () {
              
              });
              
              // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
              // of the sending event because uploadMultiple is set to true.
              this.on("sendingmultiple", function(file, xhr, formData) {
              // Gets triggered when the form is actually being sent.
              // Hide the success button or the complete form.
                  formData.append('paciente_id', $('#input-paciente_id').val());
                  formData.append('nombre', $('#input-nombre').val());
                  formData.append('descripcion', $('#input-descripcion').val());
                  formData.append('solicitado_por', {{Auth::user()->recursoHumano->id}});
                  formData.append('carpeta_id', carpeta.id);
                          
                  
              console.log('entro a sendingmultiple');
              });
              
              this.on("successmultiple", function(files, response) {
              // Gets triggered when the files have successfully been sent.
              // Redirect user or notify of success.
              window.location.href = '{{ route("odontograma.edit",["id"=>$paciente->id, "odontograma_id"=>$odontograma->id]) }}';
              
              });
              
              this.on("errormultiple", function(files, response) {
              // Gets triggered when there was an error sending the files.
              // Maybe show form again, and notify user of error
              });
          }

          });
          
          $.ajax({
              url: "{{ route('cargarArchivosCarpeta') }}",
              method: 'POST',
              data: { carpeta_id: carpeta.id,  _token: token },
              success: function(response) {
                  response.archivos.forEach(function (archivo) {
                      
                      var decodedString = atob(archivo.archivo);
                      const nuevoArchivo = new File([decodedString], archivo.nombre);
                      myDropzone.addFile(nuevoArchivo);
                  });
              
              },
              error: function(error) {
                  // Rechaza la promesa en caso de error
                  console(error);
              }

          });

      });
  }catch (error) {
      console.error('Error al obtener la lista de doctores:', error);
  }

}

</script>



@endpush