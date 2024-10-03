@extends('welcome')

@section('content')

<div class="container-fluid mt--7">
    <div class="row">

        <div class="col-xl-12 order-xl-1">

            <div class="card bg-secondary shadow">

                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ __('') }}</h3>
                        <div class="d-flex">
                            <a href="{{ route('tratamiento.edit',['id' => $tratamiento->id]) }}">
                                <button class="btn btn-icon btn-2 btn-primary" type="button">
                                    <span class="btn-inner--icon"><i class="fas fa-edit"></i></span>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">



                    <div class="  pl-lg-4 pr-lg-4">
                        <div class="row">

                                    <div class="col-lg-4 form-group">
                                        <label class="form-control-label" for="input-nombre">{{
                                            __('Nombre')}}*</label>
                                        <br>
                                        <span class="description " id="input-nombre">{{$tratamiento->nombre}}</span>

                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form-control-label" for="input-precio">{{ __('Precio')
                                            }}*</label>
                                        <br>
                                        <span class="description" id="input-precio">{{$tratamiento->precio}}</span>
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <label class="form-control-label">{{ __('Costo')}}*</label>
                                        <br>
                                        <span class="description">{{$tratamiento->costo}}</span>
                                    </div>

                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>


</div>
<br>
@endsection