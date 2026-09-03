<?php

namespace App\Support\BulkImport;

class BulkImportRegistry
{
    public static function documentoIdentidadColumn(string $help = 'Cédula del funcionario'): array
    {
        return [
            'key' => 'documento_identidad',
            'label' => 'documento_identidad',
            'required' => true,
            'example' => '12345678',
            'help' => $help,
            'aliases' => [
                'cedula',
                'cédula',
                'documento',
                'ci',
                'c i',
                'cedula identidad',
                'cedula de identidad',
                'cédula de identidad',
                'numero cedula',
                'número cédula',
                'nro cedula',
                'nro cédula',
                'nro documento',
                'numero documento',
                'num documento',
                'doc identidad',
                'doc',
                'documento identidad',
                'cedula funcionario',
                'cedula del funcionario',
                'documento del funcionario',
                'nro documento identidad',
                'identificacion',
                'identificación',
                'id funcionario',
            ],
        ];
    }

    public static function modules(): array
    {
        return [
            'funcionarios' => [
                'title' => 'Funcionarios',
                'icon' => 'fas fa-users',
                'group' => 'Principal',
                'description' => 'Alta masiva de funcionarios policiales, administrativos u obreros.',
                'parent_key' => null,
                'columns' => [
                    self::documentoIdentidadColumn('Cédula (única)'),
                    ['key' => 'nombre_completo', 'label' => 'nombre_completo', 'required' => true, 'example' => 'Juan Pérez', 'help' => 'Nombre y apellido'],
                    ['key' => 'fecha_nacimiento', 'label' => 'fecha_nacimiento', 'required' => true, 'example' => '15/05/1990', 'help' => 'YYYY-MM-DD o DD/MM/YYYY'],
                    ['key' => 'sexo', 'label' => 'sexo', 'required' => false, 'example' => 'Masculino', 'help' => 'Masculino | Femenino'],
                    ['key' => 'numero_placa', 'label' => 'numero_placa', 'required' => false, 'example' => 'CP-001', 'help' => 'N° de credencial (opcional; vacío = Sin Credencial Asignada)'],
                    ['key' => 'fecha_ingreso', 'label' => 'fecha_ingreso', 'required' => true, 'example' => '10/01/2015', 'help' => 'YYYY-MM-DD o DD/MM/YYYY'],
                    ['key' => 'estatus', 'label' => 'estatus', 'required' => true, 'example' => 'Operativo', 'help' => 'Operativo, No Operativo, En Reposo, Retirado, Suspendido, Jubilado, Fallecido, URRA'],
                    ['key' => 'tipo_funcionario', 'label' => 'tipo_funcionario', 'required' => true, 'example' => 'Policial', 'help' => 'Policial | Administrativo | Obrero'],
                    ['key' => 'telefono', 'label' => 'telefono', 'required' => false, 'example' => '04141234567', 'help' => 'Teléfono principal (opcional)'],
                    ['key' => 'correo_electronico', 'label' => 'correo_electronico', 'required' => false, 'example' => 'juan@correo.com', 'help' => 'Email (opcional)'],
                    ['key' => 'cargo', 'label' => 'cargo', 'required' => false, 'example' => 'SECRETARIO I', 'help' => 'Nombre exacto en Cargos administrativos'],
                    ['key' => 'tipo_sangre', 'label' => 'tipo_sangre', 'required' => false, 'example' => 'O+', 'help' => 'A+/A-/B+/B-/AB+/AB-/O+/O-'],
                    ['key' => 'estado_civil', 'label' => 'estado_civil', 'required' => false, 'example' => 'Soltero', 'help' => 'Estado civil'],
                    ['key' => 'direccion', 'label' => 'direccion', 'required' => false, 'example' => 'Calle 1', 'help' => 'Dirección'],
                    ['key' => 'centro_votacion', 'label' => 'centro_votacion', 'required' => false, 'example' => 'Escuela X', 'help' => 'Centro de votación (requiere municipio y parroquia)'],
                    ['key' => 'municipio', 'label' => 'municipio', 'required' => false, 'example' => 'Valera', 'help' => 'Municipio del centro de votación (Estado Trujillo)'],
                    ['key' => 'parroquia', 'label' => 'parroquia', 'required' => false, 'example' => 'La Beatriz', 'help' => 'Parroquia del centro de votación'],
                    ['key' => 'tipo_vivienda', 'label' => 'tipo_vivienda', 'required' => false, 'example' => 'Propia', 'help' => 'Propia | Alquilada | No posee'],
                    ['key' => 'direccion_vivienda', 'label' => 'direccion_vivienda', 'required' => false, 'example' => 'Av. 2', 'help' => 'Si vivienda Propia/Alquilada'],
                    ['key' => 'sabe_conducir', 'label' => 'sabe_conducir', 'required' => false, 'example' => '1', 'help' => '0 o 1'],
                    ['key' => 'tipos_conduccion', 'label' => 'tipos_conduccion', 'required' => false, 'example' => 'Vehículo;Moto', 'help' => 'Separar con ; → Vehículo, Moto, Jack, Grúa'],
                    ['key' => 'telefono_residencial', 'label' => 'telefono_residencial', 'required' => false, 'example' => '02711234567', 'help' => 'Teléfono residencial'],
                    ['key' => 'talla_camisa', 'label' => 'talla_camisa', 'required' => false, 'example' => 'M', 'help' => 'Talla'],
                    ['key' => 'talla_pantalon', 'label' => 'talla_pantalon', 'required' => false, 'example' => '32', 'help' => 'Talla'],
                    ['key' => 'talla_zapatos', 'label' => 'talla_zapatos', 'required' => false, 'example' => '42', 'help' => 'Talla'],
                    ['key' => 'talla_saco', 'label' => 'talla_saco', 'required' => false, 'example' => '40', 'help' => 'Talla'],
                    ['key' => 'talla_kepin_toka', 'label' => 'talla_kepin_toka', 'required' => false, 'example' => '7', 'help' => 'Talla'],
                    ['key' => 'talla_tacon', 'label' => 'talla_tacon', 'required' => false, 'example' => '38', 'help' => 'Talla'],
                    ['key' => 'talla_falda', 'label' => 'talla_falda', 'required' => false, 'example' => 'M', 'help' => 'Talla'],
                    ['key' => 'talla_gorra', 'label' => 'talla_gorra', 'required' => false, 'example' => 'L', 'help' => 'Talla'],
                ],
                'notes' => [
                    'La fotografía no se carga por Excel; se asigna luego en el formulario.',
                    'Si el documento_identidad ya existe, la fila se omite (no se actualiza).',
                    'Si hay registros duplicados en BD, se eliminan dejando solo el más antiguo.',
                    'Las fechas aceptan formato DD/MM/YYYY (Excel en español) o YYYY-MM-DD.',
                    'numero_placa es opcional; si está vacío se guardará como Sin Credencial Asignada.',
                    'El campo cargo debe coincidir con un registro de Configuraciones → Cargos administrativos (o se crea).',
                ],
            ],
            'cargos_funcionarios' => [
                'title' => 'Cargos administrativos',
                'icon' => 'fas fa-briefcase',
                'group' => 'Submódulos',
                'description' => 'Asignar o actualizar el cargo administrativo de funcionarios existentes.',
                'parent_key' => 'documento_identidad',
                'columns' => [
                    self::documentoIdentidadColumn('Cédula del funcionario'),
                    ['key' => 'cargo', 'label' => 'cargo', 'required' => true, 'example' => 'SECRETARIO I', 'help' => 'Nombre en Configuraciones → Cargos administrativos'],
                ],
                'notes' => [
                    'El funcionario (documento_identidad) debe existir previamente.',
                    'Actualiza cargo_administrativo_id del funcionario.',
                    'Si el cargo no existe en el catálogo, se crea automáticamente.',
                    'Si la misma cédula+cargo ya está asignada, la fila se omite.',
                    'Si hay funcionarios duplicados por cédula en BD, se dejan solo uno.',
                ],
            ],
            'familiares' => [
                'title' => 'Familiares',
                'icon' => 'fas fa-heart',
                'group' => 'Submódulos',
                'description' => 'Carga de hijos y familiares vinculados a un funcionario existente.',
                'parent_key' => 'documento_identidad',
                'columns' => [
                    self::documentoIdentidadColumn('Cédula del funcionario padre'),
                    ['key' => 'nombre_completo', 'label' => 'nombre_completo', 'required' => true, 'example' => 'María Pérez', 'help' => 'Nombre del familiar', 'aliases' => ['nombre completo', 'nombre y apellido', 'nombres y apellidos']],
                    ['key' => 'nombre_familiar', 'label' => 'nombre_familiar', 'required' => false, 'example' => '', 'help' => 'Alternativa si el nombre está en otra columna', 'aliases' => ['nombre del familiar', 'nombre']],
                    ['key' => 'parentesco', 'label' => 'parentesco', 'required' => true, 'example' => 'Hijo(a)', 'help' => 'Padre | Madre | Hijo(a) | Esposo(a) | Conyugue | Union Estable de Hechos'],
                    ['key' => 'fecha_nacimiento', 'label' => 'fecha_nacimiento', 'required' => true, 'example' => '2010-03-20', 'help' => 'YYYY-MM-DD o DD/MM/YYYY'],
                    ['key' => 'sexo', 'label' => 'sexo', 'required' => true, 'example' => 'F', 'help' => 'M o F'],
                    ['key' => 'posee_discapacidad', 'label' => 'posee_discapacidad', 'required' => true, 'example' => '0', 'help' => '0/No o 1/Si'],
                    ['key' => 'discapacidad', 'label' => 'discapacidad', 'required' => false, 'example' => 'Visual', 'help' => 'Obligatorio si posee_discapacidad=1 (nombre del catálogo)'],
                    ['key' => 'telefono', 'label' => 'telefono', 'required' => false, 'example' => '04140001122', 'help' => 'Teléfono'],
                    ['key' => 'direccion', 'label' => 'direccion', 'required' => false, 'example' => 'Calle 2', 'help' => 'Dirección'],
                    ['key' => 'edad', 'label' => 'edad', 'required' => false, 'example' => '14', 'help' => '0–120'],
                    ['key' => 'discapacidad_requerimientos', 'label' => 'discapacidad_requerimientos', 'required' => false, 'example' => 'Insulina', 'help' => 'Medicinas / apoyos'],
                    ['key' => 'discapacidad_observaciones', 'label' => 'discapacidad_observaciones', 'required' => false, 'example' => 'Control mensual', 'help' => 'Observaciones'],
                ],
                'notes' => [
                    'El funcionario (documento_identidad) debe existir previamente.',
                    'El informe médico no se adjunta por Excel.',
                    'Duplicado = mismo funcionario + nombre (sin acentos) + fecha de nacimiento: se omite y se eliminan extras en BD.',
                    'Al reimportar se limpian primero los duplicados ya existentes de ese funcionario.',
                ],
            ],
            'academia' => [
                'title' => 'Nivel académico',
                'icon' => 'fas fa-graduation-cap',
                'group' => 'Submódulos',
                'description' => 'Carga masiva de títulos y grados académicos del funcionario.',
                'parent_key' => 'documento_identidad',
                'columns' => [
                    self::documentoIdentidadColumn(),
                    ['key' => 'tipo_formacion', 'label' => 'tipo_formacion', 'required' => true, 'example' => 'Licenciatura', 'help' => 'Primaria, Secundaria, Bachillerato, Bachiller en Ciencias, Técnico superior universitario, Licenciatura, Ingeniería, Especialización, Maestría, Doctorado, Post-doctorado'],
                    ['key' => 'anio_graduacion', 'label' => 'anio_graduacion', 'required' => true, 'example' => '2018', 'help' => 'Año 1950–2100'],
                    ['key' => 'titulo', 'label' => 'titulo', 'required' => false, 'example' => 'Informática', 'help' => 'Nombre de la formación'],
                    ['key' => 'institucion', 'label' => 'institucion', 'required' => false, 'example' => 'ULA', 'help' => 'Institución'],
                    ['key' => 'descripcion', 'label' => 'descripcion', 'required' => false, 'example' => 'Mención…', 'help' => 'Descripción'],
                ],
                'notes' => [
                    'El documento fondo negro no se carga por Excel.',
                    'anio_graduacion se guarda como fecha_fin = AÑO-12-31.',
                    'Duplicado = mismo funcionario + tipo_formacion + año + título (se omite / se limpia en BD).',
                ],
            ],
            'cursos' => [
                'title' => 'Cursos y diplomados',
                'icon' => 'fas fa-book-reader',
                'group' => 'Submódulos',
                'description' => 'Cursos, diplomados y talleres del funcionario.',
                'parent_key' => 'documento_identidad',
                'columns' => [
                    self::documentoIdentidadColumn(),
                    ['key' => 'tipo', 'label' => 'tipo', 'required' => true, 'example' => 'Curso', 'help' => 'Curso | Diplomado | Taller'],
                    ['key' => 'nombre_curso', 'label' => 'nombre_curso', 'required' => true, 'example' => 'Criminalística', 'help' => 'Se busca/crea en catálogo de cursos'],
                    ['key' => 'fecha_inicio', 'label' => 'fecha_inicio', 'required' => true, 'example' => '2022-06-01', 'help' => 'YYYY-MM-DD o DD/MM/YYYY'],
                    ['key' => 'duracion_valor', 'label' => 'duracion_valor', 'required' => true, 'example' => '40', 'help' => 'Número 1–9999'],
                    ['key' => 'duracion_tipo', 'label' => 'duracion_tipo', 'required' => true, 'example' => 'Horas', 'help' => 'Años | Meses | Horas'],
                    ['key' => 'institucion', 'label' => 'institucion', 'required' => false, 'example' => 'CICPC', 'help' => 'Institución'],
                    ['key' => 'descripcion', 'label' => 'descripcion', 'required' => false, 'example' => 'Nivel básico', 'help' => 'Descripción'],
                ],
                'notes' => [
                    'Si nombre_curso no existe en el catálogo, se crea automáticamente.',
                    'Duplicado = mismo funcionario + curso + tipo + fecha_inicio (se omite / se limpia en BD).',
                ],
            ],
            'jerarquias' => [
                'title' => 'Jerarquías',
                'icon' => 'fas fa-medal',
                'group' => 'Submódulos',
                'description' => 'Historial de jerarquías policiales del funcionario.',
                'parent_key' => 'documento_identidad',
                'columns' => [
                    self::documentoIdentidadColumn(),
                    ['key' => 'jerarquia', 'label' => 'jerarquia', 'required' => true, 'example' => 'Inspector', 'help' => 'Nombre en Configuraciones → Cargos (se crea si no existe)'],
                    ['key' => 'fecha_inicio', 'label' => 'fecha_inicio', 'required' => true, 'example' => '15/03/2020', 'help' => 'YYYY-MM-DD o DD/MM/YYYY'],
                    ['key' => 'fecha_fin', 'label' => 'fecha_fin', 'required' => false, 'example' => '10/06/2024', 'help' => 'YYYY-MM-DD o DD/MM/YYYY (no aplica si is_actual=1)'],
                    ['key' => 'is_actual', 'label' => 'is_actual', 'required' => false, 'example' => '1', 'help' => '0 o 1 — marcar como jerarquía actual'],
                ],
                'notes' => [
                    'El funcionario (documento_identidad) debe existir previamente.',
                    'Si is_actual=1, las demás jerarquías del funcionario pasan a histórico.',
                    'Duplicado = misma jerarquía + fecha_inicio (se omite / se limpia en BD).',
                ],
            ],
            'reposos' => [
                'title' => 'Reposos médicos',
                'icon' => 'fas fa-medkit',
                'group' => 'Submódulos',
                'description' => 'Solicitudes de reposo médico del funcionario.',
                'parent_key' => 'documento_identidad',
                'columns' => [
                    self::documentoIdentidadColumn(),
                    ['key' => 'fecha_revision', 'label' => 'fecha_revision', 'required' => true, 'example' => '2026-01-10', 'help' => 'YYYY-MM-DD o DD/MM/YYYY'],
                    ['key' => 'diagnostico', 'label' => 'diagnostico', 'required' => true, 'example' => 'Lumbalgia', 'help' => 'Diagnóstico'],
                    ['key' => 'fecha_reposo_inicio', 'label' => 'fecha_reposo_inicio', 'required' => true, 'example' => '2026-01-11', 'help' => 'YYYY-MM-DD o DD/MM/YYYY'],
                    ['key' => 'estado_reposo', 'label' => 'estado_reposo', 'required' => true, 'example' => '1', 'help' => '1=Vigente | 2=Continuo | 0=Finalizado'],
                    ['key' => 'fecha_reposo_fin', 'label' => 'fecha_reposo_fin', 'required' => false, 'example' => '2026-01-20', 'help' => 'Obligatorio si estado_reposo=1; vacío si Continuo'],
                ],
                'notes' => [
                    'Los días de reposo se calculan automáticamente (días hábiles).',
                    'Los archivos del reposo no se cargan por Excel.',
                    'Un reposo vigente puede cambiar el estatus del funcionario a En Reposo.',
                    'Duplicado = mismo funcionario + inicio + diagnóstico + fecha revisión (se omite / se limpia en BD).',
                ],
            ],
            'vacaciones' => [
                'title' => 'Vacaciones',
                'icon' => 'fas fa-plane-departure',
                'group' => 'Submódulos',
                'description' => 'Solicitudes de vacaciones del funcionario.',
                'parent_key' => 'documento_identidad',
                'columns' => [
                    self::documentoIdentidadColumn('Cédula del funcionario'),
                    ['key' => 'fecha_emision', 'label' => 'fecha_emision', 'required' => true, 'example' => '2026-02-01', 'help' => 'Fecha desde / emisión (YYYY-MM-DD o DD/MM/YYYY)', 'aliases' => ['fecha de emision', 'fecha emision', 'fecha inicio', 'fecha desde', 'desde']],
                    ['key' => 'fecha_inicio', 'label' => 'fecha_inicio', 'required' => false, 'example' => '', 'help' => 'Alternativa a fecha_emision'],
                    ['key' => 'fecha_desde', 'label' => 'fecha_desde', 'required' => false, 'example' => '', 'help' => 'Alternativa a fecha_emision'],
                    ['key' => 'fecha_hasta', 'label' => 'fecha_hasta', 'required' => false, 'example' => '2026-02-14', 'help' => 'Fecha hasta del periodo (YYYY-MM-DD o DD/MM/YYYY)', 'aliases' => ['hasta', 'fecha hasta', 'fecha fin periodo']],
                    ['key' => 'estatus', 'label' => 'estatus', 'required' => true, 'example' => 'APROBADAS', 'help' => 'APROBADAS | NEGADAS | VENCIDAS | REGLAMENTARIAS | EN PROCESO', 'aliases' => ['estado', 'status', 'estatus vacaciones']],
                    ['key' => 'estado', 'label' => 'estado', 'required' => false, 'example' => '', 'help' => 'Alternativa a estatus'],
                    ['key' => 'fecha_reintegro', 'label' => 'fecha_reintegro', 'required' => false, 'example' => '2026-02-15', 'help' => 'Fecha de reintegro (independiente de hasta)', 'aliases' => ['fecha de reintegro', 'fecha reintegro', 'reintegro']],
                    ['key' => 'fecha_fin', 'label' => 'fecha_fin', 'required' => false, 'example' => '', 'help' => 'Alternativa a fecha_hasta'],
                    ['key' => 'is_disfrutadas', 'label' => 'is_disfrutadas', 'required' => false, 'example' => '0', 'help' => '0 o 1 (si reintegro ≤ hoy se marca 1)', 'aliases' => ['disfrutadas', 'vacaciones disfrutadas']],
                    ['key' => 'descripcion', 'label' => 'descripcion', 'required' => false, 'example' => 'Periodo ordinaria', 'help' => 'Descripción', 'aliases' => ['observaciones', 'nota', 'detalle']],
                ],
                'notes' => [
                    'El estatus se guarda en mayúsculas.',
                    'fecha_hasta es el fin del periodo; fecha_reintegro es el día de reintegro (pueden diferir).',
                    'Acepta encabezados como "Fecha de emisión", "Cédula", "Estado", etc.',
                    'Duplicado = mismo funcionario + fecha_emision + estatus (se omite / se limpia en BD).',
                ],
            ],
            'reconocimientos' => [
                'title' => 'Reconocimientos',
                'icon' => 'fas fa-trophy',
                'group' => 'Submódulos',
                'description' => 'Reconocimientos, condecoraciones y felicitaciones del funcionario.',
                'parent_key' => 'documento_identidad',
                'columns' => [
                    self::documentoIdentidadColumn(),
                    ['key' => 'tipo', 'label' => 'tipo', 'required' => true, 'example' => 'Reconocimiento', 'help' => 'Reconocimiento | Condecoración | Felicitaciones', 'aliases' => ['tipo reconocimiento', 'tipo de reconocimiento']],
                    ['key' => 'autoridad', 'label' => 'autoridad', 'required' => true, 'example' => 'Inspector Rivas', 'help' => 'Autoridad que otorga', 'aliases' => ['otorgado por', 'quien otorga']],
                    ['key' => 'fecha', 'label' => 'fecha', 'required' => true, 'example' => '15/08/2024', 'help' => 'YYYY-MM-DD o DD/MM/YYYY', 'aliases' => ['fecha reconocimiento', 'fecha de reconocimiento']],
                    ['key' => 'descripcion', 'label' => 'descripcion', 'required' => true, 'example' => 'Mérito al servicio', 'help' => 'Descripción del reconocimiento', 'aliases' => ['detalle', 'observaciones', 'motivo']],
                ],
                'notes' => [
                    'El funcionario (documento_identidad) debe existir previamente.',
                    'Duplicado = mismo funcionario + tipo + fecha + descripción + autoridad (se omite / se limpia en BD).',
                ],
            ],
            'radiogramas' => [
                'title' => 'Radiogramas',
                'icon' => 'fas fa-broadcast-tower',
                'group' => 'Submódulos',
                'description' => 'Asignaciones a estaciones de comando (radiogramas).',
                'parent_key' => 'documento_identidad',
                'columns' => [
                    self::documentoIdentidadColumn(),
                    ['key' => 'estacion', 'label' => 'estacion', 'required' => true, 'example' => 'Comando Valera', 'help' => 'Nombre de la estación (se busca/crea en catálogo)', 'aliases' => ['estación', 'estacion comando', 'estación de comando', 'comando']],
                    ['key' => 'fecha_inicio', 'label' => 'fecha_inicio', 'required' => true, 'example' => '01/03/2024', 'help' => 'YYYY-MM-DD o DD/MM/YYYY', 'aliases' => ['fecha inicio', 'desde']],
                    ['key' => 'fecha_final', 'label' => 'fecha_final', 'required' => false, 'example' => '30/06/2024', 'help' => 'YYYY-MM-DD o DD/MM/YYYY', 'aliases' => ['fecha fin', 'fecha final', 'hasta']],
                    ['key' => 'is_actual', 'label' => 'is_actual', 'required' => false, 'example' => '1', 'help' => '0 o 1 — estación actual del funcionario', 'aliases' => ['actual', 'vigente', 'en servicio']],
                    ['key' => 'descripcion', 'label' => 'descripcion', 'required' => false, 'example' => 'Traslado temporal', 'help' => 'Descripción / observaciones', 'aliases' => ['observaciones', 'nota', 'detalle']],
                ],
                'notes' => [
                    'El funcionario (documento_identidad) debe existir previamente.',
                    'Si la estación no existe, se crea automáticamente.',
                    'Si is_actual=1, los demás radiogramas del funcionario pasan a histórico.',
                    'Duplicado = mismo funcionario + estación + fecha_inicio (se omite / se limpia en BD).',
                ],
            ],
        ];
    }

    public static function get(string $key): ?array
    {
        return self::modules()[$key] ?? null;
    }

    public static function keys(): array
    {
        return array_keys(self::modules());
    }
}
