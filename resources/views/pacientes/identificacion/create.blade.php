@extends('welcome')

@section('content')
@if(!isset($paciente))
<div class="header pb-8 pt-5  d-flex align-items-center">
    <!-- Mask -->
    <span class="bg-gradient-default opacity-8"></span>
    <!-- Header container -->
    <div class="container-fluid d-flex align-items-center">
        <div class="row">
            <div class="col-md-12 {{ $class ?? '' }}">
                <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="tabs-text" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 {{ ( request()->is('paciente/create')| preg_match('/paciente\/\d+\/identificacion.*/', request()->path()) ) ? 'active' : '' }}"
                            id="tabs-text-1-tab" role="tab" aria-controls="tabs-text-1"
                            aria-selected="true">Identificación</a>
                    </li>
                    @can('ver_historia_clinica')
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 disabled" id="tabs-text-3-tab" role="tab"
                            aria-controls="tabs-text-3" aria-selected="false">Historia Clínica</a>
                    </li>
                    @endcan
                    @can('ver_odontograma')
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 disabled" role="tab" aria-controls="tabs-text-3"
                            aria-selected="false">Odontogramas</a>
                    </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 disabled" id="tabs-text-3-tab" role="tab"
                            aria-controls="tabs-text-3" aria-selected="false">Implantes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 disabled" id="tabs-text-3-tab" role="tab"
                            aria-controls="tabs-text-3" aria-selected="false">Odontopediatría</a>
                    </li>
                    @can('ver_documentos')
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 disabled" id="tabs-text-2-tab" role="tab"
                            aria-controls="tabs-text-2" aria-selected="false">Documentos</a>
                    </li>
                    @endcan
                    @can('ver_historial')
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 disabled" id="tabs-text-3-tab" role="tab"
                            aria-controls="tabs-text-3" aria-selected="false">Historial</a>
                    </li>
                    @endcan
                </ul>
            </div>
        </div>
    </div>
