<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hoja de Vida - Oficial</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }
    .header {
      text-align: center;
      width: 100% !important;
    }
    .header img {
      width: 100px;
    }
    .header h1 {
      font-size: 24px;
      color: #1e90ff;
      margin: 0;
    }
    .header p {
      font-size: 14px;
      margin: 5px 0;
    }
    .container {
      display: flex;
      width: 210mm; /* A4 width */
      height: 297mm; /* A4 height */
      margin: 0 auto;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      position: relative;
    }
    .left-section {
      width: 30%;
      padding: 20px;
      background-color: #29166f;
      color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      position: running(leftSection);
    }
    .left-section img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      margin-bottom: 20px;
    }
    .left-section h2 {
      margin: 0 0 10px;
      font-size: 24px;
    }
    .left-section p {
      margin: 5px 0;
      font-size: 14px;
    }
    .left-section ul {
      list-style: none;
      padding: 0;
    }
    .left-section ul li {
      margin: 5px 0;
    }
    .right-section {
      width: 70%;
      padding: 20px;
      overflow: auto;
      max-height: 257mm; /* Ajuste para caber en A4 con márgenes */
    }
    .right-section h2 {
      color: #29166f;
      font-size: 20px;
      margin-bottom: 10px;
    }
    .right-section p {
      margin: 5px 0;
      font-size: 14px;
    }
    .right-section ul {
      list-style: disc;
      padding-left: 20px;
    }
    .right-section .experience-item, .right-section .formation-item, .right-section .family-item, .right-section .vacation-item {
      margin-bottom: 15px;
      border: 1px solid #ccc;
      padding: 10px;
    }
    .no-print {
      display: inline-block;
      background-color: #000;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      font-size: 16px;
      margin-bottom: 10px;
    }
    @media print {
      body {
        margin: 0;
        padding: 0;
      }
      .header {
        width: 100%;
        text-align: center;
      }
      .container {
        width: 210mm;
        height: 297mm;
        margin: 0;
        box-shadow: none;
        page-break-after: always;
      }
      .left-section {
        position: running(leftSection);
        -webkit-region-break-inside: avoid;
        page-break-inside: avoid;
        color: #000;
        border-right: 1px solid #ccc;
      }
      @page {
        size: A4;   
        @top-left {
          content: element(leftSection);
        }
      }
      .right-section {
        overflow: visible;
        max-height: none;
        page-break-inside: auto;
      }
      .no-print {
        display: none;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="left-section">
      <img src="{{ $officer->fotografia ? 'http://localhost/cpet/public/storage/' . $officer->fotografia : asset('images/oficial-icon.png') }}" alt="Foto Oficial">
      <h2>{{ $officer->nombre_completo }}</h2>
      <div>
        <h3>Datos Oficiales</h3>
        <p><strong>Nro. Credencial:</strong> {{ $officer->numero_placa }}</p>
        <p><strong>Fecha de Ingreso:</strong> {{ \Carbon\Carbon::parse($officer->fecha_ingreso)->format('d-m-Y') }}</p>
        <p><strong>Jerarquía Actual:</strong> {{ ($officer->oficiales_cargos->where('is_actual', 1)->first() != null) ? $officer->oficiales_cargos->where('is_actual', 1)->first()->cargo->nombre_cargo : "Sin Cargo" }}</p>
        <p><strong>Estatus:</strong> {{ $officer->estatus}}</p>
        <h3>Datos personales</h3>
        <p><strong>Documento:</strong> {{ $officer->documento_identidad }}</p>
        <p><strong>Correo Electrónico:</strong> {{ $officer->correo_electronico }}</p>
        <p><strong>Teléfono:</strong> {{ $officer->telefono }}</p>
        <p><strong>Dirección:</strong> {{ $officer->direccion }}</p>
        <h3>Competencias</h3>
        <ul>
          <li><strong>Tipado Sangre:</strong> {{ $officer->tipo_sangre }}</li>
          <li><strong>Talla Camisa:</strong> {{ $officer->talla_camisa }}</li>
          <li><strong>Talla Zapato:</strong> {{ $officer->talla_zapato }}</li>
          <li><strong>Estado Civil:</strong> {{ $officer->estado_civil }}</li>
        </ul>
      </div>
    </div>
    <div class="right-section">
    <div class="header">
        <img src="{{asset('images/icon/logo.png')}}" alt="Logo Institución">
        <h1>Cuerpo de Policía del Estado Trujillo</h1>
        <p>Dirección General | Teléfono: 123-456-7890 | Email: info@policia.com</p>
    </div>
    <button class="btn btn-primary no-print" onclick="window.print()">Imprimir Hoja de Vida</button>
      @if(count($officer->oficiales_academicos) > 0)
        <h2>Formación</h2>
        @foreach ($officer->oficiales_academicos as $academico)
          <div class="formation-item">
            <p><strong>Tipo Formación:</strong> {{ $academico->tipo_formacion }}</p>
            <p><strong>Institución:</strong> {{ $academico->institucion }}</p>
            <p><strong>Fecha Inicio:</strong> {{ \Carbon\Carbon::parse($academico->fecha_inicio)->format('d-m-Y') }}</p>
            <p><strong>Fecha Fin:</strong> {{ ($academico->fecha_fin) ? \Carbon\Carbon::parse($academico->fecha_fin)->format('d-m-Y') : "Cursando / Sin terminar" }}</p>
            <p><strong>Título:</strong> {{ $academico->titulo }}</p>
          </div>
        @endforeach
      @endif
      @if(count($officer->oficiales_cargos) > 0)
        <h2>Cargos alcanzados</h2>
        @foreach ($officer->oficiales_cargos as $cargo)
          <div class="experience-item">
            <p><strong>Cargo:</strong> {{ $cargo->cargo->nombre_cargo }}</p>
            <p><strong>Fecha Inicio:</strong> {{ \Carbon\Carbon::parse($cargo->fecha_inicio)->format('d-m-Y') }}</p>
            <p><strong>Fecha Fin:</strong> {{ ($cargo->is_actual) ? "Actual" : \Carbon\Carbon::parse($cargo->fecha_fin)->format('d-m-Y') }}</p>
          </div>
        @endforeach
      @endif
      @if(count($officer->oficiales_radiogramas) > 0)
        <h2>Radiogramas</h2>
        @foreach ($officer->oficiales_radiogramas as $radiograma)
          <div class="formation-item">
            <p><strong>Estación:</strong> {{ $radiograma->estacione->estacion }}</p>
            <p><strong>Fecha Inicio:</strong> {{ \Carbon\Carbon::parse($radiograma->fecha_inicio)->format('d-m-Y') }}</p>
            <p><strong>Fecha Fin:</strong> {{ ($radiograma->fecha_fin) ? \Carbon\Carbon::parse($radiograma->fecha_fin)->format('d-m-Y') : "Cursando / Sin terminar" }}</p>
            @if($radiograma->is_actual)
            <p><strong>Estado:</strong> Presta servicio actualmente</p>
            @endif
          </div>
        @endforeach
      @endif
      @if(count($officer->oficiales_cursos) > 0)
        <h2>Cursos, capacitaciones y diplomados</h2>
        @foreach ($officer->oficiales_cursos as $curso)
          <div class="experience-item">
            <p><strong>Cargo:</strong> Patrullero</p>
            <p><strong>Fecha Inicio:</strong> 2020-06-01</p>
            <p><strong>Fecha Fin:</strong> Actual</p>
            <p><strong>Descripción:</strong> Responsable de patrullaje y seguridad ciudadana</p>
          </div>
        @endforeach
      @endif
      @if(count($officer->oficiales_familiares) > 0)
        <h2>Información Familiar</h2>
        @foreach ($officer->oficiales_familiares as $familiar)
          <div class="experience-item">
            <p><strong>Familiar:</strong> {{ $familiar->nombre }}</p>
            <p><strong>Parentesco:</strong> {{ $familiar->parentesco }}</p>
            <p><strong>Fecha Nacimiento:</strong> {{ \Carbon\Carbon::parse($familiar->fecha_nacimiento)->format('d-m-Y') }}</p>
            <p><strong>Teléfono:</strong> {{ ($familiar->telefono) ? $familiar->telefono : "Sin Telefono" }}</p>
          </div>
        @endforeach
      @endif
      @if(count($officer->oficiales_vacaciones) > 0)
        <h2>Vacaciones</h2>
        @foreach ($officer->oficiales_vacaciones as $vacaciones)
        <div class="vacation-item">
          <p><strong>Vacación desde - hasta:</strong> {{$vacaciones->fecha_emision}} a {{$vacaciones->fecha_reintegro}}</p>
          <p><strong>Estatus:</strong> {{$vacaciones->estatus}}</p>
          <p><strong>Disfrutadas:</strong> {{($vacaciones->is_disfrutadas) ? "Si" : "No"}}</p>
          @if($vacaciones->descripcion)
          <p><strong>Descripción:</strong> {{$vacaciones->descripcion}}</p>
          @endif
        </div>
        @endforeach
      @endif
    </div>
  </div>
  
</body>
</html>