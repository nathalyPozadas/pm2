@extends('layouts.app', ['title' => __('User Profile')])

@section('content')
     

    <div class="container-fluid mt--7">
        <div class="row ">
            
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="mb-0">{{ __('Perfil') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('profile.update') }}" autocomplete="off">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('Identificación') }}</h6>
                            
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif


                            <div class="pl-lg-4">

                                <div class="  pl-lg-4 pr-lg-4">
                                    <div class="row">
                                        <div class="col col-lg-8">
                                            <div class="row ">
                                                <div class="col-lg-6 form-group">
                                                    <label class="form-control-label">{{ __('Fecha
                                                        de Ingreso') }}</label>
                                                    <br>
                                                    <span class="description ">
                                                    @if(auth()->user()->recursoHumano->tipo!=='auxiliar')
                                                    {{\Carbon\Carbon::parse(auth()->user()->recursoHumano->fecha_ingreso)->format('d-m-Y')}}
                                                    @endif
                                                </span>


                                                </div>
                                                @if(auth()->user()->recursoHumano->tipo !=='auxiliar')
                                                    <div class="col-lg-6 form-group">
                                                        <label class="form-control-label">{{ __('Antiguedad')}}</label>
                                                        <br>
                                                        <span class="description ">
                                                        @php
                                                        $fecha_actual = now();
                                                        $diferencia = $fecha_actual->diff(auth()->user()->recursoHumano->fecha_ingreso);
                                                        $años = $diferencia->y;
                                                        $meses = $diferencia->m;
                                                        @endphp


                                                        @if($años > 0)
                                                        {{ $años }} año{{ $años != 1 ? 's' : '' }}
                                                        @if($meses > 0)
                                                        {{ $meses }} mes{{ $meses != 1 ? 'es' : '' }}
                                                        @endif
                                                        @else
                                                        {{ $meses }} mes{{ $meses != 1 ? 'es' : '' }}
                                                        @endif

                                                        </span>

                                                    </div>
                                                @endif
                                                <div class="col-lg-6 form-group">
                                                    <label class="form-control-label">{{
                                                        __('Nombres')}}*</label>
                                                    <br>
                                                    <span class="description " id="input-nombres">{{auth()->user()->recursoHumano->nombres}}</span>

                                                </div>
                                                <div class="col-lg-6 form-group">
                                                    <label class="form-control-label">{{ __('Apellidos')
                                                        }}*</label>
                                                    <br>
                                                    <span class="description">{{auth()->user()->recursoHumano->apellidos}}</span>
                                                </div>
                                                <div class="col-lg-6 form-group">
                                                    <label class="form-control-label">{{ __('Fecha
                                                        de
                                                        Nacimiento') }}</label>
                                                    <br>
                                                    <span class="description">{{auth()->user()->recursoHumano->fecha_nacimiento}}</span>
                                                    @php
                                                    $diferencia = now()->diff(auth()->user()->recursoHumano->fecha_nacimiento);
                                                    $años = $diferencia->y;
                                                    @endphp

                                                    (   
                                                    @if($años > 0)
                                                    {{ $años }} año{{ $años != 1 ? 's' : '' }}
                                                    @endif
                                                    )
                                                </div>
                                                <div class="col-lg-6 form-group">
                                                    <label class="form-control-label">{{ __('CI') }}</label>
                                                    <br>
                                                    <span class="description">{{auth()->user()->recursoHumano->ci}}</span>

                                                </div>


                                            </div>
                                        </div>

                                        <div class="col col-lg-4 d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <label class="d-flex align-items-center justify-content-center" style="width: 100%; height: 100%;">

                                                @if(isset(auth()->user()->recursoHumano->foto))
                                                <img src="data:image/jpg;base64,{{auth()->user()->recursoHumano->foto}}" ondragstart="return false;" class="rounded-circle"
                                                    style="max-width: 100%; max-height: 100%; width: auto; height: auto;">
                                                @else
                                                <img src="{{ asset('argon') }}/img/theme/team-4-800x800.jpg" ondragstart="return false;"
                                                    class="rounded-circle" style="max-width: 100%; max-height: 100%; width: auto; height: auto;">
                                                @endif
                                            </label>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 form-group">
                                            <label class="form-control-label">{{ __('Celular') }}*</label>
                                            <br>
                                            <span class="description">{{auth()->user()->recursoHumano->celular}}</span>
                                        </div>
                                        <div class="col-lg-4 form-group">
                                            <label class="form-control-label">{{ __('Correo') }}</label>
                                            <br>
                                            <span class="description">{{auth()->user()->recursoHumano->correo}}</span>

                                        </div>
                                        @if(auth()->user()->recursoHumano->tipo !== 'secretaria')
                                            <div class="col-lg-4 form-group">
                                                <label class="form-control-label">{{ __('Especialidad') }}</label>
                                                <br>
                                                <span class="description">{{auth()->user()->recursoHumano->especialidad}}</span>

                                            </div>
                                        @endif    
                                        <div class="col-lg-4 form-group">
                                            <label class="form-control-label">{{ __('Estado
                                                Civil')
                                                }}</label>
                                            <br>
                                            <span class="description">{{auth()->user()->recursoHumano->estado_civil}}</span>
                                        </div>

                                        <div class="col-lg-4 form-group">
                                            <label class="form-control-label">{{ __('Sexo') }}</label>
                                            <br>
                                            <span class="description">{{auth()->user()->recursoHumano->sexo}}</span>
                                        </div>
                                        @if(auth()->user()->recursoHumano->tipo !== 'auxiliar')
                                            <div class="col-lg-4 form-group">
                                                <label class="form-control-label">{{ __('Curriculum') }}</label>
                                                <br>
                                                @if( isset(auth()->user()->recursoHumano->curriculum))
                                                <a href="javascript:void(0);" onclick="verContenido('{{ route('ver.archivo', ['id' => auth()->user()->recursoHumano->id]) }}')"
                                                    class="btn btn-primary" role="button"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="16"
                                                        viewBox="0 0 512 512">
                                                        <path
                                                            d="M0 64C0 28.7 28.7 0 64 0L224 0l0 128c0 17.7 14.3 32 32 32l128 0 0 144-208 0c-35.3 0-64 28.7-64 64l0 144-48 0c-35.3 0-64-28.7-64-64L0 64zm384 64l-128 0L256 0 384 128zM176 352l32 0c30.9 0 56 25.1 56 56s-25.1 56-56 56l-16 0 0 32c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-48 0-80c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24l-16 0 0 48 16 0zm96-80l32 0c26.5 0 48 21.5 48 48l0 64c0 26.5-21.5 48-48 48l-32 0c-8.8 0-16-7.2-16-16l0-128c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16l0-64c0-8.8-7.2-16-16-16l-16 0 0 96 16 0zm80-112c0-8.8 7.2-16 16-16l48 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 32 32 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 48c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-64 0-64z"
                                                            fill="white" />
                                                    </svg></a>
                                                @else
                                                <span class="description">Sin subir</span>
                                                @endif
                                            </div>
                                        @endif            
                                    </div>

                                    <div class=" form-group">
                                        <label class="form-control-label">{{ __('Direccion')
                                            }}</label>
                                        <br>
                                        <span class="description">{{auth()->user()->recursoHumano->direccion}}</span>

                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email', auth()->user()->email) }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Actualizar') }}</button>
                                </div>
                            </div>
                        </form>
                        <hr class="my-4" />
                        <form method="post" action="{{ route('profile.password') }}" autocomplete="off">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('Contraseña') }}</h6>

                            @if (session('password_status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('password_status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-current-password">{{ __('Contraseña actual') }}</label>
                                    <input type="password" name="old_password" id="input-current-password" class="form-control form-control-alternative{{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="{{ __('Contraseña actual') }}" value="" required>
                                    
                                    @if ($errors->has('old_password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-password">{{ __('Nueva Contraseña') }}</label>
                                    <input type="password" name="password" id="input-password" class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Nueva Contraseña') }}" value="" required>
                                    
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-password-confirmation">{{ __('Confirmar Contraseña') }}</label>
                                    <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control form-control-alternative" placeholder="{{ __('Confirmar nueva contraseña') }}" value="" required>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Actualizar contraseña') }}</button>
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
