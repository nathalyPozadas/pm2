@extends('welcome')

@push('header-js-lista')


  <script src="{{ asset('argon')}}/vendor/jquery-ui/jquery-ui.js"></script>
  <script src="{{ asset('argon')}}/vendor/chart.js/dist/Chart.min.js"></script>
  <script src="{{ asset('argon')}}/vendor/chart.js/dist/chartjs-plugin-datalabels.min.js"></script>

@endpush

@section('content')
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
            <div class="card-header border-0">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h3 class="mb-0">Reporte Pacientes</h3>
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

                        <div class="container p-0">
                            <div class="row">
                                <div class="col m-4">
                                    Genero
                                    <canvas id="graficoSexo"></canvas>
                                </div>
                                <div class="col m-4">
                                    Edad
                                    <canvas id="graficoEdad"></canvas>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-4">
                                    Mensual
                                    <canvas id="graficoMensual"></canvas>
                                </div>
                                <div class="col mb-4">
                                    Anual
                                    <canvas id="graficoAnual"></canvas>
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
    var datosGraficaAsistenciaAnual = @json($datosGraficoAnual);
    var datosGraficaAsistenciaMensual = @json($datosGraficoMensual);
    console.log('datos asistencia anual::',datosGraficaAsistenciaAnual);
    console.log('datos asistencia mensual::',datosGraficaAsistenciaMensual);
    //  GRAFICO GENERO
    var ctx = document.getElementById('graficoSexo').getContext('2d');
    var datos = @json($datosGraficoSexo);

    var chartSexo = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Hombres', 'Mujeres'],
        datasets: [{
            label: 'Cantidad',
            data: [datos.cantHombres, datos.cantMujeres],
            backgroundColor: ['#2196F3', '#F8BBD0'],
        }]
    },
    options: {
        legend: {
            display: true,
            position: 'right',
            labels: {
                boxWidth: 12,
                padding: 10
            }
        },
        tooltips: {
        enabled: false
         },
        plugins: {
        datalabels: {
            formatter: (value, ctx) => {
                let sum = 0;
                let dataArr = ctx.chart.data.datasets[0].data;
                dataArr.map(data => {
                    sum += data;
                });
                let percentage = (value*100 / sum).toFixed(2)+"%";
                return percentage;
            },
            color: '#fff',
        }
    }
    }
});


    //  GRAFICO EDAD    
    var ctx = document.getElementById('graficoEdad').getContext('2d');
    var datos = @json($datosGraficoEdad);

    var chartEdad = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Niños(0-14)', 'Jóvenes(15-17)','Adultos(18-70)','Adulto Mayor(>70)'],
            datasets: [{
                label: 'Cantidad',
                data: [datos.cantGrupo1, datos.cantGrupo2,datos.cantGrupo3,datos.cantGrupo4],
                backgroundColor: ['#B3E5FC','#AB47BC', '#FF8A65','#8D6E63'],
            }]
        },
        options: {
                legend: {
                    display: true,
                    position: 'right', 
                    labels: {
                        boxWidth: 12,
                        padding: 10  
                    }
                }
            }
    });

   


//  GRAFICOS MENSUAL
        var ctx = document.getElementById('graficoMensual').getContext('2d');
        var registrosPorMes = @json($datosGraficoMensual);

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

        var chartNuevosMensual = new Chart(ctx, {
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

//  GRAFICO ANUAL
        var ctx = document.getElementById('graficoAnual').getContext('2d');
        var registrosPorAnio = @json($datosGraficoAnual);

        var chartNuevosAnual = new Chart(ctx, {
            type: 'bar', 
            data: {
                labels: Object.keys(registrosPorAnio), 
                datasets: [{
                    label: 'Cantidad de Registros',
                    data: Object.values(registrosPorAnio),
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

    let btn_actualizar_graficas = document.getElementById('btn-actualizar-graficas');

    btn_actualizar_graficas.addEventListener('click', function() {
        actualizarGraficas();
    });

    let quitarFiltro = document.getElementById('quitarFiltro');

    quitarFiltro.addEventListener('click', function() {
        window.location.href = '{{ route('reporte.pacientes') }}';
    });

    function actualizarGraficas(){
    fecha_inicio = document.getElementById('fecha_inicio').value;
    fecha_fin = document.getElementById('fecha_fin').value;
    var token = $('meta[name="csrf-token"]').attr('content');

    fetch("{{ route('reporte.pacientes2') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    _token: token,
                    fecha_inicio: fecha_inicio, 
                    fecha_fin: fecha_fin
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                var datosSexo = data.datosGraficoSexo;
            chartSexo.data.datasets[0].data = [datosSexo.cantHombres, datosSexo.cantMujeres];
            chartSexo.update();

            var datosEdad = data.datosGraficoEdad;
            chartEdad.data.datasets[0].data = [datosEdad.cantGrupo1, datosEdad.cantGrupo2,datosEdad.cantGrupo3,datosEdad.cantGrupo4];
            chartEdad.update();

            var datosMensual = data.datosGraficoMensual;

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
            chartNuevosMensual.data.datasets = datasets;
            chartNuevosMensual.update();

            var datosAnual = data.datosGraficoAnual;
            chartNuevosAnual.data.labels = Object.keys(datosAnual);
            chartNuevosAnual.data.datasets[0].data = Object.values(datosAnual);
            chartNuevosAnual.update();
                
            })
            .catch(error => {
                console.error('Error en la consulta fetch:', error);
            });
    }
    
</script>



@endpush