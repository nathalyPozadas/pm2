@extends('welcome')

@push('header-js-lista')

   
   <script src="{{ asset('calendario') }}/index.global.js"></script>

   <script>
var calendar;
document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');

  calendar = new FullCalendar.Calendar(calendarEl, {
    
    buttonText: {
              today: 'hoy',
              month: 'mes',
              week: 'semana',
              day: 'día'
          },
          monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
          monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
          dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
          dayNamesShort: ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'],
          weekends: true,
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
    },
    
    initialDate: new Date(),
    navLinks: true, // can click day/week names to navigate views
    selectable: true,
    selectMirror: true,
    select: function(arg) {
      @can('administrar_agenda')
       mostrarModalRegistrarCita(arg);
      @endcan
    },

    eventClick: function(arg) {
      let eventoId= arg.event.id;
      if(eventoId.includes('cumpleanio')){
        let posicionCodigo = eventoId.indexOf('cumpleanio');
        let paciente_id = eventoId.substring(posicionCodigo + 'cumpleanio'.length).trim();
        mostrarDatosCumpleanero(paciente_id);
      }else{
        mostrarCita(arg.event.id);
      }
    },
    editable: false,
    dayMaxEvents: true, // allow "more" link when too many events

  });

  calendar.setOption('locale', 'es');


    
  calendar.render();
  
  
    
});

</script>
   
<style>

  body {
    margin: 40px 10px;
    padding: 0;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
  }

  #calendar {
    max-width: 1100px;
    margin: 0 auto;
  }

</style>

@endpush

@section('content')
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Agenda</h3>
                        </div>
                    </div>
                </div>

                <div class="col-12 mx-0">
                    <div id='calendar'></div>
                    
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


<div class="modal fade" id="modalRegistrarCita" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  
</div>

<div class="modal fade" id="modalQR" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  
</div>
@endsection


@push('js')

<script>
    
document.addEventListener('DOMContentLoaded', function() {
  cargarEventos();
});

function cargarEventos(){
    let datos={
        _token : $('meta[name="csrf-token"]').attr('content')
    }
    $.ajax({
      url: "{{ route('agenda.obtenerCitas') }}", 
      method: 'POST',
      data: datos,
      success: function (response) {
        console.log(response);
        // Manejar la respuesta exitosa del servidor
        const citas = response.citas;
        const cumpleaneros = response.cumpleaneros;
        citas.forEach(function (cita) {
          agregarCita(cita.id,cita.fecha, cita.hora_inicio, cita.hora_fin, cita.motivo, cita.nombre_doctor+' '+cita.apellido_doctor, cita.nombre_paciente+' '+cita.apellido_paciente, cita.ultimo_estado);
        });
        cumpleaneros.forEach(function (cumpleanero) {
          agregarCumple(cumpleanero);
        });
      },
      error: function (error) {
        // Manejar errores en la solicitud AJAX
        console.error('Error en la solicitud AJAX:', error);
      }
    });
  

}

