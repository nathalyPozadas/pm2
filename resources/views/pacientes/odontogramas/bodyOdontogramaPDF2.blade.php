<div>
    <div style="text-align: right;">
        <h5>{{$fecha_actual}}</h5>
    </div>
    <div class="titulo">
        <h2>Odontograma #{{$odontograma_id}} </h2>
        @if($odontograma_estado == 'REVISION FINALIZADA')
            <div class="estado-fase2">{{$odontograma_estado}}</div>
        @else
            <div class="estado-fase3">{{$odontograma_estado}}</div>
        @endif
    </div>
</div>

<br>
<h3>Paciente: {{$paciente->apellidos . ' ' . $paciente->nombres}}</h3>
<br>

