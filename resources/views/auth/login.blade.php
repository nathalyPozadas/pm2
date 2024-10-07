@extends('layouts.app', ['class' => 'bg-gradient-secondary'])

@section('content')
    @include('layouts.headers.guest')

    <div class="container ">
        <div class="row ">
            <div class="col-lg-6 d-flex justify-content-center align-items-center text-center">
                <img src="{{ asset('argon') }}/img/brand/LOGOTIPO-PERBOL-1024x274.png" alt="Logo" class="img-fluid" style="max-width: 95%;">
            </div>

            <div class="col-lg-6 col-md-7">
                <div class="card bg-primary shadow border-0">
                    <div class="card-header bg-transparent pb-5">
                        <div class="text-muted text-center mt-2 mb-3"><small>{{ __('Inicio de Sesión') }}</small></div>
                        <div class="btn-wrapper text-center-login ">
                            Pallets Management
                        </div>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        
                        <form role="form" method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" type="email" name="email" value="{{ old('email') }}" value="admin@argon.com" required autofocus>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" type="password" value="secret" required>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="custom-control custom-control-alternative custom-checkbox">
                                <input class="custom-control-input" name="remember" id="customCheckLogin" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customCheckLogin">
                                    <span class="text-muted">{{ __('Remember me') }}</span>
                                </label>
                            </div>
                            <div >
                                <button type="submit" class="btn btn-primary my-4 input-group justify-content-center" style="background-color: #5882db;">{{ __('Ingresar') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
@endsection
