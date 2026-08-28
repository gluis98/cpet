@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-brand-600">Cuenta</p>
        <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">Mi perfil</h1>
        <p class="mt-1 text-sm text-slate-500">Consulta tus datos de acceso y cambia tu contraseña.</p>
    </div>

    @if (session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <i class="fas fa-check-circle mr-1.5"></i>{{ session('success') }}
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-2">
        {{-- Datos (solo lectura) --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 bg-slate-50 px-5 py-4">
                <h2 class="text-sm font-semibold text-slate-800">
                    <i class="fas fa-id-card mr-2 text-brand-600"></i>Datos de la cuenta
                </h2>
                <p class="mt-0.5 text-xs text-slate-500">Esta información no puede modificarse desde aquí.</p>
            </div>
            <div class="divide-y divide-slate-100 px-5 py-2">
                <div class="py-3">
                    <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">Nombre</p>
                    <p class="mt-1 text-sm font-medium text-slate-900">{{ $user->name }}</p>
                </div>
                <div class="py-3">
                    <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">Correo electrónico</p>
                    <p class="mt-1 text-sm font-medium text-slate-900">{{ $user->email }}</p>
                </div>
                <div class="py-3">
                    <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">Rol</p>
                    <p class="mt-1">
                        <span class="inline-flex rounded-full bg-brand-50 px-2.5 py-0.5 text-xs font-semibold text-brand-800">
                            {{ $user->role ?? 'Usuario' }}
                        </span>
                    </p>
                </div>
                <div class="py-3">
                    <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">Cuenta creada</p>
                    <p class="mt-1 text-sm text-slate-700">
                        {{ $user->created_at?->locale('es')->isoFormat('D [de] MMMM [de] YYYY') ?? '—' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Cambiar contraseña --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 bg-slate-50 px-5 py-4">
                <h2 class="text-sm font-semibold text-slate-800">
                    <i class="fas fa-key mr-2 text-accent-600"></i>Cambiar contraseña
                </h2>
                <p class="mt-0.5 text-xs text-slate-500">Solo puedes actualizar tu contraseña de acceso.</p>
            </div>
            <form method="POST" action="{{ route('profile.password.update') }}" class="space-y-4 p-5" novalidate>
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="mb-1 block text-xs font-semibold text-slate-600">Contraseña actual</label>
                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        class="form-control @error('current_password') is-invalid @enderror"
                        required
                        autocomplete="current-password"
                        placeholder="Tu contraseña actual"
                    >
                    @error('current_password')
                        <span class="mt-1 block text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-1 block text-xs font-semibold text-slate-600">Nueva contraseña</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        required
                        autocomplete="new-password"
                        placeholder="Mínimo 8 caracteres"
                    >
                    @error('password')
                        <span class="mt-1 block text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="mb-1 block text-xs font-semibold text-slate-600">Confirmar nueva contraseña</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control"
                        required
                        autocomplete="new-password"
                        placeholder="Repite la nueva contraseña"
                    >
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Guardar contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
