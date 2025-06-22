<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>CPET - {{$title}}</title>

    <!-- Fontfaces CSS-->
    <link href="{{asset("css/font-face.css")}}" rel="stylesheet" media="all">
    <link href="{{asset("vendor/fontawesome-free/css/all.min.css")}}" rel="stylesheet" media="all">
    <link href="{{asset("vendor/mdi-font/css/material-design-iconic-font.min.css")}}" rel="stylesheet" media="all">
    <link rel="shortcut icon" href="{{ asset("images/icon/logo.png") }}" type="image/x-icon">

    <!-- Bootstrap CSS-->
    <link href="{{asset("vendor/bootstrap-4.1/bootstrap.min.css")}}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{asset("vendor/animsition/animsition.min.css")}}" rel="stylesheet" media="all">
    <link href="{{asset("vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css")}}" rel="stylesheet" media="all">
    <link href="{{asset("vendor/wow/animate.css")}}" rel="stylesheet" media="all">
    <link href="{{asset("vendor/css-hamburgers/hamburgers.min.css")}}" rel="stylesheet" media="all">
    <link href="{{asset("vendor/slick/slick.css")}}" rel="stylesheet" media="all">
    <link href="{{asset("vendor/select2/select2.min.css")}}" rel="stylesheet" media="all">
    <link href="{{asset("vendor/perfect-scrollbar/perfect-scrollbar.css")}}" rel="stylesheet" media="all">
    <link href="{{asset("vendor/vector-map/jqvmap.min.css")}}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{asset("css/theme.css")}}" rel="stylesheet" media="all">
    <link href="{{asset("css/dataTables.bootstrap4.css")}}" rel="stylesheet" media="all">
    <link href="{{asset("vendor/datatables-buttons/css/buttons.bootstrap4.min.css")}}" rel="stylesheet" media="all">
    @yield('styles')
</head>

