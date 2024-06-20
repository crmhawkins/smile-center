<!-- contenedor-sidebar -->
<!-- Top Bar Start -->
<div class="topbar">

    <!-- LOGO -->
    <div class="topbar-left" style="margin-bottom: -145px !important;">
        <a href="{{route('home')}}" class="logo">
            <span class="logo-light">
                <img class="img-fluid p-4" src="{{ asset('assets/images/logo_empresa.png') }}" alt="Logo La Fabrica">
                {{-- <i class="mdi mdi-camera-control"></i> La Fabrica --}}
            </span>
            <span class="logo-sm">
                <img class="img-fluid p-1" src="{{ asset('assets/images/logo_empresa.png') }}" alt="Logo La Fabrica">
            </span>
        </a>
    </div>

    <nav class="navbar-custom">
        <ul class="navbar-right list-inline float-right mb-0">
            <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
                <a class="nav-link waves-effect" href="#" id="btn-fullscreen">
                    <i class="mdi mdi-arrow-expand-all noti-icon"></i>
                </a>
            </li>

            <!-- notification -->
            <li class="dropdown notification-list list-inline-item">
                <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="mdi mdi-bell-outline noti-icon"></i>
                    @if (isset($alertas))
                    <span class="badge badge-pill badge-danger noti-icon-badge">{{ count($alertas) }}</span>
                    @else
                    <span class="badge badge-pill badge-danger noti-icon-badge">0</span>
                    @endif
                </a>
                @if (isset($alertas))
                    @if (count($alertas) > 0)
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-lg px-1">
                            <!-- item-->
                            <h6 class="dropdown-item-text">
                                Notifications
                            </h6>
                            <div class="slimscroll notification-item-list">
                                <!-- item-->
                                @livewire('lista-alertas')
                            </div>
                        </div>
                        @else
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-lg px-1">
                            <!-- item-->
                            <h6 class="dropdown-item-text">
                                No tienes notificaciones
                            </h6>
                        </div>
                    @endif
                @endif
            </li>

            <li class="dropdown notification-list list-inline-item">
                <div class="dropdown notification-list nav-pro-img">
                    <a class="dropdown-toggle nav-link arrow-none nav-user" data-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="https://crm.fabricandoeventosjerez.com/assets/images/users/user-4.jpg" alt="user"
                            class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <!-- item-->
                        {{-- <a class="dropdown-item" href="#"><i class="mdi mdi-account-circle"></i> Profile</a>
                        <a class="dropdown-item" href="#"><i class="mdi mdi-wallet"></i> Wallet</a>
                        <a class="dropdown-item d-block" href="#"><span
                                class="badge badge-success float-right">11</span><i class="mdi mdi-settings"></i>
                            Settings</a>
                        <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline"></i> Lock
                            screen</a>
                        <div class="dropdown-divider"></div> --}}
                        {{-- Formulario invisible para que Laravel detecte el cierre de sesión como POST. --}}
                        @auth
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @endauth

                        {{-- El mismo enlace, con un evento onclick para que haga submit del formulario y cierre sesión.  --}}
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                class="mdi mdi-power text-danger"></i>Cerrar sesión</a>
                    </div>
                </div>
            </li>

        </ul>

        <ul class="list-inline menu-left mb-0">
            <li class="float-left">
                <button class="button-menu-mobile open-left waves-effect">
                    <i class="mdi mdi-menu"></i>
                </button>
            </li>
            {{-- <li class="d-none d-md-inline-block">
                        <form role="search" class="app-search">
                            <div class="form-group mb-0">
                                <input type="text" class="form-control" placeholder="Search..">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </li> --}}
        </ul>

    </nav>

</div>
<!-- Top Bar End -->
