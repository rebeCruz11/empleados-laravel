@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Gestión de Empleados')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="h3 mb-0 text-gray-800">
            <i class="bi bi-speedometer2"></i> Dashboard de Empleados
        </h1>
        <p class="text-muted">Análisis integral y estadísticas del personal</p>
    </div>
    <div>
        <a href="{{ route('empleados.reporte') }}" class="btn btn-primary" target="_blank">
            <i class="bi bi-file-earmark-pdf"></i> Generar Reporte PDF
        </a>
        <a href="{{ route('empleados.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-list-ul"></i> Ver Lista
        </a>
    </div>
</div>

<!-- Estadísticas Financieras -->
<div class="row">
    <div class="col-12">
        <h4 class="mb-3"><i class="bi bi-cash-stack"></i> Estadísticas Financieras</h4>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Promedio Salario Base
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            ${{ number_format($estadisticas['financieras']['promedio_salario_base'], 2) }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-currency-dollar fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Bonificaciones
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            ${{ number_format($estadisticas['financieras']['total_bonificaciones'], 2) }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-gift fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Descuentos
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            ${{ number_format($estadisticas['financieras']['total_descuentos'], 2) }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-exclamation-triangle fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card {{ $estadisticas['financieras']['crecimiento_vs_anio_anterior'] >= 0 ? 'success' : 'danger' }}">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold {{ $estadisticas['financieras']['crecimiento_vs_anio_anterior'] >= 0 ? 'text-success' : 'text-danger' }} text-uppercase mb-1">
                            Crecimiento vs Año Anterior
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            @if($estadisticas['financieras']['crecimiento_vs_anio_anterior'] > 0)
                                +{{ number_format($estadisticas['financieras']['crecimiento_vs_anio_anterior'], 2) }}%
                            @else
                                {{ number_format($estadisticas['financieras']['crecimiento_vs_anio_anterior'], 2) }}%
                            @endif
                        </div>
                        <small class="{{ $estadisticas['financieras']['crecimiento_vs_anio_anterior'] >= 0 ? 'text-success' : 'text-danger' }}">
                            <i class="bi bi-arrow-{{ $estadisticas['financieras']['crecimiento_vs_anio_anterior'] >= 0 ? 'up' : 'down' }}"></i> Salario Base Promedio
                        </small>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-graph-{{ $estadisticas['financieras']['crecimiento_vs_anio_anterior'] >= 0 ? 'up' : 'down' }}-arrow fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Total Nómina -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card stat-card success">
            <div class="card-body text-center">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-2">
                    Total Nómina Mensual
                </div>
                <div class="h2 mb-0 font-weight-bold text-success">
                    ${{ number_format($estadisticas['financieras']['total_nomina'], 2) }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas Demográficas -->
<div class="row mt-4">
    <div class="col-12">
        <h4 class="mb-3"><i class="bi bi-people"></i> Estadísticas Demográficas</h4>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Edad Promedio
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $estadisticas['demograficas']['edad_promedio'] }} años
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-calendar3 fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Empleados
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $estadisticas['demograficas']['total_empleados'] }}
                        </div>
                        <small class="text-success">
                            <i class="bi bi-check-circle"></i> {{ $estadisticas['demograficas']['empleados_activos'] }} activos
                        </small>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-person-badge fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Edad Prom. Directivos
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $estadisticas['demograficas']['edad_promedio_directivos'] }} años
                        </div>
                        <small class="text-muted">{{ $estadisticas['demograficas']['total_directivos'] }} directivos</small>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-briefcase fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Edad Prom. Operativos
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $estadisticas['demograficas']['edad_promedio_operativos'] }} años
                        </div>
                        <small class="text-muted">{{ $estadisticas['demograficas']['total_operativos'] }} operativos</small>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-tools fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gráfico de Distribución por Sexo (Pastel) -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-pie-chart"></i> Distribución por Sexo
            </div>
            <div class="card-body">
                <canvas id="sexoChart" height="250"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-bar-chart"></i> Resumen Demográfico
            </div>
            <div class="card-body">
                <div class="row text-center">
                    @foreach($estadisticas['demograficas']['distribucion_sexo'] as $sexo => $datos)
                        <div class="col-4">
                            <h3 class="mb-0">{{ $datos['porcentaje'] }}%</h3>
                            <small class="text-muted">
                                {{ $sexo == 'M' ? 'Masculino' : ($sexo == 'F' ? 'Femenino' : 'Otro') }}
                            </small>
                            <p class="mb-0 text-muted">{{ $datos['total'] }} empleados</p>
                        </div>
                    @endforeach
                </div>
                <hr>
                <div class="mt-3">
                    <p class="mb-1"><strong>Total Empleados:</strong> {{ $estadisticas['demograficas']['total_empleados'] }}</p>
                    <p class="mb-1"><strong>Activos:</strong> <span class="text-success">{{ $estadisticas['demograficas']['empleados_activos'] }}</span></p>
                    <p class="mb-0"><strong>Inactivos:</strong> <span class="text-secondary">{{ $estadisticas['demograficas']['empleados_inactivos'] }}</span></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas de Desempeño -->
<div class="row mt-4">
    <div class="col-12">
        <h4 class="mb-3"><i class="bi bi-graph-up-arrow"></i> Estadísticas de Desempeño</h4>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Evaluación Promedio
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $estadisticas['desempeno']['evaluacion_promedio'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-star-fill fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Correlación Salario-Desempeño
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $estadisticas['desempeno']['correlacion_salario_desempeno'] }}
                        </div>
                        <small class="text-muted">Coef. Pearson</small>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-graph-up fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Empleados Excelentes
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $estadisticas['desempeno']['empleados_excelentes'] }}
                        </div>
                        <small class="text-muted">> 95 puntos</small>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-trophy fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Personal sobre 70
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $estadisticas['desempeno']['porcentaje_sobre_70'] }}%
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-check-circle fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card danger">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Empleados Deficientes
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $estadisticas['desempeno']['empleados_deficientes'] }}
                        </div>
                        <small class="text-muted">< 70 puntos</small>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-exclamation-circle fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas de Antigüedad -->
<div class="row mt-4">
    <div class="col-12">
        <h4 class="mb-3"><i class="bi bi-clock-history"></i> Estadísticas de Antigüedad</h4>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Tiempo Promedio Permanencia
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $estadisticas['antiguedad']['tiempo_promedio_permanencia'] }} años
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-hourglass-split fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Personal +10 Años
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $estadisticas['antiguedad']['porcentaje_mas_10_anos'] }}%
                        </div>
                        <small class="text-muted">{{ $estadisticas['antiguedad']['empleados_mas_10_anos'] }} empleados</small>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-award fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Correlación Antigüedad-Salario
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $estadisticas['antiguedad']['correlacion_antiguedad_salario'] }}
                        </div>
                        <small class="text-muted">Coef. Pearson</small>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-link-45deg fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Antigüedad Promedio
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $estadisticas['antiguedad']['antiguedad_promedio'] }} años
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-calendar-check fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Estadísticas por Departamento -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-building"></i> Estadísticas por Departamento</span>
                <a href="{{ route('empleados.index') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-list-ul"></i> Ver Todos los Empleados
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Departamento</th>
                                <th class="text-center">Total Empleados</th>
                                <th class="text-end">Salario Promedio</th>
                                <th class="text-center">Evaluación Promedio</th>
                                <th class="text-center">Edad Promedio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($estadisticas['por_departamento'] as $dept)
                                <tr>
                                    <td>
                                        <strong>{{ $dept->departamento }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">{{ $dept->total_empleados }}</span>
                                    </td>
                                    <td class="text-end">
                                        ${{ number_format($dept->promedio_salario, 2) }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge {{ $dept->promedio_evaluacion >= 80 ? 'bg-success' : ($dept->promedio_evaluacion >= 70 ? 'bg-warning' : 'bg-danger') }}">
                                            {{ $dept->promedio_evaluacion }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {{ $dept->edad_promedio }} años
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gráficos Principales -->
<div class="row mt-4">
    <div class="col-12">
        <h4 class="mb-3"><i class="bi bi-bar-chart-line"></i> Visualizaciones y Gráficos</h4>
    </div>
    
    <!-- Salario Promedio por Departamento (Barras) -->
    <div class="col-lg-12 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-bar-chart"></i> Salario Promedio por Departamento
            </div>
            <div class="card-body">
                <canvas id="salarioChart" height="80"></canvas>
            </div>
        </div>
    </div>

    <!-- Desempeño vs Salario (Dispersión) -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-diagram-3"></i> Desempeño vs Salario Base (Dispersión)
            </div>
            <div class="card-body">
                <canvas id="dispersionChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Evolución Salario Promedio (Lineal) -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-graph-up"></i> Evolución Salario Promedio (2021-2025)
            </div>
            <div class="card-body">
                <canvas id="evolucionChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Preparar datos para los gráficos
    const departamentos = @json($estadisticas['por_departamento']->pluck('departamento'));
    const salarios = @json($estadisticas['por_departamento']->pluck('promedio_salario'));
    const evaluaciones = @json($estadisticas['por_departamento']->pluck('promedio_evaluacion'));
    const datosDispersion = @json($estadisticas['datos_dispersion']);
    const evolucionLabels = @json($estadisticas['evolucion_salario']['labels']);
    const evolucionData = @json($estadisticas['evolucion_salario']['data']);
    const distribucionSexo = @json($estadisticas['demograficas']['distribucion_sexo']);

    // 1. Gráfico de Salario por Departamento (Barras)
    const ctx1 = document.getElementById('salarioChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: departamentos,
            datasets: [{
                label: 'Salario Promedio ($)',
                data: salarios,
                backgroundColor: 'rgba(78, 115, 223, 0.7)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Salario Promedio por Departamento'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Salario ($)'
                    }
                }
            }
        }
    });

    // 2. Gráfico de Dispersión (Desempeño vs Salario)
    const ctx2 = document.getElementById('dispersionChart').getContext('2d');
    
    // Agrupar por departamento para colores
    const coloresDept = {
        'Ventas': 'rgba(255, 99, 132, 0.6)',
        'Producción': 'rgba(54, 162, 235, 0.6)',
        'RRHH': 'rgba(255, 206, 86, 0.6)',
        'Finanzas': 'rgba(75, 192, 192, 0.6)',
        'TI': 'rgba(153, 102, 255, 0.6)',
        'Marketing': 'rgba(255, 159, 64, 0.6)',
        'Logística': 'rgba(199, 199, 199, 0.6)',
        'Calidad': 'rgba(83, 102, 255, 0.6)'
    };

    const datasetsPorDept = {};
    datosDispersion.forEach(item => {
        if (!datasetsPorDept[item.departamento]) {
            datasetsPorDept[item.departamento] = [];
        }
        datasetsPorDept[item.departamento].push({x: item.x, y: item.y});
    });

    const datasetsDispersion = Object.keys(datasetsPorDept).map(dept => ({
        label: dept,
        data: datasetsPorDept[dept],
        backgroundColor: coloresDept[dept] || 'rgba(100, 100, 100, 0.6)'
    }));

    new Chart(ctx2, {
        type: 'scatter',
        data: {
            datasets: datasetsDispersion
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'right'
                },
                title: {
                    display: true,
                    text: 'Relación Desempeño vs Salario Base'
                }
            },
            scales: {
                x: {
                    type: 'linear',
                    position: 'bottom',
                    title: {
                        display: true,
                        text: 'Salario Base ($)'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Evaluación de Desempeño'
                    },
                    max: 100,
                    min: 0
                }
            }
        }
    });

    // 3. Gráfico de Distribución por Sexo (Pastel)
    const ctx3 = document.getElementById('sexoChart').getContext('2d');
    
    const sexoLabels = [];
    const sexoData = [];
    const sexoColors = [];
    
    Object.keys(distribucionSexo).forEach(key => {
        sexoLabels.push(key === 'M' ? 'Masculino' : (key === 'F' ? 'Femenino' : 'Otro'));
        sexoData.push(distribucionSexo[key].total);
        sexoColors.push(
            key === 'M' ? 'rgba(54, 162, 235, 0.7)' : 
            (key === 'F' ? 'rgba(255, 99, 132, 0.7)' : 'rgba(255, 206, 86, 0.7)')
        );
    });

    new Chart(ctx3, {
        type: 'pie',
        data: {
            labels: sexoLabels,
            datasets: [{
                data: sexoData,
                backgroundColor: sexoColors,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                },
                title: {
                    display: true,
                    text: 'Distribución de Empleados por Sexo'
                }
            }
        }
    });

    // 4. Gráfico de Evolución Salario (Lineal)
    const ctx4 = document.getElementById('evolucionChart').getContext('2d');
    new Chart(ctx4, {
        type: 'line',
        data: {
            labels: evolucionLabels,
            datasets: [{
                label: 'Salario Promedio ($)',
                data: evolucionData,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Evolución del Salario Promedio (2021-2025)'
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    title: {
                        display: true,
                        text: 'Salario ($)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Año'
                    }
                }
            }
        }
    });
</script>
@endpush
