@extends('layouts.app', ['title' => __('User Profile')])

@section('content')

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0">
                            
                            @if(!isset($rrhh))
                                @if($rrhh_tipo == 'doctor')
                                
                                {{ __('Nuevo Doctor') }}
                                @elseif($rrhh_tipo == 'secretaria')
                                {{ __('Nueva Secretaria') }}
                                @else
                                {{ __('Nuevo Auxiliar') }}
                                @endif
                            @endif    
                            
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($rrhh))
                    <form method="post" action="{{  route('rrhh.update',['id'=>$rrhh->id]) }}" enctype="multipart/form-data" autocomplete="off">
                    <?php  echo "<script>console.log($rrhh);</script>"; ?>
                    @else
                    <form method="post" action="{{ route('rrhh.store') }}" enctype="multipart/form-data" autocomplete="off">
                    @endif
                        @csrf
                        @method('post')
                        
                        <input type="hidden" name="rrhh_tipo" value="{{ $rrhh_tipo }}">
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
                                <div class="col col-lg-8">
                                    <div class="row">
                                        @if($rrhh_tipo <> 'auxiliar')
                                        <div
                                            class="col-lg-12 form-group {{ $errors->has('fecha_ingreso') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-fecha_ingreso">{{ __('Fecha
                                                de Ingreso') }}</label>
                                            @if(isset($rrhh))
                                            <input type="date" name="fecha_ingreso" id="input-fecha_ingreso"
                                                class="form-control form-control-alternative {{ $errors->has('fecha_ingreso') ? ' is-invalid' : '' }}" value="{{$rrhh->fecha_ingreso}}">
                                            @else
                                            <input type="date" name="fecha_ingreso" id="input-fecha_ingreso"
                                                class="form-control form-control-alternative {{ $errors->has('fecha_ingreso') ? ' is-invalid' : '' }}" value="{{$fecha_actual}}">
                                            @endif
                                            @if ($errors->has('fecha_ingreso'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fecha_ingreso') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        @endif
                                        <div
                                            class="col-lg-6 form-group {{ $errors->has('apellidos') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-email">{{ __('Apellidos')
                                                }}</label>
                                            <input type="text" name="apellidos" id="input-email" class="form-control form-control-alternative {{ $errors->has('apellidos') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('Apellidos') }}" value="{{ $rrhh->apellidos ?? old('apellidos') }}" >
                                                @if ($errors->has('apellidos'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('apellidos') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div
                                            class="col-lg-6 form-group {{ $errors->has('nombres') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-name">{{ __('Nombres')
                                                }}</label>
                                            <input type="text" name="nombres" id="input-name" class="form-control form-control-alternative {{ $errors->has('nombres') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('Nombres') }}"  value="{{ $rrhh->nombres ?? old('nombres') }}" autofocus>
                                                @if ($errors->has('nombres'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('nombres') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div
                                            class="col-lg-6 form-group {{ $errors->has('fecha_nacimiento') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-fecha_nacimiento">{{ __('Fecha
                                                de Nacimiento') }}</label>
                                            <input type="date" name="fecha_nacimiento" id="input-fecha_nacimiento"
                                                class="form-control form-control-alternative {{ $errors->has('fecha_nacimiento') ? ' is-invalid' : '' }}" value="{{ $rrhh->fecha_nacimiento ?? old('fecha_nacimiento') }}">
                                                @if ($errors->has('fecha_nacimiento'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fecha_nacimiento') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-lg-6 form-group {{ $errors->has('ci') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-ci">{{ __('CI') }}</label>
                                            <input type="number" name="ci" id="input-ci" class="form-control form-control-alternative {{ $errors->has('ci') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('Carnet de Identidad') }}" value="{{ $rrhh->ci ?? old('ci') }}" >
                                                @if ($errors->has('ci'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('ci') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-4 d-flex align-items-center justify-content-center">
                                    <label for="file-upload" class="d-flex align-items-center justify-content-center" style="cursor: pointer; width: 100%; height: 100%;">
        <input id="file-upload" name="foto" type="file" style="display: none;" onchange="mostrarPesoFoto()">
        @if(isset($rrhh->foto) )
        
        <img 
            id="imagenSeleccionada"
            src="data:image/jpg;base64,{{$rrhh->foto}}"
            class="rounded-circle"
            style="max-width: 60%; max-height: 60%; width: auto; height: auto; ">
        @else
        <img 
            id="imagenSeleccionada"
            src="{{ asset('argon') }}/img/theme/team-4-800x800.jpg"
            class="rounded-circle"
            style="max-width: 60%; max-height: 60%; width: auto; height: auto;">
        @endif

        
    </label>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-4 form-group {{ $errors->has('celular') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-celular">{{ __('Celular') }}</label>
                                    <input type="number" name="celular" id="input-celular" class="form-control form-control-alternative {{ $errors->has('celular') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Celular') }}" value="{{ $rrhh->celular ?? old('celular') }}" >
                                        @if ($errors->has('celular'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('celular') }}</strong>
                                            </span>
                                            @endif
                                </div>

                                <div class="col-lg-4 form-group {{ $errors->has('correo') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-correo">{{ __('Correo') }}</label>
                                    <input type="email" name="correo" id="input-correo" class="form-control form-control-alternative {{ $errors->has('correo') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Correo') }}" value="{{ $rrhh->correo ?? old('correo') }}" >
                                        @if ($errors->has('correo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('correo') }}</strong>
                                            </span>
                                            @endif
                                </div>
                                @if($rrhh_tipo <> 'secretaria')
                                    <div
                                        class="col-lg-4 form-group{{ $errors->has('especialidad') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-especialidad">{{ __('Especialidad')
                                            }}</label>
                                        <input type="text" name="especialidad" id="input-especialidad"
                                            class="form-control form-control-alternative {{ $errors->has('especialidad') ? ' is-invalid' : '' }}" placeholder="{{ __('Especialidad') }}" value="{{ $rrhh->especialidad ?? old('especialidad') }}" >
                                            @if ($errors->has('especialidad'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('especialidad') }}</strong>
                                            </span>
                                            @endif
                                    </div>
                                    @endif
                                    <div
                                        class="col-lg-4 form-group {{ $errors->has('estado_civil') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-estado_civil">{{ __('Estado Civil')
                                            }}</label>
                                            <select class="form-control  form-control-alternative {{ $errors->has('estado_civil') ? ' is-invalid' : '' }}" name="estado_civil" id="choices-button"
                                                placeholder="Estado Civil">
                                                
                                                @if(isset($rrhh) )
                                                <option value=null {{ $rrhh->estado_civil == null? ' selected' : '' }}>Por definir</option>
                                                <option value="solter@" {{ $rrhh->estado_civil == 'Solter@'? ' selected' : '' }}>Solter@</option>
                                                <option value="casad@" {{ $rrhh->estado_civil == 'Casad@'? ' selected' : '' }}>Casad@</option>
                                                <option value="divorciad@" {{ $rrhh->estado_civil == 'Divorciad@'? ' selected' : '' }}>Divorciad@</option>
                                                <option value="viud@" {{ $rrhh->estado_civil == 'Viud@'? ' selected' : '' }}>Viud@</option>
                                                <option value="union libre" {{ $rrhh->estado_civil == 'Unión libre'? ' selected' : '' }}>Unión libre</option>
                                                @else
                                                <option value=null {{  old('estado_civil')=== null ?  ' selected' : '' }}>Por definir</option>
                                                <option value="solter@" {{ old('estado_civil') == 'solter@' ? ' selected' : '' }}>Solter@</option>
                                                <option value="casad@" {{ old('estado_civil') == 'casad@' ? 'selected' : '' }}>Casad@</option>
                                                <option value="divorciad@" {{ old('estado_civil') == 'divorciad@' ? 'selected' : '' }}>Divorciado</option>
                                                <option value="viud@" {{ old('estado_civil') == 'viud@' ? 'selected' : '' }}>Viud@</option>
                                                <option value="union libre" {{ old('estado_civil') == 'union libre' ? 'selected' : '' }}>Unión libre</option>
                                                @endif
                                                
                                            </select>
                                    </div>
                                    <div class="col-lg-4 form-group{{ $errors->has('sexo') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-sexo">{{ __('Sexo') }}</label>
                                        <select class="form-control  form-control-alternative {{ $errors->has('sexo') ? ' is-invalid' : '' }}" name="sexo" id="input-sexo">
                                                @if(isset($rrhh) )
                                                <option value="masculino" {{ $rrhh->sexo == 'masculino'? ' selected' : '' }}>Masculino</option>
                                                <option value="femenino" {{ $rrhh->sexo == 'femenino'? ' selected' : '' }} }}>Femenino</option>
                                                @else
                                                <option value="masculino" {{ old('sexo') == 'masculino' || old('sexo') === null? ' selected' : '' }}>Masculino</option>
                                                <option value="femenino" {{ old('sexo') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                                @endif
                                            </select>
                                    </div>
                                    <div
                                        class="col-lg-4 form-group{{ $errors->has('curriculum') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-curriculum">{{ __('Curriculum')
                                            }}</label>
                                        <input type="file" name="curriculum" accept=".pdf" id="input-curriculum" class="form-control form-control-alternative {{ $errors->has('curriculum') ? ' is-invalid' : '' }}"
                                        onchange="mostrarPesoArchivo()" >
                                            @if ($errors->has('curriculum'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('curriculum') }}</strong>
                                            </span>
                                            @endif
                                    </div>
                                    <div
                                        class="col-lg-12 form-group{{ $errors->has('direccion') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-direccion">{{ __('Direccion')
                                            }}</label>
                                        <input type="text" name="direccion" id="input-direccion" class="form-control form-control-alternative {{ $errors->has('direccion') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Direccion') }}" value="{{ $rrhh->direccion ?? old('direccion') }}">
                                            @if ($errors->has('direccion'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('direccion') }}</strong>
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

<div class="modal fade" id="modalErrorPeso" tabindex="-1" role="dialog" aria-labelledby=""
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id=""></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="">Archivo no permitido.<br>El peso máximo permitido por archivo es 16MB.</p>
      
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')

<script>
    document.getElementById('file-upload').addEventListener('change', function(event) {
        var input = event.target;

        // Verificar si se seleccionó un archivo
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                // Asignar la imagen al elemento <img>
                document.getElementById('imagenSeleccionada').src = e.target.result;
            };

            // Leer el contenido de la imagen como una URL de datos (base64)
            reader.readAsDataURL(input.files[0]);
        }
    });

    function mostrarPesoArchivo() {
    var inputArchivo = document.getElementById('input-curriculum');

        if (inputArchivo.files.length > 0) {
            var pesoArchivo = inputArchivo.files[0].size;

            var pesoMegabytes = pesoArchivo / (1024 * 1024);
            if(pesoMegabytes>16){
                $('#modalErrorPeso').modal('show');
                inputArchivo.value = "";
            }
        }
    }

    function mostrarPesoFoto(){
        var inputArchivo = document.getElementById('file-upload');

        if (inputArchivo.files.length > 0) {
            var pesoArchivo = inputArchivo.files[0].size;

            var pesoMegabytes = pesoArchivo / (1024 * 1024);
            if(pesoMegabytes>16){
                $('#modalErrorPeso').modal('show');
                inputArchivo.value = "";
            }
        } 
    }

</script>

@endpush