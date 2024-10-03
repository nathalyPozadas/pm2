@extends('layouts.app', ['title' => __('User Profile')])

@section('content')

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0">
                            @if(isset($situacion))
                            {{ __('Editar Diagnóstico') }}
                            @else
                            {{ __('Nuevo Diagnóstico') }}
                            @endif
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($situacion))
                    <form method="post" action="{{  route('situacion.update',['id'=>$situacion->id]) }}" enctype="multipart/form-data" autocomplete="off">
                    @else
                    <form method="post" action="{{ route('situacion.store') }}" enctype="multipart/form-data" autocomplete="off">
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
                                        <div class="col-lg-4 form-group {{ $errors->has('nombre') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-nombre">{{ __('Nombre')
                                                }}</label>
                                            <input type="text" name="nombre" id="input-nombre" class="form-control form-control-alternative  {{ $errors->has('nombre') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('Nombre') }}"  value="{{ $situacion->nombre ?? old('nombre') }}" autofocus>
                                                @if ($errors->has('nombre'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('nombre') }}</strong>
                                            </span>
                                            @endif
                                            </div>
                                        <div class="col-lg-4 form-group {{ $errors->has('icono') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-icono">{{ __('Icono')
                                                }}</label>
                                            <input  type="file" name="icono" id="input-icono" class="form-control form-control-alternative"
                                                 >
                                                
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