function mostrarModalRegistrarCita(arg){
    const fechaCalendario =(arg.startStr.split('T'))[0];
    
    console.log('arumento:::',arg);
    
    console.log('entro a mostrarModalRegistrarCita');
    let doctores_activos_opciones="";
    @foreach($doctores_activos as $doctor_activo)
    doctores_activos_opciones +=`<option value="{{$doctor_activo->id}}" >{{$doctor_activo->nombres." ".$doctor_activo->apellidos}}</option>`;
    @endforeach
    let pacientes_activos_opciones="";
    @foreach($pacientes_activos as $paciente_activo)
    pacientes_activos_opciones +=`<option value="{{$paciente_activo->id}}" data-whatsapp="{{$paciente_activo->celular}}">{{$paciente_activo->ci." - ".$paciente_activo->nombres." ".$paciente_activo->apellidos}}</option>`;
    @endforeach
    
    const opcionesDoctores =
    $('#modalRegistrarCita').empty();
    var contenidoModal = 
      `
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Cita</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p id=""></p>

            <div class="col-lg-12 form-group">
                <label class="form-control-label" for="input-fecha_cita">{{ __('Fecha') }}</label>
                <input type="date" name="fecha_nacimiento" id="input-fecha_cita" class="form-control form-control-alternative" value="${fechaCalendario}">
            </div>

            <div class="col-lg-12 form-group">
                <label class="form-control-label" for="input-hora_inicio">{{ __('Hora Inicio') }}</label>
            <input type="time" id="input-hora_inicio" name="input-hora_inicio" min="00:00" max="23:59" class="form-control form-control-alternative" required />
            </div>

            <div class="col-lg-12 form-group">
                <label class="form-control-label" for="input-hora_fin">{{ __('Hora Fin') }}</label>
            <input type="time" id="input-hora_fin" name="input-hora_fin" min="00:00" max="23:59" class="form-control form-control-alternative" required />
            </div>

            <div class="col-lg-12 form-group">
                <label class="form-control-label" for="input-motivo">{{ __('Motivo') }}</label>
                <select class="form-control  form-control-alternative" name="motivo"
                    id="input-motivo">
                    <option value="consulta" >Consulta</option>
                    <option value="tratamiento" >Tratamiento</option>
                    
                </select>
            </div>  
            <div class="col-lg-12 form-group">
                <label class="form-control-label" for="input-doctor">{{ __('Doctor') }}</label>
                <select id="input-doctor" name="doctor" data-live-search="true" data-live-search-style="startsWith" class="selectpicker form-control form-control-alternative" >
                    ${doctores_activos_opciones}
                </select>
            </div> 

            <div class="col-lg-12 form-group d-flex flex-column ">
                <label class="form-control-label mb-2" for="input-doctor">{{ __('Paciente') }}</label>
                <div class="d-flex align-items-center">
                    <select id="input-paciente" name="doctor" data-live-search="true" data-live-search-style="startsWith" class="selectpicker form-control form-control-alternative mr-2">
                        ${pacientes_activos_opciones}
                    </select>
                    `;
                    @if(isset($pacientes_activos[0]))
contenidoModal +=`
                    <a id="whatsapp-button" href="whatsapp://send?phone=591{{$pacientes_activos[0]->celular}}">
                        <button class="btn btn-icon btn-2 btn-primary" type="button">
                          <span class="btn-inner--icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                  fill="currentColor" class="bi bi-whatsapp"
                                  viewBox="0 0 16 16">
                                  <path
                                      d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                              </svg>
                          </span>
                        </button>
                    </a>
                    `;
                    @endif
contenidoModal +=`
                </div>
            </div>

            <div class="col-lg-12 form-group">
                <label class="form-control-label" for="input-estado_confirmacion">{{ __('Estado Confirmación') }}</label>
                <select class="form-control  form-control-alternative" name="motivo"
                    id="input-estado_confirmacion">
                    <option value="sin confirmar" >Sin confirmar</option>
                    <option value="confirmada" >Confirmada</option>
                    <option value="cancelada" >Cancelada</option>
                    <option value="asistio" >Asistió</option>
                </select>
            </div> 

      
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary" onClick="registrarCita()" >Aceptar</button>
          </div>
        </div>
      </div>
      `;

      
      $('#modalRegistrarCita').append(contenidoModal);

      $('#modalRegistrarCita').modal('show');
      const pacientesSelect = document.querySelector('#input-paciente');
      const whatsappButton = document.querySelector('#whatsapp-button');

      pacientesSelect.addEventListener('change', () => {
          const selectedPatientIndex = pacientesSelect.selectedIndex;
          const selectedPatientWhatsApp = pacientesSelect.options[selectedPatientIndex].getAttribute('data-whatsapp');

          whatsappButton.href = `whatsapp://send?phone=591${selectedPatientWhatsApp}`;
      });

      
}

