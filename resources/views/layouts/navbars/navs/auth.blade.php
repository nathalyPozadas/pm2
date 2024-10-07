<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">
        <!-- Brand -->
        
        <!-- Form -->
        <div class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
        </div>
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle" style="width: 60px; height: 60px;">
    @if(auth()->user()->recursoHumano && isset(auth()->user()->recursoHumano->foto) )
        <img alt="Image placeholder" src="data:image/jpg;base64,{{ auth()->user()->recursoHumano->foto }}" style="width: 100%; height: 100%; object-fit: cover;">
    @else
        <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-4-800x800.jpg" style="width: 100%; height: 100%; object-fit: cover;">
    @endif
</span>

    <div class="media-body ml-2 d-none d-lg-block">
    <span class="mb-0 text-sm ">{{auth()->user()->trabajador->apellidos.' '.auth()->user()->trabajador->nombres}}</span><br>
        <span class="mb-0 text-sm font-weight-bold">{{ auth()->user()->name }}</span>
    </div>
</div>

                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __() }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('Mi perfil') }}</span>
                    </a>
                  
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Cerrar Sesión') }}</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>




<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
            <div class="container-fluid">

                <div class="header-body">
                    <!-- Card stats -->
                    <div class="row">




                    </div>
                </div>
            </div>
        </div>
        
        
