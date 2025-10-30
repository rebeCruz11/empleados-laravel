@extends('layouts.app')

@section('title', 'Editar Empleado')

@section('content')
<div class="page-header">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="bi bi-pencil-square"></i> Editar Empleado
    </h1>
    <p class="text-muted">Actualizar la información de {{ $empleado->nombre }}</p>
</div>

<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-file-earmark-text"></i> Formulario de Edición
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <h6 class="alert-heading"><i class="bi bi-exclamation-triangle"></i> Errores de validación:</h6>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('empleados.update', $empleado->id_empleado) }}">
                    @csrf
                    @method('PUT')
                    
                    <!-- Información Personal -->
                    <h5 class="border-bottom pb-2 mb-3">
                        <i class="bi bi-person"></i> Información Personal
                    </h5>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label for="nombre" class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" value="{{ old('nombre', $empleado->nombre) }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="sexo" class="form-label">Sexo <span class="text-danger">*</span></label>
                            <select class="form-select @error('sexo') is-invalid @enderror" 
                                    id="sexo" name="sexo" required>
                                <option value="">Seleccione...</option>
                                <option value="M" {{ old('sexo', $empleado->sexo) == 'M' ? 'selected' : '' }}>Masculino</option>
                                <option value="F" {{ old('sexo', $empleado->sexo) == 'F' ? 'selected' : '' }}>Femenino</option>
                                <option value="O" {{ old('sexo', $empleado->sexo) == 'O' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('sexo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                                   id="fecha_nacimiento" name="fecha_nacimiento" 
                                   value="{{ old('fecha_nacimiento', $empleado->fecha_nacimiento->format('Y-m-d')) }}" required>
                            <small class="form-text text-muted">El empleado debe tener al menos 18 años</small>
                            @error('fecha_nacimiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_contratacion" class="form-label">Fecha de Contratación <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('fecha_contratacion') is-invalid @enderror" 
                                   id="fecha_contratacion" name="fecha_contratacion" 
                                   value="{{ old('fecha_contratacion', $empleado->fecha_contratacion->format('Y-m-d')) }}" required>
                            <small class="form-text text-muted">No puede ser futura ni superar 80 años</small>
                            @error('fecha_contratacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Información Laboral -->
                    <h5 class="border-bottom pb-2 mb-3 mt-4">
                        <i class="bi bi-building"></i> Información Laboral
                    </h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="departamento" class="form-label">Departamento <span class="text-danger">*</span></label>
                            <select class="form-select @error('departamento') is-invalid @enderror" 
                                    id="departamento" name="departamento" required>
                                <option value="">Seleccione...</option>
                                @foreach($departamentos as $dept)
                                    <option value="{{ $dept }}" {{ old('departamento', $empleado->departamento) == $dept ? 'selected' : '' }}>
                                        {{ $dept }}
                                    </option>
                                @endforeach
                            </select>
                            @error('departamento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="puesto" class="form-label">Puesto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('puesto') is-invalid @enderror" 
                                   id="puesto" name="puesto" value="{{ old('puesto', $empleado->puesto) }}" required>
                            @error('puesto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Información Financiera -->
                    <h5 class="border-bottom pb-2 mb-3 mt-4">
                        <i class="bi bi-cash-stack"></i> Información Financiera
                    </h5>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="salario_base" class="form-label">Salario Base <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" class="form-control @error('salario_base') is-invalid @enderror" 
                                       id="salario_base" name="salario_base" value="{{ old('salario_base', $empleado->salario_base) }}" required>
                                @error('salario_base')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="bonificacion" class="form-label">Bonificación</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" class="form-control @error('bonificacion') is-invalid @enderror" 
                                       id="bonificacion" name="bonificacion" value="{{ old('bonificacion', $empleado->bonificacion) }}">
                                @error('bonificacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="descuento" class="form-label">Descuento</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" class="form-control @error('descuento') is-invalid @enderror" 
                                       id="descuento" name="descuento" value="{{ old('descuento', $empleado->descuento) }}">
                                @error('descuento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Evaluación y Estado -->
                    <h5 class="border-bottom pb-2 mb-3 mt-4">
                        <i class="bi bi-star"></i> Evaluación y Estado
                    </h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="evaluacion_desempeno" class="form-label">Evaluación de Desempeño (0-100)</label>
                            <input type="number" step="0.01" class="form-control @error('evaluacion_desempeno') is-invalid @enderror" 
                                   id="evaluacion_desempeno" name="evaluacion_desempeno" 
                                   value="{{ old('evaluacion_desempeno', $empleado->evaluacion_desempeno) }}" min="0" max="100">
                            @error('evaluacion_desempeno')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                            <select class="form-select @error('estado') is-invalid @enderror" 
                                    id="estado" name="estado" required>
                                <option value="1" {{ old('estado', $empleado->estado) == 1 ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ old('estado', $empleado->estado) == 0 ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                        <a href="{{ route('empleados.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Actualizar Empleado
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Validación en tiempo real de las fechas
    document.getElementById('fecha_nacimiento').addEventListener('change', function() {
        const fechaNacimiento = new Date(this.value);
        const hoy = new Date();
        const edad = Math.floor((hoy - fechaNacimiento) / (365.25 * 24 * 60 * 60 * 1000));
        
        if (edad < 18) {
            alert('El empleado debe tener al menos 18 años de edad');
            this.value = '';
        }
    });

    document.getElementById('fecha_contratacion').addEventListener('change', function() {
        const fechaContratacion = new Date(this.value);
        const hoy = new Date();
        
        if (fechaContratacion > hoy) {
            alert('La fecha de contratación no puede ser futura');
            this.value = '';
        }

        const fechaNacimiento = document.getElementById('fecha_nacimiento').value;
        if (fechaNacimiento) {
            const nacimiento = new Date(fechaNacimiento);
            const antiguedad = Math.floor((hoy - fechaContratacion) / (365.25 * 24 * 60 * 60 * 1000));
            const edadContratacion = Math.floor((fechaContratacion - nacimiento) / (365.25 * 24 * 60 * 60 * 1000));
            
            if (antiguedad > 80) {
                alert('La fecha de contratación no puede superar los 80 años de antigüedad');
                this.value = '';
            }
            
            if (edadContratacion < 18) {
                alert('El empleado debe tener al menos 18 años al momento de la contratación');
                this.value = '';
            }
        }
    });
</script>
@endpush
