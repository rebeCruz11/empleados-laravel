<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Services\EstadisticasEmpleadosService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class EmpleadoController extends Controller
{
    protected $estadisticasService;

    public function __construct(EstadisticasEmpleadosService $estadisticasService)
    {
        $this->estadisticasService = $estadisticasService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Empleado::query();

        // Filtros
        if ($request->filled('departamento')) {
            $query->where('departamento', $request->departamento);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        // Por defecto mostrar solo activos, a menos que se especifique
        if (!$request->has('estado') && !$request->has('todos')) {
            $query->activos();
        }

        // Paginación de 5 registros manteniendo los parámetros de búsqueda
        $empleados = $query->orderBy('nombre')->paginate(5)->withQueryString();
        
        // Obtener estadísticas
        $estadisticas = $this->estadisticasService->obtenerEstadisticasGenerales();
        
        // Obtener departamentos únicos para el filtro
        $departamentos = Empleado::distinct()->pluck('departamento');

        return view('empleados.index', compact('empleados', 'estadisticas', 'departamentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departamentos = ['Ventas', 'Producción', 'RRHH', 'Finanzas', 'TI', 'Marketing', 'Logística', 'Calidad'];
        return view('empleados.create', compact('departamentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:100', 'min:3'],
            'departamento' => ['required', 'string', 'max:50'],
            'puesto' => ['required', 'string', 'max:50'],
            'salario_base' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'bonificacion' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
            'descuento' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
            'fecha_contratacion' => ['required', 'date', 'before_or_equal:today', 'after_or_equal:1940-01-01'],
            'fecha_nacimiento' => ['required', 'date', 'before:-18 years', 'after:1900-01-01'],
            'sexo' => ['required', Rule::in(['M', 'F', 'O'])],
            'evaluacion_desempeno' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'estado' => ['required', 'boolean']
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
            'departamento.required' => 'El departamento es obligatorio',
            'puesto.required' => 'El puesto es obligatorio',
            'salario_base.required' => 'El salario base es obligatorio',
            'salario_base.min' => 'El salario base debe ser mayor o igual a 0',
            'fecha_contratacion.required' => 'La fecha de contratación es obligatoria',
            'fecha_contratacion.before_or_equal' => 'La fecha de contratación no puede ser futura',
            'fecha_contratacion.after_or_equal' => 'La fecha de contratación debe ser desde 1940 en adelante',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria',
            'fecha_nacimiento.before' => 'El empleado debe tener al menos 18 años',
            'fecha_nacimiento.after' => 'La fecha de nacimiento debe ser posterior a 1900',
            'sexo.required' => 'El sexo es obligatorio',
            'sexo.in' => 'El sexo debe ser M, F u O',
            'evaluacion_desempeno.max' => 'La evaluación de desempeño no puede ser mayor a 100',
            'evaluacion_desempeno.min' => 'La evaluación de desempeño no puede ser menor a 0',
            'estado.required' => 'El estado es obligatorio'
        ]);

        // Validación adicional: fecha de contratación no puede ser más de 80 años después del nacimiento
        $fechaNacimiento = Carbon::parse($validated['fecha_nacimiento']);
        $fechaContratacion = Carbon::parse($validated['fecha_contratacion']);
        
        // Validar que la fecha de contratación sea al menos 18 años después del nacimiento
        if ($fechaContratacion->lessThan($fechaNacimiento->copy()->addYears(18))) {
            return back()->withErrors([
                'fecha_contratacion' => 'La fecha de contratación debe ser al menos 18 años después del nacimiento'
            ])->withInput();
        }

        // Validar que no tenga más de 80 años de trabajo
        $antiguedad = $fechaContratacion->diffInYears(Carbon::now());
        if ($antiguedad > 80) {
            return back()->withErrors([
                'fecha_contratacion' => 'La fecha de contratación no puede superar los 80 años de antigüedad'
            ])->withInput();
        }

        // Validar que la edad actual del empleado al contratar no supere los 65 años
        $edadAlContratar = $fechaNacimiento->diffInYears($fechaContratacion);
        if ($edadAlContratar > 65) {
            return back()->withErrors([
                'fecha_contratacion' => 'La edad al momento de contratación no puede ser mayor a 65 años'
            ])->withInput();
        }

        Empleado::create($validated);

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleados.show', compact('empleado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $empleado = Empleado::findOrFail($id);
        $departamentos = ['Ventas', 'Producción', 'RRHH', 'Finanzas', 'TI', 'Marketing', 'Logística', 'Calidad'];
        return view('empleados.edit', compact('empleado', 'departamentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $empleado = Empleado::findOrFail($id);

        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:100', 'min:3'],
            'departamento' => ['required', 'string', 'max:50'],
            'puesto' => ['required', 'string', 'max:50'],
            'salario_base' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'bonificacion' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
            'descuento' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
            'fecha_contratacion' => ['required', 'date', 'before_or_equal:today', 'after_or_equal:1940-01-01'],
            'fecha_nacimiento' => ['required', 'date', 'before:-18 years', 'after:1900-01-01'],
            'sexo' => ['required', Rule::in(['M', 'F', 'O'])],
            'evaluacion_desempeno' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'estado' => ['required', 'boolean']
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
            'departamento.required' => 'El departamento es obligatorio',
            'puesto.required' => 'El puesto es obligatorio',
            'salario_base.required' => 'El salario base es obligatorio',
            'salario_base.min' => 'El salario base debe ser mayor o igual a 0',
            'fecha_contratacion.required' => 'La fecha de contratación es obligatoria',
            'fecha_contratacion.before_or_equal' => 'La fecha de contratación no puede ser futura',
            'fecha_contratacion.after_or_equal' => 'La fecha de contratación debe ser desde 1940 en adelante',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria',
            'fecha_nacimiento.before' => 'El empleado debe tener al menos 18 años',
            'fecha_nacimiento.after' => 'La fecha de nacimiento debe ser posterior a 1900',
            'sexo.required' => 'El sexo es obligatorio',
            'sexo.in' => 'El sexo debe ser M, F u O',
            'evaluacion_desempeno.max' => 'La evaluación de desempeño no puede ser mayor a 100',
            'evaluacion_desempeno.min' => 'La evaluación de desempeño no puede ser menor a 0',
            'estado.required' => 'El estado es obligatorio'
        ]);

        // Validaciones adicionales
        $fechaNacimiento = Carbon::parse($validated['fecha_nacimiento']);
        $fechaContratacion = Carbon::parse($validated['fecha_contratacion']);
        
        if ($fechaContratacion->lessThan($fechaNacimiento->copy()->addYears(18))) {
            return back()->withErrors([
                'fecha_contratacion' => 'La fecha de contratación debe ser al menos 18 años después del nacimiento'
            ])->withInput();
        }

        $antiguedad = $fechaContratacion->diffInYears(Carbon::now());
        if ($antiguedad > 80) {
            return back()->withErrors([
                'fecha_contratacion' => 'La fecha de contratación no puede superar los 80 años de antigüedad'
            ])->withInput();
        }

        $edadAlContratar = $fechaNacimiento->diffInYears($fechaContratacion);
        if ($edadAlContratar > 65) {
            return back()->withErrors([
                'fecha_contratacion' => 'La edad al momento de contratación no puede ser mayor a 65 años'
            ])->withInput();
        }

        $empleado->update($validated);

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado eliminado exitosamente');
    }

    /**
     * Muestra el dashboard con estadísticas y gráficos
     */
    public function dashboard()
    {
        $estadisticas = $this->estadisticasService->obtenerEstadisticasCompletas();
        return view('empleados.dashboard', compact('estadisticas'));
    }

    /**
     * Genera y muestra el reporte completo de empleados
     */
    public function reporte()
    {
        $estadisticas = $this->estadisticasService->obtenerEstadisticasCompletas();
        $empleados = Empleado::activos()
            ->orderBy('departamento')
            ->orderBy('nombre')
            ->get();
        
        return view('empleados.reporte', compact('estadisticas', 'empleados'));
    }
}
