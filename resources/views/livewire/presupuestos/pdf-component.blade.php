<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Presupuesto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #0056b3;
            padding-bottom: 10px;
        }
        .header img {
            max-width: 150px;
        }
        .header .clinic-info {
            text-align: right;
            margin-top: -40px;
        }
        .content {
            margin-top: 20px;
        }
        h1, h2 {
            color: #0056b3;
        }
        .section-title {
            font-size: 18px;
            border-bottom: 1px solid #0056b3;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .info-table, .services-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table th, .info-table td, .services-table th, .services-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .info-table th, .services-table th {
            background-color: #f2f2f2;
            color: #0056b3;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <img src="{{ public_path('images/logo.png') }}" alt="Logo Clínica">
            </div>
            <div class="clinic-info">
                <h2>Clínica dental Smile Center</h2>
                <p>Av. María Guerrero nº 2,</p>
                <p>La Línea de la Concepción,</p><p> 11300 Cádiz</p>
                <p>Teléfono: 956 095 708</p>
                <p>clinicadentalsmilecenter@gmail.com</p>
            </div>
        </div>
        <div class="content">
            <h2 class="section-title">Datos del cliente</h2>
            <table class="info-table">
                <tr>
                    <th>Paciente</th>
                    <td>{{ $paciente->nombre }} {{ $paciente->apellido }}</td>
                    <th>Fecha de Emisión</th>
                    <td>{{ $presupuesto->fechaEmision }}</td>
                </tr>
            </table>

            <h2 class="section-title">Observaciones</h2>
            <div style="border: 1px solid #ddd; padding: 10px; margin-bottom: 20px;">
                <p style="white-space: pre;">{{ $presupuesto->observacion }}</p>
            </div>

            <h2 class="section-title">Servicios</h2>
            <table class="services-table">
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listaServicios as $servicio)
                        <tr>
                            <td>{{ $servicio->nombre }}</td>
                            <td>{{ $servicio->descripcion }}</td>
                            <td>{{ $servicio->precio }} €</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="footer">
            <p>Gracias por confiar en nuestra clínica dental.</p>
        </div>
    </div>
</body>
</html>
