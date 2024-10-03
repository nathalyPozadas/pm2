@extends('welcome')

@section('content')

@include('users.partials.headerPaciente')

<div class="container-fluid mt--7">
    <div class="row">

        <div class="col-xl-12 order-xl-1">

            <div class="card bg-secondary shadow">

            <div class="card-header bg-white border-0">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">{{ __('Exámenes Odontopediatría') }}</h3>
        <div class="d-flex">
            <div>
                    <a href="{{ route('certifiado_dientes',['id' => $paciente->id]) }}" target="_blank">
                        <button class="btn btn-icon btn-2 btn-primary" type="button">
                            <span class="btn-inner--icon"><i class="ni ni-paper-diploma"></i></span>
                            Certificado de dientes
                        </button>
                    </a>
            </div>
        </div>
    </div>
</div>

                <div class="card-body">
                    <h6 class="heading-small text-muted mb-4">{{ __('Examen clínico') }}</h6>
                    <div class="  pl-lg-4 pr-lg-4">
                        @can('administrar_odontopediatria')
                            <div class="row">
                                <a href="{{ !isset($examen_clinico) ? route('examen_clinico.create',['id' => $paciente->id]):  route('examen_clinico.edit',['id' => $paciente->id,'examen_clinico_id'=>$examen_clinico->id])}}">
                                    <button class="btn btn-icon btn-2 btn-primary" type="button">
                                    {{!isset($examen_clinico)? 'Registrar':'Actualizar'}}
                                    </button>
                                </a>
                            </div>
                        @endcan
                        @if(isset($examen_clinico))
                        <div class="row">
                            <div class="col-lg-3 form-group">
                                <label class="form-control-label" for="input-denticion">{{ __('Dentición') }}</label>
                                <br>
                                <span class="description">
                                        @switch($examen_clinico->denticion)
                                            @case('decidua')
                                                Decidua
                                                @break
                                            @case('mixta')
                                                Mixta
                                                @break
                                            @case('permanente')
                                                Permanente
                                                @break
                                            @default
                                                Por definir
                                        @endswitch
                                </span>
                            </div>

                            <div class="col-lg-3 form-group">
                                <label class="form-control-label" for="input-erupcion_dentaria">{{ __('Erupción dentaria') }}</label>
                                <br>
                                <span class="description">
                                        @switch($examen_clinico->erupcion_dentaria)
                                            @case('edad_adecuado')
                                                De acuerdo a la edad
                                                @break
                                            @case('tardia')
                                            Tardía
                                                @break
                                            @default
                                                Por definir
                                        @endswitch
                                </span>
                            </div>

                            <div class="col-lg-3 form-group">
                                <label class="form-control-label" for="input-erupcion_dentaria">{{ __('Respiración') }}</label>
                                <br>
                                <span class="description">
                                    {{$examen_clinico->respiracion?? '-'}}
                                </span>
                            </div>

                            <div class="col-lg-3 form-group">
                                <label class="form-control-label" for="input-fonacion">{{ __('Fonación') }}</label>
                                <br>
                                <span class="description">
                                    {{$examen_clinico->fonacion?? '-'}}
                                </span>
                            </div>    

                            <div class="col-lg-3 form-group">
                                <label class="form-control-label" for="input-audicion">{{ __('Audición') }}</label>
                                <br>
                                <span class="description">
                                    {{$examen_clinico->audicion?? '-'}}
                                </span>
                            </div> 

                                

                                
                            </div>

                            <h6 class="heading-small text-muted mb-4">{{ __('ATM') }}</h6>
                            <div class="  pl-lg-4 pr-lg-4">

                            </div>
                            <div class="row">

                                <div class="col-1 custom-control custom-checkbox ">
                                    <input type="checkbox" class="custom-control-input"
                                        name="ruido" id="ruido"
                                        data-toggle="collapse" data-target="info_obligatorio"
                                        {{ isset($examen_clinico) && $examen_clinico->ruido == 1 ? 'checked' : '' }}
                                        disabled
                                    >
                                    <label class="custom-control-label" for="ruido">Ruido</label>
                                </div>

                                <div class="col-lg-3 form-group">
                                    <label class="form-control-label" for="input-ubicacion_atm">{{ __('Donde') }}</label>
                                    <br>
                                    <span class="description">
                                        {{$examen_clinico->ubicacion_atm?? '-'}}
                                    </span>
                                </div> 

                            </div>
                            <div class="row">
                                
                                <div class="col-1 custom-control custom-checkbox ">
                                    <input type="checkbox" class="custom-control-input"
                                        name="dolor" id="dolor"
                                        data-toggle="collapse" data-target="info_obligatorio"
                                        {{ isset($examen_clinico) && $examen_clinico->dolor == 1 ? 'checked' : '' }}
                                        disabled
                                    >
                                    <label class="custom-control-label" for="dolor" >Dolor</label>
                                </div>

                                <div class="col-lg-3 form-group">
                                    <label class="form-control-label" for="input-apertura">{{ __('Apertura') }}</label>
                                    <br>
                                    <span class="description">
                                            @switch($examen_clinico->apertura)
                                                @case('final_apertura')
                                                Final apertura
                                                    @break
                                                @case('maxima_apertura')
                                                Máxima apertura
                                                    @break
                                                @default
                                                    Por definir
                                            @endswitch
                                    </span>
                                </div>

                            </div>     

                        @endif
                    </div>  

                    <h6 class="heading-small text-muted mb-4">{{ __('Análisis de oclusión') }}</h6>
                    <div class="  pl-lg-4 pr-lg-4">
                        @can('administrar_odontopediatria')
                            <div class="row">
                                <a href="{{ !isset($analisis_oclusion) ? route('analisis_oclusion.create',['id' => $paciente->id]):  route('analisis_oclusion.edit',['id' => $paciente->id,'analisis_oclusion_id'=>$analisis_oclusion->id]) }}">
                                    <button class="btn btn-icon btn-2 btn-primary" type="button">
                                    {{!isset($analisis_oclusion)? 'Registrar':'Actualizar'}}
                                    </button>
                                </a>
                            </div>
                        @endcan
                        @if(isset($analisis_oclusion))
                        <div class="row">
                                <div class="col-2 custom-control custom-checkbox ">
                                    <input type="checkbox" class="custom-control-input"
                                        name="apinamiento_dentario" id="apinamiento_dentario"
                                        data-toggle="collapse" data-target="info_obligatorio"
                                        {{ isset($analisis_oclusion) && $analisis_oclusion->apinamiento_dentario == 1 ? 'checked' : '' }}
                                        disabled
                                    >
                                    <label class="custom-control-label" for="apinamiento_dentario" >Apiñamiento dentario</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 form-group">
                                    <label class="form-control-label" for="input-superior">{{ __('Superior') }}</label>
                                    <br>
                                    <span class="description">
                                            @switch($analisis_oclusion->superior)
                                                @case('leve')
                                                    Leve
                                                    @break
                                                @case('moderado')
                                                    Moderado
                                                    @break
                                                @case('severo')
                                                    Severo
                                                    @break
                                                @default
                                                    Por definir
                                            @endswitch
                                    </span>
                                </div>
                                <div class="col-lg-3 form-group">
                                    <label class="form-control-label" for="input-inferior">{{ __('Inferior') }}</label>
                                    <br>
                                    <span class="description">
                                            @switch($analisis_oclusion->inferior)
                                                @case('leve')
                                                    Leve
                                                    @break
                                                @case('moderado')
                                                    Moderado
                                                    @break
                                                @case('severo')
                                                    Severo
                                                    @break
                                                @default
                                                    Por definir
                                            @endswitch
                                    </span>
                                </div>
                                <div class="col-lg-3 form-group">
                                    <label class="form-control-label" for="input-linea_sonrisa">{{ __('Linea de sonrisa') }}</label>
                                    <br>
                                    <span class="description">
                                            @switch($analisis_oclusion->linea_sonrisa)
                                                @case('un_tercio_corona')
                                                    1/3 corona
                                                    @break
                                                @case('corona_completa')
                                                    Toda la corona
                                                    @break
                                                @case('corona_clinica_y_encia')
                                                    Corona clínica y encía
                                                    @break
                                                @default
                                                    Por definir
                                            @endswitch
                                    </span>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-2 custom-control custom-checkbox ">
                                    <input type="checkbox" class="custom-control-input"
                                        name="desvio_linea_media" id="desvio_linea_media"
                                        data-toggle="collapse" data-target="info_obligatorio"
                                        {{ isset($analisis_oclusion) && $analisis_oclusion->desvio_linea_media == 1 ? 'checked' : '' }}
                                        disabled
                                    >
                                    <label class="custom-control-label" for="desvio_linea_media" >Desvio linea media</label>
                                </div>
                            </div>
                            <div class="row">  
                                <div class="col-lg-3 form-group">
                                    <label class="form-control-label" for="input-desvio_superior">{{ __('Desvio superior') }}</label>
                                    <br>
                                    <span class="description">
                                            @switch($analisis_oclusion->desvio_superior)
                                                @case('derecha')
                                                    Derecha
                                                    @break
                                                @case('izquierda')
                                                    Izquierda
                                                    @break
                                                @default
                                                    Por definir
                                            @endswitch
                                    </span>
                                </div>
                                
                                <div class="col-lg-3 form-group">
                                    <label class="form-control-label" for="input-desvio_inferior">{{ __('Desvio inferior') }}</label>
                                    <br>
                                    <span class="description">
                                            @switch($analisis_oclusion->desvio_inferior)
                                                @case('derecha')
                                                    Derecha
                                                    @break
                                                @case('izquierda')
                                                    Izquierda
                                                    @break
                                                @default
                                                    Por definir
                                            @endswitch
                                    </span>
                                </div>

                                <div class="col-lg-3 form-group">
                                    <label class="form-control-label" for="input-mordida_cruzada">{{ __('Mordida cruzada') }}</label>
                                    <br>
                                    <span class="description">
                                            @switch($analisis_oclusion->mordida_cruzada)
                                                @case('derecha')
                                                    Derecha
                                                    @break
                                                @case('izquierda')
                                                    Izquierda
                                                    @break
                                                @default
                                                    Por definir
                                            @endswitch
                                    </span>
                                </div>
                                
                                <div class="col-lg-3 form-group">
                                    <label class="form-control-label" for="input-mordida_cruzada_lado">{{ __('Mordida cruzada lado') }}</label>
                                    <br>
                                    <span class="description">
                                            @switch($analisis_oclusion->mordida_cruzada_lado)
                                                @case('unilateral')
                                                    Unilateral
                                                    @break
                                                @case('bilateral')
                                                    Bilateral
                                                    @break
                                                @default
                                                    Por definir
                                            @endswitch
                                    </span>
                                </div>
                                
                            </div>
                                
                            <div class="row">
                                <div class="col-2 custom-control custom-checkbox ">
                                    <input type="checkbox" class="custom-control-input"
                                        name="mordida_abierta_anterior" id="mordida_abierta_anterior"
                                        data-toggle="collapse" data-target="info_obligatorio"
                                        {{ isset($analisis_oclusion) && $analisis_oclusion->mordida_abierta_anterior == 1 ? 'checked' : '' }}
                                        disabled
                                    >
                                    <label class="custom-control-label" for="mordida_abierta_anterior" >Mordida abierta anterior</label>
                                </div>
                                <div class="col-2 custom-control custom-checkbox ">
                                    <input type="checkbox" class="custom-control-input"
                                        name="sensibilidad_dentaria" id="sensibilidad_dentaria"
                                        data-toggle="collapse" data-target="info_obligatorio"
                                        {{ isset($analisis_oclusion) && $analisis_oclusion->sensibilidad_dentaria == 1 ? 'checked' : '' }}
                                        disabled
                                    >
                                    <label class="custom-control-label" for="sensibilidad_dentaria" >Sensibilidad dentaria</label>
                                </div>
                            </div>
                        @endif
                    </div>  
                    
                    <h6 class="heading-small text-muted mb-4">{{ __('Evaluación de tejido blando') }}</h6>
                    <div class="  pl-lg-4 pr-lg-4">
                        @can('administrar_odontopediatria')
                            <div class="row">
                                <a href="{{ !isset($evaluacion_tb) ? route('evaluacion_tb.create',['id' => $paciente->id]):  route('evaluacion_tb.edit',['id' => $paciente->id, 'evaluacion_tb_id'=>$evaluacion_tb->id]) }}">
                                    <button class="btn btn-icon btn-2 btn-primary" type="button">
                                    {{!isset($evaluacion_tb)? 'Registrar':'Actualizar'}}
                                    </button>
                                </a>
                            </div>
                        @endcan
                        @if(isset($evaluacion_tb))
                        <div class="row">

                            <div class="col-lg-3 form-group">
                                    <label class="form-control-label" for="input-labio_superior">{{ __('Labio superior') }}</label>
                                    <br>
                                    <span class="description">
                                        {{$evaluacion_tb->labio_superior?? '-'}}
                                    </span>
                            </div> 
                            <div class="col-lg-3 form-group">
                                    <label class="form-control-label" for="input-labio_inferior">{{ __('Labio inferior') }}</label>
                                    <br>
                                    <span class="description">
                                        {{$evaluacion_tb->labio_inferior?? '-'}}
                                    </span>
                            </div>
                            <div class="col-lg-3 form-group">
                                    <label class="form-control-label" for="input-frenillos">{{ __('Frenillos') }}</label>
                                    <br>
                                    <span class="description">
                                        {{$evaluacion_tb->frenillos?? '-'}}
                                    </span>
                            </div>
                            <div class="col-lg-3 form-group">
                                    <label class="form-control-label" for="input-lengua">{{ __('Lengua') }}</label>
                                    <br>
                                    <span class="description">
                                        {{$evaluacion_tb->lengua?? '-'}}
                                    </span>
                            </div>
                            <div class="col-lg-3 form-group">
                                    <label class="form-control-label" for="input-mucosa">{{ __('Mucosa') }}</label>
                                    <br>
                                    <span class="description">
                                        {{$evaluacion_tb->mucosa?? '-'}}
                                    </span>
                            </div>
                            <div class="col-lg-3 form-group">
                                    <label class="form-control-label" for="input-paladar_duro">{{ __('Paladar duro') }}</label>
                                    <br>
                                    <span class="description">
                                        {{$evaluacion_tb->paladar_duro?? '-'}}
                                    </span>
                            </div>
                            <div class="col-lg-3 form-group">
                                    <label class="form-control-label" for="input-paladar_blando">{{ __('Paladar blando') }}</label>
                                    <br>
                                    <span class="description">
                                        {{$evaluacion_tb->paladar_blando?? '-'}}
                                    </span>
                            </div>
                            <div class="col-lg-3 form-group">
                                    <label class="form-control-label" for="input-glandulas_salivales">{{ __('Glándulas salivales') }}</label>
                                    <br>
                                    <span class="description">
                                        {{$evaluacion_tb->glandulas_salivales?? '-'}}
                                    </span>
                            </div>
                            <div class="col-lg-3 form-group">
                                    <label class="form-control-label" for="input-piso_de_boca">{{ __('Piso de boca') }}</label>
                                    <br>
                                    <span class="description">
                                        {{$evaluacion_tb->piso_de_boca?? '-'}}
                                    </span>
                            </div>
                            <div class="col-lg-3 form-group">
                                    <label class="form-control-label" for="input-observaciones_tb">{{ __('Observaciones TB') }}</label>
                                    <br>
                                    <span class="description">
                                        {{$evaluacion_tb->observaciones_tb?? '-'}}
                                    </span>
                            </div>

                            </div>
                        @endif
                    </div>  
                </div>

            </div>
        </div>
    </div>


</div>
<br>





@endsection