function registrarCita(){
  console.log('horainicio:::::', $('#input-hora_inicio').val());
    let datos={
        _token : $('meta[name="csrf-token"]').attr('content'),
        fecha:$('#input-fecha_cita').val(),
        hora_inicio:$('#input-hora_inicio').val(),
        hora_fin:$('#input-hora_fin').val(),
        doctor_id:$('#input-doctor').val(),
        paciente_id:$('#input-paciente').val(),
        motivo: $('#input-motivo').val(),
        estado: $('#input-estado_confirmacion').val()
    }
    $.ajax({
      url: "{{ route('agenda.store') }}", 
      method: 'POST',
      data: datos,
      success: function (response) {

        // Manejar la respuesta exitosa del servidor
        console.log('Solicitud exitosa:', response);
        agregarCita(response.cita.id, response.cita.fecha,response.cita.hora_inicio,response.cita.hora_fin,  response.cita.motivo, response.cita.nombre_doctor+' '+response.cita.apellido_doctor, response.cita.nombre_paciente+' '+ response.cita.apellido_paciente, response.cita.estado);
      },
      error: function (error) {
        // Manejar errores en la solicitud AJAX
        console.error('Error en la solicitud AJAX:', error);
      }
    });
    $('#modalRegistrarCita').modal('hide');
  
}

function agregarCita(cita_id, fecha,hora_inicio,hora_fin, motivo, nombre_doctor, nombre_paciente, estado){
  let color = '';

switch (estado) {
    case "sin confirmar":
        color = '#FFF176';
        break;
    case "confirmada":
        color = '#ffaf49';
        break;
    case "cancelada":
        color = '#EF5350';
        break;    
    case "asistio":
        color = '#66BB6A';
        break;
    default:
        color = '#E0E0E0';
}

  calendar.addEvent({
      id:  cita_id,
      title: 'Dr:'+nombre_doctor+' - '+nombre_paciente+' - Motivo:'+motivo,
      start: fecha+'T'+hora_inicio,
      end: fecha+'T'+hora_fin,
      color: color,
      textColor: 'black'
    });
}

function agregarCumple(cumpleanero){
  let color = '#80D8FF';

  calendar.addEvent({
      id:  'cumpleanio'+cumpleanero.id,
      title: 'Cumpleaños de '+cumpleanero.apellidos+' '+cumpleanero.nombres,
      allDay : true,
      start: cumpleanero.fecha_cumpleanio,
      color: color,
      textColor: 'black'
    });
}


function mostrarCita(cita_id){
const datos={
  _token : $('meta[name="csrf-token"]').attr('content'),
  cita_id: cita_id
}
$.ajax({
      url: "{{ route('agenda.obtenerCita') }}", 
      method: 'POST',
      data: datos,
      success: function (response) {
        mostrarModalDatosCita(response.cita, response.mensaje);
      },
      error: function (error) {
        // Manejar errores en la solicitud AJAX
        console.error('Error en la solicitud AJAX:', error);
      }
    });
}


