<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radiograma - {{ $oficial->oficiale->nombre_completo }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f0f0f0;
            font-family: 'Arial', 'Helvetica', sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Simulación de Hoja A4 */
        .page-simulation {
            background-color: white;
            width: 210mm;
            height: 297mm;
            padding: 15mm;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }

        /* Contenedor principal */
        .page-wrapper {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        /* Sección de cada radiograma */
        .radiograma-section {
            height: 48%; 
            position: relative;
            box-sizing: border-box;
            padding: 10px 0;
            display: flex;
            flex-direction: column;
        }

        /* Header con logo */
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
            position: relative;
        }

        .header-logo {
            position: absolute;
            left: 0;
            width: 60px;
            height: 60px;
            object-fit: contain;
        }

        .header-title {
            text-align: center;
            flex: 1;
        }

        .header-title h2 {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            color: #000;
            margin: 0;
        }

        .header-title p {
            font-size: 11px;
            color: #555;
            margin: 3px 0 0 0;
        }

        /* Etiqueta de tipo de documento */
        .document-type {
            text-align: center;
            font-size: 10px;
            margin-bottom: 10px;
            color: #888;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Línea divisoria */
        .divider {
            border-top: 2px dashed #333;
            margin: 10px 0;
            position: relative;
            text-align: center;
            width: 100%;
        }

        .divider span {
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            background: #fff;
            padding: 0 15px;
            font-size: 10px;
            color: #333;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 1px;
        }

        /* Estilos de contenido */
        .grid {
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .label {
            font-weight: bold;
            font-size: 13px;
            color: #000;
        }

        .input-field {
            text-align: justify;
            line-height: 1.6;
            display: inline-block;
            font-size: 13px;
            color: #000;
        }

        .text-right {
            text-align: right;
        }

        .flex-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Sección de firmas */
        .signature-row {
            margin-top: auto;
            padding-top: 25px;
            display: flex;
            justify-content: space-around;
            text-align: center;
            font-size: 11px;
        }

        .signature-box {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .signature-line {
            width: 200px;
            border-top: 2px solid #000;
            margin-bottom: 5px;
        }

        .signature-label {
            font-size: 11px;
            font-weight: bold;
            color: #333;
        }

        /* Estilos de impresión */
        @media print {
            body {
                background: none;
                padding: 0;
            }
            
            .page-simulation {
                box-shadow: none;
                margin: 0;
                border: none;
                width: 100%;
                height: 100%;
                padding: 10mm;
            }
            
            .no-print {
                display: none;
            }

            /* Asegurar que el contenido se ajuste bien en la página */
            .radiograma-section {
                page-break-inside: avoid;
            }
        }

        /* Botón de impresión */
        .no-print {
            margin-bottom: 20px;
            background: #007bff;
            color: white;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            border: none;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }

        .no-print:hover {
            background: #0056b3;
        }

        @page {
            size: A4;
            margin: 0;
        }
    </style>
</head>
<body>

    <button class="no-print" onclick="window.print()">🖨️ Imprimir Radiograma</button>

    <div class="page-simulation">
        <div class="page-wrapper">
            
            <!-- COPIA 1 - ORIGINAL -->
            <div class="radiograma-section">
                <!-- Header con logo -->
                <div class="header">
                    <img src="{{ asset('images/icon/logo.png') }}" alt="Logo" class="header-logo">
                    <div class="header-title">
                        <h2>Cuerpo de Policía del Estado Trujillo</h2>
                        <p>Comando General</p>
                    </div>
                </div>

                <div class="document-type">ORIGINAL</div>

                <div class="grid text-right">
                    <span class="label">Trujillo, {{ \Carbon\Carbon::parse($oficial->fecha_inicio)->locale('es')->isoFormat('D [de] MMMM [del] YYYY') }}</span>
                </div>

                <div class="grid">
                    <span class="label">RGDMA. Nro. C-G-P: </span>
                    <span class="input-field">{{ str_pad($oficial->id, 3, '0', STR_PAD_LEFT) }}-{{ \Carbon\Carbon::parse($oficial->fecha_inicio)->format('Y') }}</span>
                </div>

                <div class="grid">
                    <div><span class="label">Ciudadano(a)</span></div>
                    <div><span class="label">{{ ($oficial->oficiale->oficiales_cargos->where('is_actual', 1)->first() != null) ? $oficial->oficiale->oficiales_cargos->where('is_actual', 1)->first()->cargo->nombre_cargo : "Sin Cargo" }}</span></div>
                    <div class="flex-between">
                        <span class="label">{{ strtoupper($oficial->oficiale->nombre_completo) }}</span> 
                        <span class="label">C.I.N: {{ number_format($oficial->oficiale->documento_identidad, 0, '', '.') }}</span>
                    </div>
                </div>

                <div class="grid">
                    <span class="label">Presente:</span>
                </div>

                <div class="grid">
                    <span class="input-field">
                        PARA SU CONOCIMIENTO Y DEMÁS FINES DE ESTRICTO CUMPLIMIENTO, A PARTIR DE LA PRESENTE FECHA, 
                        PRESTARÁ SU SERVICIO EN {{ strtoupper($oficial->estacione->estacion) }}
                        @if($oficial->descripcion), {{ strtoupper($oficial->descripcion) }}@endif, 
                        POR DISPOSICIÓN DEL COMANDO SUPERIOR. IGUALMENTE HAGO DE SU CONOCIMIENTO QUE DEBERÁ 
                        PRESENTARSE EN SU UNIDAD DE DESTINO.
                    </span>
                </div>

                <div class="signature-row">
                    <div class="signature-box">
                        <div class="signature-line"></div>
                        <span class="signature-label">Recibido por</span>
                    </div>
                    <div class="signature-box">
                        <div class="signature-line"></div>
                        <span class="signature-label">Firma y Sello Autorizado</span>
                    </div>
                </div>
            </div>

            <!-- LÍNEA DE CORTE -->
            <div class="divider">
                <span>✂ Corte por aquí</span>
            </div>

            <!-- COPIA 2 - DUPLICADO -->
            <div class="radiograma-section">
                <!-- Header con logo -->
                <div class="header">
                    <img src="{{ asset('images/icon/logo.png') }}" alt="Logo" class="header-logo">
                    <div class="header-title">
                        <h2>Cuerpo de Policía del Estado Trujillo</h2>
                        <p>Comando General</p>
                    </div>
                </div>

                <div class="document-type">Copia</div>

                <div class="grid text-right">
                    <span class="label">Trujillo, {{ \Carbon\Carbon::parse($oficial->fecha_inicio)->locale('es')->isoFormat('D [de] MMMM [del] YYYY') }}</span>
                </div>

                <div class="grid">
                    <span class="label">RGDMA. Nro. C-G-P: </span>
                    <span class="input-field">{{ str_pad($oficial->id, 3, '0', STR_PAD_LEFT) }}-{{ \Carbon\Carbon::parse($oficial->fecha_inicio)->format('Y') }}</span>
                </div>

                <div class="grid">
                    <div><span class="label">Ciudadano(a)</span></div>
                    <div><span class="label">{{ ($oficial->oficiale->oficiales_cargos->where('is_actual', 1)->first() != null) ? $oficial->oficiale->oficiales_cargos->where('is_actual', 1)->first()->cargo->nombre_cargo : "Sin Cargo" }}</span></div>
                    <div class="flex-between">
                        <span class="label">{{ strtoupper($oficial->oficiale->nombre_completo) }}</span> 
                        <span class="label">C.I.N: {{ number_format($oficial->oficiale->documento_identidad, 0, '', '.') }}</span>
                    </div>
                </div>

                <div class="grid">
                    <span class="label">Presente:</span>
                </div>

                <div class="grid">
                    <span class="input-field">
                        PARA SU CONOCIMIENTO Y DEMÁS FINES DE ESTRICTO CUMPLIMIENTO, A PARTIR DE LA PRESENTE FECHA, 
                        PRESTARÁ SU SERVICIO EN {{ strtoupper($oficial->estacione->estacion) }}
                        @if($oficial->descripcion), {{ strtoupper($oficial->descripcion) }}@endif, 
                        POR DISPOSICIÓN DEL COMANDO SUPERIOR. IGUALMENTE HAGO DE SU CONOCIMIENTO QUE DEBERÁ 
                        PRESENTARSE EN SU UNIDAD DE DESTINO.
                    </span>
                </div>

                <div class="signature-row">
                    <div class="signature-box">
                        <div class="signature-line"></div>
                        <span class="signature-label">Recibido por</span>
                    </div>
                    <div class="signature-box">
                        <div class="signature-line"></div>
                        <span class="signature-label">Firma y Sello Autorizado</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Auto-cerrar ventana después de imprimir (opcional)
        window.onafterprint = function() {
            // window.close(); // Descomenta si deseas cerrar automáticamente
        };
    </script>

</body>
</html>
