@extends('layouts.app')

@section('styles')
<style>
    .dashboard-card {
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        border: none;
        overflow: hidden;
    }
    
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px;
        border-radius: 15px;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        transform: translate(30px, -30px);
    }
    
    .stat-card.blue {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .stat-card.green {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    
    .stat-card.orange {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    
    .stat-card.teal {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        margin: 10px 0;
    }
    
    .stat-icon {
        font-size: 3rem;
        opacity: 0.3;
        position: absolute;
        right: 20px;
        bottom: 20px;
    }
    
    .table-responsive-custom {
        max-height: 400px;
        overflow-y: auto;
    }
    
    .badge-status {
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .badge-reposo {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }
    
    .badge-servicio {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }
    
    .timeline-item {
        border-left: 3px solid #667eea;
        padding-left: 20px;
        margin-bottom: 20px;
        position: relative;
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -8px;
        top: 0;
        width: 13px;
        height: 13px;
        border-radius: 50%;
        background: #667eea;
    }
    
    .card-header-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: bold;
        border: none;
        padding: 15px 20px;
    }
    
    .empty-state {
        text-align: center;
        padding: 40px;
        color: #999;
    }
    
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 15px;
        opacity: 0.3;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    .urgent-notification {
        animation: pulse 2s infinite;
        background: #ff4444 !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Título del Dashboard -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="font-weight-bold text-dark">
                <i class="fas fa-chart-line mr-2"></i>Dashboard - Sistema CPET
            </h2>
            <p class="text-muted">Resumen general del sistema de gestión policial</p>
        </div>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card blue">
                <h6 class="text-uppercase mb-1">Total Funcionarios</h6>
                <div class="stat-number">{{ number_format($totalOfficers, 0, '', '.') }}</div>
                <p class="mb-0">Registrados en el sistema</p>
                <i class="fas fa-users stat-icon"></i>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card green">
                <h6 class="text-uppercase mb-1">Operativos</h6>
                <div class="stat-number">{{ number_format($operativos, 0, '', '.') }}</div>
                <p class="mb-0">En servicio activo</p>
                <i class="fas fa-user-check stat-icon"></i>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card orange">
                <h6 class="text-uppercase mb-1">En Reposo</h6>
                <div class="stat-number">{{ number_format($funcionariosReposo->count(), 0, '', '.') }}</div>
                <p class="mb-0">Reposos médicos vigentes</p>
                <i class="fas fa-bed stat-icon"></i>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card teal">
                <h6 class="text-uppercase mb-1">Radiogramas</h6>
                <div class="stat-number">{{ number_format($funcionariosServicio->count(), 0, '', '.') }}</div>
                <p class="mb-0">Asignaciones activas</p>
                <i class="fas fa-file-alt stat-icon"></i>
            </div>
        </div>
    </div>

    <!-- Fila de Tablas -->
    <div class="row">
        <!-- Funcionarios en Reposo -->
        <div class="col-lg-6 mb-4">
            <div class="card dashboard-card">
                <div class="card-header card-header-custom">
                    <i class="fas fa-heartbeat mr-2"></i>Funcionarios en Reposo Médico
                    <span class="badge badge-light float-right">{{ $funcionariosReposo->count() }}</span>
                </div>
                <div class="card-body p-0">
                    @if($funcionariosReposo->count() > 0)
                        <div class="table-responsive-custom">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Funcionario</th>
                                        <th>Diagnóstico</th>
                                        <th>Inicio</th>
                                        <th>Fin</th>
                                        <th>Días</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($funcionariosReposo as $reposo)
                                    <tr>
                                        <td>
                                            <strong>{{ $reposo->oficiale->nombre_completo }}</strong><br>
                                            <small class="text-muted">{{ $reposo->oficiale->documento_identidad }}</small>
                                        </td>
                                        <td>
                                            <small>{{ Str::limit($reposo->diagnostico, 30) }}</small>
                                        </td>
                                        <td>
                                            <small>{{ \Carbon\Carbon::parse($reposo->fecha_reposo_inicio)->format('d/m/Y') }}</small>
                                        </td>
                                        <td>
                                            <small class="font-weight-bold {{ \Carbon\Carbon::parse($reposo->fecha_reposo_fin)->isPast() ? 'text-danger' : 'text-success' }}">
                                                {{ \Carbon\Carbon::parse($reposo->fecha_reposo_fin)->format('d/m/Y') }}
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge badge-reposo">{{ $reposo->dias_reposo }} días</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-smile"></i>
                            <p>No hay funcionarios en reposo actualmente</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Funcionarios en Servicio (Radiogramas) -->
        <div class="col-lg-6 mb-4">
            <div class="card dashboard-card">
                <div class="card-header card-header-custom">
                    <i class="fas fa-broadcast-tower mr-2"></i>Asignaciones de Servicio (Radiogramas)
                    <span class="badge badge-light float-right">{{ $funcionariosServicio->count() }}</span>
                </div>
                <div class="card-body p-0">
                    @if($funcionariosServicio->count() > 0)
                        <div class="table-responsive-custom">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Funcionario</th>
                                        <th>Estación</th>
                                        <th>Fecha Inicio</th>
                                        <th>Descripción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($funcionariosServicio as $servicio)
                                    <tr>
                                        <td>
                                            <strong>{{ $servicio->oficiale->nombre_completo }}</strong><br>
                                            <small class="text-muted">{{ $servicio->oficiale->documento_identidad }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-servicio">{{ $servicio->estacione->estacion }}</span>
                                        </td>
                                        <td>
                                            <small>{{ \Carbon\Carbon::parse($servicio->fecha_inicio)->format('d/m/Y') }}</small><br>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($servicio->fecha_inicio)->diffForHumans() }}</small>
                                        </td>
                                        <td>
                                            <small>{{ Str::limit($servicio->descripcion ?? 'Sin descripción', 40) }}</small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>No hay radiogramas activos actualmente</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Notificaciones Urgentes -->
    @if($notificaciones->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning border-0 shadow-sm" role="alert">
                <h5 class="alert-heading">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Notificaciones Urgentes - Reincorporaciones Próximas
                </h5>
                <hr>
                <div class="row">
                    @foreach($notificaciones as $notif)
                    <div class="col-md-6 mb-3">
                        <div class="timeline-item">
                            <strong>{{ $notif->oficiale->nombre_completo }}</strong><br>
                            <small class="text-muted">
                                <i class="fas fa-calendar-check mr-1"></i>
                                Se reincorpora mañana ({{ \Carbon\Carbon::parse($notif->fecha_reposo_fin)->format('d/m/Y') }})
                            </small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Auto-refresh cada 5 minutos
        setTimeout(function() {
            location.reload();
        }, 300000); // 5 minutos
    });
</script>
@endsection
