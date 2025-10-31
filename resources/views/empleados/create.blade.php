@extends('layouts.app')

@section('title', 'Nuevo Empleado')

@section('content')
<div class="page-header mb-4">
    <h1 class="h3 mb-1 text-gray-800">
        <i class="bi bi-person-plus-fill"></i> Registrar Nuevo Empleado
    </h1>
    <p class="text-muted">Complete el formulario con la información del empleado</p>
</div>

<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-file-earmark-text"></i> Formulario de Registro
            </div>
            <div class="card-body">
                <form id="formEmpleado" method="POST" action="{{ route('empleados.store') }}">
                    @csrf
                    <!-- Información Personal -->
                    <h5 class="border-bottom pb-2 mb-3 text-primary">
                        <i class="bi bi-person"></i> Información Personal
                    </h5>

                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label for="nombre" class="form-label fw-semibold">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="sexo" class="form-label fw-semibold">Sexo <span class="text-danger">*</span></label>
                            <select class="form-select" id="sexo" name="sexo" >
                                <option value="">Seleccione...</option>
                                <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                                <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
                                <option value="O" {{ old('sexo') == 'O' ? 'selected' : '' }}>Otro</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fecha_nacimiento" class="form-label fw-semibold">Fecha de Nacimiento <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" >
                            <small class="form-text text-muted">El empleado debe tener al menos 18 años</small>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_contratacion" class="form-label fw-semibold">Fecha de Contratación <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="fecha_contratacion" name="fecha_contratacion" value="{{ old('fecha_contratacion') }}" >
                            <small class="form-text text-muted">No puede ser futura ni superar 80 años</small>
                        </div>
                    </div>

                    <!-- Información Laboral -->
                    <h5 class="border-bottom pb-2 mb-3 mt-4 text-primary">
                        <i class="bi bi-building"></i> Información Laboral
                    </h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="departamento" class="form-label fw-semibold">Departamento <span class="text-danger">*</span></label>
                            <select class="form-select" id="departamento" name="departamento" >
                                <option value="">Seleccione...</option>
                                @foreach($departamentos as $dept)
                                    <option value="{{ $dept }}" {{ old('departamento') == $dept ? 'selected' : '' }}>
                                        {{ $dept }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="puesto" class="form-label fw-semibold">Puesto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="puesto" name="puesto" value="{{ old('puesto') }}" >
                        </div>
                    </div>

                    <!-- Información Financiera -->
                    <h5 class="border-bottom pb-2 mb-3 mt-4 text-primary">
                        <i class="bi bi-cash-stack"></i> Información Financiera
                    </h5>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="salario_base" class="form-label fw-semibold">Salario Base <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" class="form-control" id="salario_base" name="salario_base" value="{{ old('salario_base') }}" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="bonificacion" class="form-label fw-semibold">Bonificación</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" class="form-control" id="bonificacion" name="bonificacion" value="{{ old('bonificacion', 0) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="descuento" class="form-label fw-semibold">Descuento</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" class="form-control" id="descuento" name="descuento" value="{{ old('descuento', 0) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Evaluación y Estado -->
                    <h5 class="border-bottom pb-2 mb-3 mt-4 text-primary">
                        <i class="bi bi-star"></i> Evaluación y Estado
                    </h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="evaluacion_desempeno" class="form-label fw-semibold">Evaluación de Desempeño (0-100)</label>
                            <input type="number" step="0.01" class="form-control" id="evaluacion_desempeno" name="evaluacion_desempeno" value="{{ old('evaluacion_desempeno', 0) }}" min="0" max="100">
                        </div>
                        <div class="col-md-6">
                            <label for="estado" class="form-label fw-semibold">Estado <span class="text-danger">*</span></label>
                            <select class="form-select" id="estado" name="estado" required>
                                <option value="1" {{ old('estado', 1) == 1 ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ old('estado') == 0 ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                        <a href="{{ route('empleados.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Guardar Empleado
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const form = document.getElementById('formEmpleado');

function mostrarError(mensaje) {
    Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: mensaje,
        confirmButtonColor: '#3085d6',
    });
}

form.addEventListener('submit', function(e) {
    e.preventDefault(); // prevenir envío automático
    
    // Campos requeridos
    const nombre = document.getElementById('nombre').value.trim();
    const sexo = document.getElementById('sexo').value;
    const fechaNacimiento = document.getElementById('fecha_nacimiento').value;
    const fechaContratacion = document.getElementById('fecha_contratacion').value;
    const departamento = document.getElementById('departamento').value;
    const puesto = document.getElementById('puesto').value;
    const salario = parseFloat(document.getElementById('salario_base').value);
    const bonificacion = parseFloat(document.getElementById('bonificacion').value);
    const descuento = parseFloat(document.getElementById('descuento').value);
    const evaluacion = parseFloat(document.getElementById('evaluacion_desempeno').value);
    const estado = document.getElementById('estado').value;

    if(!nombre){ mostrarError('El nombre es obligatorio'); return; }
    if(!sexo){ mostrarError('El sexo es obligatorio'); return; }
    if(!fechaNacimiento){ mostrarError('La fecha de nacimiento es obligatoria'); return; }
    if(!fechaContratacion){ mostrarError('La fecha de contratación es obligatoria'); return; }
    if(!departamento){ mostrarError('El departamento es obligatorio'); return; }
    if(!puesto){ mostrarError('El puesto es obligatorio'); return; }
    if(!salario || salario < 0){ mostrarError('El salario base debe ser mayor o igual a 0'); return; }
    if(bonificacion < 0){ mostrarError('La bonificación no puede ser negativa'); return; }
    if(descuento < 0){ mostrarError('El descuento no puede ser negativo'); return; }
    if(evaluacion < 0 || evaluacion > 100){ mostrarError('La evaluación debe estar entre 0 y 100'); return; }
    if(!estado){ mostrarError('El estado es obligatorio'); return; }

    // Validación de fechas
    const hoy = new Date();
    const nacimiento = new Date(fechaNacimiento);
    const contratacion = new Date(fechaContratacion);
    const edad = Math.floor((hoy - nacimiento) / (365.25*24*60*60*1000));
    if(edad < 18){ mostrarError('El empleado debe tener al menos 18 años'); return; }
    if(contratacion > hoy){ mostrarError('La fecha de contratación no puede ser futura'); return; }
    const edadContratacion = Math.floor((contratacion - nacimiento)/(365.25*24*60*60*1000));
    if(edadContratacion < 18){ mostrarError('El empleado debe tener al menos 18 años al momento de la contratación'); return; }

    // Si pasa todas las validaciones, enviar el formulario
    form.submit();
});
</script>
@endpush
