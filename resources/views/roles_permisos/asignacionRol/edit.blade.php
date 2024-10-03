@extends('layouts.app', ['title' => __('User Profile')])

@section('content')

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0">
                            {{ __('Asignar Rol a un usuario') }}
                           
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('asignacion_rol.update', ['id'=>$empleado->id]) }}" enctype="multipart/form-data" autocomplete="off">
                   
                        @csrf
                        @method('post')
                        <h6 class="heading-small text-muted mb-4">{{ __('') }}</h6>


                        <div class="pl-lg-4 pr-lg-4">
                            <div class="row">
                                    <div class="col-lg-4 form-group">
                                        <label class="form-control-label" for="input-nombres">{{ __('Empleado')}}*</label>
                                        <br>
                                        <span class="description " id="input-nombres">{{$empleado->apellidos.''.$empleado->nombres}}</span>
                                    </div>
                                    <div class="col-lg-4 form-group">
                                            <label class="form-control-label" for="input-rol">{{ __('Rol') }}</label>
                                            <select class="form-control  form-control-alternative" name="rol"
                                                id="input-rol">
                                                <option value=null {{ $empleado->rol_id == null? ' selected' : ''
                                                    }}>Sin asignacion</option>
                                                @foreach ( $roles as $rol)
                                                <option value="{{$rol->id}}" {{ $empleado->rol_id == $rol->id? ' selected' : ''
                                                    }}>{{$rol->name}}</option>
                                                @endforeach
                                            </select>
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