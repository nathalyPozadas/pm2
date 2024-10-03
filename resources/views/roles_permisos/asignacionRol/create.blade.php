@extends('layouts.app', ['title' => __('User Profile')])

@section('content')

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0">
                            {{ __('Asignación de rol') }}
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($pregunta))
                    <form method="post" action="{{  route('pregunta.update',['id'=>$pregunta->id]) }}"
                        enctype="multipart/form-data" autocomplete="off">
                        @else
                        <form method="post" action="{{ route('pregunta.store') }}" enctype="multipart/form-data"
                            autocomplete="off">
                            @endif
                            @csrf
                            @method('post')
                            <h6 class="heading-small text-muted mb-4">{{ __('') }}</h6>

                            @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif


                            <div class="pl-lg-4 pr-lg-4">
                                <div class="row">
                                    <div
                                        class="col-lg-10 form-group {{ $errors->has('enunciado') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-enunciado">{{ __('Enunciado')
                                            }}</label>
                                        <input type="text" name="enunciado" id="input-enunciado"
                                            class="form-control form-control-alternative  {{ $errors->has('enunciado') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Enunciado') }}"
                                            value="{{ $pregunta->enunciado ?? old('enunciado') }}" autofocus>
                                        @if ($errors->has('enunciado'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('enunciado') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div
                                        class="col-lg-10 form-group {{ $errors->has('tipo_check') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-enunciado">{{ __('Respuesta
                                            esperada')
                                            }}</label>
                                        <div class="custom-control custom-radio mb-3 custom-control-alternative">
                                            <input name="tipo_check"
                                                class="custom-control-input form-control form-control-alternative {{ $errors->has('tipo_check') ? ' is-invalid' : '' }}"
                                                id="customRadio5" type="radio" value="1">
                                            <label class="custom-control-label" for="customRadio5">Responder marcando un
                                                check</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input name="tipo_check"
                                                class="custom-control-input form-control form-control-alternative {{ $errors->has('tipo_check') ? ' is-invalid' : '' }}"
                                                id="customRadio6" type="radio" value="2">
                                            <label class="custom-control-label" for="customRadio6">Responder ingresando
                                                información</label>@if ($errors->has('tipo_check'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('tipo_check') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                        <div id="campoTexto" class="col-6 custom-control custom-checkbox " style="display: none;">
                                            <input type="checkbox" class="custom-control-input"
                                                name="info_obligatorio" id="info_obligatorio"
                                                data-toggle="collapse" data-target="info_obligatorio"
                                            >

                                            <label class="custom-control-label"
                                                for="info_obligatorio">obligatorio</label>
                                        </div>

                                        

                                    </div>
                                </div>


                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Guardar') }}</button>
                                </div>
                            </div>
                        </form>

                </div>
            </div>
        </div>
    </div>


</div>
<br>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('.input-radio').change(function () {
            if ($('input[name=custom-radio-2]:checked').length > 0) {
                $('#miFormulario').removeClass('has-danger');
            }
        });

        $('input[type="radio"]').click(function () {
            if ($(this).attr('id') == 'customRadio6') {
                $('#campoTexto').show();
            } else {
                $('#campoTexto').hide();
            }
        });
    });
</script>
@endpush