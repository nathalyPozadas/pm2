@extends('welcome')

@section('content')

@include('users.partials.headerPaciente')

<div class="container-fluid mt--7">
    <div class="row">

        <div class="col-xl-12 order-xl-1">

            <div class="card bg-secondary shadow">

                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ __('') }}</h3>

                    </div>
                </div>
                <div class="card-body">
                    <div class="  pl-lg-4 pr-lg-4">
                        @foreach($respuestas as $respuesta)
                        <div class="row text-align-center">
                            <div class="col-12 d-flex align-items-center align-text-center">
                                <div class="col-6 custom-control ">
                                    <label class="description">{{ strtoupper($respuesta->enunciado) }}</label>
                                </div>
                                <div class="col-6 ">
                                    <label class="description">{{ $respuesta->pivot->comentario }}</label>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection