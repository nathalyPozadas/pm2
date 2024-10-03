@extends('welcome')

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

            <a class="btn btn-secondary btn-sm" href="{{ route('odontogramaPDF', ['odontograma_id'=>$odontograma->id]) }}" target="_blank">Imprimir</a>
          </div>
          <div class="col-7">
          </div>
            
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
                <div class="item-odontograma " >{{$i}}
                  <img id="pieza-{{$i}}" src="{{ asset('argon')}}/img/iconos-odontograma/diente-base.svg" style="  height: 60%;
                  width: 100%;">
                </div>
                @endfor

                @php
                $start = 21;
                $end = 28;
                @endphp

                @for ($i = $start; $i <= $end; $i++) 
                <div class=" item-odontograma " >{{$i}}
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
              <div class=" item-odontograma"  >{{$i}}
                <img id="pieza-{{$i}}" src="{{ asset('argon')}}/img/iconos-odontograma/diente-base.svg" style="  height: 60%;
                  width: 100%;">
              </div>
              @endfor
              @php
              $start = 61;
              $end = 65;
              @endphp

              @for ($i = $start; $i <= $end; $i++)
               <div  class=" item-odontograma" >{{$i}}
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
            <div  class=" item-odontograma" >
              <img id="pieza-{{$i}}" src="{{ asset('argon')}}/img/iconos-odontograma/diente-base.svg" style="  height: 60%;
                  width: 100%;">{{$i}}
            </div>
            @endfor
            @php
            $start = 71;
            $end = 75;
            @endphp

            @for ($i = $start; $i <= $end; $i++)
             <div  class=" item-odontograma "  >
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
          <div class=" item-odontograma " >
            <img id="pieza-{{$i}}" src="{{ asset('argon')}}/img/iconos-odontograma/diente-base.svg" style="  height: 60%;
                  width: 100%;">{{$i}}
          </div>
          @endfor
          @php
          $start = 31;
          $end = 38;
          @endphp

          @for ($i = $start; $i <= $end; $i++) 
          <div class="item-odontograma" >
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
  
</div>

<div class="modal fade" id="modalPagosTratamiento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  
</div>
@endsection

@push('js')

<script>
  var preciosPorTratamiento = {
    '0': '0',
        @foreach($tratamientos as $tratamiento)
  '{{ $tratamiento->id }}': '{{ $tratamiento->precio }}',
    @endforeach
    };

    $(document).ready(function () {
    $('#modalAgregarSituacion').modal('hide');
    redibujarTabla({{ $odontograma-> id}});
    
    
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
                              <td>`;
                                  @foreach($tratamientos as $tratamiento)
                                  if (diente.tratamiento !== null && diente.tratamiento.tratamiento_id == {{ $tratamiento -> id }}){
              nuevaFila +=         `{{ $tratamiento->nombre }}`;
                                  }
                                  @endforeach
                                  if(diente.tratamiento == null){
              nuevaFila +=         `Sin solicitud de tratamiento`;                      
                                  }
               nuevaFila += `</td>`;
                              if (diente.tratamiento !== null) {
                                nuevaFila += `<td > ${diente.tratamiento.precio}
                                              </td>`;
                                monto_presupuesto_total += diente.tratamiento.precio;
                              }else{
                                nuevaFila += `<td></td>`;
                              }
              
                              if(estado_odontograma == "fase1" ){
              nuevaFila +=    `<td>
                               </td>`;
                                }
              nuevaFila +=     `</tr>`;
            }else{
              nuevaFila += `<tr id=${diente.id}>
                              <td>${diente.pieza}</td>
                              <td>${diente.situacion}</td>
                              <td>`;
                                
                                  if( diente.tratamiento==null){
                                  nuevaFila += 'Sin solicitud de tratamiento';
                                  }else{
                                    if(diente.tratamiento!==null  ){
                                    nuevaFila += `${diente.tratamiento.nombre}`;
                                    }
                                  }
                                
              nuevaFila +=    `</td>`;
                              if (diente.tratamiento !== null) {
                                nuevaFila += `<td>`;
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
                                    <button class="btn btn-icon btn-2 btn-primary" type="button"  onClick="modalAgregarPago(${diente.tratamiento.id})"  >
                                        <span class="btn-inner--icon"><i class="ni ni-bullet-list-67"></i></span>
                                    </button>
                                 </a>`;
                               }
              nuevaFila +=    `</td>
                              <td>`;
                              if (diente.tratamiento !== null) {
              nuevaFila +=     `<a >
                                    <button class="btn btn-icon btn-2 btn-primary" type="button" onClick="modalAgregarAccion(${diente.tratamiento.id},${diente.pieza},'${diente.tratamiento.nombre}','${diente.tratamiento.estado}')" >
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
        $('#presupuesto_total').text('BS. '+monto_presupuesto_total);
        $('#pago_pendiente').text('Saldo: '+monto_pago_pendiente);
        $('#pago_realizado').text('A Cuenta: '+monto_pago_realizado);  
  },
  error: function (error) {
    console.error('Error al redibujar la tabla', error);
  }
    });

  }

  function modalAgregarAccion(tratamiento_aplicado_id, piezaDental, nombre_tratamiento, estado_tratamiento) {
    $('#modal_agregar_accion_titulo').text('Tratamiento: '+nombre_tratamiento+' - Pieza dental:'+piezaDental);
    dibujarTablaAcciones(tratamiento_aplicado_id,estado_tratamiento);
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
        
        acciones.forEach(function (accion) {
          var fechaFormateada = moment(accion.fecha).format('DD-MM-YYYY');
          if(accion.activo){
                var nuevaFila = `
                          <tr id=${accion.id} >
                          <td>${fechaFormateada}</td>
                              <td>${accion.accion}</td>
                              <td></td>
                              </tr>`;
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
      
      $('#modalAgregarAccion').modal('show');
  },
  error: function (error) {
    // Manejo de errores en la llamada AJAX
    console.error('Error al redibujar la tabla', error);
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
      
    redibujarTabla({{$odontograma->id}});
      $('#modalPagosTratamiento').modal('show');
    },
    error: function (error) {
      console.error('Error en la solicitud AJAX:', error);
  }
});
  
}













</script>



@endpush