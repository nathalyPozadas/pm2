@extends('welcome')

@push('header-js-lista')



    <script src="{{ asset('argon')}}/vendor/jquery-ui/jquery-ui.js"></script>
  <script src="{{ asset('argon')}}/vendor/chart.js/dist/Chart.min.js"></script>
  <script src="{{ asset('argon')}}/vendor/chart.js/dist/chartjs-plugin-datalabels.min.js"></script>
    <link href="{{ asset('dataTables') }}/datatables.min.css" rel="stylesheet">
    <script src="{{ asset('dataTables') }}/datatables.min.js"></script>
@endpush

@section('content')
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0" >

                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <h3 class="mb-0">Reporte Citas</h3>
                        </div>
                    </div>

                </div>

                <div class="col-12">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-control-label">Desde</label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control form-control-alternative" value="{{$fecha_inicio}}">
                                
                            </div>
                            <div class="col-md-2">
                                <label class="form-control-label">Hasta</label>
                                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control form-control-alternative" value="{{$fecha_fin}}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-control-label">Doctor</label>
                                <select id="selectorDoctor" class="form-control form-control-alternative">
                                    <option value="0">Todos</option>
                                    @foreach($doctores as $doctor)
                                        <option value='{{$doctor->id}}'>{{$doctor->nombres.' '.$doctor->apellidos}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label class="form-control-label"></label>
                                <button id="btn-actualizar-graficas" class=" form-control btn btn-primary">
                                    <span class="btn-inner--icon"><i class="fas fa-check"></i></span>
                                </button>
                            </div>
                            <div class="col-md-1">
                                <label class="form-control-label"></label>
                                <button id="quitarFiltro" class=" form-control btn btn-primary">
                                    <span class="btn-inner--icon"><i class="fas fa-times"></i></span>
                                </button>
                            </div>
                        </div>

                        <div class="col mx-5 mt-4">
                            <div class="row ">
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-3 d-flex flex-column align-items-start">
                                            <p class="mb-0">Total Citas agendadas:</p>
                                            <div class="text-center">
                                                <h1 id="cantidadCitasAgendadas" style="font-size: 4em;">{{$datosTotales['agendada']}}</h1>
                                            </div>
                                        </div>
                                        <div class="col-3 d-flex flex-column align-items-start mx-4">
                                            <p class="mb-0">Total Citas asistidas:</p>
                                            <div class="text-center">
                                                <h1 id="cantidadCitasAsistidas" style="font-size: 4em;">{{$datosTotales['asistio']}}</h1>
                                            </div>
                                        </div>
                                        <div class="col-3 d-flex flex-column align-items-start">
                                            <p class="mb-0">Total Citas canceladas:</p>
                                            <div class="text-center">
                                                <h1 id="cantidadCitasCanceladas" style="font-size: 4em;">{{$datosTotales['cancelada']}}</h1>
                                            </div>
                                        </div>
                                    </div>    
                                </div> 
                                <div class="col-5 ">
                                    Anual
                                    <canvas id="graficoAnual"></canvas>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-8 mx-auto">
                                    Mensual
                                    <canvas id="graficoMensual"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">

                                <div class="col-12 ">

                                    <div class="ml-4 mb-4 mt-4">Detalle de citas</div>
                                    <div class="table-responsive px-4">
                                        <table id="tablaCitas" class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col">Nombre Paciente</th>
                                                    <th scope="col">Nombre Doctor</th>
                                                    <th scope="col">Motivo</th>
                                                    <th scope="col">Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($citas as $cita)
                                                <tr>
                                                    <td>{{$cita->fecha}}</td>
                                                    <td>{{$cita->apellido_paciente.' '.$cita->nombre_paciente}}</td>
                                                    <td>{{$cita->apellido_doctor.' '.$cita->nombre_doctor}}</td>
                                                    <td>{{$cita->motivo}}</td>
                                                    <td>{{$cita->ultimo_estado}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>


                                </div>

                                
                            
                                
                            </div>
                    </div>
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
   let fecha_inicio = "{{$fecha_inicio}}";
   let fecha_fin = "{{$fecha_fin}}";

   var datosGraficaAsistenciaMensual = @json($datosGraficaAsistenciaMensual);
   var datosGraficaAsistenciaAnual = @json($datosGraficaAsistenciaAnual);

   console.log('datos asistencia mensual::',datosGraficaAsistenciaMensual);
    console.log('datos asistencia anual::',datosGraficaAsistenciaAnual);

   var ctx = document.getElementById('graficoMensual').getContext('2d');

    var registrosPorMes = @json($datosGraficaAsistenciaMensual);

    // Crear arrays separados para asistio y cancelada
    var asistioData = [];
    var canceladaData = [];
    var labels = [];

    Object.keys(registrosPorMes).forEach(function (mes) {
        Object.keys(registrosPorMes[mes]).forEach(function (anio) {
            labels.push(new Intl.DateTimeFormat('es', { month: 'long' }).format(new Date(2000, mes - 1, 1)) + ' - ' + anio);
            asistioData.push(registrosPorMes[mes][anio].asistio);
            canceladaData.push(registrosPorMes[mes][anio].cancelada);
        });
    });

    var chartCitasMensual = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Asistio',
                    data: asistioData,
                    backgroundColor: '#66BB6A',
                    borderWidth: 1
                },
                {
                    label: 'Cancelada',
                    data: canceladaData,
                    backgroundColor: '#EF5350',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                x: {
                    type: 'linear',
                    position: 'bottom'
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctx = document.getElementById('graficoAnual').getContext('2d');
    var citasPorAnio = @json($datosGraficaAsistenciaAnual);

    var asistioData = [];
    var canceladaData = [];
    var labels = Object.keys(citasPorAnio);

    labels.forEach(function (anio) {
        asistioData.push(citasPorAnio[anio].asistio);
        canceladaData.push(citasPorAnio[anio].cancelada);
    });

    var chartCitasAnual = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Asistio',
                    data: asistioData,
                    backgroundColor: '#66BB6A'
                },
                {
                    label: 'Cancelada',
                    data: canceladaData,
                    backgroundColor: '#EF5350'
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var tablaCitas = $('#tablaCitas').DataTable({
        searching: false, // Desactivar la función de búsqueda
        ordering: false ,
    language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "(_START_ al _END_) de _TOTAL_ resultados",
        "infoEmpty": "No se encontraron resultados",
        "infoFiltered": "(Filtrado de _MAX_ total resultados)",
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
    dom: 'Blfrtip',
        buttons: [
            {
                extend: 'copy',
                exportOptions: {
                    modifier: {
                        page: 'all'
                    }
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    modifier: {
                        page: 'all'
                    }
                }
            },
            {
                extend: 'excel',
                exportOptions: {
                    modifier: {
                        page: 'all'
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    modifier: {
                        page: 'all'
                    }
                },
                customize: function(doc) {
                    // Agrega un título al documento PDF
                    doc.content[0].text = 'Reporte de Citas';
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    modifier: {
                        page: 'all'
                    }
                }
            }
        ],
        lengthMenu: [10, 25, 50, 100], // Opciones del selector de longitud de la página
        pageLength: 10,
    });

    

        
    let btn_actualizar_graficas = document.getElementById('btn-actualizar-graficas');

    btn_actualizar_graficas.addEventListener('click', function() {
        actualizarGraficas();
    });

    let quitarFiltro = document.getElementById('quitarFiltro');

    quitarFiltro.addEventListener('click', function() {
        window.location.href = '{{ route('reporte.citas') }}';
    });


function actualizarGraficas(){
    if(validarFechas() == true){
        fecha_inicio = document.getElementById('fecha_inicio').value;
        fecha_fin = document.getElementById('fecha_fin').value;
        var token = $('meta[name="csrf-token"]').attr('content');
        var doctor_id = document.getElementById('selectorDoctor').value;

        fetch("{{ route('reporte.citas2') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        _token: token,
                        fecha_inicio: fecha_inicio, 
                        fecha_fin: fecha_fin,
                        doctor_id: doctor_id
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    var nuevosRegistrosPorMes = data.datosGraficaAsistenciaMensual;

                    asistioData = [];
                    canceladaData = [];
                    labels = [];

                    Object.keys(nuevosRegistrosPorMes).forEach(function (mes) {
                        Object.keys(nuevosRegistrosPorMes[mes]).forEach(function (anio) {
                            labels.push(new Intl.DateTimeFormat('es', { month: 'long' }).format(new Date(2000, mes - 1, 1)) + ' - ' + anio);
                            asistioData.push(nuevosRegistrosPorMes[mes][anio].asistio);
                            canceladaData.push(nuevosRegistrosPorMes[mes][anio].cancelada);
                        });
                    });

                    chartCitasMensual.data.labels = labels;
                    chartCitasMensual.data.datasets[0].data = asistioData;
                    chartCitasMensual.data.datasets[1].data = canceladaData;

                    chartCitasMensual.update();
            
                    var nuevosDatosGraficaAsistenciaAnual = data.datosGraficaAsistenciaAnual;

                    asistioData = [];
                    canceladaData = [];
                    labels = Object.keys(nuevosDatosGraficaAsistenciaAnual);

                    labels.forEach(function (anio) {
                        asistioData.push(nuevosDatosGraficaAsistenciaAnual[anio].asistio);
                        canceladaData.push(nuevosDatosGraficaAsistenciaAnual[anio].cancelada);
                    });

                    chartCitasAnual.data.labels = labels;
                    chartCitasAnual.data.datasets[0].data = asistioData;
                    chartCitasAnual.data.datasets[1].data = canceladaData;

                    // Redibuja el gráfico
                    chartCitasAnual.update();
                    
                    //MONTOS actualizar
                    let cantidadCitasAgendadas = document.getElementById('cantidadCitasAgendadas');
                    cantidadCitasAgendadas.innerHTML  = data.datosTotales.agendada;

                    let cantidadCitasAsistidas = document.getElementById('cantidadCitasAsistidas');
                    cantidadCitasAsistidas.innerHTML  = data.datosTotales.asistio;

                    let cantidadCitasCanceladas = document.getElementById('cantidadCitasCanceladas');
                    cantidadCitasCanceladas.innerHTML  = data.datosTotales.cancelada;
                    
                })
                .catch(error => {
                    console.error('Error en la consulta fetch:', error);
                });
            }
}

function validarFechas() {
            var fechaInicio = $('#fecha_inicio').val();
            var fechaFin = $('#fecha_fin').val();

            if (fechaInicio && fechaFin) {
        var dateInicio = new Date(fechaInicio);
        var dateFin = new Date(fechaFin);

        if (isNaN(dateInicio) || isNaN(dateFin) || dateInicio >= dateFin) {
            console.log('Fechas no válidas');
            // Mostrar un mensaje de error al usuario o realizar otras acciones
            alert('Por favor, ingresa fechas válidas y asegúrate de que fecha_inicio sea menor a fecha_fin.');
            return false;
        } else {
            console.log('Fechas válidas');
            return true;
        }
    } else {
        console.log('Fechas no válidas');
        // Mostrar un mensaje de error al usuario o realizar otras acciones
        alert('Por favor, ingresa fechas válidas.');
        return false;
    }
}


    
</script>



@endpush