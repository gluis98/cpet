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
      color: #1e90ff;
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
      background-color: #1e90ff;
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
      <img src="https://via.placeholder.com/100" alt="Logo Institución">
      <h1>Departamento de Policía</h1>
      <p>Dirección General | Teléfono: 123-456-7890 | Email: info@policia.com</p>
    </div>
    <div class="report-title">
      <h2>Reporte de Familiares</h2>
      <p>Fecha y Hora de Emisión: 21 de junio de 2025, 08:24 PM PDT</p>
    </div>
    <div class="report-section">
      <h3>Oficial: Juan Pérez (Documento: 123456789)</h3>
      <table class="report-table">
        <thead>
          <tr>
            <th>Nombre Completo</th>
            <th>Parentesco</th>
            <th>Fecha Nacimiento</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>Campo Extra 1</th>
            <th>Campo Extra 2</th>
            <th>Campo Extra 3</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Juan Gómez</td>
            <td>Hermano</td>
            <td>1995-03-15</td>
            <td>987-654-3210</td>
            <td>Av. Secundaria #789</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
          </tr>
          <tr>
            <td>María López</td>
            <td>Madre</td>
            <td>1965-07-20</td>
            <td>555-123-4567</td>
            <td>Calle Tercera #456</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="report-section">
      <h3>Oficial: Ana Martínez (Documento: 987654321)</h3>
      <table class="report-table">
        <thead>
          <tr>
            <th>Nombre Completo</th>
            <th>Parentesco</th>
            <th>Fecha Nacimiento</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>Campo Extra 1</th>
            <th>Campo Extra 2</th>
            <th>Campo Extra 3</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Carlos Ruiz</td>
            <td>Padre</td>
            <td>1960-12-10</td>
            <td>444-789-1234</td>
            <td>Av. Principal #101</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="footer">
      <p>Generado por el Sistema de Gestión de Oficiales - © 2025</p>
    </div>
  </div>
  <button class="btn btn-primary no-print" onclick="window.print()">Imprimir Reporte</button>
</body>
</html>