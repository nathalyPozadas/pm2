@extends('welcome')
@push('headerjs')

@endpush
@section('content')

@include('users.partials.headerPaciente')
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0">{{ __('Historia') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('historia.store') }}" autocomplete="off">
                        @csrf
                        @method('post')
                        <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">
                        <h6 class="heading-small text-muted mb-4">{{ __('') }}</h6>

                        @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <div class="col ml-3">
                            <label class="form-control-label" for="input-fecha_toma">{{ __('Fecha realizada') }}</label>
                            <input type="date" name="fecha" id="input-fecha_toma" class="form-control form-control-alternative col-2" value="{{ $fecha_actual->format('Y-m-d') }}">
                        </div>
                        <br>
                        <div class="pl-lg-4">
                            <div class=" justify-content-center align-items-center">
                                @foreach ($preguntas as $pregunta)
                                @if($pregunta->tipo_check == true)
                                <div class="row text-align-center">
                                    <div class="col-12 d-flex align-items-center align-text-center">
                                        <div class="col-6 custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"
                                                name="customCheck{{$pregunta->id}}" id="customCheck{{$pregunta->id}}"
                                                data-toggle="collapse" data-target="#comentario{{$pregunta->id}}" {{
                                                old('customCheck'.$pregunta->id) === 'on' ? 'checked' : '' }}
                                            value="on">

                                            <label class="custom-control-label"
                                                for="customCheck{{$pregunta->id}}">{{strtoupper($pregunta->enunciado)}}</label>
                                        </div>
                                        <div class="col-6 {{ $errors->has('comentario'.$pregunta->id) ? 'mt-2' : 'mt-2 mb-2'}}">
                                            <div id="comentario{{$pregunta->id}}"
                                                class="{{ old('customCheck'.$pregunta->id) === 'on' ? 'collapse show' : 'collapse hide' }} ">
                                                <input type="text" name="comentario{{$pregunta->id}}"
                                                    class="form-control form-control-sm form-control-alternative {{ $errors->has('comentario'.$pregunta->id) ? ' is-invalid' : '' }}"
                                                    placeholder="{{ __('Comentario') }}" autofocus>
                                                @if ($errors->has('comentario'.$pregunta->id))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('comentario'.$pregunta->id) }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="row text-align-center mt-2 {{ $errors->has('comentario'.$pregunta->id) ? ' ' : ' mb-2' }}">
                                        <div class="col-lg-1 {{ $errors->has('comentario'.$pregunta->id) ? 'form-group mt-2' : '' }}">
                                            <label class="form-control-label" style="font-weight: 400;"
                                                for="customCheck{{$pregunta->id}}">{{strtoupper($pregunta->enunciado)}}</label>
                                        </div>
                                        <div class="col-6 {{ $errors->has('comentario'.$pregunta->id) ? 'form-group mt-2' : '' }} ">
                                            <div id="comentario{{$pregunta->id}}">
                                                <input type="text" name="comentario{{$pregunta->id}}"
                                                    class="form-control form-control-sm form-control-alternative {{ $errors->has('comentario'.$pregunta->id) ? ' is-invalid' : '' }}"
                                                    placeholder="{{ __('Comentario') }}" autofocus>
                                                    @if ($errors->has('comentario'.$pregunta->id))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('comentario'.$pregunta->id) }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                </div>
                                @endif
                                @endforeach

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
        // Escuchar el cambio en el estado del checkbox
        $('[id^=customCheck]').on('change', function () {
            var id = $(this).attr('id').replace('customCheck', '');
            var comentarioDiv = $('#comentario' + id);

            // Si el checkbox está marcado, ocultar los mensajes de error
            if ($(this).prop('checked')) {
                comentarioDiv.find('.invalid-feedback').hide();
            }
        });
    });
</script>
@endpush