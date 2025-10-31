<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha de Empleado - {{ $empleado->nombre }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; padding: 20px; }
        h1, h2, h3 { margin: 0; }
        .header { text-align: center; border-bottom: 3px solid #0d6efd; margin-bottom: 25px; padding-bottom: 10px; }
        .header h1 { color: #0d6efd; font-size: 24px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 6px 10px; border-bottom: 1px solid #ddd; }
        .info-table td.label { background-color: #f8f9fa; width: 35%; font-weight: bold; color: #555; }
        .section { margin-bottom: 25px; }
        .section-title { background-color: #0d6efd; color: white; padding: 8px 12px; border-radius: 4px; margin-bottom: 10px; font-size: 14px; }
        .badge { display: inline-block; padding: 3px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; }
        .bg-success { background-color: #d1e7dd; color: #0f5132; }
        .bg-danger { background-color: #f8d7da; color: #842029; }
        .bg-warning { background-color: #fff3cd; color: #664d03; }
        .bg-info { background-color: #cfe2ff; color: #084298; }

        /* Cards de indicadores */
        .stat-card {
            flex: 1 1 22%;
            margin: 5px;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            color: white;
        }
        .stat-blue { background-color: #0d6efd; }
        .stat-purple { background-color: #6f42c1; }
        .stat-green { background-color: #198754; }
        .stat-yellow { background-color: #ffc107; color: #000; }
        .stat-red { background-color: #dc3545; }
        .stat-value { font-size: 20px; font-weight: bold; margin-top: 5px; }
        .stat-label { font-size: 14px; font-weight: bold; margin-bottom: 5px; }
        .stats-container { display:flex; flex-wrap:wrap; justify-content:space-between; margin-top:10px; }

        .footer { text-align: center; color: #888; font-size: 11px; margin-top: 30px; border-top: 1px solid #ddd; padding-top: 10px; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Ficha de Empleado</h1>
        <p>Generado el {{ now()->format('d/m/Y') }}</p>
    </div>

    <!-- Información Personal -->
    <div class="section">
        <div class="section-title">Información Personal</div>
        <table class="info-table">
            <tr><td class="label">Nombre:</td><td>{{ $empleado->nombre }}</td></tr>
            <tr><td class="label">Sexo:</td><td>{{ $empleado->sexo_completo }}</td></tr>
            <tr><td class="label">Fecha de Nacimiento:</td><td>{{ $empleado->fecha_nacimiento->format('d/m/Y') }}</td></tr>
            <tr><td class="label">Edad:</td><td>{{ $empleado->edad }} años</td></tr>
            <tr><td class="label">Estado:</td>
                <td>
                    @if($empleado->estado == 1)
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-danger">Inactivo</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- Información Laboral -->
    <div class="section">
        <div class="section-title">Información Laboral</div>
        <table class="info-table">
            <tr><td class="label">Departamento:</td><td>{{ $empleado->departamento }}</td></tr>
            <tr><td class="label">Puesto:</td><td>{{ $empleado->puesto }}</td></tr>
            <tr><td class="label">Fecha de Contratación:</td><td>{{ $empleado->fecha_contratacion->format('d/m/Y') }}</td></tr>
            <tr><td class="label">Antigüedad:</td><td>{{ $empleado->antiguedad }} años</td></tr>
            <tr><td class="label">Evaluación:</td>
                <td>
                    <span class="badge 
                        {{ $empleado->evaluacion_desempeno >= 80 ? 'bg-success' : ($empleado->evaluacion_desempeno >= 70 ? 'bg-warning' : 'bg-danger') }}">
                        {{ $empleado->evaluacion_desempeno }}%
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <!-- Información Financiera -->
    <div class="section">
        <div class="section-title">Información Financiera</div>
        <table class="info-table">
            <tr><td class="label">Salario Base:</td><td>${{ number_format($empleado->salario_base, 2) }}</td></tr>
            <tr><td class="label">Bonificación:</td><td>${{ number_format($empleado->bonificacion, 2) }}</td></tr>
            <tr><td class="label">Descuento:</td><td>${{ number_format($empleado->descuento, 2) }}</td></tr>
            <tr><td class="label">Salario Bruto:</td><td>${{ number_format($empleado->salario_bruto, 2) }}</td></tr>
            <tr><td class="label"><strong>Salario Neto:</strong></td><td><strong>${{ number_format($empleado->salario_neto, 2) }}</strong></td></tr>
            <tr><td class="label">Relación Desempeño/Salario:</td><td>{{ $empleado->relacion_desempeno_salario }}</td></tr>
        </table>
    </div>

    <!-- Indicadores Rápidos -->
    <div class="section page-break">
        <div class="section-title">Indicadores Rápidos</div>

        @php
            $indicadores = [
                'Edad' => ['valor' => $empleado->edad . ' años', 'class' => 'stat-blue'],
                'Antigüedad' => ['valor' => $empleado->antiguedad . ' años', 'class' => 'stat-purple'],
                'Evaluación' => [
                    'valor' => $empleado->evaluacion_desempeno . '%',
                    'class' => $empleado->evaluacion_desempeno >= 80 ? 'stat-green' : ($empleado->evaluacion_desempeno >= 70 ? 'stat-yellow' : 'stat-red')
                ],
                'Salario Neto' => ['valor' => '$' . number_format($empleado->salario_neto, 0), 'class' => 'stat-blue'],
            ];
        @endphp

        <div class="stats-container">
            @foreach($indicadores as $label => $info)
                <div class="stat-card {{ $info['class'] }}">
                    <div class="stat-label">{{ $label }}</div>
                    <div class="stat-value">{{ $info['valor'] }}</div>
                </div>
            @endforeach
        </div>

        <div style="text-align:center; margin-top:20px;">
            <h3>Gráfica de Indicadores</h3>
            <img src="data:image/png;base64,{{ $chart }}" alt="Gráfica de Indicadores" style="max-width:100%; height:auto;"/>
        </div>
    </div>

    <div class="footer">
        Sistema de Gestión de Empleados — Reporte generado automáticamente el {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>
