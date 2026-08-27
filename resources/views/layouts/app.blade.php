<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CPET — {{ $title ?? 'Sistema' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/icon/logo.png') }}" type="image/x-icon">

    {{-- Bootstrap 4 (modales / DataTables / vistas legacy) --}}
    <link href="{{ asset('vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('styles')

</head>
<body class="app-shell font-sans antialiased">
@php
    $notifCount = \App\Models\OficialesSalud::where('is_vigente', 1)
        ->whereDate('fecha_reposo_fin', \Carbon\Carbon::tomorrow()->format('Y-m-d'))
        ->count();
    $notificacionesNav = \App\Models\OficialesSalud::with('oficiale')
        ->where('is_vigente', 1)
        ->whereDate('fecha_reposo_fin', \Carbon\Carbon::tomorrow()->format('Y-m-d'))
        ->get();
    $funcionariosOpen = request()->is('officers/tipo*') || request()->is('officers/ficha*') || request()->is('officers/search*');
    $configOpen = request()->is('stations*') || request()->is('users*') || request()->is('config*');
@endphp

<div class="app-content-shell min-h-screen lg:pl-[17.5rem]">
    <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-slate-900/55 opacity-0 pointer-events-none transition-opacity lg:hidden"></div>

    <aside id="app-sidebar" class="fixed inset-y-0 left-0 z-50 flex w-[17.5rem] -translate-x-full flex-col overflow-hidden shadow-2xl transition-transform duration-300 lg:translate-x-0"
           style="background: linear-gradient(175deg, #0a1a2e 0%, #0f2744 42%, #163556 100%);">
        <div class="pointer-events-none absolute inset-0 opacity-40"
             style="background-image: radial-gradient(circle at 20% 0%, rgba(212,168,75,0.22), transparent 42%), radial-gradient(circle at 100% 80%, rgba(47,111,173,0.35), transparent 45%);"></div>

        {{-- Branding --}}
        <div class="relative z-10 flex items-center gap-3 px-5 pb-5 pt-5">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/10 p-1.5 shadow-inner ring-1 ring-white/20">
                <img src="{{ asset('images/icon/logo.png') }}" alt="CPET" class="h-full w-full rounded-xl object-cover">
            </div>
            <div class="min-w-0 flex-1 leading-tight">
                <p class="text-[1.15rem] font-bold tracking-[0.06em] text-white">CPET</p>
                <p class="sidebar-muted mt-0.5 text-[11px] font-medium uppercase tracking-wider">Policía Edo. Trujillo</p>
            </div>
            <button type="button" id="sidebar-close" class="rounded-lg p-2 lg:hidden" aria-label="Cerrar menú">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Usuario --}}
        <div class="relative z-10 mx-4 mb-3 rounded-2xl border border-white/10 bg-white/5 px-3.5 py-3 backdrop-blur-sm">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/avatar.png') }}" alt="" class="h-10 w-10 rounded-full object-cover ring-2 ring-accent-400/50">
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                    <p class="sidebar-muted truncate text-[11px]">{{ auth()->user()->email ?? 'Sesión activa' }}</p>
                </div>
            </div>
        </div>

        <nav class="relative z-10 flex-1 space-y-1 overflow-y-auto px-3 py-2 text-sm">
            <p class="sidebar-muted px-3 pb-1 pt-2 text-[10px] font-semibold uppercase tracking-[0.14em]">Menú</p>

            <a href="{{ route('home') }}"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ Route::currentRouteName() === 'home' ? 'nav-link-active' : '' }}">
                <span class="sidebar-icon flex h-8 w-8 items-center justify-center rounded-lg bg-white/5"><i class="fas fa-home text-sm"></i></span>
                <span class="flex-1 font-medium">Dashboard</span>
                @if($notifCount > 0)
                    <span class="rounded-full bg-accent-500 px-2 py-0.5 text-[11px] font-bold text-brand-900">{{ $notifCount }}</span>
                @endif
            </a>

            <div class="nav-group {{ $funcionariosOpen ? 'nav-sub-open' : '' }}">
                <button type="button" class="nav-toggle flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left transition {{ $funcionariosOpen ? 'nav-link-active' : '' }}">
                    <span class="sidebar-icon flex h-8 w-8 items-center justify-center rounded-lg bg-white/5"><i class="fas fa-users text-sm"></i></span>
                    <span class="flex-1 font-medium">Funcionarios</span>
                    <i class="fas fa-chevron-down sidebar-muted text-[10px] transition-transform {{ $funcionariosOpen ? 'rotate-180' : '' }}"></i>
                </button>
                <div class="nav-sub ml-3 space-y-0.5 border-l border-white/10 py-1 pl-3">
                    <a href="{{ route('officers.tipo', 'policial') }}"
                       class="flex items-center gap-2 rounded-lg px-3 py-2 text-[13px] transition {{ request()->is('officers/tipo/policial*') ? 'nav-link-active' : '' }}">
                        <i class="fas fa-shield-alt sidebar-icon w-4 text-center text-xs"></i> Policial
                    </a>
                    <a href="{{ route('officers.tipo', 'administrativo') }}"
                       class="flex items-center gap-2 rounded-lg px-3 py-2 text-[13px] transition {{ request()->is('officers/tipo/administrativo*') ? 'nav-link-active' : '' }}">
                        <i class="fas fa-briefcase sidebar-icon w-4 text-center text-xs"></i> Administrativo
                    </a>
                    <a href="{{ route('officers.tipo', 'obrero') }}"
                       class="flex items-center gap-2 rounded-lg px-3 py-2 text-[13px] transition {{ request()->is('officers/tipo/obrero*') ? 'nav-link-active' : '' }}">
                        <i class="fas fa-tools sidebar-icon w-4 text-center text-xs"></i> Obrero
                    </a>
                </div>
            </div>

            <div class="nav-group {{ $configOpen ? 'nav-sub-open' : '' }}">
                <button type="button" class="nav-toggle flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left transition {{ $configOpen ? 'nav-link-active' : '' }}">
                    <span class="sidebar-icon flex h-8 w-8 items-center justify-center rounded-lg bg-white/5"><i class="fas fa-cog text-sm"></i></span>
                    <span class="flex-1 font-medium">Configuraciones</span>
                    <i class="fas fa-chevron-down sidebar-muted text-[10px] transition-transform {{ $configOpen ? 'rotate-180' : '' }}"></i>
                </button>
                <div class="nav-sub ml-3 space-y-0.5 border-l border-white/10 py-1 pl-3">
                    <a href="{{ route('stations') }}"
                       class="flex items-center gap-2 rounded-lg px-3 py-2 text-[13px] transition {{ request()->is('stations*') ? 'nav-link-active' : '' }}">
                        <i class="fas fa-building sidebar-icon w-4 text-center text-xs"></i> Estaciones
                    </a>
                    <a href="{{ route('users') }}"
                       class="flex items-center gap-2 rounded-lg px-3 py-2 text-[13px] transition {{ request()->is('users*') ? 'nav-link-active' : '' }}">
                        <i class="fas fa-user-cog sidebar-icon w-4 text-center text-xs"></i> Usuarios
                    </a>
                    <a href="{{ route('config.discapacidades') }}"
                       class="flex items-center gap-2 rounded-lg px-3 py-2 text-[13px] transition {{ request()->is('config/discapacidades*') ? 'nav-link-active' : '' }}">
                        <i class="fas fa-wheelchair sidebar-icon w-4 text-center text-xs"></i> Discapacidades
                    </a>
                    <a href="{{ route('config.cursos') }}"
                       class="flex items-center gap-2 rounded-lg px-3 py-2 text-[13px] transition {{ request()->is('config/cursos*') ? 'nav-link-active' : '' }}">
                        <i class="fas fa-book sidebar-icon w-4 text-center text-xs"></i> Cursos / diplomados
                    </a>
                    <a href="{{ route('config.cargos') }}"
                       class="flex items-center gap-2 rounded-lg px-3 py-2 text-[13px] transition {{ request()->routeIs('config.cargos') ? 'nav-link-active' : '' }}">
                        <i class="fas fa-medal sidebar-icon w-4 text-center text-xs"></i> Cargos
                    </a>
                    <a href="{{ route('config.cargos_administrativos') }}"
                       class="flex items-center gap-2 rounded-lg px-3 py-2 text-[13px] transition {{ request()->routeIs('config.cargos_administrativos') ? 'nav-link-active' : '' }}">
                        <i class="fas fa-briefcase sidebar-icon w-4 text-center text-xs"></i> Cargos administrativos
                    </a>
                </div>
            </div>
        </nav>

        <div class="relative z-10 border-t border-white/10 p-4">
            <a href="#"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="logout-link flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition">
                <i class="fas fa-sign-out-alt w-5 text-center"></i>
                Cerrar sesión
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </aside>

    <div class="flex min-h-screen w-full min-w-0 flex-col">
        <header class="app-topbar sticky top-0 z-30 w-full border-b border-slate-200/70 bg-white shadow-sm">
            <div class="flex h-[4.25rem] w-full items-center gap-3 px-4 sm:px-6 lg:px-8">
                <button type="button" id="sidebar-open" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm hover:bg-slate-50 lg:hidden" aria-label="Abrir menú">
                    <i class="fas fa-bars"></i>
                </button>

                <form method="GET" action="{{ route('officers.search') }}" class="hidden min-w-0 flex-1 items-center sm:flex sm:max-w-lg">
                    <div class="relative w-full">
                        <i class="fas fa-search pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
                        <input type="search" name="q" value="{{ request('q') }}"
                               placeholder="Buscar cédula o nombre…"
                               class="w-full rounded-xl border border-slate-200 bg-slate-50/80 py-2.5 pl-10 pr-3 text-sm text-slate-800 shadow-inner outline-none transition focus:border-brand-400 focus:bg-white focus:ring-4 focus:ring-brand-100">
                    </div>
                </form>

                <div class="ml-auto flex shrink-0 items-center gap-2">
                    <button type="button" id="btn-bulk-import" title="Carga masiva"
                            class="inline-flex h-10 items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 text-sm font-medium text-slate-700 shadow-sm transition hover:border-brand-300 hover:bg-brand-50 hover:text-brand-800">
                        <i class="fas fa-file-excel text-brand-600"></i>
                        <span class="hidden sm:inline">Carga masiva</span>
                    </button>

                    <button type="button" id="btn-reports" title="Reportes"
                            class="inline-flex h-10 items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 text-sm font-medium text-slate-700 shadow-sm transition hover:border-brand-300 hover:bg-brand-50 hover:text-brand-800">
                        <i class="fas fa-print text-brand-600"></i>
                        <span class="hidden sm:inline">Reportes</span>
                    </button>

                    <div class="relative" id="notif-wrap">
                        <button type="button" id="notif-toggle" title="Notificaciones"
                                class="relative inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:border-brand-300 hover:bg-brand-50 hover:text-brand-800">
                            <i class="fas fa-bell"></i>
                            @if($notificacionesNav->count() > 0)
                                <span class="absolute -right-1 -top-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-accent-500 px-1 text-[10px] font-bold text-brand-900 ring-2 ring-white">
                                    {{ $notificacionesNav->count() }}
                                </span>
                            @endif
                        </button>
                        <div id="notif-panel" class="absolute right-0 top-full z-50 mt-2 hidden w-80 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl">
                            <div class="border-b border-slate-100 bg-gradient-to-r from-brand-50 to-white px-4 py-3 text-sm font-semibold text-brand-800">
                                {{ $notificacionesNav->count() }} notificación(es)
                            </div>
                            <div class="max-h-72 overflow-y-auto">
                                @forelse($notificacionesNav as $notif)
                                    <div class="border-b border-slate-50 px-4 py-3 text-sm">
                                        <p class="font-medium text-slate-800">{{ $notif->oficiale->nombre_completo ?? 'Funcionario' }}</p>
                                        <p class="text-xs text-slate-500">Se reincorpora mañana · {{ \Carbon\Carbon::parse($notif->fecha_reposo_fin)->format('d/m/Y') }}</p>
                                    </div>
                                @empty
                                    <div class="px-4 py-6 text-center text-sm text-slate-500">Sin notificaciones pendientes</div>
                                @endforelse
                            </div>
                            <a href="{{ route('home') }}" class="block border-t border-slate-100 px-4 py-2.5 text-center text-sm font-semibold text-brand-700 hover:bg-brand-50">Ver dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="mt-4 border-b border-slate-200/50 bg-white/60 px-4 py-3 backdrop-blur-sm sm:mt-5 sm:px-6 lg:px-8">
            <nav class="flex flex-wrap items-center gap-2 text-sm text-slate-500">
                <a href="{{ route('home') }}" class="font-semibold text-brand-700 hover:text-accent-600">Inicio</a>
                @if(($title ?? '') !== 'Dashboard' && Route::currentRouteName() !== 'home')
                    <span class="text-slate-300">/</span>
                    <span class="truncate font-medium text-slate-700">{{ $title }}</span>
                @endif
            </nav>
        </div>

        <main class="flex-1 px-4 pb-6 pt-4 sm:px-6 sm:pt-5 lg:px-8">
            <div class="rounded-2xl border border-white/80 bg-white/95 p-5 shadow-[0_12px_40px_rgba(15,39,68,0.08)] ring-1 ring-slate-200/60 sm:p-7">
                @yield('content')
            </div>
        </main>

        <footer class="px-4 py-5 text-center text-xs text-slate-500 sm:px-6 lg:px-8">
            © {{ date('Y') }} CPET · Policía del Estado Trujillo ·
            <a href="https://www.instagram.com/adsyssystems/" target="_blank" rel="noopener" class="font-medium text-brand-700 hover:text-accent-600">Adsys Sistemas</a>
        </footer>
    </div>