<body class="animsition">
    <!-- Modal -->
    <div class="modal fade" id="reportesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="reportesModalLabel">Generar Reportes</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <ul class="nav nav-tabs" id="reportesTabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="oficiales-tab" data-toggle="tab" href="#oficiales" role="tab" aria-controls="oficiales" aria-selected="true">Oficiales</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="cargos-tab" data-toggle="tab" href="#cargos" role="tab" aria-controls="cargos" aria-selected="false">Cargos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="familiares-tab" data-toggle="tab" href="#familiares" role="tab" aria-controls="familiares" aria-selected="false">Familiares</a>
            </li>
            {{-- <li class="nav-item">
              <a class="nav-link" id="academico-tab" data-toggle="tab" href="#academico" role="tab" aria-controls="academico" aria-selected="false">Académico</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="cursos-tab" data-toggle="tab" href="#cursos" role="tab" aria-controls="cursos" aria-selected="false">Cursos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="vacaciones-tab" data-toggle="tab" href="#vacaciones" role="tab" aria-controls="vacaciones" aria-selected="false">Vacaciones</a>
            </li> --}}
          </ul>
          <div class="tab-content" id="reportesTabContent">
            <!-- Tab Oficiales -->
            <div class="tab-pane fade show active" id="oficiales" role="tabpanel" aria-labelledby="oficiales-tab">
                <div class="card">
                    <div class="card-header">
                        <h4 class="font-weight-bold">Ficha de oficial</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('report.officers.card') }}" method="GET" target="_blank" class="mt-2">
                          @csrf
                          <hr>
                          <div class="form-group">
                              <label for="documento_identidad">Documento de identidad (*)</label>
                              <input type="text" name="documento_identidad" class="form-control" required placeholder="Ingrese el documento de identidad del oficial. Ejemplo: 12345678">
                          </div>
                          <div class="form-group">
                              <button type="submit" class="btn btn-primary">Generar Reporte</button>
                          </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="font-weight-bold">Reporte general de oficiales</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('report.officers') }}" method="GET" target="_blank" class="mt-2">
                          @csrf
                          <hr>
                          <div class="alert alert-info">
                              <p>Generar reporte de oficiales.</p>
                          </div>
                          <div class="form-group">
                              <button type="submit" class="btn btn-primary">Generar Reporte</button>
                          </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                      <h4 class="font-weight-bold">Reporte de oficiales por fecha de nacimiento</h4>
                    </div>
                    <div class="card-body">
                      <form action="{{ route('report.officers_born_date') }}" method="GET" target="_blank" class="mt-2">
                        @csrf
                        <hr>
                        <div class="form-group">
                          <label for="fechaInicio">Fecha de Nacimiento (Inicio)</label>
                          <input type="date" class="form-control" id="fechaInicio" name="fechaInicio">
                        </div>
                        <div class="form-group">
                          <label for="fechaFin">Fecha de Nacimiento (Fin)</label>
                          <input type="date" class="form-control" id="fechaFin" name="fechaFin">
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary">Generar Reporte</button>
                        </div>
                      </form>
                    </div>
                  </div>

                  <div class="card">
                    <div class="card-header">
                      <h4 class="font-weight-bold">Reporte de oficiales por fecha de ingreso</h4>
                    </div>
                    <div class="card-body">
                      <form action="{{ route('report.officers.ingress_date') }}" method="GET" target="_blank" class="mt-2">
                        @csrf
                        <hr>
                        <div class="form-group">
                            <label for="fechaInicio">Fecha desde (Inicio)</label>
                            <input type="date" class="form-control" id="fechaInicio" name="fechaInicio">
                          </div>
                          <div class="form-group">
                            <label for="fechaFin">Fecha hasta (Fin)</label>
                            <input type="date" class="form-control" id="fechaFin" name="fechaFin">
                          </div>
                          <div class="form-group">
                            <button type="submit" class="btn btn-primary">Generar Reporte</button>
                          </div>
                      </form>
                    </div>
                  </div>
            </div>
            <!-- Tab Cargos -->
            <div class="tab-pane fade" id="cargos" role="tabpanel" aria-labelledby="cargos-tab">
                <form action="{{ route('report.officers.officers_cargo') }}" method="GET" target="_blank" class="mt-2">
                @csrf
                <div class="form-group">
                  <label for="filtroCargo">Cargo (*)</label>
                  <select class="form-control" name="id_cargo" required>
                    <option value="">Seleccione un cargo</option>
                    @foreach (\App\Models\Cargo::all() as $cargo)
                      <option value="{{ $cargo->id }}">{{ $cargo->nombre_cargo }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                    <label for="fechaInicio">Fecha desde (Inicio)</label>
                    <input type="date" class="form-control" id="fechaInicio" name="fechaInicio">
                </div>
                <div class="form-group">
                    <label for="fechaFin">Fecha hasta (Fin)</label>
                    <input type="date" class="form-control" id="fechaFin" name="fechaFin">
                </div>
                <button type="submit" class="btn btn-primary">Generar Reporte</button>
              </form>
            </div>
            <!-- Tab Académico -->
            <div class="tab-pane fade" id="academico" role="tabpanel" aria-labelledby="academico-tab">
              <form>
                <div class="form-group">
                  <label for="filtroTipoFormacion">Tipo Formación</label>
                  <input type="text" class="form-control" id="filtroTipoFormacion" placeholder="Filtrar por tipo">
                </div>
                <div class="form-group">
                  <label for="filtroInstitucion">Institución</label>
                  <input type="text" class="form-control" id="filtroInstitucion" placeholder="Filtrar por institución">
                </div>
                <button type="submit" class="btn btn-primary">Generar Reporte</button>
              </form>
            </div>
            <!-- Tab Cursos -->
            <div class="tab-pane fade" id="cursos" role="tabpanel" aria-labelledby="cursos-tab">
              <form>
                <div class="form-group">
                  <label for="filtroCursoNombre">Nombre Curso</label>
                  <input type="text" class="form-control" id="filtroCursoNombre" placeholder="Filtrar por nombre">
                </div>
                <div class="form-group">
                  <label for="filtroCursoFecha">Fecha Inicio</label>
                  <input type="date" class="form-control" id="filtroCursoFecha">
                </div>
                <button type="submit" class="btn btn-primary">Generar Reporte</button>
              </form>
            </div>
            <!-- Tab Familiares -->
            <div class="tab-pane fade" id="familiares" role="tabpanel" aria-labelledby="familiares-tab">
                <form action="{{ route('report.officers.family_members') }}" method="GET" target="_blank" class="mt-2">
                    @csrf
                    <div class="form-group">
                        <label for="parentesco">Parentesco (*)</label>
                        <select class="form-control" name="parentesco" required>
                            <option value>--- SELECCIONE UN PARENTESCO ---</option>
                            <option value="Padre">Padre</option>
                            <option value="Madre">Madre</option>
                            <option value="Hijo(a)">Hijo(a)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fechaNacimientoInicio">Fecha de Nacimiento (Inicio)</label>
                        <input type="date" class="form-control"  name="fecha_nacimiento_inicio">
                    </div>
                    <div class="form-group">
                        <label for="fechaNacimientoFin">Fecha de Nacimiento (Fin)</label>
                        <input type="date" class="form-control" name="fecha_nacimiento_fin">
                    </div>
                    <button type="submit" class="btn btn-primary">Generar Reporte</button>
                </form>
            </div>
            <!-- Tab Vacaciones -->
            <div class="tab-pane fade" id="vacaciones" role="tabpanel" aria-labelledby="vacaciones-tab">
              <form>
                <div class="form-group">
                  <label for="filtroFechaEmision">Fecha Emisión</label>
                  <input type="date" class="form-control" id="filtroFechaEmision">
                </div>
                <div class="form-group">
                  <label for="filtroEstatus">Estatus</label>
                  <input type="text" class="form-control" id="filtroEstatus" placeholder="Filtrar por estatus">
                </div>
                <button type="submit" class="btn btn-primary">Generar Reporte</button>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  
    <div class="page-wrapper">
        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar2">
            <div class="logo text-white">
                <a href="#">
                    <img src="{{ asset("images/icon/logo.png") }}" alt="Cool Admin"  width="50" height="50" />
                </a>
                <span class="h4 ml-4">
                    J.A.A
                </span>
            </div>
            <div class="menu-sidebar2__content js-scrollbar1">
                <div class="account2">
                    <div class="image img-cir img-120">
                        <img src="{{ asset("images/avatar.png") }}" alt="Usuario" />
                    </div>
                    <h4 class="name">{{auth()->user()->name}}</h4>
                    <a href="#"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('Salir') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
                <nav class="navbar-sidebar2">
                    <ul class="list-unstyled navbar__list">
                        <li class="@if(\Route::currentRouteName() == 'dashboard') active @endif">
                            <a href="inbox.html">
                                <i class="fas fa-home"></i>Inicio</a>
                            {{-- <span class="inbox-num">3</span> --}}
                        </li>
                        <li class="@if(\Route::currentRouteName() == 'officers') active @endif">
                            <a href="{{Route('officers')}}">
                                <i class="fas fa-user"></i>Oficiales</a>
                            {{-- <span class="inbox-num">3</span> --}}
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-cog"></i>Configuraciones
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                {{-- <li>
                                    <a href="index.html">
                                        <i class="fas fa-arrow-right"></i>Profesiones</a>
                                </li>
                                <li>
                                    <a href="index2.html">
                                        <i class="fas fa-arrow-right"></i>Cursos</a>
                                </li>
                                <li>
                                    <a href="index3.html">
                                        <i class="fas fa-arrow-right"></i>Estados</a>
                                </li>
                                <li>
                                    <a href="index4.html">
                                        <i class="fas fa-arrow-right"></i>Municipios</a>
                                </li>
                                <li>
                                    <a href="index4.html">
                                    <i class="fas fa-arrow-right"></i>Parroquias</a>
                                </li> --}}
                                <li>
                                    <a href="{{Route('users')}}">
                                        <i class="fas fa-arrow-right"></i>Usuarios</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container2">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop2">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap2">
                            <div class="logo d-block d-lg-none">
                                <a href="#">
                                    <img src="images/icon/logo-white.png" alt="CoolAdmin" />
                                </a>
                            </div>
                            <div class="header-button2">
                                <div class="header-button-item js-item-menu" id="btn-reports">
                                    <i class="zmdi zmdi-print" ></i>
                                </div>
                                <div class="header-button-item has-noti js-item-menu">
                                    <i class="zmdi zmdi-notifications"></i>
                                    <div class="notifi-dropdown js-dropdown">
                                        <div class="notifi__title">
                                            <p>Tienes 1 notificación(es)</p>
                                        </div>
                                        {{-- <div class="notifi__item">
                                            <div class="bg-c1 img-cir img-40">
                                                <i class="zmdi zmdi-email-open"></i>
                                            </div>
                                            <div class="content">
                                                <p>You got a email notification</p>
                                                <span class="date">April 12, 2018 06:50</span>
                                            </div>
                                        </div>
                                        <div class="notifi__item">
                                            <div class="bg-c2 img-cir img-40">
                                                <i class="zmdi zmdi-account-box"></i>
                                            </div>
                                            <div class="content">
                                                <p>Your account has been blocked</p>
                                                <span class="date">April 12, 2018 06:50</span>
                                            </div>
                                        </div> --}}
                                        <div class="notifi__item">
                                            <div class="bg-c3 img-cir img-40">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="content">
                                                <p>Nueva solicitud de vacaciones</p>
                                                <span class="date">{{ \Carbon\Carbon::now()->format('d \d\e F \d\e\l Y \a \\l\a\s H:i') }}</span>
                                            </div>
                                        </div>
                                        <div class="notifi__footer">
                                            <a href="#">Todas las notificaciones</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <aside class="menu-sidebar2 js-right-sidebar d-block d-lg-none">
                <div class="logo">
                    <a href="#">
                        <img src="images/icon/logo-white.png" alt="Cool Admin" />
                    </a>
                </div>
                <div class="menu-sidebar2__content js-scrollbar2">
                    <div class="account2">
                        <div class="image img-cir img-120">
                            <img src="images/icon/avatar-big-01.jpg" alt="John Doe" />
                        </div>
                        <h4 class="name">john doe</h4>
                        <a href="#">Sign out</a>
                    </div>
                    <nav class="navbar-sidebar2">
                        <ul class="list-unstyled navbar__list">
                            <li class="active has-sub">
                                <a class="js-arrow" href="#">
                                    <i class="fas fa-tachometer-alt"></i>Dashboard
                                    <span class="arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </span>
                                </a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="index.html">
                                            <i class="fas fa-tachometer-alt"></i>Dashboard 1</a>
                                    </li>
                                    <li>
                                        <a href="index2.html">
                                            <i class="fas fa-tachometer-alt"></i>Dashboard 2</a>
                                    </li>
                                    <li>
                                        <a href="index3.html">
                                            <i class="fas fa-tachometer-alt"></i>Dashboard 3</a>
                                    </li>
                                    <li>
                                        <a href="index4.html">
                                            <i class="fas fa-tachometer-alt"></i>Dashboard 4</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="inbox.html">
                                    <i class="fas fa-chart-bar"></i>Inbox</a>
                                <span class="inbox-num">3</span>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fas fa-shopping-basket"></i>eCommerce</a>
                            </li>
                            <li class="has-sub">
                                <a class="js-arrow" href="#">
                                    <i class="fas fa-trophy"></i>Features
                                    <span class="arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </span>
                                </a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="table.html">
                                            <i class="fas fa-table"></i>Tables</a>
                                    </li>
                                    <li>
                                        <a href="form.html">
                                            <i class="far fa-check-square"></i>Forms</a>
                                    </li>
                                    <li>
                                        <a href="calendar.html">
                                            <i class="fas fa-calendar-alt"></i>Calendar</a>
                                    </li>
                                    <li>
                                        <a href="map.html">
                                            <i class="fas fa-map-marker-alt"></i>Maps</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-sub">
                                <a class="js-arrow" href="#">
                                    <i class="fas fa-copy"></i>Pages
                                    <span class="arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </span>
                                </a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="login.html">
                                            <i class="fas fa-sign-in-alt"></i>Login</a>
                                    </li>
                                    <li>
                                        <a href="register.html">
                                            <i class="fas fa-user"></i>Register</a>
                                    </li>
                                    <li>
                                        <a href="forget-pass.html">
                                            <i class="fas fa-unlock-alt"></i>Forget Password</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-sub">
                                <a class="js-arrow" href="#">
                                    <i class="fas fa-desktop"></i>UI Elements
                                    <span class="arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </span>
                                </a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="button.html">
                                            <i class="fab fa-flickr"></i>Button</a>
                                    </li>
                                    <li>
                                        <a href="badge.html">
                                            <i class="fas fa-comment-alt"></i>Badges</a>
                                    </li>
                                    <li>
                                        <a href="tab.html">
                                            <i class="far fa-window-maximize"></i>Tabs</a>
                                    </li>
                                    <li>
                                        <a href="card.html">
                                            <i class="far fa-id-card"></i>Cards</a>
                                    </li>
                                    <li>
                                        <a href="alert.html">
                                            <i class="far fa-bell"></i>Alerts</a>
                                    </li>
                                    <li>
                                        <a href="progress-bar.html">
                                            <i class="fas fa-tasks"></i>Progress Bars</a>
                                    </li>
                                    <li>
                                        <a href="modal.html">
                                            <i class="far fa-window-restore"></i>Modals</a>
                                    </li>
                                    <li>
                                        <a href="switch.html">
                                            <i class="fas fa-toggle-on"></i>Switchs</a>
                                    </li>
                                    <li>
                                        <a href="grid.html">
                                            <i class="fas fa-th-large"></i>Grids</a>
                                    </li>
                                    <li>
                                        <a href="fontawesome.html">
                                            <i class="fab fa-font-awesome"></i>FontAwesome</a>
                                    </li>
                                    <li>
                                        <a href="typo.html">
                                            <i class="fas fa-font"></i>Typography</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>
            <!-- END HEADER DESKTOP-->

            <!-- BREADCRUMB-->
            <section class="au-breadcrumb m-t-75 border-bottom">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="au-breadcrumb-content">
                                    <div class="au-breadcrumb-left">
                                        <span class="au-breadcrumb-span">Estás aquí:</span>
                                        <ul class="list-unstyled list-inline au-breadcrumb__list">
                                            <li class="list-inline-item active">
                                                <a href="#">Inicio</a>
                                            </li>
                                            @if(\Route::currentRouteName() != 'home')
                                            <li class="list-inline-item seprate">
                                                <span>/</span>
                                            </li>
                                            <li class="list-inline-item">{{$title}}</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END BREADCRUMB-->

            {{-- MAIN CONTENT --}}
            <section class="container-fluid bg-white shadow p-4">
                @yield('content')
            </section>
            {{-- END MAIN CONTENT --}}

            <section>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="copyright">
                                <p>Copyright © 2025 CPET. Todos los derechos reservados. Desarrollado por: <a href="https://www.instagram.com/adsyssystems/" target="_blank">Adsys Sistemas</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="{{asset("vendor/jquery-3.2.1.min.js")}}"></script>
    <!-- Bootstrap JS-->
    <script src="{{asset("vendor/bootstrap-4.1/popper.min.js")}}"></script>
    <script src="{{asset("vendor/bootstrap-4.1/bootstrap.min.js")}}"></script>
    <!-- Vendor JS       -->
    <script src="{{asset("vendor/slick/slick.min.js")}}">
    </script>
    <script src="{{asset("vendor/wow/wow.min.js")}}"></script>
    <script src="{{asset("vendor/animsition/animsition.min.js")}}"></script>
    <script src="{{asset("vendor/bootstrap-progressbar/bootstrap-progressbar.min.js")}}">
    </script>
    <script src="{{asset("vendor/counter-up/jquery.waypoints.min.js")}}"></script>
    <script src="{{asset("vendor/counter-up/jquery.counterup.min.js")}}">
    </script>
    <script src="{{asset("vendor/circle-progress/circle-progress.min.js")}}"></script>
    <script src="{{asset("vendor/perfect-scrollbar/perfect-scrollbar.js")}}"></script>
    <script src="{{asset("vendor/chartjs/Chart.bundle.min.js")}}"></script>
    <script src="{{asset("vendor/select2/select2.min.js")}}">
    </script>
    <script src="{{asset("vendor/vector-map/jquery.vmap.js")}}"></script>
    <script src="{{asset("vendor/vector-map/jquery.vmap.min.js")}}"></script>
    <script src="{{asset("vendor/vector-map/jquery.vmap.sampledata.js")}}"></script>
    <script src="{{asset("vendor/vector-map/jquery.vmap.world.js")}}"></script>

    <!-- Main JS-->
    <script src="{{asset("js/main.js")}}"></script>
    <script src="{{asset("js/sweetalert2@11.js") }}"></script>
    <script src="{{asset("js/dataTables.js") }}"></script>
    <script src="{{asset("js/dataTables.bootstrap4.js") }}"></script>
    <script src="{{asset("js/dataTables.responsive.js") }}"></script>
    <script src="{{asset("vendor/datatables-buttons/js/dataTables.buttons.min.js") }}"></script>
    <script src="{{asset("vendor/jszip/jszip.min.js") }}"></script>
    <script src="{{asset("vendor/pdfmake/pdfmake.min.js") }}"></script>
    <script src="{{asset('vendor/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset("vendor/datatables-buttons/js/buttons.html5.min.js") }}"></script>
    <script src="{{asset("vendor/datatables-buttons/js/buttons.print.min.js") }}"></script>
    <script src="{{asset("vendor/datatables-buttons/js/buttons.colVis.min.js") }}"></script>
    <script>
    var title = "{!! $title !!}";
    window.leftImageBase64 = "{!! $leftImagePath !!}";


    $(document).ready(function() {
        $('#btn-reports').click(function() {
            $('#reportesModal').modal('show');
        });
    })

    </script>
    <script src="{{asset("js/datatable-spanish.js") }}"></script>
    @yield('scripts')
</body>

</html>
<!-- end document-->
