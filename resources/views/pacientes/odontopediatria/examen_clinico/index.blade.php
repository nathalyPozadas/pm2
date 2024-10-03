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
                        <h3 class="mb-0">{{ __('Examen Clínico') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ isset($examen_clinico) ? route('examen_clinico.update',['examen_clinico_id'=>$examen_clinico->id]) : route('examen_clinico.store', ['id'=>$paciente->id]) }}"
                            enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            @method('post')
                            <div class="row">
                                <div class="col-lg-3 form-group{{ $errors->has('denticion') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-denticion">{{ __('Dentición')
                                        }}</label>
                                    <select class="form-control  form-control-alternative" name="denticion"
                                        id="choices-button">

                                        @if(isset($examen_clinico))
                                        <option  value=""{{ $examen_clinico->denticion == null ? '
                                            selected' : '' }}>Por definir</option>
                                        <option value="decidua" {{ $examen_clinico->denticion == 'decidua'? '
                                            selected' : '' }}>Decidua</option>
                                        <option value="mixta" {{ $examen_clinico->denticion == 'mixta'? '
                                            selected' : '' }}>Mixta</option>
                                        <option value="permanente" {{ $examen_clinico->denticion == 'permanente'? '
                                            selected' : '' }}>Permanente</option>
                                        @else
                                        <option value="" {{  old('denticion')===null ? 
                                            ' selected' : '' }}>Por definir</option>
                                        <option value="decidua" {{ old('denticion')=='decidua' ?
                                            ' selected' : '' }}>Decidua</option>
                                        <option value="mixta" {{ old('denticion')=='mixta' ? 'selected'
                                            : '' }}>Mixta</option>
                                        <option value="permanente" {{ old('denticion')=='permanente'
                                            ? 'selected' : '' }}>Permanente</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="col-lg-3 form-group{{ $errors->has('erupcion_dentaria') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-erupcion_dentaria">{{ __('Erupción dentaria')
                                        }}</label>
                                    <select class="form-control  form-control-alternative" name="erupcion_dentaria"
                                        id="choices-button">

                                        @if(isset($examen_clinico))
                                        <option value="" {{ $examen_clinico->erupcion_dentaria == null? '
                                            selected' : '' }}>Por definir</option>
                                        <option value="edad_adecuado" {{ $examen_clinico->erupcion_dentaria == 'edad_adecuado'? '
                                            selected' : '' }}>De acuerdo a la edad</option>
                                        <option value="tardia" {{ $examen_clinico->erupcion_dentaria == 'tardia'? '
                                            selected' : '' }}>Tardía</option>
                                        @else
                                        <option value="" {{  old('erupcion_dentaria')===null ? 
                                            ' selected' : '' }}>Por definir</option>
                                        <option value="edad_adecuado" {{ old('erupcion_dentaria')=='edad_adecuado' ?
                                            ' selected' : '' }}>De acuerdo a la edad</option>
                                        <option value="tardia" {{ old('erupcion_dentaria')=='tardia' ? 'selected'
                                            : '' }}>Tardía</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="col-lg-3 form-group{{ $errors->has('respiracion') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{
                                        __('Respiración')}}</label>
                                    <input type="text" name="respiracion" id="input-name"
                                        class="form-control form-control-alternative {{ $errors->has('respiracion') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Respiración') }}"
                                        value="{{ $examen_clinico->respiracion ?? old('respiracion') }}" autofocus>

                                    @if ($errors->has('respiracion'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('respiracion') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-lg-3 form-group{{ $errors->has('fonacion') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{
                                        __('Fonación')}}</label>
                                    <input type="text" name="fonacion" id="input-name"
                                        class="form-control form-control-alternative {{ $errors->has('fonacion') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Fonación') }}"
                                        value="{{ $examen_clinico->fonacion ?? old('fonacion') }}" autofocus>

                                    @if ($errors->has('fonacion'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('fonacion') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-lg-3 form-group{{ $errors->has('audicion') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{
                                        __('Audición')}}</label>
                                    <input type="text" name="audicion" id="input-name"
                                        class="form-control form-control-alternative {{ $errors->has('audicion') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Audición') }}"
                                        value="{{ $examen_clinico->audicion ?? old('audicion') }}" autofocus>
                                    @if ($errors->has('audicion'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('audicion') }}</strong>
                                    </span>
                                    @endif
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
                                    >
                                    <label class="custom-control-label" for="ruido">Ruido</label>
                                </div>

                                <div class="col-lg-3 form-group{{ $errors->has('ubicacion_atm') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{
                                        __('Donde')}}</label>
                                    <input type="text" name="ubicacion_atm" id="input-name"
                                        class="form-control form-control-alternative {{ $errors->has('ubicacion_atm') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Ubicación ATM') }}"
                                        value="{{ $examen_clinico->ubicacion_atm ?? old('ubicacion_atm') }}" autofocus>
                                    @if ($errors->has('ubicacion_atm'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ubicacion_atm') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-1 custom-control custom-checkbox ">
                                    <input type="checkbox" class="custom-control-input"
                                        name="dolor" id="dolor"
                                        data-toggle="collapse" data-target="info_obligatorio"
                                        {{ isset($examen_clinico) && $examen_clinico->dolor == 1 ? 'checked' : '' }}
                                    >
                                    <label class="custom-control-label" for="dolor" >Dolor</label>
                                </div>

                                <div class="col-lg-3 form-group{{ $errors->has('apertura') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-apertura">{{ __('Apertura')
                                        }}</label>
                                    <select class="form-control  form-control-alternative" name="apertura"
                                        id="choices-button">

                                        @if(isset($examen_clinico))
                                        <option value="" {{ $examen_clinico->apertura == null? 
                                            ' selected' : '' }}>Por definir</option>
                                        <option value="final_apertura" {{ $examen_clinico->apertura == 'final_apertura'? 
                                            ' selected' : '' }}>Final apertura</option>
                                        <option value="maxima_apertura" {{ $examen_clinico->apertura == 'maxima_apertura'? 
                                            ' selected' : '' }}>Máxima apertura</option>
                                        @else
                                        <option value="" {{  old('apertura')===null ? 
                                            ' selected' : '' }}>Por definir</option>
                                        <option value="final_apertura" {{ old('apertura')=='final_apertura' ?
                                            ' selected' : '' }}>Final apertura</option>
                                        <option value="maxima_apertura" {{ old('apertura')=='maxima_apertura' ? 
                                            'selected' : '' }}>Máxima apertura</option>
                                        @endif
                                    </select>
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