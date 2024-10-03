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
                        <h3 class="mb-0">{{ __('Evaluación de tejido blando') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ isset($evaluacion_tb) ? route('evaluacion_tb.update',['evaluacion_tb_id'=>$evaluacion_tb->id]) : route('evaluacion_tb.store', ['id'=>$paciente->id]) }}"
                            enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            @method('post')
                            <div class="row">

                                <div class="col-lg-3 form-group{{ $errors->has('labio_superior') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{
                                        __('Labio superior')}}</label>
                                    <input type="text" name="labio_superior" id="input-name"
                                        class="form-control form-control-alternative {{ $errors->has('labio_superior') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Labio superior') }}"
                                        value="{{ $evaluacion_tb->labio_superior ?? old('labio_superior') }}" autofocus>

                                    @if ($errors->has('labio_superior'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('labio_superior') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-lg-3 form-group{{ $errors->has('labio_inferior') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{
                                        __('Labio inferior')}}</label>
                                    <input type="text" name="labio_inferior" id="input-name"
                                        class="form-control form-control-alternative {{ $errors->has('labio_inferior') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Labio inferior') }}"
                                        value="{{ $evaluacion_tb->labio_inferior ?? old('labio_inferior') }}" autofocus>

                                    @if ($errors->has('labio_inferior'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('labio_inferior') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-lg-3 form-group{{ $errors->has('frenillos') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{
                                        __('Frenillos')}}</label>
                                    <input type="text" name="frenillos" id="input-name"
                                        class="form-control form-control-alternative {{ $errors->has('frenillos') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Frenillos') }}"
                                        value="{{ $evaluacion_tb->frenillos ?? old('frenillos') }}" autofocus>

                                    @if ($errors->has('frenillos'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('frenillos') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-lg-3 form-group{{ $errors->has('lengua') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{
                                        __('Lengua')}}</label>
                                    <input type="text" name="lengua" id="input-name"
                                        class="form-control form-control-alternative {{ $errors->has('lengua') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Lengua') }}"
                                        value="{{ $evaluacion_tb->lengua ?? old('lengua') }}" autofocus>

                                    @if ($errors->has('lengua'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lengua') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-lg-3 form-group{{ $errors->has('mucosa') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{
                                        __('Mucosa')}}</label>
                                    <input type="text" name="mucosa" id="input-name"
                                        class="form-control form-control-alternative {{ $errors->has('mucosa') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Mucosa') }}"
                                        value="{{ $evaluacion_tb->mucosa ?? old('mucosa') }}" autofocus>

                                    @if ($errors->has('mucosa'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mucosa') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-lg-3 form-group{{ $errors->has('paladar_duro') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{
                                        __('Paladar duro')}}</label>
                                    <input type="text" name="paladar_duro" id="input-name"
                                        class="form-control form-control-alternative {{ $errors->has('paladar_duro') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Paladar duro') }}"
                                        value="{{ $evaluacion_tb->paladar_duro ?? old('paladar_duro') }}" autofocus>

                                    @if ($errors->has('paladar_duro'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('paladar_duro') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-lg-3 form-group{{ $errors->has('paladar_blando') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{
                                        __('Paladar blando')}}</label>
                                    <input type="text" name="paladar_blando" id="input-name"
                                        class="form-control form-control-alternative {{ $errors->has('paladar_blando') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Paladar blando') }}"
                                        value="{{ $evaluacion_tb->paladar_blando ?? old('paladar_blando') }}" autofocus>

                                    @if ($errors->has('paladar_blando'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('paladar_blando') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-lg-3 form-group{{ $errors->has('glandulas_salivales') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{
                                        __('Glándulas salivales')}}</label>
                                    <input type="text" name="glandulas_salivales" id="input-name"
                                        class="form-control form-control-alternative {{ $errors->has('glandulas_salivales') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Glándulas salivales') }}"
                                        value="{{ $evaluacion_tb->glandulas_salivales ?? old('glandulas_salivales') }}" autofocus>

                                    @if ($errors->has('glandulas_salivales'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('glandulas_salivales') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-lg-3 form-group{{ $errors->has('piso_de_boca') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{
                                        __('Piso de boca')}}</label>
                                    <input type="text" name="piso_de_boca" id="input-name"
                                        class="form-control form-control-alternative {{ $errors->has('piso_de_boca') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Piso de boca') }}"
                                        value="{{ $evaluacion_tb->piso_de_boca ?? old('piso_de_boca') }}" autofocus>

                                    @if ($errors->has('piso_de_boca'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('piso_de_boca') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-lg-3 form-group{{ $errors->has('observaciones_tb') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{
                                        __('Observaciones tejido blando')}}</label>
                                    <input type="text" name="observaciones_tb" id="input-name"
                                        class="form-control form-control-alternative {{ $errors->has('observaciones_tb') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Observaciones tejido blando') }}"
                                        value="{{ $evaluacion_tb->observaciones_tb ?? old('observaciones_tb') }}" autofocus>

                                    @if ($errors->has('observaciones_tb'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('observaciones_tb') }}</strong>
                                    </span>
                                    @endif
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