function  mostrarModalDatosCita(cita, mensaje){
    const fechaCalendario =cita.fecha;
    let opcionesDoctores ="";
    @foreach($doctores_activos as $doctor_activo)
    if({{$doctor_activo->id}} !== cita.recurso_humano_id){
      opcionesDoctores +=`<option value="{{$doctor_activo->id}}" >{{$doctor_activo->nombres." ".$doctor_activo->apellidos}}</option>`;
    }else{
      opcionesDoctores +=`<option value="{{$doctor_activo->id}}" selected >{{$doctor_activo->nombres." ".$doctor_activo->apellidos}}</option>`;
    }
    @endforeach
    let opcionesPacientes="";
    @foreach($pacientes_activos as $paciente_activo)
    if({{$paciente_activo->id}} !== cita.paciente_id){
      opcionesPacientes +=`<option value="{{$paciente_activo->id}}" >{{$paciente_activo->ci." - ".$paciente_activo->nombres." ".$paciente_activo->apellidos}}</option>`;
    }else{
      opcionesPacientes +=`<option value="{{$paciente_activo->id}}" selected >{{$paciente_activo->ci." - ".$paciente_activo->nombres." ".$paciente_activo->apellidos}}</option>`;
    }
    @endforeach
    
    $('#modalRegistrarCita').empty();
    var banner = '';
    if(cita.ultimo_estado=='sin confirmar'){
      banner =`<div class="row "> <h3><span  class="badge  badge-dark" style="background-color: #FFF176;">SIN CONFIRMAR</span></h3>
                <a id="whatsapp-button" href="https://wa.me/591${cita.celular_paciente}?text=${mensaje}" >
                <button class="btn btn-sm btn-icon btn-2 btn-primary" type="button">Solicitar Confirmación
                  <span class="btn-inner--icon">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                          fill="currentColor" class="bi bi-whatsapp"
                          viewBox="0 0 16 16">
                          <path
                              d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                      </svg>
                  </span>
                </button>
                </a>
                </div>
      `;
    }
    if(cita.ultimo_estado=='confirmada'){
    banner =`<h3><span class="badge  badge-dark" style="background-color: #ffaf49;">CONFIRMADA</span></h3>`;
    }
    if(cita.ultimo_estado=='cancelada'){
    banner =`<h3><span  class="badge  badge-dark" style="background-color: #EF5350;">CANCELADA</span></h3>`;
    }
    if(cita.ultimo_estado=='asistio'){
    banner =`<h3><span  class="badge  badge-dark" style="background-color: #66BB6A;">ASISTIO</span></h3>`;
    }

    var contenidoModal = 
      `<div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cita</h5><div class="col-1"></div>
            @can('administrar_agenda')
            <button class="btn btn-sm btn-icon btn-2 btn-primary" type="button" onClick="cargarEditarCita(${cita.id})">
                                                <span class="btn-inner--icon"><i class="fas fa-edit"></i></span>
                                            </button>
            @endcan
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <div class="col-lg-12 form-group">
            ${banner}
          </div>
            <div class="col-lg-12 form-group">
                <label class="form-control-label" for="input-fecha_cita">{{ __('Fecha') }}</label>
                <br>
                <span class="description">${cita.fecha}</span>
            </div>

            <div class="col-lg-6 form-group">
                <label class="form-control-label" for="input-fecha_cita">{{ __('Hora') }}</label>
                <br>
                <span class="description">${cita.hora_inicio.slice(0, 5)}</span> - <span class="description">${cita.hora_fin.slice(0, 5)}</span>
            </div>
            

            <div class="col-lg-12 form-group">
                <label class="form-control-label" for="input-motivo">{{ __('Motivo') }}</label>
                <br>
                <span  class="description">${cita.motivo}</span>
            </div>  
            <div class="col-lg-12 form-group">
                <label class="form-control-label" for="input-doctor">{{ __('Doctor') }}</label>
                <br>
                <span  class="description">${cita.nombre_doctor+' '+cita.apellido_doctor}</span>
                
            </div> 


            <div class="col-lg-12 form-group d-flex flex-column ">
                <label class="form-control-label mb-2" for="input-doctor">{{ __('Paciente') }}</label>
                <div class="d-flex align-items-center">
                <br>
                <span  class="description" style="margin-right: 10px;">${cita.nombre_paciente+' '+cita.apellido_paciente}</span>
                    <a id="whatsapp-button" href="whatsapp://send?phone=591${cita.celular_paciente}">
                        <button class="btn btn-icon btn-2 btn-primary" type="button">
                          <span class="btn-inner--icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                  fill="currentColor" class="bi bi-whatsapp"
                                  viewBox="0 0 16 16">
                                  <path
                                      d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                              </svg>
                          </span>
                        </button>
                    </a>
                </div>
            </div>
  
          </div>
        </div>
      </div>
      `;

      
      $('#modalRegistrarCita').append(contenidoModal);
      $('#modalRegistrarCita').modal('show');
}

function cargarEditarCita(cita_id){
  const datos={
  _token : $('meta[name="csrf-token"]').attr('content'),
  cita_id: cita_id
  }
  $.ajax({
      url: "{{ route('agenda.obtenerCita') }}", 
      method: 'POST',
      data: datos,
      success: function (response) {
        mostrarModalEditarCita(response.cita);
      },
      error: function (error) {
        // Manejar errores en la solicitud AJAX
        console.error('Error en la solicitud AJAX:', error);
      }
  });
}

