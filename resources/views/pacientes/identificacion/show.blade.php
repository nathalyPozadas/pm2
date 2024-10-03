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
        @if($paciente->activo==true)
        <div class="d-flex">
            <div>
                @can('administrar_pacientes')
                    <a href="{{ route('paciente.edit',['id' => $paciente->id]) }}">
                        <button class="btn btn-icon btn-2 btn-primary" type="button">
                            <span class="btn-inner--icon"><i class="fas fa-edit"></i></span>
                        </button>
                    </a>
                @endcan
            </div>
            <div>
                @can('administrar_pacientes')
                    <a>
                        <button class="btn btn-icon btn-2 btn-primary" type="button" data-toggle="modal" data-target="#exampleModal">
                            <span class="btn-inner--icon"><i class="fas fa-solid fa-trash"></i></span>
                        </button>
                    </a>
                @endcan
            </div>
        </div>
        @endif
    </div>
</div>

                <div class="card-body">
                    <div class="  pl-lg-4 pr-lg-4">
                        <div class="row">
                            <div class="col-lg-4 form-group">
                                <label class="form-control-label" for="input-fecha_nacimiento">{{ __('Fecha
                                    de
                                    ingreso') }}</label>
                                <br>
                                <span class="description">{{\Carbon\Carbon::parse($paciente->fecha_creacion)->format('d-m-Y') }}</span>
                            </div>
                            <div class="col-lg-4 form-group">
                                <label class="form-control-label" for="input-fecha_nacimiento">{{ __('Código') }}</label>
                                <br>
                                <span class="description">{{$paciente->codigo}}</span>
                            </div>
                        </div>
                    </div>
                <h6 class="heading-small text-muted mb-4">{{ __('Información del Paciente') }}</h6>
                    <div class="  pl-lg-4 pr-lg-4">
                        <div class="row">
                            <div class="col col-lg-8">
                                <div class="row ">
                                    <div class="col-lg-6 form-group">
                                        <label class="form-control-label" for="input-email">{{ __('Apellidos')
                                            }}*</label>
                                        <br>
                                        <span class="description">{{$paciente->apellidos}}</span>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="form-control-label" for="input-nombres">{{ __('Nombres')}}*</label>
                                        <br>
                                        <span class="description " id="input-nombres">{{$paciente->nombres}}</span>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="form-control-label" for="input-sexo">{{ __('Sexo') }}</label>
                                        <br>
                                        <span class="description" id="input-sexo">{{$paciente->sexo}}</span>
                                    </div>
                                    <div
                                        class="col-lg-6 form-group">
                                        <label class="form-control-label" for="input-estado_civil">{{ __('Estado
                                            Civil')
                                            }}</label>
                                        <br>
                                        <span class="description">{{$paciente->estado_civil}}</span>
                                    </div>

                                </div>
                            </div>

                            <div class="col col-lg-4 d-flex align-items-center justify-content-center"
                                style="height: 200px;">
                                <label for="file-upload" class="d-flex align-items-center justify-content-center"
                                    style="width: 100%; height: 100%;">
                                    @if(isset($paciente->foto))
                                        <img src="data:image/jpg;base64,{{$paciente->foto}}" ondragstart="return false;"  class="rounded-circle" style="max-width: 100%; max-height: 100%; width: auto; height: auto;">
                                    @else
                                        <img src="{{ asset('argon') }}/img/theme/team-4-800x800.jpg" ondragstart="return false;"  class="rounded-circle" style="max-width: 100%; max-height: 100%; width: auto; height: auto;">
                                    @endif
                                </label>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-4 form-group">
                                <label class="form-control-label" for="input-ci">{{ __('CI') }}</label>
                                <br>
                                <span class="description">{{$paciente->ci}}</span>

                            </div>

                            <div class="col-lg-4 form-group">
                                <label class="form-control-label" for="input-fecha_nacimiento">{{ __('Fecha
                                    de
                                    Nacimiento') }}</label>
                                <br>
                                <span class="description">
                                @if(isset($paciente->fecha_nacimiento))
                                {{\Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('d-m-Y') }}
                                @endif
                            </span>

                            </div>
                            <div class="col-lg-4 form-group">
                                <label class="form-control-label" for="input-profesion">{{ __('Profesion')
                                    }}</label>
                                <br>
                                <span class="description">{{$paciente->profesion}}</span>

                            </div>
                            <div class="col-lg-4 form-group">
                                <label class="form-control-label" for="input-celular">{{ __('Celular') }}*</label>
                                <br>
                                <span class="description">{{$paciente->celular}}</span>
                                <a href="whatsapp://send?phone=591{{$paciente->celular}}" >
                                    <button class="btn-sm btn-icon btn-2 btn-primary" type="button">
                                        <span class="btn-inner--icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-whatsapp"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                            </svg></span>
                                    </button>
                                </a>
                            </div>
                            <div class="col-lg-4 form-group">
                                <label class="form-control-label" for="input-correo">{{ __('Correo') }}</label>
                                <br>
                                <span class="description">{{$paciente->correo}}</span>
                            </div>
                            <div class="col-lg-4 form-group">
                                <label class="form-control-label" for="input-tipo_sangre">{{ __('Tipo de Sangre')
                                    }}</label>
                                <br>
                                <span class="description" style="color: red;">{{$paciente->tipo_sangre}}</span>

                            </div>

                            <div class="col-lg-4 form-group">
                                <label class="form-control-label" for="input-pais">{{ __('País')
                                    }}</label>
                                <br>
                                <span class="description" style="color: red;">{{$paciente->pais}}</span>

                            </div>
                            <div class="col-lg-4 form-group">
                                <label class="form-control-label" for="input-pais">{{ __('Ciudad')
                                    }}</label>
                                <br>
                                <span class="description" style="color: red;">{{$paciente->ciudad}}</span>

                            </div>
                            <div class="col-lg-4 form-group">
                                <label class="form-control-label" for="input-provincia">{{ __('Provincia')
                                    }}</label>
                                <br>
                                <span class="description" style="color: red;">{{$paciente->provincia}}</span>

                            </div>
                        </div>




                        <div class=" form-group">
                            <label class="form-control-label" for="input-direccion">{{ __('Direccion')
                                }}</label>
                            <br>
                            <span class="description">{{$paciente->direccion}}</span>

                        </div>
                    </div>
                    
                    @if(isset($contacto_emergencia))
                    <h6 class="heading-small text-muted mb-4">{{ __('Contactos de Referencia') }}</h6>
                    <div class="  pl-lg-4 pr-lg-4">
                    @if(isset($contacto_emergencia->nombre1))
                    <div class="row" >
                    <div class="col-lg-4 form-group">
                                <label class="form-control-label" for="input-nombre1_emergencia">{{ __('Nombre')
                                    }}</label>
                                <br>
                                <span class="description">{{$contacto_emergencia->nombre1}}</span>
                            </div>

                            <div class="col-lg-4 form-group">
                                <label class="form-control-label" for="input-parentesco1_emergencia">{{ __('Parentesco')
                                    }}</label>
                                <br>
                                <span class="description">{{$contacto_emergencia->parentesco1}}</span>
                            </div>
                            <div class="col-lg-4 form-group">
                                <label class="form-control-label" for="input-celular1_emergencia">{{ __('Celular')
                                    }}</label>
                                <br>
                                <span class="description">{{$contacto_emergencia->celular1}}</span>
                                <a href="whatsapp://send?phone=591{{$contacto_emergencia->celular1}}" >
                                    <button class="btn-sm btn-icon btn-2 btn-primary" type="button">
                                        <span class="btn-inner--icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-whatsapp"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                            </svg></span>
                                    </button>
                                </a>
                            </div>
                                </div>
                            @endif
                            @if(isset($contacto_emergencia->nombre2))
                    <div class="row" >
                    <div class="col-lg-4 form-group">
                                <label class="form-control-label" for="input-nombre2_emergencia">{{ __('Nombre')
                                    }}</label>
                                <br>
                                <span class="description">{{$contacto_emergencia->nombre2}}</span>
                            </div>

                            <div class="col-lg-4 form-group">
                                <label class="form-control-label" for="input-parentesco2_emergencia">{{ __('Parentesco')
                                    }}</label>
                                <br>
                                <span class="description">{{$contacto_emergencia->parentesco2}}</span>
                            </div>
                            <div class="col-lg-4 form-group">
                                <label class="form-control-label" for="input-celular2_emergencia">{{ __('Celular')
                                    }}</label>
                                <br>
                                <span class="description">{{$contacto_emergencia->celular2}}</span>
                                <a href="whatsapp://send?phone=591{{$contacto_emergencia->celular2}}" >
                                    <button class="btn-sm btn-icon btn-2 btn-primary" type="button">
                                        <span class="btn-inner--icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-whatsapp"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                            </svg></span>
                                    </button>
                                </a>
                            </div>
                                </div>
                            @endif
                                </div>
                    @endif
                                
                </div>
            </div>
        </div>
    </div>


</div>
<br>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Dar de baja Paciente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Esta seguro que desea dar de baja al paciente {{ ' '.$paciente->nombres.' '.$paciente->apellidos .' ?'}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <form method="POST" action="{{ route('paciente.delete',['id'=>$paciente->id]) }}">
            @csrf
            @method('POST')
            <button type="submit" class="btn btn-primary">Confirmar</button>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection

