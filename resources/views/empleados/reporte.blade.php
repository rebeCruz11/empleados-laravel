<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Empleados - {{ date('d/m/Y') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #0d6efd;
        }
        
        .header h1 {
            color: #0d6efd;
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .header .subtitle {
            color: #666;
            font-size: 14px;
        }
        
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        
        .section-title {
            background-color: #0d6efd;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }
        
        .stat-card .label {
            color: #6c757d;
            font-size: 11px;
            text-transform: uppercase;
            margin-bottom: 8px;
            font-weight: bold;
        }
        
        .stat-card .value {
            color: #0d6efd;
            font-size: 24px;
            font-weight: bold;
        }
        
        .stat-card .value.success {
            color: #198754;
        }
        
        .stat-card .value.warning {
            color: #ffc107;
        }
        
        .stat-card .value.danger {
            color: #dc3545;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 11px;
        }
        
        table thead {
            background-color: #e9ecef;
        }
        
        table th {
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
        }
        
        table td {
            padding: 8px;
            border-bottom: 1px solid #dee2e6;
        }
        
        table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .badge-success {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        
        .badge-danger {
            background-color: #f8d7da;
            color: #842029;
        }
        
        .badge-info {
            background-color: #cfe2ff;
            color: #084298;
        }
        
        .badge-warning {
            background-color: #fff3cd;
            color: #664d03;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #dee2e6;
            text-align: center;
            color: #6c757d;
            font-size: 11px;
        }
        
        .no-print {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0d6efd;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            margin: 5px;
        }
        
        .btn:hover {
            background-color: #0b5ed7;
        }
        
        .btn-secondary {
            background-color: #6c757d;
        }
        
        .btn-secondary:hover {
            background-color: #5c636a;
        }
        
        @media print {
            body {
                padding: 10px;
            }
            
            .no-print {
                display: none !important;
            }
            
            .section {
                page-break-inside: avoid;
            }
            
            table {
                page-break-inside: auto;
            }
            
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
        
        .resumen {
            background-color: #e7f3ff;
            border-left: 4px solid #0d6efd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .resumen p {
            margin: 5px 0;
        }
        
        .resumen strong {
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" class="btn">🖨️ Imprimir / Guardar PDF</button>
        <a href="{{ route('empleados.index') }}" class="btn btn-secondary">← Volver</a>
    </div>

    <div class="header">
        <h1>📊 Reporte de Gestión de Empleados</h1>
        <p class="subtitle">Generado el {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <!-- Resumen Ejecutivo -->
    <div class="resumen">
        <h3 style="margin-bottom: 10px;">📋 Resumen Ejecutivo</h3>
        <p><strong>Total Empleados Activos:</strong> {{ $estadisticas['demograficas']['empleados_activos'] }}</p>
        <p><strong>Nómina Total:</strong> ${{ number_format($estadisticas['financieras']['total_nomina'], 2) }}</p>
        <p><strong>Promedio Salario Neto:</strong> ${{ number_format($estadisticas['financieras']['promedio_salario_neto'], 2) }}</p>
        <p><strong>Crecimiento vs Año Anterior:</strong> 
            @if($estadisticas['financieras']['crecimiento_vs_anio_anterior'] >= 0)
                <span style="color: #198754;">+{{ number_format($estadisticas['financieras']['crecimiento_vs_anio_anterior'], 2) }}%</span>
            @else
                <span style="color: #dc3545;">{{ number_format($estadisticas['financieras']['crecimiento_vs_anio_anterior'], 2) }}%</span>
            @endif
        </p>
        <p><strong>Evaluación Promedio:</strong> {{ $estadisticas['desempeno']['evaluacion_promedio'] }}/100</p>
    </div>

    <!-- Estadísticas Financieras -->
    <div class="section">
        <div class="section-title">💰 Estadísticas Financieras</div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="label">Salario Base Promedio</div>
                <div class="value">${{ number_format($estadisticas['financieras']['promedio_salario_base'], 2) }}</div>
            </div>
            <div class="stat-card">
                <div class="label">Total Bonificaciones</div>
                <div class="value success">${{ number_format($estadisticas['financieras']['total_bonificaciones'], 2) }}</div>
            </div>
            <div class="stat-card">
                <div class="label">Total Descuentos</div>
                <div class="value danger">${{ number_format($estadisticas['financieras']['total_descuentos'], 2) }}</div>
            </div>
            <div class="stat-card">
                <div class="label">Salario Mínimo</div>
                <div class="value">${{ number_format($estadisticas['financieras']['salario_minimo'], 2) }}</div>
            </div>
            <div class="stat-card">
                <div class="label">Salario Máximo</div>
                <div class="value">${{ number_format($estadisticas['financieras']['salario_maximo'], 2) }}</div>
            </div>
            <div class="stat-card">
                <div class="label">Crecimiento Anual</div>
                <div class="value {{ $estadisticas['financieras']['crecimiento_vs_anio_anterior'] >= 0 ? 'success' : 'danger' }}">
                    {{ $estadisticas['financieras']['crecimiento_vs_anio_anterior'] >= 0 ? '+' : '' }}{{ number_format($estadisticas['financieras']['crecimiento_vs_anio_anterior'], 2) }}%
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas Demográficas -->
    <div class="section">
        <div class="section-title">👥 Estadísticas Demográficas</div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="label">Edad Promedio</div>
                <div class="value">{{ $estadisticas['demograficas']['edad_promedio'] }} años</div>
            </div>
            <div class="stat-card">
                <div class="label">Edad Prom. Directivos</div>
                <div class="value">{{ $estadisticas['demograficas']['edad_promedio_directivos'] }} años</div>
                <small style="color: #6c757d;">({{ $estadisticas['demograficas']['total_directivos'] }} empleados)</small>
            </div>
            <div class="stat-card">
                <div class="label">Edad Prom. Operativos</div>
                <div class="value">{{ $estadisticas['demograficas']['edad_promedio_operativos'] }} años</div>
                <small style="color: #6c757d;">({{ $estadisticas['demograficas']['total_operativos'] }} empleados)</small>
            </div>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Sexo</th>
                    <th>Total</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($estadisticas['demograficas']['distribucion_sexo'] as $sexo => $data)
                <tr>
                    <td>{{ $sexo == 'M' ? 'Masculino' : ($sexo == 'F' ? 'Femenino' : 'Otro') }}</td>
                    <td>{{ $data['total'] }}</td>
                    <td>{{ $data['porcentaje'] }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Estadísticas de Desempeño -->
    <div class="section">
        <div class="section-title">⭐ Estadísticas de Desempeño</div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="label">Evaluación Promedio</div>
                <div class="value">{{ $estadisticas['desempeno']['evaluacion_promedio'] }}/100</div>
            </div>
            <div class="stat-card">
                <div class="label">Empleados Excelentes (≥95)</div>
                <div class="value success">{{ $estadisticas['desempeno']['empleados_excelentes'] }}</div>
            </div>
            <div class="stat-card">
                <div class="label">Empleados Buenos (80-94)</div>
                <div class="value">{{ $estadisticas['desempeno']['empleados_buenos'] }}</div>
            </div>
            <div class="stat-card">
                <div class="label">Correlación Salario-Desempeño</div>
                <div class="value">{{ $estadisticas['desempeno']['correlacion_salario_desempeno'] }}</div>
            </div>
            <div class="stat-card">
                <div class="label">Empleados Regulares (70-79)</div>
                <div class="value warning">{{ $estadisticas['desempeno']['empleados_regulares'] }}</div>
            </div>
            <div class="stat-card">
                <div class="label">Empleados Deficientes (<70)</div>
                <div class="value danger">{{ $estadisticas['desempeno']['empleados_deficientes'] }}</div>
            </div>
        </div>
    </div>

    <!-- Estadísticas de Antigüedad -->
    <div class="section">
        <div class="section-title">📅 Estadísticas de Antigüedad</div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="label">Antigüedad Promedio</div>
                <div class="value">{{ $estadisticas['antiguedad']['antiguedad_promedio'] }} años</div>
            </div>
            <div class="stat-card">
                <div class="label">Empleados +10 años</div>
                <div class="value">{{ $estadisticas['antiguedad']['empleados_mas_10_anos'] }}</div>
                <small style="color: #6c757d;">({{ $estadisticas['antiguedad']['porcentaje_mas_10_anos'] }}%)</small>
            </div>
            <div class="stat-card">
                <div class="label">Correlación Antigüedad-Salario</div>
                <div class="value">{{ $estadisticas['antiguedad']['correlacion_antiguedad_salario'] }}</div>
            </div>
        </div>
    </div>

    <!-- Estadísticas por Departamento -->
    <div class="section">
        <div class="section-title">🏢 Estadísticas por Departamento</div>
        <table>
            <thead>
                <tr>
                    <th>Departamento</th>
                    <th>Total Empleados</th>
                    <th>Salario Promedio</th>
                    <th>Evaluación Promedio</th>
                    <th>Edad Promedio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($estadisticas['por_departamento'] as $dept)
                <tr>
                    <td><strong>{{ $dept->departamento }}</strong></td>
                    <td>{{ $dept->total_empleados }}</td>
                    <td>${{ number_format($dept->promedio_salario, 2) }}</td>
                    <td>{{ $dept->promedio_evaluacion }}/100</td>
                    <td>{{ $dept->edad_promedio }} años</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Lista de Empleados -->
    <div class="section" style="page-break-before: always;">
        <div class="section-title">📋 Lista Completa de Empleados Activos</div>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Departamento</th>
                    <th>Puesto</th>
                    <th>Salario Base</th>
                    <th>Salario Neto</th>
                    <th>Evaluación</th>
                    <th>Edad</th>
                    <th>Antigüedad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($empleados as $empleado)
                <tr>
                    <td><strong>{{ $empleado->nombre }}</strong></td>
                    <td>{{ $empleado->departamento }}</td>
                    <td>{{ $empleado->puesto }}</td>
                    <td>${{ number_format($empleado->salario_base, 2) }}</td>
                    <td>${{ number_format($empleado->salario_neto, 2) }}</td>
                    <td>
                        @if($empleado->evaluacion_desempeno >= 95)
                            <span class="badge badge-success">{{ $empleado->evaluacion_desempeno }}</span>
                        @elseif($empleado->evaluacion_desempeno >= 80)
                            <span class="badge badge-info">{{ $empleado->evaluacion_desempeno }}</span>
                        @elseif($empleado->evaluacion_desempeno >= 70)
                            <span class="badge badge-warning">{{ $empleado->evaluacion_desempeno }}</span>
                        @else
                            <span class="badge badge-danger">{{ $empleado->evaluacion_desempeno }}</span>
                        @endif
                    </td>
                    <td>{{ $empleado->edad }} años</td>
                    <td>{{ $empleado->antiguedad }} años</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Sistema de Gestión de Empleados - Reporte generado el {{ date('d/m/Y H:i:s') }}</p>
        <p>Total de empleados activos en el sistema: {{ $empleados->count() }}</p>
    </div>
</body>
</html>