function mostrarModalEditarCita(cita){
    console.log(cita);
    const fechaCalendario =cita.fecha;
    let opcionesDoctores ="";
    @foreach($doctores_activos as $doctor_activo)
    if({{$doctor_activo->id}} !== cita.recurso_humano_id){
      opcionesDoctores +=`<option value="{{$doctor_activo->id}}" >{{$doctor_activo->nombres." ".$doctor_activo->apellidos}}</option>`;
    }else{
      opcionesDoctores +=`<option value="{{$doctor_activo->id}}" selected >{{$doctor_activo->nombres." ".$doctor_activo->apellidos}}</option>`;
    }
    @endforeach
    let opcionesPacientes="";
    @foreach($pacientes_activos as $paciente_activo)
    if({{$paciente_activo->id}} !== cita.paciente_id){
      opcionesPacientes +=`<option value="{{$paciente_activo->id}}" >{{$paciente_activo->ci." - ".$paciente_activo->nombres." ".$paciente_activo->apellidos}}</option>`;
    }else{
      opcionesPacientes +=`<option value="{{$paciente_activo->id}}" selected >{{$paciente_activo->ci." - ".$paciente_activo->nombres." ".$paciente_activo->apellidos}}</option>`;
    }
    @endforeach
    let opcionesEstado="";
    const estados = ["sin confirmar", "confirmada", "cancelada", "asistio"];
    estados.forEach(function(estado) {
      if(cita.ultimo_estado == estado){
        opcionesEstado +=`<option value="${estado}" selected>${estado}</option>`;
      }else{
        opcionesEstado +=`<option value="${estado}" >${estado}</option>`;
      }
      
    // Tu código aquí para cada elemento del array
});
 
    $('#modalRegistrarCita').empty();
    var contenidoModal = 
      `
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar Cita</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-lg-12 form-group">
                <label class="form-control-label" for="input-fecha_cita">{{ __('Fecha') }}</label>
                <input type="date" name="fecha_nacimiento" id="input-fecha_cita" class="form-control form-control-alternative" value="${fechaCalendario}">
            </div>
            <div class="col-lg-12 form-group">
                <label class="form-control-label" for="input-hora_inicio">{{ __('Hora Inicio') }}</label>
            <input type="time" id="input-hora_inicio" name="input-hora_inicio" min="00:00" max="23:59" class="form-control form-control-alternative" required value="${cita.hora_inicio}" />
            </div>

            <div class="col-lg-12 form-group">
                <label class="form-control-label" for="input-hora_fin">{{ __('Hora Fin') }}</label>
            <input type="time" id="input-hora_fin" name="input-hora_fin" min="00:00" max="23:59" class="form-control form-control-alternative" required value="${cita.hora_fin}"/>
            </div>
            <div class="col-lg-12 form-group">
                <label class="form-control-label" for="input-motivo">{{ __('Motivo') }}</label>
                <select class="form-control  form-control-alternative" name="motivo"
                    id="input-motivo">`;
      if(cita.motivo == 'consulta'){              
        contenidoModal +=`<option value="consulta" selected>Consulta</option>
                          <option value="tratamiento" >Tratamiento</option>`;
      }else{
        contenidoModal +=`<option value="consulta" >Consulta</option>
                          <option value="tratamiento" selected >Tratamiento</option>`;
      }              
      contenidoModal +=  `</select>
            </div>  
            <div class="col-lg-12 form-group">
                <label class="form-control-label" for="input-doctor">{{ __('Doctor') }}</label>
                <select id="input-doctor" name="doctor" data-live-search="true" data-live-search-style="startsWith" class="selectpicker form-control form-control-alternative" >
                    ${opcionesDoctores}
                </select>
            </div> 
            <div class="col-lg-12 form-group">
                <label class="form-control-label" for="input-doctor">{{ __('Paciente') }}</label>
                <select id="input-paciente" name="doctor" data-live-search="true" data-live-search-style="startsWith" class="selectpicker form-control form-control-alternative" >
                    ${opcionesPacientes}
                </select>
            </div> 
            <div class="col-lg-12 form-group">
                <label class="form-control-label" for="input-estado_confirmacion">{{ __('Estado Confirmación') }}</label>
                <select class="form-control  form-control-alternative" name="motivo"
                    id="input-estado_confirmacion">
                    ${opcionesEstado}
                </select>
            </div> 
      
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary" onClick="actualizarCita(${cita.id})" >Aceptar</button>
          </div>
        </div>
      </div>
      `;

      
      $('#modalRegistrarCita').append(contenidoModal);
      $('#modalRegistrarCita').modal('show');
      
}

