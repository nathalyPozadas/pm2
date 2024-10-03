@extends('layouts.app', ['title' => __('User Profile')])

@section('content')

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0">
                            {{ __('Editar mensajes') }}
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    
                    <form method="post" action="{{  route('mensajeria.update') }}" >
                        @csrf
                        
                        <div class="pl-lg-4 pr-lg-4">
                              
                            <div class="row">
                                <div class="col-lg-12 form-group {{ $errors->has('msg_confirmacion_cita') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-confirmacion_cita">{{ __('Mensaje confirmación cita') }}</label>
                                    <br>
                                    <span>Puedes insertar el nombre y horario de la cita agregando [nombre],[hora_inicio] y [hora_fin] donde desees en tu mensaje.<br> Por ejemplo: Buen día, recordarle que hoy tiene una cita a las [hora_inicio].</span>
                                    <input type="text" name="msg_confirmacion_cita" id="input-confirmacion_cita" class="form-control form-control-alternative {{ $errors->has('msg_confirmacion_cita') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Mensaje confirmación cita') }}" value="{{ $mensajeria->msg_confirmacion_cita ?? old('msg_confirmacion_cita') }}" >
                                        @if ($errors->has('msg_confirmacion_cita'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('msg_confirmacion_cita') }}</strong>
                                            </span>
                                            @endif
                                </div>

                                <div class="col-lg-12 form-group {{ $errors->has('msg_felicitacion_cumple') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-felicitacion">{{ __('Mensaje felicitación cumpleaños') }}</label>
                                    <input type="text" name="msg_felicitacion_cumple" id="input-felicitacion" class="form-control form-control-alternative {{ $errors->has('mensaje_felicitacion') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Mensaje felicitación cumpleaños') }}" value="{{ $mensajeria->msg_felicitacion_cumple ?? old('msg_felicitacion_cumple') }}" >
                                        @if ($errors->has('msg_felicitacion_cumple'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('msg_felicitacion_cumple') }}</strong>
                                            </span>
                                            @endif
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
</script>

@endpush