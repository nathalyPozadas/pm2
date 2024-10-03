@extends('welcome')

@push('header-js-lista')
@endpush

@section('content')

    @include('users.partials.headerPaciente') 
    <div class="container-fluid mt--7">
    <div class="row">

        <div class="col-xl-12 order-xl-1">

            <div class="card bg-secondary shadow">

                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0">{{ __('Análisis oclusión') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ isset($analisis_oclusion) ? route('analisis_oclusion.update',['analisis_oclusion_id'=>$analisis_oclusion->id]) : route('analisis_oclusion.store', ['id'=>$paciente->id]) }}"
                            enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            @method('post')
                            <div class="row">
                                <div class="col-2 custom-control custom-checkbox ">
                                    <input type="checkbox" class="custom-control-input"
                                        name="apinamiento_dentario" id="apinamiento_dentario"
                                        data-toggle="collapse" data-target="info_obligatorio"
                                        {{ isset($analisis_oclusion) && $analisis_oclusion->apinamiento_dentario == 1 ? 'checked' : '' }}
                                    >
                                    <label class="custom-control-label" for="apinamiento_dentario" >Apiñamiento dentario</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 form-group{{ $errors->has('superior') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-superior">{{ __('Superior')
                                        }}</label>
                                    <select class="form-control  form-control-alternative" name="superior"
                                        id="choices-button">

                                        @if(isset($analisis_oclusion))
                                        <option value="" {{ $analisis_oclusion->superior == null? 
                                            ' selected' : '' }}>Por definir</option>
                                        <option value="leve" {{ $analisis_oclusion->superior == 'leve'?
                                            ' selected' : '' }}>Leve</option>
                                        <option value="moderado" {{ $analisis_oclusion->superior == 'moderado'? 
                                            ' selected' : '' }}>Moderado</option>
                                        <option value="severo" {{ $analisis_oclusion->superior == 'severo'? 
                                            ' selected' : '' }}>Severo</option>
                                        @else
                                        <option value="" {{  old('superior')===null ? 
                                            ' selected' : '' }}>Por definir</option>
                                        <option value="leve" {{ old('superior')=='leve' ?
                                            ' selected' : '' }}>Leve</option>
                                        <option value="moderado" {{ old('superior')=='moderado' ?
                                            ' selected' : '' }}>Moderado</option>
                                        <option value="severo" {{ old('superior')=='severo'?
                                            ' selected' : '' }}>Severo</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="col-lg-3 form-group{{ $errors->has('inferior') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-inferior">{{ __('Inferior')
                                        }}</label>
                                    <select class="form-control  form-control-alternative" name="inferior"
                                        id="choices-button">

                                        @if(isset($analisis_oclusion))
                                        <option value="" {{ $analisis_oclusion->inferior == null? 
                                            ' selected' : '' }}>Por definir</option>
                                        <option value="leve" {{ $analisis_oclusion->inferior == 'leve'?
                                            ' selected' : '' }}>Leve</option>
                                        <option value="moderado" {{ $analisis_oclusion->inferior == 'moderado'? 
                                            ' selected' : '' }}>Moderado</option>
                                        <option value="severo" {{ $analisis_oclusion->inferior == 'severo'? 
                                            ' selected' : '' }}>Severo</option>
                                        @else
                                        <option value="" {{  old('inferior')===null ? 
                                            ' selected' : '' }}>Por definir</option>
                                        <option value="leve" {{ old('inferior')=='leve' ?
                                            ' selected' : '' }}>Leve</option>
                                        <option value="moderado" {{ old('inferior')=='moderado' ?
                                            ' selected' : '' }}>Moderado</option>
                                        <option value="severo" {{ old('inferior')=='severo'?
                                            ' selected' : '' }}>Severo</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="col-lg-3 form-group{{ $errors->has('linea_sonrisa') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-superior">{{ __('Linea de sonrisa')
                                        }}</label>
                                    <select class="form-control  form-control-alternative" name="linea_sonrisa"
                                        id="choices-button">

                                        @if(isset($analisis_oclusion))
                                        <option value="" {{ $analisis_oclusion->linea_sonrisa == null? 
                                            ' selected' : '' }}>Por definir</option>
                                        <option value="un_tercio_corona" {{ $analisis_oclusion->linea_sonrisa == 'un_tercio_corona'? 
                                            ' selected' : '' }}>1/3 corona</option>
                                        <option value="corona_completa" {{ $analisis_oclusion->linea_sonrisa == 'corona_completa'? 
                                            ' selected' : '' }}>Toda la corona</option>
                                        <option value="corona_clinica_y_encia" {{ $analisis_oclusion->linea_sonrisa == 'corona_clinica_y_encia'? 
                                            ' selected' : '' }}>Corona clínica y encía</option>
                                        @else
                                        <option value="" {{  old('linea_sonrisa')===null ? 
                                            ' selected' : '' }}>Por definir</option>
                                        <option value="un_tercio_corona" {{ old('linea_sonrisa')=='un_tercio_corona' ?
                                            ' selected' : '' }}>1/3 corona</option>
                                        <option value="corona_completa" {{ old('linea_sonrisa')=='corona_completa' ?
                                            ' selected' : '' }}>Toda la corona</option>
                                        <option value="corona_clinica_y_encia" {{ old('linea_sonrisa')=='corona_clinica_y_encia'?
                                            ' selected' : '' }}>Corona clínica y encía</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2 custom-control custom-checkbox ">
                                    <input type="checkbox" class="custom-control-input"
                                        name="desvio_linea_media" id="desvio_linea_media"
                                        data-toggle="collapse" data-target="info_obligatorio"
                                        {{ isset($analisis_oclusion) && $analisis_oclusion->desvio_linea_media == 1 ? 'checked' : '' }}
                                    >
                                    <label class="custom-control-label" for="desvio_linea_media" >Desvio linea media</label>
                                </div>
                            </div>
                            <div class="row">  
                                <div class="col-lg-3 form-group{{ $errors->has('desvio_superior') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-desvio_superior">{{ __('Desvio superior')
                                        }}</label>
                                    <select class="form-control  form-control-alternative" name="desvio_superior"
                                        id="choices-button">

                                        @if(isset($analisis_oclusion))
                                        <option value="" {{ $analisis_oclusion->desvio_superior == null? 
                                            ' selected' : '' }}>Por definir</option>
                                        <option value="derecha" {{ $analisis_oclusion->desvio_superior == 'derecha'? 
                                            ' selected' : '' }}>Derecha</option>
                                        <option value="izquierda" {{ $analisis_oclusion->desvio_superior == 'izquierda'? 
                                            ' selected' : '' }}>Izquierda</option>
                                        @else
                                        <option value="" {{  old('desvio_superior')===null ? 
                                            ' selected' : '' }}>Por definir</option>
                                        <option value="derecha" {{ old('desvio_superior')=='derecha' ?
                                            ' selected' : '' }}>Derecha</option>
                                        <option value="izquierda" {{ old('desvio_superior')=='izquierda' ?
                                            ' selected' : '' }}>Izquierda</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="col-lg-3 form-group{{ $errors->has('desvio_inferior') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-desvio_inferior">{{ __('Desvio inferior')
                                        }}</label>
                                    <select class="form-control  form-control-alternative" name="desvio_inferior"
                                        id="choices-button">

                                        @if(isset($analisis_oclusion))
                                        <option value="" {{ $analisis_oclusion->desvio_inferior == null? 
                                            ' selected' : '' }}>Por definir</option>
                                        <option value="derecha" {{ $analisis_oclusion->desvio_inferior == 'derecha'? 
                                            ' selected' : '' }}>Derecha</option>
                                        <option value="izquierda" {{ $analisis_oclusion->desvio_inferior == 'izquierda'? 
                                            ' selected' : '' }}>Izquierda</option>
                                        @else
                                        <option value="" {{  old('desvio_inferior')===null ? 
                                            ' selected' : '' }}>Por definir</option>
                                        <option value="derecha" {{ old('desvio_inferior')=='derecha' ?
                                            ' selected' : '' }}>Derecha</option>
                                        <option value="izquierda" {{ old('desvio_inferior')=='izquierda' ?
                                            ' selected' : '' }}>Izquierda</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="col-lg-3 form-group{{ $errors->has('mordida_cruzada') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-mordida_cruzada">{{ __('Mordida cruzada')
                                        }}</label>
                                    <select class="form-control  form-control-alternative" name="mordida_cruzada"
                                        id="choices-button">

                                        @if(isset($analisis_oclusion))
                                        <option value="" {{ $analisis_oclusion->mordida_cruzada == null? 
                                            ' selected' : '' }}>Por definir</option>
                                        <option value="derecha" {{ $analisis_oclusion->mordida_cruzada == 'derecha'? 
                                            ' selected' : '' }}>Derecha</option>
                                        <option value="izquierda" {{ $analisis_oclusion->mordida_cruzada == 'izquierda'? 
                                            ' selected' : '' }}>Izquierda</option>
                                        @else
                                        <option value="" {{  old('mordida_cruzada')===null ? 
                                            ' selected' : '' }}>Por definir</option>
                                        <option value="derecha" {{ old('mordida_cruzada')=='derecha' ?
                                            ' selected' : '' }}>Derecha</option>
                                        <option value="izquierda" {{ old('mordida_cruzada')=='izquierda' ?
                                            ' selected' : '' }}>Izquierda</option>
                                        @endif
                                    </select>
                                </div>
                                
                            

                                <div class="col-lg-3 form-group{{ $errors->has('mordida_cruzada_lado') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-mordida_cruzada_lado">{{ __('Mordida cruzada lado')
                                            }}</label>
                                        <select class="form-control  form-control-alternative" name="mordida_cruzada_lado"
                                            id="choices-button">

                                            @if(isset($analisis_oclusion))
                                            <option value="" {{ $analisis_oclusion->mordida_cruzada_lado == null? 
                                                ' selected' : '' }}>Por definir</option>
                                            <option value="unilateral" {{ $analisis_oclusion->mordida_cruzada_lado == 'unilateral'? 
                                                ' selected' : '' }}>Unilateral</option>
                                            <option value="bilateral" {{ $analisis_oclusion->mordida_cruzada_lado == 'bilateral'? 
                                                ' selected' : '' }}>Bilateral</option>
                                            @else
                                            <option value="" {{  old('mordida_cruzada_lado')===null ? 
                                                ' selected' : '' }}>Por definir</option>
                                            <option value="unilateral" {{ old('mordida_cruzada_lado')=='unilateral' ?
                                                ' selected' : '' }}>Unilateral</option>
                                            <option value="bilateral" {{ old('mordida_cruzada_lado')=='bilateral' ?
                                                ' selected' : '' }}>Bilateral</option>
                                            @endif
                                        </select>
                                </div>
                            </div>
                                
                            <div class="row">
                                <div class="col-2 custom-control custom-checkbox ">
                                    <input type="checkbox" class="custom-control-input"
                                        name="mordida_abierta_anterior" id="mordida_abierta_anterior"
                                        data-toggle="collapse" data-target="info_obligatorio"
                                        {{ isset($analisis_oclusion) && $analisis_oclusion->mordida_abierta_anterior == 1 ? 'checked' : '' }}
                                    >
                                    <label class="custom-control-label" for="mordida_abierta_anterior" >Mordida abierta anterior</label>
                                </div>
                                <div class="col-2 custom-control custom-checkbox ">
                                    <input type="checkbox" class="custom-control-input"
                                        name="sensibilidad_dentaria" id="sensibilidad_dentaria"
                                        data-toggle="collapse" data-target="info_obligatorio"
                                        {{ isset($analisis_oclusion) && $analisis_oclusion->sensibilidad_dentaria == 1 ? 'checked' : '' }}
                                    >
                                    <label class="custom-control-label" for="sensibilidad_dentaria" >Sensibilidad dentaria</label>
                                </div>
                            </div>

                                       
                            <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Guardar') }}</button>
                            </div>
                    </form>
                </div>
                
            </div>
        </div>
        
    </div>
    </div>

@endsection

@push('js')
<script>
 
</script>
@endpush