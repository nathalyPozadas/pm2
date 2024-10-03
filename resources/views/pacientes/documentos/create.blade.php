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
                        <h3 class="mb-0">
                            @if(isset($carpeta))
                            {{ __('') }}
                            @else
                            {{ __('Nuevo folder') }}
                            @endif
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($carpeta))
                    <form method="post" action="{{  route('carpeta.update',['id'=>$carpeta->id]) }}" autocomplete="off">
                    @else
                    <form method="post" action="{{ route('carpeta.store') }}" autocomplete="off">
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
                                        <div class="col-lg-4 form-group{{ $errors->has('nombre') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-name">{{ __('Nombre')
                                                }}</label>
                                            <input type="text" name="nombre" id="input-name" class="form-control form-control-alternative {{ $errors->has('nombre') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('Nombre') }}"  value="{{ $tratamiento->nombre ?? old('nombre') }}" autofocus>
                                                @if ($errors->has('nombre'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('nombre') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-lg-4 form-group{{ $errors->has('precio') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-precio">{{ __('Precio')
                                                }}</label>
                                            <input type="number" name="precio" id="input-precio" class="form-control form-control-alternative {{ $errors->has('precio') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('0') }}" value="{{ $tratamiento->precio ?? old('precio') }}" >
                                                @if ($errors->has('precio'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('precio') }}</strong>
                                            </span>
                                            @endif

                                        </div>
                                        <div class="col-lg-4 form-group{{ $errors->has('costo') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-costo">{{ __('Costo')
                                                }}</label>
                                            <input type="number" name="costo" id="input-costo" class="form-control form-control-alternative {{ $errors->has('costo') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('0') }}" value="{{ $tratamiento->costo ?? old('costo') }}" >
                                                @if ($errors->has('costo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('costo') }}</strong>
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

@endpush