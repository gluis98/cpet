<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reporte de Familiares</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }
    .container {
      width: 210mm; /* A4 width */
      height: 297mm; /* A4 height */
      margin: 0 auto;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 20mm;
      box-sizing: border-box;
    }
    .header {
      text-align: center;
      margin-bottom: 20mm;
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
    .report-section {
      margin-bottom: 20mm;
    }
    .report-section h3 {
      color: #000;
      margin-bottom: 10px;
    }
    .report-table {
      width: 100%;
      border-collapse: collapse;
    }
    .report-table th, .report-table td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }
    .report-table th {
      background-color: #000;
      color: #fff;
    }
    .report-table td {
      background-color: #f9f9f9;
    }
    .footer {
      text-align: center;
      font-size: 12px;
      color: #666;
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
      .container {
        width: 210mm;
        height: 297mm;
        margin: 0;
        padding: 20mm;
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
      <h1>Departamento de Policía</h1>
      <p>Dirección General | Teléfono: 123-456-7890 | Email: info@policia.com</p>
    </div>
    <div class="report-title">
      <h2>Reporte de Familiares</h2>
      <p>Fecha y Hora de Emisión: 21 de junio de 2025, 08:24 PM PDT</p>
    </div>
    <button class="btn btn-primary no-print" onclick="window.print()">Imprimir Reporte</button>
    @foreach($oficiales as $officer)
    <div class="report-section">
        <h3>Oficial: {{$officer->nombre_completo}} (Documento: V{{number_format($officer->documento_identidad)}})</h3>
        <table class="report-table">
            <thead>
                <tr>
                    <th>Nombre Completo</th>
                    <th>Parentesco</th>
                    <th>Fecha Nacimiento</th>
                    <th>Género</th>
                    <th>Edad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($officer->oficiales_familiares as $family)
                <tr>
                    <td>{{$family->nombre_completo}}</td>
                    <td>{{$family->parentesco}}</td>
                    <td>{{ \Carbon\Carbon::parse($family->fecha_nacimiento)->format('d-m-Y') }}</td>
                    <td>{{($family->sexo == 'M' ? 'Masculino' : 'Femenino')}}</td>
                    <td>{{ \Carbon\Carbon::parse($family->fecha_nacimiento)->age }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endforeach
    <hr>
    <div class="footer">
      <p>Generado por el Sistema de Gestión de Oficiales - Desarrollado por: <a href="https://www.instagram.com/adsyssystems/">Adsys Sistemas</a> © 2025</p>
    </div>
  </div>
  
</body>
</html>