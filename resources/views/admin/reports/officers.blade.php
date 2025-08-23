<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reporte de Oficiales</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }
    .container {
      width: 100%; /* A4 width */
      height: 297mm; /* A4 height */
      margin: 0 auto;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      box-sizing: border-box;
    }
    .header {
      text-align: center;
      margin-bottom: 20mm;
      width: 100% !important;
    }
    .header img {
      width: 100px;
      margin-bottom: 10px;
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
    .report-title {
      text-align: center;
      font-size: 20px;
      margin-bottom: 20mm;
      color: #333;
    }
    .report-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20mm;
    }
    .report-table th, .report-table td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }
    .report-table th {
      background-color: #000;
      color: #fff;
      font-size: 10px;
      object-fit: cover;
    }
    .report-table td {
      background-color: #f9f9f9;
      font-size: 8px;
    }
    .footer {
      text-align: center;
      font-size: 12px;
      color: #666;
    }

    a {
        text-decoration: none;
        color: #000;
        font-weight: bold;
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
        margin-bottom: 20mm;
        }

      .container {
        width: 100%;
        height: 297mm;
        box-shadow: none;
      }
      .no-print {
        display: none;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <img src="{{asset('images/icon/logo.png')}}" alt="Logo Institución">
      <h1>Cuerpo de Policía del Estado Trujillo</h1>
      <p>Dirección General | Teléfono: 123-456-7890 | Email: info@policia.com</p>
    </div>
    <div class="report-title">
      <h2>Reporte de Oficiales</h2>
      <p>Fecha y Hora de Emisión: 21 de junio de 2025, 08:22 PM PDT</p>
    </div>
    <button class="btn btn-primary no-print" onclick="window.print()">Imprimir Reporte</button>
    <table class="report-table">
      <thead>
        <tr>
          <th>Nro. Credencial</th>
          <th>Cédula</th>
          <th>Nombre Completo</th>
          <th>Fecha Nacimiento</th>
          <th>Cargo</th>
          @if (request()->routeIs('report.officers.officers_cargo') )
          <th>Inicio en el cargo</th>
          <th>Fin en el cargo</th>
          @endif
          <th>Tipo Sangre</th>
          <th>Talla Camisa</th>
          <th>Talla Pantalon</th>
          <th>Talla Zapato</th>
          <th>Talla Saco</th>
          <th>Talla Kepin/Toka</th>
          <th>Talla Tacón</th>
          <th>Talla Falda</th>
          <th>Talla Gorra</th>
          <th>Fecha Ingreso</th>
          <th>Estado Civil</th>
          <th colspan="3">Dirección</th>
          <th>Teléfono</th>
          <th>Correo Electrónico</th>
          <th>Estatus Encomienda</th>
          <th>Centro Votación</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($oficiales as $officer)
        <tr>
            <td>{{$officer->numero_placa}}</td>
            <td>{{$officer->documento_identidad}}</td>
            <td>{{$officer->nombre_completo}}</td>
            <td>{{ \Carbon\Carbon::parse($officer->fecha_nacimiento)->format('d-m-Y') }}</td>
            @if (!request()->routeIs('report.officers.officers_cargo') )
            <td>{{ ($officer->oficiales_cargos->where('id_cargo', request()->id_cargo)->where('is_actual', 1)->first() != null) ? $officer->oficiales_cargos->where('id_cargo', request()->id_cargo)->where('is_actual', 1)->first()->cargo->nombre_cargo : "Sin Cargo"}}</td>
            @else
            <td>
              {{$officer->oficiales_cargos->where('id_cargo', request()->id_cargo)->first()->cargo->nombre_cargo}}
            </td>
            <td>
              {{ \Carbon\Carbon::parse($officer->oficiales_cargos->where('id_cargo', request()->id_cargo)->first()->fecha_inicio)->format('d-m-Y') }}
            </td>
            <td>
              {{ ($officer->oficiales_cargos->where('id_cargo', request()->id_cargo)->first()->fecha_fin) ? \Carbon\Carbon::parse($officer->oficiales_cargos->where('id_cargo', request()->id_cargo)->first()->fecha_fin)->format('d-m-Y') : "Actual" }}
            </td>
            @endif
            <td>{{$officer->tipo_sangre}}</td>
            <td>{{ $officer->talla_camisa ?? 'S/I' }}</td>
            <td>{{ $officer->talla_pantalon ?? 'S/I' }}</td>
            <td>{{ $officer->talla_zapato ?? 'S/I' }}</td>
            <td>{{ $officer->talla_saco ?? 'S/I' }}</td>
            <td>{{ $officer->talla_kepin_toka ?? 'S/I' }}</td>
            <td>{{ $officer->talla_tacon ?? 'S/I' }}</td>
            <td>{{ $officer->talla_falda ?? 'S/I' }}</td>
            <td>{{ $officer->talla_gorra ?? 'S/I' }}</td>
            <td>{{ \Carbon\Carbon::parse($officer->fecha_ingreso)->format('d-m-Y') }}</td>
            <td>{{$officer->estado_civil}}</td>
            <td colspan="3">{{$officer->direccion}}</td>
            <td>{{$officer->telefono}}</td>
            <td>{{$officer->correo_electronico}}</td>
            <td>{{$officer->estatus}}</td>
            <td>{{$officer->centro_votacion}}</td>
        </tr>
        @endforeach
        <!-- Agrega más filas según necesites -->
      </tbody>
    </table>
    <hr>
    <div class="footer">
      <p>Generado por el Sistema de Gestión de Oficiales - Desarrollado por: <a href="https://www.instagram.com/adsyssystems/">Adsys Sistemas</a> © 2025</p>
    </div>
  </div>
  {{-- <button class="btn btn-primary no-print" onclick="window.print()">Imprimir Reporte</button> --}}
</body>
</html>