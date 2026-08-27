<?php

namespace App\Support\BulkImport;

class BulkImportRegistry
{
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
                    ['key' => 'documento_identidad', 'label' => 'documento_identidad', 'required' => true, 'example' => '12345678', 'help' => 'Cédula (única)'],
                    ['key' => 'nombre_completo', 'label' => 'nombre_completo', 'required' => true, 'example' => 'Juan Pérez', 'help' => 'Nombre y apellido'],
                    ['key' => 'fecha_nacimiento', 'label' => 'fecha_nacimiento', 'required' => true, 'example' => '1990-05-15', 'help' => 'YYYY-MM-DD'],
                    ['key' => 'sexo', 'label' => 'sexo', 'required' => false, 'example' => 'Masculino', 'help' => 'Masculino | Femenino'],
                    ['key' => 'numero_placa', 'label' => 'numero_placa', 'required' => true, 'example' => 'CP-001', 'help' => 'N° de credencial'],
                    ['key' => 'fecha_ingreso', 'label' => 'fecha_ingreso', 'required' => true, 'example' => '2015-01-10', 'help' => 'YYYY-MM-DD'],
                    ['key' => 'estatus', 'label' => 'estatus', 'required' => true, 'example' => 'Operativo', 'help' => 'Operativo, No Operativo, En Reposo, Retirado, Suspendido, Jubilado, Fallecido, URRA'],
                    ['key' => 'tipo_funcionario', 'label' => 'tipo_funcionario', 'required' => true, 'example' => 'Policial', 'help' => 'Policial | Administrativo | Obrero'],
                    ['key' => 'telefono', 'label' => 'telefono', 'required' => true, 'example' => '04141234567', 'help' => 'Teléfono principal'],
                    ['key' => 'correo_electronico', 'label' => 'correo_electronico', 'required' => true, 'example' => 'juan@correo.com', 'help' => 'Email'],
                    ['key' => 'cargo', 'label' => 'cargo', 'required' => false, 'example' => 'SECRETARIO I', 'help' => 'Nombre exacto en Cargos administrativos'],
                    ['key' => 'tipo_sangre', 'label' => 'tipo_sangre', 'required' => false, 'example' => 'O+', 'help' => 'A+/A-/B+/B-/AB+/AB-/O+/O-'],
                    ['key' => 'estado_civil', 'label' => 'estado_civil', 'required' => false, 'example' => 'Soltero', 'help' => 'Estado civil'],
                    ['key' => 'direccion', 'label' => 'direccion', 'required' => false, 'example' => 'Calle 1', 'help' => 'Dirección'],
                    ['key' => 'centro_votacion', 'label' => 'centro_votacion', 'required' => false, 'example' => 'Escuela X', 'help' => 'Centro de votación'],
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
                    'El campo cargo debe coincidir con un registro de Configuraciones → Cargos administrativos (o se crea).',
                ],
            ],
            'familiares' => [
                'title' => 'Familiares',
                'icon' => 'fas fa-heart',
                'group' => 'Submódulos',
                'description' => 'Carga de hijos y familiares vinculados a un funcionario existente.',
                'parent_key' => 'documento_identidad',
                'columns' => [
                    ['key' => 'documento_identidad', 'label' => 'documento_identidad', 'required' => true, 'example' => '12345678', 'help' => 'Cédula del funcionario padre'],
                    ['key' => 'nombre_completo', 'label' => 'nombre_completo', 'required' => true, 'example' => 'María Pérez', 'help' => 'Nombre del familiar'],
                    ['key' => 'parentesco', 'label' => 'parentesco', 'required' => true, 'example' => 'Hijo(a)', 'help' => 'Padre | Madre | Hijo(a) | Esposo(a) | Conyugue | Union Estable de Hechos'],
                    ['key' => 'fecha_nacimiento', 'label' => 'fecha_nacimiento', 'required' => true, 'example' => '2010-03-20', 'help' => 'YYYY-MM-DD'],
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
                ],
            ],
            'academia' => [
                'title' => 'Formación académica',
                'icon' => 'fas fa-graduation-cap',
                'group' => 'Submódulos',
                'description' => 'Títulos y grados académicos del funcionario.',
                'parent_key' => 'documento_identidad',
                'columns' => [
                    ['key' => 'documento_identidad', 'label' => 'documento_identidad', 'required' => true, 'example' => '12345678', 'help' => 'Cédula del funcionario'],
                    ['key' => 'tipo_formacion', 'label' => 'tipo_formacion', 'required' => true, 'example' => 'Licenciatura', 'help' => 'Primaria, Secundaria, Bachillerato, Bachiller en Ciencias, Técnico superior universitario, Licenciatura, Ingeniería, Especialización, Maestría, Doctorado, Post-doctorado'],
                    ['key' => 'anio_graduacion', 'label' => 'anio_graduacion', 'required' => true, 'example' => '2018', 'help' => 'Año 1950–2100'],
                    ['key' => 'titulo', 'label' => 'titulo', 'required' => false, 'example' => 'Informática', 'help' => 'Nombre de la formación'],
                    ['key' => 'institucion', 'label' => 'institucion', 'required' => false, 'example' => 'ULA', 'help' => 'Institución'],
                    ['key' => 'descripcion', 'label' => 'descripcion', 'required' => false, 'example' => 'Mención…', 'help' => 'Descripción'],
                ],
                'notes' => [
                    'El documento fondo negro no se carga por Excel.',
                    'anio_graduacion se guarda como fecha_fin = AÑO-12-31.',
                ],
            ],
            'cursos' => [
                'title' => 'Cursos y diplomados',
                'icon' => 'fas fa-book-reader',
                'group' => 'Submódulos',
                'description' => 'Cursos, diplomados y talleres del funcionario.',
                'parent_key' => 'documento_identidad',
                'columns' => [
                    ['key' => 'documento_identidad', 'label' => 'documento_identidad', 'required' => true, 'example' => '12345678', 'help' => 'Cédula del funcionario'],
                    ['key' => 'tipo', 'label' => 'tipo', 'required' => true, 'example' => 'Curso', 'help' => 'Curso | Diplomado | Taller'],
                    ['key' => 'nombre_curso', 'label' => 'nombre_curso', 'required' => true, 'example' => 'Criminalística', 'help' => 'Se busca/crea en catálogo de cursos'],
                    ['key' => 'fecha_inicio', 'label' => 'fecha_inicio', 'required' => true, 'example' => '2022-06-01', 'help' => 'YYYY-MM-DD'],
                    ['key' => 'duracion_valor', 'label' => 'duracion_valor', 'required' => true, 'example' => '40', 'help' => 'Número 1–9999'],
                    ['key' => 'duracion_tipo', 'label' => 'duracion_tipo', 'required' => true, 'example' => 'Horas', 'help' => 'Años | Meses | Horas'],
                    ['key' => 'institucion', 'label' => 'institucion', 'required' => false, 'example' => 'CICPC', 'help' => 'Institución'],
                    ['key' => 'descripcion', 'label' => 'descripcion', 'required' => false, 'example' => 'Nivel básico', 'help' => 'Descripción'],
                ],
                'notes' => [
                    'Si nombre_curso no existe en el catálogo, se crea automáticamente.',
                ],
            ],
            'reposos' => [
                'title' => 'Reposos médicos',
                'icon' => 'fas fa-medkit',
                'group' => 'Submódulos',
                'description' => 'Solicitudes de reposo médico del funcionario.',
                'parent_key' => 'documento_identidad',
                'columns' => [
                    ['key' => 'documento_identidad', 'label' => 'documento_identidad', 'required' => true, 'example' => '12345678', 'help' => 'Cédula del funcionario'],
                    ['key' => 'fecha_revision', 'label' => 'fecha_revision', 'required' => true, 'example' => '2026-01-10', 'help' => 'YYYY-MM-DD'],
                    ['key' => 'diagnostico', 'label' => 'diagnostico', 'required' => true, 'example' => 'Lumbalgia', 'help' => 'Diagnóstico'],
                    ['key' => 'fecha_reposo_inicio', 'label' => 'fecha_reposo_inicio', 'required' => true, 'example' => '2026-01-11', 'help' => 'YYYY-MM-DD'],
                    ['key' => 'estado_reposo', 'label' => 'estado_reposo', 'required' => true, 'example' => '1', 'help' => '1=Vigente | 2=Continuo | 0=Finalizado'],
                    ['key' => 'fecha_reposo_fin', 'label' => 'fecha_reposo_fin', 'required' => false, 'example' => '2026-01-20', 'help' => 'Obligatorio si estado_reposo=1; vacío si Continuo'],
                ],
                'notes' => [
                    'Los días de reposo se calculan automáticamente (días hábiles).',
                    'Los archivos del reposo no se cargan por Excel.',
                    'Un reposo vigente puede cambiar el estatus del funcionario a En Reposo.',
                ],
            ],
            'vacaciones' => [
                'title' => 'Vacaciones',
                'icon' => 'fas fa-plane-departure',
                'group' => 'Submódulos',
                'description' => 'Solicitudes de vacaciones del funcionario.',
                'parent_key' => 'documento_identidad',
                'columns' => [
                    ['key' => 'documento_identidad', 'label' => 'documento_identidad', 'required' => true, 'example' => '12345678', 'help' => 'Cédula del funcionario'],
                    ['key' => 'fecha_emision', 'label' => 'fecha_emision', 'required' => true, 'example' => '2026-02-01', 'help' => 'YYYY-MM-DD'],
                    ['key' => 'estatus', 'label' => 'estatus', 'required' => true, 'example' => 'APROBADAS', 'help' => 'APROBADAS | NEGADAS | VENCIDAS | REGLAMENTARIAS | EN PROCESO'],
                    ['key' => 'fecha_reintegro', 'label' => 'fecha_reintegro', 'required' => false, 'example' => '2026-02-15', 'help' => 'YYYY-MM-DD'],
                    ['key' => 'is_disfrutadas', 'label' => 'is_disfrutadas', 'required' => false, 'example' => '0', 'help' => '0 o 1 (si reintegro ≤ hoy se marca 1)'],
                    ['key' => 'descripcion', 'label' => 'descripcion', 'required' => false, 'example' => 'Periodo ordinaria', 'help' => 'Descripción'],
                ],
                'notes' => [
                    'El estatus se guarda en mayúsculas.',
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
