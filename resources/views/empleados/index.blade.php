@extends('layouts.app')

@section('title', 'Lista de Empleados')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="h3 mb-0 text-gray-800">
            <i class="bi bi-list-ul"></i> Lista de Empleados
        </h1>
        <p class="text-muted">Gestión y administración del personal</p>
    </div>
    <div>
        <a href="{{ route('empleados.reporte') }}" class="btn btn-success" target="_blank">
            <i class="bi bi-file-earmark-pdf"></i> Reporte PDF
        </a>
        <a href="{{ route('empleados.dashboard') }}" class="btn btn-info">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('empleados.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus-fill"></i> Nuevo Empleado
        </a>
    </div>
</div>

<!-- Filtros -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('empleados.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="buscar" class="form-label">
                    <i class="bi bi-search"></i> Buscar por nombre
                </label>
                <input type="text" class="form-control" id="buscar" name="buscar" 
                       value="{{ request('buscar') }}" placeholder="Nombre del empleado">
            </div>
            <div class="col-md-2">
                <label for="departamento" class="form-label">
                    <i class="bi bi-building"></i> Departamento
                </label>
                <select class="form-select" id="departamento" name="departamento">
                    <option value="">Todos</option>
                    @foreach($departamentos as $dept)
                        <option value="{{ $dept }}" {{ request('departamento') == $dept ? 'selected' : '' }}>
                            {{ $dept }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="estado" class="form-label">
                    <i class="bi bi-toggle-on"></i> Estado
                </label>
                <select class="form-select" id="estado" name="estado">
                    <option value="">Solo Activos</option>
                    <option value="1" {{ request('estado') == '1' ? 'selected' : '' }}>Activos</option>
                    <option value="0" {{ request('estado') == '0' ? 'selected' : '' }}>Inactivos</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="salario_min" class="form-label">
                    <i class="bi bi-currency-dollar"></i> Salario Mínimo
                </label>
                <input type="number" class="form-control @error('salario_min') is-invalid @enderror" 
                       id="salario_min" name="salario_min" 
                       value="{{ request('salario_min') }}" 
                       placeholder="Ej: 30000" 
                       step="0.01" min="0" max="99999999.99">
                @error('salario_min')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-2">
                <label for="salario_max" class="form-label">
                    <i class="bi bi-currency-dollar"></i> Salario Máximo
                </label>
                <input type="number" class="form-control @error('salario_max') is-invalid @enderror" 
                       id="salario_max" name="salario_max" 
                       value="{{ request('salario_max') }}" 
                       placeholder="Ej: 80000" 
                       step="0.01" min="0" max="99999999.99">
                @error('salario_max')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100" title="Aplicar filtros">
                    <i class="bi bi-funnel"></i>
                </button>
            </div>
        </form>
        
        @if(request()->hasAny(['buscar', 'departamento', 'estado', 'salario_min', 'salario_max']))
            <div class="mt-3">
                <a href="{{ route('empleados.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Limpiar filtros
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Estadísticas Rápidas -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                    Total Empleados Activos
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $estadisticas['demograficas']['empleados_activos'] }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Promedio Salario Base
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    ${{ number_format($estadisticas['financieras']['promedio_salario_base'], 2) }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Evaluación Promedio
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $estadisticas['desempeno']['evaluacion_promedio'] }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Edad Promedio
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $estadisticas['demograficas']['edad_promedio'] }} años
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Empleados -->
<div class="card">
    <div class="card-header">
        <i class="bi bi-table"></i> Empleados Registrados ({{ $empleados->total() }})
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Departamento</th>
                        <th>Puesto</th>
                        <th>Salario Neto</th>
                        <th>Evaluación</th>
                        <th>Antigüedad</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($empleados as $empleado)
                        <tr>
                            <td>{{ $empleado->id_empleado }}</td>
                            <td>
                                <strong>{{ $empleado->nombre }}</strong>
                                <br>
                                <small class="text-muted">{{ $empleado->sexo_completo }}</small>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $empleado->departamento }}</span>
                            </td>
                            <td>{{ $empleado->puesto }}</td>
                            <td>${{ number_format($empleado->salario_neto, 2) }}</td>
                            <td>
                                <span class="badge {{ $empleado->evaluacion_desempeno >= 80 ? 'bg-success' : ($empleado->evaluacion_desempeno >= 70 ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $empleado->evaluacion_desempeno }}
                                </span>
                            </td>
                            <td>{{ $empleado->antiguedad }} años</td>
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
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('empleados.show', $empleado->id_empleado) }}" 
                                       class="btn btn-sm btn-info" title="Ver detalles">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('empleados.edit', $empleado->id_empleado) }}" 
                                       class="btn btn-sm btn-warning" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('empleados.destroy', $empleado->id_empleado) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Está seguro de eliminar este empleado?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="bi bi-inbox fs-1 text-muted"></i>
                                <p class="text-muted mt-2">No se encontraron empleados</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $empleados->onEachSide(1)->links() }}
        </div>
    </div>
</div>
@endsection
