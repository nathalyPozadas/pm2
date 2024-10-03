@extends('welcome')

@section('content')

<div class="container-fluid mt--7">
    <div class="row">

        <div class="col-xl-12 order-xl-1">

            <div class="card bg-secondary shadow">

                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ __('Mensajes predeterminados') }}</h3>
                        
                        <div class="d-flex">
                            <div>
                                <a href="{{ route('mensajeria.edit') }}">
                                    <button class="btn btn-icon btn-2 btn-primary" type="button">
                                        <span class="btn-inner--icon"><i class="fas fa-edit"></i></span>
                                    </button>
                                </a>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="card-body">



                    <div class="  pl-lg-4 pr-lg-4">
                        <div class="row">
                            <div class="col col-lg-8">
                                <div class="row ">
                                    <div
                                        class="col-lg-12 form-group">
                                        <label class="form-control-label" >{{ __('Mensaje para solicitar confirmación de una cita') }}</label>
                                        <br>
                                        <span class="description ">{{$mensajeria->mensaje_confirmacion}}</span>


                                    </div>
                                    
                                    <div class="col-lg-12 form-group">
                                        <label class="form-control-label" >{{__('Mensaje de felicitación cumpleaños')}}</label>
                                        <br>
                                        <span class="description " id="input-nombres">{{$mensajeria->mensaje_cumple}}</span>

                                    </div>
                                    


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

@push('js')
<script>

</script>

@endpush