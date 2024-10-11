<h6 class="navbar-heading text-muted">Navegación</h6>

<ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-address-book text-primary"></i> {{ __('Personal') }}
                </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="{{ route( 'lista_empaques.index')}}">
                    <i class="far fa-list-alt text-primary"></i> {{ __('Packing List') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route( 'empaque.index')}}">
                    <i class="fas fa-pallet text-primary"></i> {{ __('Empaques') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-dolly text-primary"></i> {{ __('Movimientos') }}
                </a>
            </li>
           
            
</ul>

<hr class="my-3">
<h6 class="navbar-heading text-muted">Administración</h6>
<ul class="navbar-nav mb-md-3">
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-sitemap text-primary"></i> {{ __(key: 'Empresa') }}
            </a>
        </li> 

        <li class="nav-item">
                <a class="nav-link active" href="#navbar-examples2" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples2">
                    <i class="far fa-file-alt text-primary" style="color: #f4645f;"></i>
                    <span class="nav-link-text" >{{ __('Reportes') }}</span>
                </a>

                <div class="collapse " id="navbar-examples2">
                    <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route( 'reporte.listas')}}">
                                    {{ __('Reporte Listas') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route( 'reporte.empaques')}}">
                                    {{ __('Reporte Empaques') }}
                                </a>
                            </li>
                    </ul>
                </div>
            </li>
               
</ul>