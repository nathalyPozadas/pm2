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
                            <h3 class="mb-0">Reporte Ingresos</h3>
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
                                <label class="form-control-label">Paciente</label>
                                <select id="selectorPaciente" class="form-control form-control-alternative">
                                    <option value="0">Todos</option>
                                    @foreach($pacientes as $paciente)
                                        <option value='{{$paciente->id}}'>{{$paciente->nombres.' '.$paciente->apellidos}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-control-label">Tratamiento</label>
                                <select id="selectorTratamiento" class="form-control form-control-alternative">
                                    <option value="0">Todos</option>
                                    @foreach($tratamientos as $tratamiento)
                                        <option value='{{$tratamiento->id}}'>{{$tratamiento->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-control-label">Situacion</label>
                                <select id="selectorSituacion" class="form-control form-control-alternative">
                                    <option value="0">Todos</option>
                                    @foreach($situaciones as $situacion)
                                        <option value='{{$situacion->id}}'>{{$situacion->nombre}}</option>
                                    @endforeach
                                </select>
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
                                <button id="btn-actualizar-graficas" onClick="actualizarGraficas()" class=" form-control btn btn-primary">
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

                        <div class="">
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="ml-4 mb-4">Ingresos mensuales (Bs.)</div>
                                        <canvas id="graficoMensual"></canvas>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="ml-4 mb-2">Ingresos anuales (Bs.)</div>
                                    <canvas id="graficoAnual"></canvas>
                                </div>  
                            </div>      
                            <div class="row">

                                <div class="col-6 ">

                                    <div class="ml-4 mb-4 mt-4">Ingresos por pacientes</div>
                                    <div class="table-responsive px-4">
                                        <table id="tablaPacientes" class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Nombre</th>
                                                    <th scope="col">Monto total (Bs.)</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($listaPacientes as $paciente)
                                                <tr>
                                                    <td>{{$paciente->nombres.' '.$paciente->apellidos}}</td>
                                                    <td>{{$paciente->total_pagado}}</td>
                                                    <td class="text-right">
                                                        <a href="{{ route('paciente.show',['id'=>$paciente->id]) }}">
                                                            <button class="btn btn-icon btn-2 btn-primary" type="button">

                                                                <span class="btn-inner--icon"><i class="fas fa-eye"></i></span>
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>


                                </div>

                                <div class="col-6 ">
                                    <div class="ml-4 mb-4 mt-4">Ingresos por doctores</div>
                                    <div class="table-responsive px-4">
                                        <table id="tablaDoctores" class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Nombre</th>
                                                    <th scope="col">Monto total [BS]</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($listaDoctores as $doctor)
                                                <tr>
                                                    <td>{{$doctor->nombres.' '.$doctor->apellidos}}</td>
                                                    <td>{{$doctor->total_pagado}}</td>
                                                    <td class="text-right">
                                                        <a href="{{ route('rrhh.show',['id'=>$doctor->id]) }}">
                                                            <button class="btn btn-icon btn-2 btn-primary" type="button">

                                                                <span class="btn-inner--icon"><i class="fas fa-eye"></i></span>
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                            
                                
                            </div>

                            <div class="row">

                                <div class="col-12 ">

                                    <div class="ml-4 mb-4 mt-4">Detalle de ingresos</div>
                                    <div class="table-responsive px-4">
                                        <table id="tablaDetalleIngresos" class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col">Código Paciente</th>
                                                    <th scope="col">Nombre Paciente</th>
                                                    <th scope="col">Monto Pagado</th>
                                                    <th scope="col">Tratamiento</th>
                                                    <th scope="col">Costo Tratamiento</th> 
                                                    <th scope="col">A cuenta</th> 
                                                    <th scope="col">Saldo</th>
                                                    <th scope="col">Detalle</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($pagos as $pago)
                                                <tr>
                                                    <td>{{\Carbon\Carbon::parse($pago->fecha)->format('d-m-Y')}}</td>
                                                    <td>{{$pago->paciente_codigo}}</td>
                                                    <td>{{$pago->paciente_apellidos.' '.$pago->paciente_nombres}}</td>
                                                    <td>{{$pago->monto_pagado}}</td>
                                                    <td>{{$pago->tratamiento_nombre}}</td>
                                                    <td>{{$pago->tratamiento_aplicado_precio}}</td>
                                                    <td>{{$pago->monto_acumulado}}</td>
                                                    <td>{{$pago->tratamiento_aplicado_precio-$pago->monto_acumulado}}</td>
                                                    <td>{{'odontograma('.$pago->odontograma_identificador.')-'.$pago->tratamiento_nombre.'-'.$pago->situacion_nombre.'-pieza#'.$pago->diente_pieza}}</td>
                                                    <td class="text-right">
                                                        <a href="{{ route('odontograma.edit' ,['id'=>$pago->paciente_id,'odontograma_id'=>$pago->odontograma_id ]) }}">
                                                                <button class="btn btn-icon btn-2 btn-primary" type="button">
                                                                    <span class="btn-inner--icon"><i class="fas fa-eye"></i></span>
                                                                </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>


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

//GRAFICA MENSUAL
    let datosGraficaPagosMensual = @json($datosGraficaPagosMensual);
    console.log('datosmensual::', datosGraficaPagosMensual);

    let listaPacientes = @json($listaPacientes);
    console.log('listaPacientes::', listaPacientes);
    let pagos = @json($pagos);
    console.log('pagos::', pagos);

    var ctx = document.getElementById('graficoMensual').getContext('2d');
        var registrosPorMes = @json($datosGraficaPagosMensual);

        var labels = Object.keys(registrosPorMes);
        // Lista de colores predefinidos
        var colores = ['#9965f4', '#c6f68d', '#EF9A9A', '#FFFF33', '#4DB6AC', '#42A5F5', '#FF5733', '#33FF57', '#5733FF', '#FFFF33', '#33FFFF', '#DCE775'];

        var datasets = Object.keys(registrosPorMes[labels[0]]).map(function (anio, index) {
            return {
                label: 'Año ' + anio,
                data: labels.map(function (mes) {
                    return registrosPorMes[mes][anio];
                }),
                backgroundColor: colores[index % colores.length], 
                borderColor: colores[index % colores.length],
                borderWidth: 1
            };
        });

        var chartIngresosMensual = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels.map(function (mes) {
                    return new Intl.DateTimeFormat('es', { month: 'long' }).format(new Date(2000, mes - 1, 1));
                }),
                datasets: datasets
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

//GRAFICA ANUAL

var ctx = document.getElementById('graficoAnual').getContext('2d');
        var ingresosPorAnio = @json($datosGraficaPagosAnual);

        var chartIngresosAnual = new Chart(ctx, {
            type: 'bar', 
            data: {
                labels: Object.keys(ingresosPorAnio), 
                datasets: [{
                    label: 'Cantidad de Registros',
                    data: Object.values(ingresosPorAnio),
                    backgroundColor: '#4FC3F7'              
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

//datatables 
        
    var tablaPacientes = $('#tablaPacientes').DataTable({
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
                    doc.content[0].text = 'Ingresos por Pacientes';
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

    var tablaDoctores = $('#tablaDoctores').DataTable({
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
                    doc.content[0].text = 'Ingresos por Doctor';
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

    var tablaDetalleIngresos = $('#tablaDetalleIngresos').DataTable({
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
                    doc.content[0].text = 'Detalle de Ingresos';
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
        window.location.href = '{{ route('reporte.ingresos') }}';
    });


    function actualizarGraficas(){
        let fecha_inicio = document.getElementById('fecha_inicio').value;
        let fecha_fin = document.getElementById('fecha_fin').value;
        let paciente_id = document.getElementById('selectorPaciente').value;
        let doctor_id = document.getElementById('selectorDoctor').value;
        let situacion_id = document.getElementById('selectorSituacion').value;
        let tratamiento_id = document.getElementById('selectorTratamiento').value;
        var token = $('meta[name="csrf-token"]').attr('content');

        fetch("{{ route('reporte.ingresos2') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        _token: token,
                        fecha_inicio: fecha_inicio, 
                        fecha_fin: fecha_fin,
                        doctor_id: doctor_id,
                        paciente_id: paciente_id,
                        tratamiento_id: tratamiento_id,
                        situacion_id: situacion_id
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    //actualizando grafica mensual
                    var datosMensual = data.datosGraficaPagosMensual;
                    var labelsMensual = Object.keys(datosMensual);
                
                    datasets = Object.keys(datosMensual[labelsMensual[0]]).map(function (anio, index) {
                        return {
                            label: 'Año ' + anio,
                            data: labels.map(function (mes) {
                                return datosMensual[mes][anio];
                            }),
                            backgroundColor: colores[index % colores.length], 
                            borderColor: colores[index % colores.length],
                            borderWidth: 1
                        };
                    });
                    chartIngresosMensual.data.datasets = datasets;
                    chartIngresosMensual.update();

                    //actualizando grafica anual
                    var datosAnual = data.datosGraficaPagosAnual;
                    chartIngresosAnual.data.labels = Object.keys(datosAnual);
                    chartIngresosAnual.data.datasets[0].data = Object.values(datosAnual);
                    chartIngresosAnual.update();

                    //actualizando datatables pacientes
                    $('#tablaPacientes').DataTable().destroy();

                    // Limpia el cuerpo de la tabla
                    $('#tablaPacientes tbody').empty();

                    // Itera sobre los nuevos datos y rellena la tabla
                    data.listaPacientes.forEach(function(paciente) {
                        var pacienteUrl = '{{ route("paciente.show", ["id" => ":id"]) }}';
                        pacienteUrl = pacienteUrl.replace(':id', paciente.id);

                        var newRow = '<tr>' +
                            '<td>' + paciente.nombres + ' ' + paciente.apellidos + '</td>' +
                            '<td>' + paciente.total_pagado + '</td>' +
                            '<td class="text-right">' +
                            '<a href="' + pacienteUrl + '">' +
                            '<button class="btn btn-icon btn-2 btn-primary" type="button">' +
                            '<span class="btn-inner--icon"><i class="fas fa-eye"></i></span>' +
                            '</button>' +
                            '</a>' +
                            '</td>' +
                            '</tr>';

                        $('#tablaPacientes tbody').append(newRow);
                    });


                    // Vuelve a inicializar la tabla con los nuevos datos
                    $('#tablaPacientes').DataTable({
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
                                    doc.content[0].text = 'Pacientes';
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

                    //actualizando datatables doctores
                    $('#tablaDoctores').DataTable().destroy();

                    $('#tablaDoctores tbody').empty();

                    data.listaDoctores.forEach(function(doctor) {
                        var doctorUrl = '{{ route("rrhh.show", ["id" => ":id"]) }}';
                        doctorUrl = doctorUrl.replace(':id', doctor.id);

                        var newRow = '<tr>' +
                            '<td>' + doctor.nombres + ' ' + doctor.apellidos + '</td>' +
                            '<td>' + doctor.total_pagado + '</td>' +
                            '<td class="text-right">' +
                            '<a href="' + doctorUrl + '">' +
                            '<button class="btn btn-icon btn-2 btn-primary" type="button">' +
                            '<span class="btn-inner--icon"><i class="fas fa-eye"></i></span>' +
                            '</button>' +
                            '</a>' +
                            '</td>' +
                            '</tr>';

                        $('#tablaDoctores tbody').append(newRow);
                    });

                    // Vuelve a inicializar la tabla con los nuevos datos
                    $('#tablaDoctores').DataTable({
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
                                    doc.content[0].text = 'Ingresos por Doctor';
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

                    //actualizando datatables doctores
                    $('#tablaDetalleIngresos').DataTable().destroy();

                    $('#tablaDetalleIngresos tbody').empty();



                    data.pagos.forEach(function(pago) {
                        var odontogramaUrl = '{{ route("odontograma.edit", ["id"=>":id","odontograma_id" => ":odontograma_id"]) }}';
                        odontogramaUrl = odontogramaUrl.replace(':id', pago.paciente_id);
                        odontogramaUrl = odontogramaUrl.replace(':odontograma_id', pago.odontograma_identificador);

                        var fechaFormateada = formatearFecha(pago.fecha);
                        var montoAcumulado = pago.tratamiento_aplicado_precio - pago.monto_acumulado;
                        var newRow = '<tr>' +
                            '<td>' + fechaFormateada + '</td>' +
                            '<td>' + pago.paciente_codigo + '</td>' +
                            '<td>' + pago.paciente_apellidos+' '+pago.paciente_nombres + '</td>' +
                            '<td>' + pago.monto_pagado +'</td>' +
                            '<td>' + pago.tratamiento_nombre +'</td>' +
                            '<td>' + pago.tratamiento_aplicado_precio +'</td>' +
                            '<td>' + pago.monto_acumulado +'</td>' +
                            '<td>' + montoAcumulado +'</td>' +
                            '<td>' + 'Odontograma('+pago.odontograma_identificador+')-'+pago.tratamiento_nombre+'-'+pago.situacion_nombre+'-pieza#'+pago.diente_pieza+'</td>' +
                            '<td class="text-right">' +
                            '<a href="' + odontogramaUrl + '">' +
                            '<button class="btn btn-icon btn-2 btn-primary" type="button">' +
                            '<span class="btn-inner--icon"><i class="fas fa-eye"></i></span>' +
                            '</button>' +
                            '</a>' +
                            '</td>' +
                            '</tr>';

                        $('#tablaDetalleIngresos tbody').append(newRow);
                    });

                    // Vuelve a inicializar la tabla con los nuevos datos
                    $('#tablaDetalleIngresos').DataTable({
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
                                    doc.content[0].text = 'Detalle de Ingresos';
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

                })
                .catch(error => {
                    console.error('Error en la consulta fetch:', error);
                });
    }

    function formatearFecha(fechaString){

        var partesFecha = fechaString.split("-");


        var fechaFormateada = partesFecha[2] + "-" + partesFecha[1] + "-" + partesFecha[0];
        return fechaFormateada;
    }


    
</script>
@endpush