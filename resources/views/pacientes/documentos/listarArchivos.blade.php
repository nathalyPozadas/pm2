@extends('welcome')
@push('header-js-lista')

   <link href="{{ asset('lightbox2') }}/css/lightbox.min.css" rel="stylesheet">
   <script src="{{ asset('lightbox2') }}/js/lightbox.min.js"></script>

@endpush
@section('content')

@include('users.partials.headerPaciente') 
        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Documentos</h3>
                                </div>
                                
                            </div>
                        </div>

                        <div class="col-12">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Imagen</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Fecha de creación</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($archivos as $archivo)
                                        <tr>
                                            <td>
                                                @if (pathinfo($archivo->nombre, PATHINFO_EXTENSION) === 'jpg' || pathinfo($archivo->nombre, PATHINFO_EXTENSION) === 'png')
                                                    <a href="data:image/{{ pathinfo($archivo->nombre, PATHINFO_EXTENSION) }};base64,{{ $archivo->archivo }}" data-lightbox="gallery">
                                                        <img src="data:image/{{ pathinfo($archivo->nombre, PATHINFO_EXTENSION) }};base64,{{ $archivo->archivo }}" alt="Imagen" style="max-width: 50px; max-height: 50px;">
                                                    </a>
                                                @else
                                                    
                                                @endif
                                            </td>
                                            <td>{{ $archivo->nombre }}</td>
                                            <td>{{ \Carbon\Carbon::parse($archivo->fecha_creacion)->format('d-m-Y') }}</td>
                                            <td class="text-right">
                                            <a href="{{ route('documentos.descargar_archivo',['archivo_id' => $archivo->id]) }}">
                                                <button class="btn btn-icon btn-2 btn-primary" type="button" >
                                                    
                                                    <span class="btn-inner--icon"><i class="fas fa-download"></i></span>
                                                </button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                            

                        </div>

                        
                        <div class="card-footer py-4">
                            <nav class="d-flex justify-content-end" aria-label="...">

                            </nav>
                        </div>
                    </div>
                </div>
            </div>

        </div>



@endsection
@push('js')
<script>

</script>

@endpush