</div>
@else
@include('users.partials.headerPaciente')
@endif
<div class="container-fluid mt--7">
    <div class="row">

        <div class="col-xl-12 order-xl-1">

            <div class="card bg-secondary shadow">

                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                    @if(!isset($paciente) )
                        <h3 class="mb-0">{{ __('Nuevo Paciente') }}</h3>
                        @else

                        @endif
                    </div>
                </div>
                <div class="card-body">

                    <form method="post"
                        action="{{ isset($paciente) ? route('paciente.update',['id'=>$paciente->id]) : route('paciente.store') }}"
                        enctype="multipart/form-data" autocomplete="off">
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

                        @if(isset($paciente))
                        <div class="row">
                            <div
                                class="col-lg-4 form-group{{ $errors->has('fecha_creacion') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-fecha_creacion">{{ __('Fecha de ingreso') }}</label>
                                <input type="date" name="fecha_creacion" id="input-fecha_creacion"
                                    class="form-control form-control-alternative {{ $errors->has('fecha_creacion') ? ' is-invalid' : '' }}"
                                    value="{{ $paciente->fecha_creacion ?? old('fecha_creacion') }}">
                                    @if ($errors->has('fecha_creacion'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fecha_creacion') }}</strong>
                                            </span>
                                            @endif
                            </div>
                            
                        </div>
                        @else
                        <div class="row">
                            <div
                                class="col-lg-4 form-group{{ $errors->has('fecha_creacion') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-fecha_creacion">{{ __('Fecha de ingreso') }}</label>
                                <input type="date" name="fecha_creacion" id="input-fecha_creacion"
                                    class="form-control form-control-alternative {{ $errors->has('fecha_creacion') ? ' is-invalid' : '' }}"
                                    value="{{$fecha_actual}}">
                                    @if ($errors->has('fecha_creacion'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fecha_creacion') }}</strong>
                                            </span>
                                            @endif
                            </div>
                            <div class="col-lg-4 form-group{{ $errors->has('codigo') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-codigo">{{ __('Código') }}</label>
                                    <input type="number" name="codigo" id="input-codigo"
                                        class="form-control form-control-alternative {{ $errors->has('codigo') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Codigo') }}"
                                        value="{{ $paciente->codigo ?? old('codigo') }}">
                                    @if ($errors->has('codigo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('codigo') }}</strong>
                                    </span>
                                    @endif
                            </div>
                        </div>
                        @endif

                        <h6 class="heading-small text-muted mb-4">{{ __('Información del Paciente') }}</h6>

                        <div class="  pl-lg-4 pr-lg-4">
                            
                            <div class="row">
                                <div class="col col-lg-8">
                                    <div class="row">
                                        <div
                                            class="col-lg-6 form-group{{ $errors->has('apellidos') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-apellidos">{{ __('Apellidos')
                                                }}*</label>
                                            <input type="text" name="apellidos" id="input-apellidos"
                                                class="form-control  form-control-alternative {{ $errors->has('apellidos') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('Apellidos') }}"
                                                value="{{ $paciente->apellidos ?? old('apellidos') }}">

                                            @if ($errors->has('apellidos'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('apellidos') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div
                                            class="col-lg-6 form-group{{ $errors->has('nombres') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-name">{{
                                                __('Nombres')}}*</label>
                                            <input type="text" name="nombres" id="input-name"
                                                class="form-control form-control-alternative {{ $errors->has('nombres') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('Nombres') }}"
                                                value="{{ $paciente->nombres ?? old('nombres') }}" autofocus>

                                            @if ($errors->has('nombres'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('nombres') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-lg-6 form-group{{ $errors->has('sexo') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-sexo">{{ __('Sexo') }}</label>
                                            <select class="form-control  form-control-alternative" name="sexo"
                                                id="input-sexo">
                                                @if(isset($paciente) )
                                                <option value="masculino" {{ $paciente->sexo == 'masculino'? ' selected' : ''
                                                    }}>Masculino</option>
                                                <option value="femenino" {{ $paciente->sexo == 'femenino'? ' selected' : '' }}
                                                    }}>Femenino</option>
                                                @else
                                                <option value="masculino" {{ old('sexo')=='masculino' ||
                                                    old('sexo')===null? ' selected' : '' }}>Masculino</option>
                                                <option value="femenino" {{ old('sexo')=='femenino' ? 'selected' : '' }}>Femenino
                                                </option>
                                                @endif
                                            </select>
                                        </div>
                                        <div
                                            class="col-lg-6 form-group{{ $errors->has('estado_civil') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-estado_civil">{{ __('Estado
                                                Civil')
                                                }}</label>
                                            <select class="form-control  form-control-alternative" name="estado_civil"
                                                id="choices-button" placeholder="Estado Civil">

                                                @if(isset($paciente) )
                                                <option value="null" {{ $paciente->estado_civil == 'null'? '
                                                    selected' : '' }}>Por definir</option>
                                                <option value="solter@" {{ $paciente->estado_civil == 'solter@'? '
                                                    selected' : '' }}>Solter@</option>
                                                <option value="casad@" {{ $paciente->estado_civil == 'casad@'? '
                                                    selected' : '' }}>Casad@</option>
                                                <option value="divorciad@" {{ $paciente->estado_civil == 'divorciad@'? '
                                                    selected' : '' }}>Divorciad@</option>
                                                <option value="viud@" {{ $paciente->estado_civil == 'viud@'? ' selected'
                                                    : '' }}>Viud@</option>
                                                <option value="union libre" {{ $paciente->estado_civil == 'union libre'? ' selected'
                                                : '' }}>Unión libre</option>
                                                @else
                                                <option value="null" {{  old('estado_civil')===null ? 
                                                    ' selected' : '' }}>Por definir</option>
                                                <option value="solter@" {{ old('estado_civil')=='solter@' ?
                                                    ' selected' : '' }}>Solter@</option>
                                                <option value="casad@" {{ old('estado_civil')=='casad@' ? 'selected'
                                                    : '' }}>Casad@</option>
                                                <option value="divorciad@" {{ old('estado_civil')=='divorciad@'
                                                    ? 'selected' : '' }}>Divorciad@</option>
                                                <option value="viud@" {{ old('estado_civil')=='viud@' ? 'selected' : ''
                                                    }}>Viud@</option>
                                                <option value="union libre" {{ old('estado_civil')=='union libre' ? 'selected' : ''
                                                    }}>Unión libre</option>
                                                @endif
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                                
                                                <div class="col col-lg-4 d-flex align-items-center justify-content-center" style="height: 200px;">
    <label for="file-upload" class="d-flex align-items-center justify-content-center" style="cursor: pointer; width: 100%; height: 100%;">
        <input id="file-upload" name="foto" type="file" style="display: none;">
        @if(isset($paciente->foto) )
        <img 
            id="imagenSeleccionada"
            src="data:image/jpg;base64,{{$paciente->foto}}"
            class="rounded-circle"
            style="max-width: 100%; max-height: 100%; width: auto; height: auto;">
        @else
        <img 
            id="imagenSeleccionada"
            src="{{ asset('argon') }}/img/theme/team-4-800x800.jpg"
            class="rounded-circle"
            style="max-width: 100%; max-height: 100%; width: auto; height: auto;">
        @endif

    </label>
</div>
                            </div>
                            </div>
                            <div class="  pl-lg-4 pr-lg-4">
                            <div class="row">
                                <div class="col-lg-4 form-group{{ $errors->has('ci') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-ci">{{ __('CI') }}</label>
                                    <input type="number" name="ci" id="input-ci"
                                        class="form-control  form-control-alternative {{ $errors->has('ci') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Carnet de Identidad') }}"
                                        value="{{ $paciente->ci ?? old('ci') }}">

                                </div>

                                <div
                                    class="col-lg-4 form-group{{ $errors->has('fecha_nacimiento') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-fecha_nacimiento">{{ __('Fecha
                                        de
                                        Nacimiento') }}</label>
                                    <input type="date" name="fecha_nacimiento" id="input-fecha_nacimiento"
                                        class="form-control form-control-alternative {{ $errors->has('fecha_nacimiento') ? ' is-invalid' : '' }}"
                                        value="{{ $paciente->fecha_nacimiento ?? old('fecha_nacimiento') }}">

                                </div>
                                <div class="col-lg-4 form-group{{ $errors->has('profesion') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-profesion">{{ __('Profesion')
                                        }}</label>
                                    <input type="text" name="profesion" id="input-profesion"
                                        class="form-control form-control-alternative {{ $errors->has('profesion') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Profesión') }}"
                                        value="{{ $paciente->profesion ?? old('profesion') }}">

                                </div>
                                <div class="col-lg-4 form-group{{ $errors->has('celular') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-celular">{{ __('Celular') }}*</label>
                                    <input type="number" name="celular" id="input-celular"
                                        class="form-control form-control-alternative {{ $errors->has('celular') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Celular') }}"
                                        value="{{ $paciente->celular ?? old('celular') }}">
                                    @if ($errors->has('celular'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('celular') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-4 form-group{{ $errors->has('correo') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-correo">{{ __('Correo') }}</label>
                                    <input type="email" name="correo" id="input-correo"
                                        class="form-control form-control-alternative {{ $errors->has('correo') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Correo') }}"
                                        value="{{ $paciente->correo ?? old('correo') }}">

                                </div>
                                <div class="col-lg-4 form-group{{ $errors->has('tipo_sangre') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-tipo_sangre">{{ __('Tipo de Sangre')
                                        }}</label>
                                    
                                        <select class="form-control  form-control-alternative text-danger" name="tipo_sangre"
                                                id="input-tipo_sangre" placeholder="Estado Civil">

                                            @if(isset($paciente) )
                                                    <option value="null" {{ $paciente->tipo_sangre == 'null'? ' selected' : '' }}>Por definir</option>
                                                    <option value="O+" {{ $paciente->tipo_sangre == 'O+'? ' selected' : '' }}>O+</option>
                                                    <option value="A+" {{ $paciente->tipo_sangre == 'A+'? ' selected' : '' }}>A+</option>
                                                    <option value="B+" {{ $paciente->tipo_sangre == 'B+'? ' selected' : '' }}>B+</option>
                                                    <option value="O-" {{ $paciente->tipo_sangre == 'O-'? ' selected' : '' }}>O-</option>
                                                    <option value="A-" {{ $paciente->tipo_sangre == 'A-'? ' selected': '' }}>A-</option>
                                                    <option value="B-" {{ $paciente->tipo_sangre == 'B-'? ' selected': '' }}>B-</option>
                                                    <option value="AB+" {{ $paciente->tipo_sangre == 'AB+'? ' selected': '' }}>AB+</option>
                                                    <option value="AB-" {{ $paciente->tipo_sangre == 'AB-'? ' selected': '' }}>AB-</option>
                                            @else
                                                    <option value="null" {{ old('tipo_sangre')===null ? ' selected'
                                                        : '' }}>Por definir</option>
                                                    <option value="O+" {{ old('tipo_sangre')=='O+' ? 'selected' 
                                                        : '' }}>O+</option>
                                                    <option value="A+" {{ old('tipo_sangre')=='A+' ? 'selected'
                                                        : '' }}>A+</option>
                                                    <option value="B+" {{ old('tipo_sangre')=='B+'
                                                        ? 'selected' : '' }}>B+</option>
                                                    <option value="O-" {{ old('tipo_sangre')=='O-' ? 'selected' : ''
                                                        }}>O-</option>
                                                    <option value="A-" {{ old('tipo_sangre')=='A-' ? 'selected' : ''
                                                        }}>A-</option>
                                                    <option value="B-" {{ old('tipo_sangre')=='B-' ? 'selected' : ''
                                                        }}>B-</option>
                                                    <option value="AB+" {{ old('tipo_sangre')=='AB+' ? 'selected' : ''
                                                        }}>AB+</option>
                                                    <option value="AB-" {{ old('tipo_sangre')=='AB-' ? 'selected' : ''
                                                        }}>AB-</option>    
                                            @endif
                                        </select>

                                </div>
                                <div class="col-lg-4 form-group{{ $errors->has('pais') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-pais">{{ __('País')}}</label>
                                    <input type="text" name="pais" id="input-pais"
                                        class="form-control form-control-alternative {{ $errors->has('pais') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('País') }}"
                                        value="{{ $paciente->pais ?? old('pais') }}">

                                </div>
                                <div class="col-lg-4 form-group{{ $errors->has('ciudad') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-ciudad">{{ __('Ciudad')}}</label>
                                    <input type="text" name="ciudad" id="input-ciudad"
                                        class="form-control form-control-alternative {{ $errors->has('ciudad') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Ciudad') }}"
                                        value="{{ $paciente->ciudad ?? old('ciudad') }}">
                                </div>
                                <div class="col-lg-4 form-group{{ $errors->has('provincia') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-provincia">{{ __('Provincia')
                                        }}</label>
                                    <input type="text" name="provincia" id="input-provincia"
                                        class="form-control form-control-alternative {{ $errors->has('provincia') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Provincia') }}"
                                        value="{{ $paciente->provincia ?? old('provincia') }}">
                                </div>

                            <div class="col-lg-4  form-group{{ $errors->has('direccion') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-direccion">{{ __('Direccion')
                                    }}</label>
                                <input type="text" name="direccion" id="input-direccion"
                                    class="form-control form-control-alternative {{ $errors->has('direccion') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Direccion') }}"
                                    value="{{ $paciente->direccion ?? old('direccion') }}">

                            </div>
                            </div>
                            
                                </div>

                                <h6 class="heading-small text-muted mb-4">{{ __('Contactos de Referencia') }}</h6>
                            <div class="  pl-lg-4 pr-lg-4">

                            <div id="camposEmergencia">
                                <div class="row">
                                    <div class="col-lg-4 form-group {{ $errors->has('nombre1_emergencia') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-nombre1_emergencia">{{ __('Nombre')
                                            }}</label>
                                        <input type="text" name="nombre1_emergencia" id="input-nombre1_emergencia"
                                        class="form-control form-control-alternative {{ $errors->has('nombre1_emergencia') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Nombre') }}"
                                            value="{{ $contacto_emergencia->nombre1 ?? old('nombre1_emergencia') }}">
                                            @if ($errors->has('nombre1_emergencia'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('nombre1_emergencia') }}</strong>
                                            </span>
                                            @endif
                                    </div>
                                    <div class="col-lg-4 form-group {{ $errors->has('parentesco1_emergencia') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-parentesco1_emergencia">{{
                                            __('Parentesco') }}</label>
                                        <input type="text" name="parentesco1_emergencia"
                                            id="input-parentesco1_emergencia"
                                            class="form-control form-control-alternative {{ $errors->has('parentesco1_emergencia') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Parentesco') }}"
                                            value="{{ $contacto_emergencia->parentesco1 ?? old('parentesco1_emergencia') }}">
                                            @if ($errors->has('parentesco1_emergencia'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('parentesco1_emergencia') }}</strong>
                                            </span>
                                            @endif
                                    </div>
                                    <div class="col-lg-4 form-group {{ $errors->has('celular1_emergencia') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-celular1_emergencia">{{
                                            __('Celular') }}</label>
                                        <input type="number" name="celular1_emergencia" id="input-celular1_emergencia"
                                        class="form-control form-control-alternative {{ $errors->has('celular1_emergencia') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('celular') }}"
                                            value="{{ $contacto_emergencia->celular1 ?? old('celular1_emergencia') }}">
                                            @if ($errors->has('celular1_emergencia'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('celular1_emergencia') }}</strong>
                                            </span>
                                            @endif
                                    </div>
                                    <div class="col-lg-4 form-group {{ $errors->has('nombre2_emergencia') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-nombre2_emergencia">{{ __('Nombre')
                                            }}</label>
                                        <input type="text" name="nombre2_emergencia" id="input-nombre2_emergencia"
                                            class="form-control  form-control-alternative {{ $errors->has('nombre2_emergencia') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Nombre') }}"
                                            value="{{ $contacto_emergencia->nombre2 ?? old('nombre2_emergencia') }}">
                                            @if ($errors->has('nombre2_emergencia'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('nombre2_emergencia') }}</strong>
                                            </span>
                                            @endif

                                    </div>
                                    <div class="col-lg-4 form-group {{ $errors->has('parentesco2_emergencia') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-parentesco2_emergencia">{{
                                            __('Parentesco') }}</label>
                                        <input type="text" name="parentesco2_emergencia"
                                            id="input-parentesco2_emergencia"
                                            class="form-control  form-control-alternative {{ $errors->has('parentesco2_emergencia') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Parentesco') }}"
                                            value="{{ $contacto_emergencia->parentesco2 ?? old('parentesco2_emergencia') }}">
                                            @if ($errors->has('parentesco2_emergencia'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('parentesco2_emergencia') }}</strong>
                                            </span>
                                            @endif
                                    </div>
                                    <div class="col-lg-4 form-group {{ $errors->has('celular2_emergencia') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-celular2_emergencia">{{
                                            __('Celular') }}</label>
                                        <input type="number" name="celular2_emergencia" id="input-celular2_emergencia"
                                            class="form-control  form-control-alternative {{ $errors->has('celular2_emergencia') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('celular') }}"
                                            value="{{ $contacto_emergencia->celular2 ?? old('celular2_emergencia') }}">
                                            @if ($errors->has('celular2_emergencia'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('celular2_emergencia') }}</strong>
                                            </span>
                                            @endif
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#toggleContactoEmergencia').change(function () {
            if ($(this).is(':checked')) {
                $('#camposEmergencia').show();
            } else {
                $('#camposEmergencia').hide();
            }
        });
    });

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