@extends('layouts.app')

@section('title', 'Detalles del Empleado')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="h3 mb-0 text-gray-800">
            <i class="bi bi-person-circle"></i> Detalles del Empleado
        </h1>
        <p class="text-muted">Información completa de {{ $empleado->nombre }}</p>
    </div>
    <div>
        <a href="{{ route('empleados.edit', $empleado->id_empleado) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Editar
        </a>
        <a href="{{ route('empleados.pdf', $empleado->id_empleado) }}" class="btn btn-danger" target="_blank">
            <i class="bi bi-file-earmark-pdf"></i> Descargar PDF
        </a>
        <a href="{{ route('empleados.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="row">
    <!-- Información Personal -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-person"></i> Información Personal
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td class="text-muted" width="40%"><strong>ID Empleado:</strong></td>
                        <td>{{ $empleado->id_empleado }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted"><strong>Nombre Completo:</strong></td>
                        <td>{{ $empleado->nombre }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted"><strong>Sexo:</strong></td>
                        <td>{{ $empleado->sexo_completo }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted"><strong>Fecha de Nacimiento:</strong></td>
                        <td>{{ $empleado->fecha_nacimiento->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted"><strong>Edad Actual:</strong></td>
                        <td>
                            <span class="badge bg-info">{{ $empleado->edad }} años</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted"><strong>Estado:</strong></td>
                        <td>
                            @if($empleado->estado == 1)
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle"></i> Activo
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="bi bi-x-circle"></i> Inactivo
                                </span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Información Laboral -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-building"></i> Información Laboral
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td class="text-muted" width="40%"><strong>Departamento:</strong></td>
                        <td>
                            <span class="badge bg-secondary">{{ $empleado->departamento }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted"><strong>Puesto:</strong></td>
                        <td>{{ $empleado->puesto }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted"><strong>Fecha de Contratación:</strong></td>
                        <td>{{ $empleado->fecha_contratacion->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted"><strong>Antigüedad:</strong></td>
                        <td>
                            <span class="badge bg-primary">{{ $empleado->antiguedad }} años</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted"><strong>Evaluación de Desempeño:</strong></td>
                        <td>
                            <span class="badge {{ $empleado->evaluacion_desempeno >= 80 ? 'bg-success' : ($empleado->evaluacion_desempeno >= 70 ? 'bg-warning' : 'bg-danger') }}">
                                {{ $empleado->evaluacion_desempeno }} / 100
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Información Financiera -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-cash-stack"></i> Información Financiera
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center p-3 border rounded">
                            <small class="text-muted d-block mb-2">Salario Base</small>
                            <h4 class="mb-0">${{ number_format($empleado->salario_base, 2) }}</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 border rounded">
                            <small class="text-muted d-block mb-2">Bonificación</small>
                            <h4 class="mb-0 text-success">${{ number_format($empleado->bonificacion, 2) }}</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 border rounded">
                            <small class="text-muted d-block mb-2">Descuento</small>
                            <h4 class="mb-0 text-danger">${{ number_format($empleado->descuento, 2) }}</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 border rounded bg-light">
                            <small class="text-muted d-block mb-2"><strong>Salario Neto</strong></small>
                            <h4 class="mb-0 text-primary">${{ number_format($empleado->salario_neto, 2) }}</h4>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="alert alert-info mb-0">
                            <strong>Salario Bruto:</strong> ${{ number_format($empleado->salario_bruto, 2) }}
                            <br>
                            <small>(Salario Base + Bonificación)</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="alert alert-success mb-0">
                            <strong>Relación Desempeño/Salario:</strong> {{ $empleado->relacion_desempeno_salario }}
                            <br>
                            <small>(Evaluación / Salario Base)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Indicadores de Desempeño -->
<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card stat-card">
            <div class="card-body text-center">
                <i class="bi bi-calendar3 fs-1 text-primary"></i>
                <h5 class="mt-2">{{ $empleado->edad }} años</h5>
                <small class="text-muted">Edad Actual</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card info">
            <div class="card-body text-center">
                <i class="bi bi-hourglass-split fs-1 text-info"></i>
                <h5 class="mt-2">{{ $empleado->antiguedad }} años</h5>
                <small class="text-muted">Antigüedad</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card success">
            <div class="card-body text-center">
                <i class="bi bi-star-fill fs-1 text-success"></i>
                <h5 class="mt-2">{{ $empleado->evaluacion_desempeno }}</h5>
                <small class="text-muted">Evaluación</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card warning">
            <div class="card-body text-center">
                <i class="bi bi-wallet2 fs-1 text-warning"></i>
                <h5 class="mt-2">${{ number_format($empleado->salario_neto, 0) }}</h5>
                <small class="text-muted">Salario Neto</small>
            </div>
        </div>
    </div>
</div>

<!-- Observaciones -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-clipboard-check"></i> Análisis de Desempeño
            </div>
            <div class="card-body">
                @if($empleado->evaluacion_desempeno >= 95)
                    <div class="alert alert-success">
                        <i class="bi bi-trophy-fill"></i>
                        <strong>Excelente Desempeño:</strong> Este empleado tiene una evaluación sobresaliente ({{ $empleado->evaluacion_desempeno }}/100).
                    </div>
                @elseif($empleado->evaluacion_desempeno >= 80)
                    <div class="alert alert-info">
                        <i class="bi bi-star-fill"></i>
                        <strong>Buen Desempeño:</strong> Este empleado tiene una evaluación buena ({{ $empleado->evaluacion_desempeno }}/100).
                    </div>
                @elseif($empleado->evaluacion_desempeno >= 70)
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>Desempeño Regular:</strong> Este empleado tiene una evaluación aceptable ({{ $empleado->evaluacion_desempeno }}/100).
                    </div>
                @else
                    <div class="alert alert-danger">
                        <i class="bi bi-x-circle-fill"></i>
                        <strong>Desempeño Deficiente:</strong> Este empleado necesita mejorar su desempeño ({{ $empleado->evaluacion_desempeno }}/100).
                    </div>
                @endif

                @if($empleado->antiguedad >= 10)
                    <div class="alert alert-info">
                        <i class="bi bi-award-fill"></i>
                        <strong>Empleado Veterano:</strong> Con {{ $empleado->antiguedad }} años de antigüedad, es un miembro valioso del equipo.
                    </div>
                @endif

                @if($empleado->estado == 0)
                    <div class="alert alert-secondary">
                        <i class="bi bi-pause-circle"></i>
                        <strong>Empleado Inactivo:</strong> Este empleado actualmente está inactivo y no cuenta para las estadísticas activas.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Acciones -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <small class="text-muted">
                            <i class="bi bi-clock"></i> Registrado: {{ $empleado->created_at->format('d/m/Y H:i') }}
                            @if($empleado->updated_at != $empleado->created_at)
                                | Actualizado: {{ $empleado->updated_at->format('d/m/Y H:i') }}
                            @endif
                        </small>
                    </div>
                    <div>
                        <form action="{{ route('empleados.destroy', $empleado->id_empleado) }}" 
                              method="POST" class="d-inline"
                              onsubmit="return confirm('¿Está seguro de eliminar este empleado? Esta acción no se puede deshacer.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Eliminar Empleado
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
