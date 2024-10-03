@extends('layouts.app', ['title' => __('User Profile')])

@section('content')

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0">
                            {{ __('Editar Rol') }}
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('roles_permisos.update', ['id' => $rol->id]) }}" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @method('post') 
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
                                <div class="col-lg-4 form-group {{ $errors->has('nombre_rol') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-nombre">{{ __('Nombre') }}</label>
                                    <input type="text" name="nombre_rol" id="input-nombre" class="form-control form-control-alternative {{ $errors->has('nombre_rol') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Nombre') }}" value="{{ $rol->nombre_vista ?? old('name') }}" autofocus>
                                    @if ($errors->has('nombre_rol'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nombre_rol') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            @foreach($modulos as $modulo)
                            <li>{{ $modulo->name }}</li>
                                <?php $permisos = $modulo->permissions; ?>
                                @foreach($permisos as $permiso)
                                <div class="custom-control custom-checkbox mb-3">
                                    <input name="permisos[]" class="custom-control-input" type="checkbox" id="permiso-{{ $permiso->descriptive_name }}" value="{{ $permiso->name }}"
                                    @if($rol->permissions->contains('name', $permiso->name)) checked @endif>
                                    <label class="custom-control-label" for="permiso-{{ $permiso->descriptive_name }}">
                                        {{ $permiso->descriptive_name }}
                                    </label>
                                </div>
                                @endforeach
                            @endforeach

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