</div>

@include('partials.reportes-modal')
@include('partials.carga-masiva-modal')

<script src="{{ asset('vendor/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-4.1/popper.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2@11.js') }}"></script>
<script src="{{ asset('js/cpet-catalog-select.js') }}"></script>
<script src="{{ asset('vendor/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('vendor/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('vendor/pdfmake/vfs_fonts.js') }}"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('js/datatable-spanish.js') }}"></script>
<script src="{{ asset('js/cpet-module-table.js') }}"></script>

<script>
    var title = @json($title ?? '');
    window.leftImageBase64 = @json($leftImagePath ?? '');

    (function () {
        var sidebar = document.getElementById('app-sidebar');
        var overlay = document.getElementById('sidebar-overlay');
        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('opacity-0', 'pointer-events-none');
        }
        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('opacity-0', 'pointer-events-none');
        }
        document.getElementById('sidebar-open')?.addEventListener('click', openSidebar);
        document.getElementById('sidebar-close')?.addEventListener('click', closeSidebar);
        overlay?.addEventListener('click', closeSidebar);

        document.querySelectorAll('.nav-toggle').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var group = btn.closest('.nav-group');
                group.classList.toggle('nav-sub-open');
                var chevron = btn.querySelector('.fa-chevron-down');
                if (chevron) chevron.classList.toggle('rotate-180');
            });
        });

        var notifToggle = document.getElementById('notif-toggle');
        var notifPanel = document.getElementById('notif-panel');
        notifToggle?.addEventListener('click', function (e) {
            e.stopPropagation();
            notifPanel.classList.toggle('hidden');
        });
        document.addEventListener('click', function () {
            notifPanel?.classList.add('hidden');
        });

        $('#btn-reports').on('click', function () {
            $('#reportesModal').modal('show');
        });

        $('#btn-bulk-import').on('click', function () {
            $('#cargaMasivaModal').modal('show');
        });

        // Evita que el backdrop tape el diálogo cuando el modal está dentro del layout
        $(document).on('show.bs.modal', '.modal', function () {
            if (this.parentElement !== document.body) {
                document.body.appendChild(this);
            }
        });

        // Bootstrap 4 bloquea el foco fuera del .modal; SweetAlert2 se renderiza en body.
        // Sin esto no se puede escribir, pegar ni seleccionar texto en inputs de Swal.
        $(document).on('focusin.modal', function (e) {
            if ($(e.target).closest('.swal2-container').length) {
                e.stopImmediatePropagation();
            }
        });
    })();
</script>
@yield('scripts')
</body>
</html>