function actualizarCita(cita_id){
  let datos={
        _token : $('meta[name="csrf-token"]').attr('content'),
        cita_id: cita_id,
        fecha: $('#input-fecha_cita').val(),
        hora_inicio: $('#input-hora_inicio').val(),
        hora_fin: $('#input-hora_fin').val(),
        doctor_id: $('#input-doctor').val(),
        paciente_id: $('#input-paciente').val(),
        motivo: $('#input-motivo').val(),
        estado: $('#input-estado_confirmacion').val()
    }
    $.ajax({
      url: "{{ route('agenda.update') }}", 
      method: 'POST',
      data: datos,
      success: function (response) {
        const nombre_paciente = response.cita.nombre_paciente+' '+response.cita.apellido_paciente;
        const nombre_doctor = response.cita.nombre_doctor+' '+response.cita.apellido_doctor; 
        const motivo = response.cita.motivo;
        let color='';
        switch (response.estado_confirmacion) {
            case "sin confirmar":
                color = '#FFF176';
                break;
            case "confirmada":
                color = '#ffaf49';
                break;
            case "cancelada":
                color = '#EF5350';
                break;    
            case "asistio":
                color = '#66BB6A';
                break;
            default:
                color = '#E0E0E0';
        }
        
        var eventoExistente = calendar.getEventById(response.cita.id);

        if (eventoExistente) {
          
            eventoExistente.setProp('title', 'Dr:'+nombre_doctor+' - '+nombre_paciente+' - Motivo:'+motivo);
            eventoExistente.setStart(response.cita.fecha+'T'+response.cita.hora_inicio);
            eventoExistente.setEnd(response.cita.fecha+'T'+response.cita.hora_fin);
            eventoExistente.setProp('color', color); // Reemplaza con la nueva fecha de inicio
          
            calendar.render();
        }
      },
      error: function (error) {
        // Manejar errores en la solicitud AJAX
        console.error('Error en la solicitud AJAX:', error);
      }
    });
    $('#modalRegistrarCita').modal('hide');
}



function mostrarDatosCumpleanero(cumpleanero_id){
  console.log('es cumple de:',cumpleanero_id);
  const datos={
  _token : $('meta[name="csrf-token"]').attr('content'),
  paciente_id: cumpleanero_id
  }
  $.ajax({
      url: "/paciente/obtenerDatosCumpleanero", 
      method: 'POST',
      data: datos,
      success: function (response) {
        mostrarModalDatosCumpleanero(response.paciente, response.mensaje);
      },
      error: function (error) {
        // Manejar errores en la solicitud AJAX
        console.error('Error en la solicitud AJAX:', error);
      }
  });
}

function  mostrarModalDatosCumpleanero(paciente, mensaje){
  $('#modalRegistrarCita').empty();
    var contenidoModal = 
      `
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Paciente COD:${paciente.codigo}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-lg-12 form-group">
                <h3>Cumpleaños de ${paciente.apellidos} ${paciente.nombres}</h3>
            </div>
            
            <a id="whatsapp-button" href="https://wa.me/591${paciente.celular}?text=${mensaje}">

                        <button class="btn btn-icon btn-2 btn-primary" type="button">Envíale una felicitación 
                          <span class="btn-inner--icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                  fill="currentColor" class="bi bi-whatsapp"
                                  viewBox="0 0 16 16">
                                  <path
                                      d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                              </svg>
                          </span>
                        </button>
            </a>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
      `;

      
      $('#modalRegistrarCita').append(contenidoModal);
      $('#modalRegistrarCita').modal('show');
}
</script>


@endpush