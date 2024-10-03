<div class="header pb-8 pt-5  d-flex align-items-center" >
    <!-- Mask -->
    <span class="bg-gradient-default opacity-8"></span>
    <!-- Header container -->
    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-12 {{ $class ?? '' }}">
</h2>
<div class="card bg-secondary shadow">

                <div class="card-body">
                    <div class="  pl-lg-4 pr-lg-4 ">
                        <div class="row">
                            <div class="col col-lg-8">
                                <div class="row ">
                                <div
                                        class="col-lg-1 form-group">
                                        <label class="form-control-label" >{{ __('Código') }}</label>
                                        <br>
                                        <span class="description ">{{$paciente->codigo}}</span>


                                    </div>
                                    <div
                                        class="col-lg-4 form-group">
                                        <label class="form-control-label" >{{ __('Nombre Completo') }}</label>
                                        <br>
                                        <span class="description ">{{$paciente->apellidos.' '.$paciente->nombres}}</span>


                                    </div>
                                    
                                    <div class="col-lg-2 form-group">
                                        <label class="form-control-label" >{{__('Edad')}}</label>
                                        <br>
                                        <span class="description " id="input-nombres">
                                        @if(isset($paciente->fecha_nacimiento))
                                            @php
                                            $diferencia = now()->diff($paciente->fecha_nacimiento);
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
                                        @endif
                                        </span>

                                    </div>
                                    <div
                                        class="col-lg-2 form-group">
                                        <label class="form-control-label" >{{ __('Tipo sangre') }}</label>
                                        <br>
                                        <span class="description " style="color: red;">{{$paciente->tipo_sangre}}</span>


                                    </div>


                                </div>
                            </div>

                            

                        </div>

                        

                </div>
            </div>
        </div>
                <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="tabs-text" role="tablist">
                    <li class="nav-item">
                        <a href="{{ route('paciente.show', ['id'=>$paciente->id]) }}" class="nav-link mb-sm-3 mb-md-0 {{ preg_match('/paciente\/\d+\/identificacion.*/', request()->path()) ? 'active' : '' }}" id="tabs-text-1-tab"   role="tab" aria-controls="tabs-text-1" aria-selected="true">Identificación</a>
                    </li>
                    @can('ver_historia_clinica')
                    <li class="nav-item">
                        <a href="{{ route('historias.index',['id'=>$paciente->id]) }}"  class="nav-link mb-sm-3 mb-md-0 {{ preg_match('/paciente\/\d+\/historias.*/', request()->path()) ? 'active' : '' }}" id="tabs-text-3-tab"  role="tab"  aria-controls="tabs-text-3" aria-selected="false" >Historia Clínica</a>
                    </li>
                    @endcan
                    @can('ver_odontograma')
                    <li class="nav-item">
                        <a href="{{ route('odontogramas.index',['id'=>$paciente->id]) }}"class="nav-link mb-sm-3 mb-md-0 {{ preg_match('/paciente\/\d+\/odontogramas.*/', request()->path()) ? 'active' : '' }}" id="tabs-text-3-tab"   role="tab" aria-controls="tabs-text-3" aria-selected="false">Odontogramas</a>
                    </li>
                    @endcan
                    @php
                        $fechaNacimiento = new DateTime($paciente->fecha_nacimiento);
                        $hoy = new DateTime();
                        $edad = $hoy->diff($fechaNacimiento)->y;
                    @endphp

                    @if ($edad >= 15)
                        @can('ver_implantes')
                        <li class="nav-item">
                            <a href="{{ route('implantes.index',['id'=>$paciente->id]) }}" class="nav-link mb-sm-3 mb-md-0 {{ preg_match('/paciente\/\d+\/implantes.*/', request()->path()) ? 'active' : '' }}" id="tabs-text-3-tab"   role="tab" aria-controls="tabs-text-3" aria-selected="false">Implantes</a>
                        </li>
                        @endcan
                    @endif
                    @php
                        $fechaNacimiento = new DateTime($paciente->fecha_nacimiento);
                        $hoy = new DateTime();
                        $edad = $hoy->diff($fechaNacimiento)->y;
                    @endphp

                    @if ($edad < 15)
                        @can('ver_odontopediatria')
                        <li class="nav-item">
                            <a href={{ route('odontopediatria.index',['id'=>$paciente->id]) }} class="nav-link mb-sm-3 mb-md-0 {{ preg_match('/paciente\/\d+\/odontopediatria.*/', request()->path()) ? 'active' : '' }}" id="tabs-text-3-tab"   role="tab" aria-controls="tabs-text-3" aria-selected="false">Odontopediatría</a>
                        </li>
                        @endcan
                    @endif
                    
                    @can('ver_documentos')
                    <li class="nav-item">
                        <a href="{{ route('documentos.index',['id'=>$paciente->id]) }}" class="nav-link mb-sm-3 mb-md-0 {{ preg_match('/paciente\/\d+\/documentos.*/', request()->path()) ? 'active' : '' }}" id="tabs-text-2-tab"  role="tab" aria-controls="tabs-text-2" aria-selected="false">Documentos</a>
                    </li>
                    @endcan
                    @can('ver_historial')
                    <li class="nav-item">
                        <a href="{{ route('historial.index',['id'=>$paciente->id]) }}"class="nav-link mb-sm-3 mb-md-0 {{ preg_match('/paciente\/\d+\/historial.*/', request()->path()) ? 'active' : '' }}" id="tabs-text-3-tab"   role="tab" aria-controls="tabs-text-3" aria-selected="false">Histórico</a>
                    </li>
                    @endcan
                    
                </ul>
            </div>
        </div>
    </div>
</div> 