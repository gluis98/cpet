<style>
    #reportesModal .modal-dialog {
        max-width: 920px;
    }

    #reportesModal .modal-content {
        border: 0;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 25px 50px rgba(15, 39, 68, 0.22);
    }

    #reportesModal .modal-header {
        background: linear-gradient(135deg, #0f2744 0%, #1a4574 100%) !important;
        color: #fff !important;
        border: 0 !important;
        padding: 1rem 1.25rem;
    }

    #reportesModal .modal-header .modal-title,
    #reportesModal .modal-header small {
        color: #fff !important;
    }

    #reportesModal .modal-header .close {
        color: #fff !important;
        opacity: 0.85;
        text-shadow: none;
    }

    #reportesModal .modal-body {
        padding: 0;
    }

    #reportesModal .modal-footer {
        border-top: 1px solid #e8eef5;
        background: #f8fafc;
    }

    .reportes-layout {
        display: flex;
        min-height: 420px;
        max-height: min(72vh, 560px);
    }

    .reportes-sidebar {
        flex: 0 0 240px;
        background: linear-gradient(180deg, #f8fafc 0%, #eef3f9 100%);
        border-right: 1px solid #e2e8f0;
        overflow-y: auto;
        padding: 0.75rem 0.5rem;
    }

    .reportes-sidebar__group {
        margin-bottom: 0.85rem;
    }

    .reportes-sidebar__label {
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #64748b;
        padding: 0.35rem 0.75rem 0.25rem;
    }

    .reportes-sidebar__item {
        display: flex;
        align-items: flex-start;
        gap: 0.55rem;
        width: 100%;
        border: 0;
        border-radius: 0.65rem;
        background: transparent;
        text-align: left;
        padding: 0.6rem 0.75rem;
        font-family: inherit;
        font-size: 0.8125rem;
        font-weight: 500;
        color: #475569;
        cursor: pointer;
        transition: background 0.15s, color 0.15s, box-shadow 0.15s;
    }

    .reportes-sidebar__item i {
        width: 1.1rem;
        margin-top: 0.1rem;
        color: #94a3b8;
        flex-shrink: 0;
    }

    .reportes-sidebar__item:hover {
        background: rgba(255, 255, 255, 0.85);
        color: #1a4574;
    }

    .reportes-sidebar__item.is-active {
        background: #fff;
        color: #0f2744;
        box-shadow: 0 2px 8px rgba(15, 39, 68, 0.08);
        font-weight: 600;
    }

    .reportes-sidebar__item.is-active i {
        color: #c4922e;
    }

    .reportes-panel {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-width: 0;
        background: #fff;
    }

    .reportes-panel__head {
        padding: 1.25rem 1.5rem 0.75rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .reportes-panel__head h4 {
        margin: 0 0 0.35rem;
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f2744 !important;
    }

    .reportes-panel__head p {
        margin: 0;
        font-size: 0.8125rem;
        color: #64748b !important;
        line-height: 1.45;
    }

    .reportes-panel__body {
        flex: 1;
        overflow-y: auto;
        padding: 1.25rem 1.5rem 1.5rem;
    }

    .reportes-panel__section {
        display: none;
    }

    .reportes-panel__section.is-active {
        display: block;
    }

    .reportes-panel .form-group label {
        font-size: 0.8125rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.35rem;
    }

    .reportes-panel .form-control {
        border-radius: 0.55rem;
        border-color: #c9d5e3;
        font-size: 0.875rem;
    }

    .reportes-panel .form-control:focus {
        border-color: #4f8cc4;
        box-shadow: 0 0 0 3px rgba(47, 111, 173, 0.15);
    }

    .reportes-sizes-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.75rem 1rem;
    }

    @media (max-width: 767px) {
        .reportes-layout {
            flex-direction: column;
            max-height: none;
        }

        .reportes-sidebar {
            flex: none;
            max-height: 180px;
            border-right: 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .reportes-sizes-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="modal fade" id="reportesModal" tabindex="-1" role="dialog" aria-labelledby="reportesModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mb-0" id="reportesModalLabel">
                        <i class="fas fa-file-export mr-2"></i> Generar reportes
                    </h5>
                    <small class="d-block mt-1" style="opacity: 0.85;">Seleccione un tipo de reporte y configure los filtros</small>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="reportes-layout">
                    {{-- Sidebar --}}
                    <nav class="reportes-sidebar" aria-label="Tipos de reporte">
                        <div class="reportes-sidebar__group">
                            <div class="reportes-sidebar__label">Oficiales</div>
                            <button type="button" class="reportes-sidebar__item is-active" data-report="ficha">
                                <i class="fas fa-id-card"></i>
                                <span>Ficha de oficial</span>
                            </button>
                            <button type="button" class="reportes-sidebar__item" data-report="general">
                                <i class="fas fa-users"></i>
                                <span>Reporte general</span>
                            </button>
                            <button type="button" class="reportes-sidebar__item" data-report="tallas">
                                <i class="fas fa-ruler-combined"></i>
                                <span>Por tallas</span>
                            </button>
                            <button type="button" class="reportes-sidebar__item" data-report="nacimiento">
                                <i class="fas fa-birthday-cake"></i>
                                <span>Por fecha de nacimiento</span>
                            </button>
                            <button type="button" class="reportes-sidebar__item" data-report="ingreso">
                                <i class="fas fa-calendar-check"></i>
                                <span>Por fecha de ingreso</span>
                            </button>
                            <button type="button" class="reportes-sidebar__item" data-report="filtros">
                                <i class="fas fa-filter"></i>
                                <span>Filtros avanzados</span>
                            </button>
                        </div>

                        <div class="reportes-sidebar__group">
                            <div class="reportes-sidebar__label">Cargos</div>
                            <button type="button" class="reportes-sidebar__item" data-report="cargo">
                                <i class="fas fa-medal"></i>
                                <span>Por cargo / jerarquía</span>
                            </button>
                        </div>

                        <div class="reportes-sidebar__group">
                            <div class="reportes-sidebar__label">Familiares</div>
                            <button type="button" class="reportes-sidebar__item" data-report="familiares">
                                <i class="fas fa-heart"></i>
                                <span>Por parentesco</span>
                            </button>
                        </div>

                        <div class="reportes-sidebar__group">
                            <div class="reportes-sidebar__label">URRA</div>
                            <button type="button" class="reportes-sidebar__item" data-report="urra_historial">
                                <i class="fas fa-history"></i>
                                <span>Historial URRA</span>
                            </button>
                            <button type="button" class="reportes-sidebar__item" data-report="urra_actuales">
                                <i class="fas fa-user-shield"></i>
                                <span>Actualmente en URRA</span>
                            </button>
                        </div>
                    </nav>

                    {{-- Panel de filtros --}}
                    <div class="reportes-panel">
                        <div class="reportes-panel__head">
                            <h4 id="reportes-panel-title">Ficha de oficial</h4>
                            <p id="reportes-panel-desc">Genera la ficha individual de un funcionario por su documento de identidad.</p>
                        </div>

                        <div class="reportes-panel__body">
                            {{-- Ficha --}}
                            <div class="reportes-panel__section is-active" data-report-panel="ficha">
                                <form action="{{ route('report.officers.card') }}" method="GET" target="_blank">
                                    <div class="form-group">
                                        <label for="rep_documento_identidad">Documento de identidad <span class="text-danger">*</span></label>
                                        <input type="text" name="documento_identidad" id="rep_documento_identidad" class="form-control" required
                                               placeholder="Ejemplo: 12345678">
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-file-pdf mr-1"></i> Generar reporte
                                    </button>
                                </form>
                            </div>

                            {{-- General --}}
                            <div class="reportes-panel__section" data-report-panel="general">
                                <form action="{{ route('report.officers') }}" method="GET" target="_blank">
                                    <div class="alert alert-info border-0 mb-3" style="background:#eef4fb;color:#1a4574;">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Incluye el listado completo de funcionarios registrados en el sistema.
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-file-pdf mr-1"></i> Generar reporte
                                    </button>
                                </form>
                            </div>

                            {{-- Tallas --}}
                            <div class="reportes-panel__section" data-report-panel="tallas">
                                <form action="{{ route('report.officers.sizes') }}" method="GET" target="_blank">
                                    <p class="text-muted small mb-3">Complete uno o más campos para filtrar. Deje en blanco los que no desee usar.</p>
                                    <div class="reportes-sizes-grid">
                                        @foreach ([
                                            'talla_camisa' => 'Talla camisa',
                                            'talla_pantalon' => 'Talla pantalón',
                                            'talla_zapato' => 'Talla zapatos',
                                            'talla_saco' => 'Talla saco',
                                            'talla_kepin_toka' => 'Talla kepi / toka',
                                            'talla_tacon' => 'Talla tacón',
                                            'talla_falda' => 'Talla falda',
                                            'talla_gorra' => 'Talla gorra',
                                        ] as $campo => $label)
                                            <div class="form-group mb-0">
                                                <label for="rep_{{ $campo }}">{{ $label }}</label>
                                                <input type="text" name="{{ $campo }}" id="rep_{{ $campo }}" class="form-control" value="{{ request($campo) }}">
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">
                                        <i class="fas fa-file-pdf mr-1"></i> Generar reporte
                                    </button>
                                </form>
                            </div>

                            {{-- Nacimiento --}}
                            <div class="reportes-panel__section" data-report-panel="nacimiento">
                                <form action="{{ route('report.officers_born_date') }}" method="GET" target="_blank">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="rep_nac_inicio">Fecha de nacimiento (desde)</label>
                                            <input type="date" class="form-control" id="rep_nac_inicio" name="fechaInicio">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="rep_nac_fin">Fecha de nacimiento (hasta)</label>
                                            <input type="date" class="form-control" id="rep_nac_fin" name="fechaFin">
                                        </div>
                                    </div>
                                    <p class="text-muted small">Puede indicar solo la fecha inicial para un día específico.</p>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-file-pdf mr-1"></i> Generar reporte
                                    </button>
                                </form>
                            </div>

                            {{-- Ingreso --}}
                            <div class="reportes-panel__section" data-report-panel="ingreso">
                                <form action="{{ route('report.officers.ingress_date') }}" method="GET" target="_blank">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="rep_ing_inicio">Fecha de ingreso (desde)</label>
                                            <input type="date" class="form-control" id="rep_ing_inicio" name="fechaInicio">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="rep_ing_fin">Fecha de ingreso (hasta)</label>
                                            <input type="date" class="form-control" id="rep_ing_fin" name="fechaFin">
                                        </div>
                                    </div>
                                    <p class="text-muted small">Puede indicar solo la fecha inicial para un día específico.</p>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-file-pdf mr-1"></i> Generar reporte
                                    </button>
                                </form>
                            </div>

                            {{-- Filtros avanzados --}}
                            <div class="reportes-panel__section" data-report-panel="filtros">
                                <form action="{{ route('report.officers.filtered') }}" method="GET" target="_blank">
                                    <p class="text-muted small mb-3">Combine los filtros que necesite. Deje en blanco los que no desee usar.</p>
                                    <div class="reportes-sizes-grid">
                                        <div class="form-group mb-0">
                                            <label for="rep_sexo">Sexo</label>
                                            <select class="form-control" name="sexo" id="rep_sexo">
                                                <option value="">— Cualquiera —</option>
                                                @foreach (\App\Models\Oficiale::SEXOS as $sx)
                                                    <option value="{{ $sx }}">{{ $sx }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-0">
                                            <label for="rep_tipo_sangre">Tipo de sangre</label>
                                            <select class="form-control" name="tipo_sangre" id="rep_tipo_sangre">
                                                <option value="">— Cualquiera —</option>
                                                @foreach (['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $ts)
                                                    <option value="{{ $ts }}">{{ $ts }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-0">
                                            <label for="rep_estado_civil">Estado civil</label>
                                            <select class="form-control" name="estado_civil" id="rep_estado_civil">
                                                <option value="">— Cualquiera —</option>
                                                @foreach (['Soltero','Casado','Divorciado','Viudo','Separado','Unión libre','Concubinato'] as $ec)
                                                    <option value="{{ $ec }}">{{ $ec }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-0">
                                            <label for="rep_cantidad_hijos">Cantidad de hijos</label>
                                            <select class="form-control" name="cantidad_hijos" id="rep_cantidad_hijos">
                                                <option value="">— Cualquiera —</option>
                                                @foreach (['0','1','2','3'] as $n)
                                                    <option value="{{ $n }}">{{ $n }}</option>
                                                @endforeach
                                                <option value="4+">4 o más</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-0">
                                            <label for="rep_tipo_funcionario">Tipo de funcionario</label>
                                            <select class="form-control" name="tipo_funcionario" id="rep_tipo_funcionario">
                                                <option value="">— Cualquiera —</option>
                                                @foreach (\App\Models\Oficiale::TIPOS_FUNCIONARIO as $tf)
                                                    <option value="{{ $tf }}">{{ $tf }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-0">
                                            <label for="rep_cargo_admin">Cargo (administrativo)</label>
                                            <select class="form-control" name="cargo_administrativo_id" id="rep_cargo_admin">
                                                <option value="">— Cualquiera —</option>
                                                @foreach (\App\Models\CargosAdministrativo::orderBy('nombre_cargo')->get() as $ca)
                                                    <option value="{{ $ca->id }}">{{ $ca->nombre_cargo }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-0">
                                            <label for="rep_estatus">Estatus</label>
                                            <select class="form-control" name="estatus" id="rep_estatus">
                                                <option value="">— Cualquiera —</option>
                                                @foreach (\App\Models\Oficiale::ESTATUS as $st)
                                                    <option value="{{ $st }}">{{ $st }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-0">
                                            <label for="rep_id_cargo_f">Jerarquía</label>
                                            <select class="form-control" name="id_cargo" id="rep_id_cargo_f">
                                                <option value="">— Cualquiera —</option>
                                                @foreach (\App\Models\Cargo::orderBy('nombre_cargo')->get() as $cargo)
                                                    <option value="{{ $cargo->id }}">{{ $cargo->nombre_cargo }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-0">
                                            <label for="rep_tipo_formacion">Formación académica</label>
                                            <select class="form-control" name="tipo_formacion" id="rep_tipo_formacion">
                                                <option value="">— Cualquiera —</option>
                                                @foreach (['Primaria','Secundaria','Bachillerato','Bachiller en Ciencias','Técnico superior universitario','Licenciatura','Ingeniería','Especialización','Maestría','Doctorado','Post-doctorado'] as $fa)
                                                    <option value="{{ $fa }}">{{ $fa }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-0">
                                            <label for="rep_posee_vivienda">¿Posee vivienda?</label>
                                            <select class="form-control" name="posee_vivienda" id="rep_posee_vivienda">
                                                <option value="">— Cualquiera —</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-0">
                                            <label for="rep_tipo_vivienda">Tipo de vivienda</label>
                                            <select class="form-control" name="tipo_vivienda" id="rep_tipo_vivienda">
                                                <option value="">— Cualquiera —</option>
                                                @foreach (\App\Models\Oficiale::TIPOS_VIVIENDA as $tv)
                                                    <option value="{{ $tv }}">{{ $tv }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-0">
                                            <label for="rep_sabe_conducir">¿Sabe conducir?</label>
                                            <select class="form-control" name="sabe_conducir" id="rep_sabe_conducir">
                                                <option value="">— Cualquiera —</option>
                                                <option value="1">Sí</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-0">
                                            <label for="rep_tipo_conduccion">Tipo de vehículo</label>
                                            <select class="form-control" name="tipo_conduccion" id="rep_tipo_conduccion">
                                                <option value="">— Cualquiera —</option>
                                                @foreach (\App\Models\Oficiale::TIPOS_CONDUCCION as $tc)
                                                    <option value="{{ $tc }}">{{ $tc }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-check mt-3 mb-2">
                                        <input class="form-check-input" type="checkbox" name="jerarquia_actual" value="1" id="rep_jerarquia_actual" checked>
                                        <label class="form-check-label" for="rep_jerarquia_actual">Solo jerarquía actual (si filtra por jerarquía)</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2">
                                        <i class="fas fa-file-pdf mr-1"></i> Generar reporte
                                    </button>
                                </form>
                            </div>

                            {{-- Cargo --}}
                            <div class="reportes-panel__section" data-report-panel="cargo">
                                <form action="{{ route('report.officers.officers_cargo') }}" method="GET" target="_blank">
                                    <div class="form-group">
                                        <label for="rep_id_cargo">Cargo / jerarquía <span class="text-danger">*</span></label>
                                        <select class="form-control" name="id_cargo" id="rep_id_cargo" required>
                                            <option value="">Seleccione un cargo</option>
                                            @foreach (\App\Models\Cargo::orderBy('nombre_cargo')->get() as $cargo)
                                                <option value="{{ $cargo->id }}">{{ $cargo->nombre_cargo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="rep_cargo_inicio">Fecha desde (opcional)</label>
                                            <input type="date" class="form-control" id="rep_cargo_inicio" name="fechaInicio">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="rep_cargo_fin">Fecha hasta (opcional)</label>
                                            <input type="date" class="form-control" id="rep_cargo_fin" name="fechaFin">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-file-pdf mr-1"></i> Generar reporte
                                    </button>
                                </form>
                            </div>

                            {{-- Familiares --}}
                            <div class="reportes-panel__section" data-report-panel="familiares">
                                <form action="{{ route('report.officers.family_members') }}" method="GET" target="_blank">
                                    <div class="form-group">
                                        <label for="rep_parentesco">Parentesco</label>
                                        <select class="form-control" name="parentesco" id="rep_parentesco">
                                            <option value="">Todos</option>
                                            <option value="Padre">Padre</option>
                                            <option value="Madre">Madre</option>
                                            <option value="Hijo(a)">Hijo(a)</option>
                                            <option value="Esposo(a)">Esposo(a)</option>
                                            <option value="Conyugue">Conyugue</option>
                                            <option value="Union Estable de Hechos">Unión Estable de Hechos</option>
                                        </select>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="rep_fam_nac_inicio">Fecha de nacimiento (desde)</label>
                                            <input type="date" class="form-control" id="rep_fam_nac_inicio" name="fecha_nacimiento_inicio">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="rep_fam_nac_fin">Fecha de nacimiento (hasta)</label>
                                            <input type="date" class="form-control" id="rep_fam_nac_fin" name="fecha_nacimiento_fin">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="rep_edad_min">Edad (desde)</label>
                                            <input type="number" class="form-control" id="rep_edad_min" name="edad_min" min="0" max="120" placeholder="Ej: 5">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="rep_edad_max">Edad (hasta)</label>
                                            <input type="number" class="form-control" id="rep_edad_max" name="edad_max" min="0" max="120" placeholder="Ej: 18">
                                        </div>
                                    </div>
                                    <p class="text-muted small mb-3">Puede filtrar por edad sola o combinarla con las fechas de nacimiento. Para una edad exacta, indique el mismo valor en «desde» y «hasta».</p>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-file-pdf mr-1"></i> Generar reporte
                                    </button>
                                </form>
                            </div>

                            {{-- URRA historial --}}
                            <div class="reportes-panel__section" data-report-panel="urra_historial">
                                <form action="{{ route('report.urra.historial') }}" method="GET" target="_blank">
                                    <div class="alert alert-info border-0 mb-3" style="background:#eef4fb;color:#1a4574;">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Lista todos los registros URRA (funcionarios que ya han asistido o están asignados).
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-file-pdf mr-1"></i> Generar reporte
                                    </button>
                                </form>
                            </div>

                            {{-- URRA actuales --}}
                            <div class="reportes-panel__section" data-report-panel="urra_actuales">
                                <form action="{{ route('report.urra.actuales') }}" method="GET" target="_blank">
                                    <div class="alert alert-info border-0 mb-3" style="background:#eef4fb;color:#1a4574;">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Solo funcionarios con asignación URRA marcada como «en servicio».
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-file-pdf mr-1"></i> Generar reporte
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var meta = {
        ficha: {
            title: 'Ficha de oficial',
            desc: 'Genera la ficha individual de un funcionario por su documento de identidad.'
        },
        general: {
            title: 'Reporte general de oficiales',
            desc: 'Listado completo de todos los funcionarios registrados en el sistema.'
        },
        tallas: {
            title: 'Reporte por tallas',
            desc: 'Filtra funcionarios según tallas de uniforme y calzado.'
        },
        nacimiento: {
            title: 'Reporte por fecha de nacimiento',
            desc: 'Funcionarios cuya fecha de nacimiento esté dentro del rango indicado.'
        },
        ingreso: {
            title: 'Reporte por fecha de ingreso',
            desc: 'Funcionarios que ingresaron al cuerpo policial en el período seleccionado.'
        },
        filtros: {
            title: 'Filtros avanzados',
            desc: 'Filtra por sexo, sangre, estado civil, hijos, cargo, estatus, jerarquía, formación, vivienda y conducción.'
        },
        cargo: {
            title: 'Reporte por cargo / jerarquía',
            desc: 'Funcionarios asignados a un cargo determinado, con filtro opcional por fechas.'
        },
        familiares: {
            title: 'Reporte de familiares',
            desc: 'Familiares filtrados por parentesco, rango de edad y/o fecha de nacimiento.'
        },
        urra_historial: {
            title: 'Historial URRA',
            desc: 'Funcionarios que han tenido (o tienen) una asignación URRA registrada.'
        },
        urra_actuales: {
            title: 'Actualmente en URRA',
            desc: 'Funcionarios cuya asignación URRA está marcada como en servicio.'
        }
    };

    function activateReport(key) {
        var info = meta[key] || meta.ficha;

        document.querySelectorAll('.reportes-sidebar__item').forEach(function (btn) {
            btn.classList.toggle('is-active', btn.getAttribute('data-report') === key);
        });

        document.querySelectorAll('.reportes-panel__section').forEach(function (panel) {
            panel.classList.toggle('is-active', panel.getAttribute('data-report-panel') === key);
        });

        var titleEl = document.getElementById('reportes-panel-title');
        var descEl = document.getElementById('reportes-panel-desc');
        if (titleEl) titleEl.textContent = info.title;
        if (descEl) descEl.textContent = info.desc;
    }

    document.querySelectorAll('.reportes-sidebar__item').forEach(function (btn) {
        btn.addEventListener('click', function () {
            activateReport(btn.getAttribute('data-report'));
        });
    });

    var modal = document.getElementById('reportesModal');
    if (modal && typeof $ !== 'undefined') {
        $(modal).on('shown.bs.modal', function () {
            var active = document.querySelector('.reportes-sidebar__item.is-active');
            activateReport(active ? active.getAttribute('data-report') : 'ficha');
        });
    }
});
</script>
