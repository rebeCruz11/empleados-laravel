<?php

namespace App\Services;

use App\Models\Empleado;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EstadisticasEmpleadosService
{
    /**
     * Obtiene estadísticas financieras
     */
    public function obtenerEstadisticasFinancieras()
    {
        $empleadosActivos = Empleado::activos();
        $empleadosActivosCollection = $empleadosActivos->get();

        // Calcular promedio salario neto actual
        $promedioSalarioNetoActual = round($empleadosActivosCollection->avg('salario_neto'), 2);
        
        // Calcular crecimiento dinámico vs año anterior
        $fechaHaceUnAnio = Carbon::now()->subYear();
        
        // Obtener empleados que estaban activos hace un año
        $empleadosAnteriores = Empleado::where('fecha_contratacion', '<=', $fechaHaceUnAnio)
            ->where(function($query) use ($fechaHaceUnAnio) {
                $query->where('estado', true)
                      ->orWhere('updated_at', '>=', $fechaHaceUnAnio);
            })
            ->get();
        
        $crecimientoVsAnioAnterior = 0;
        
        if ($empleadosAnteriores->count() > 0) {
            // Calcular salario promedio del año anterior (simulado con reducción del 5%)
            $promedioSalarioAnterior = $empleadosAnteriores->avg('salario_base') * 0.95;
            $promedioSalarioActual = $empleadosActivos->avg('salario_base');
            
            if ($promedioSalarioAnterior > 0) {
                $crecimientoVsAnioAnterior = round((($promedioSalarioActual - $promedioSalarioAnterior) / $promedioSalarioAnterior) * 100, 2);
            }
        }

        return [
            'promedio_salario_base' => round($empleadosActivos->avg('salario_base'), 2),
            'total_bonificaciones' => round($empleadosActivos->sum('bonificacion'), 2),
            'total_descuentos' => round($empleadosActivos->sum('descuento'), 2),
            'promedio_salario_neto' => $promedioSalarioNetoActual,
            'total_nomina' => round($empleadosActivosCollection->sum('salario_neto'), 2),
            'salario_minimo' => round($empleadosActivos->min('salario_base'), 2),
            'salario_maximo' => round($empleadosActivos->max('salario_base'), 2),
            'crecimiento_vs_anio_anterior' => $crecimientoVsAnioAnterior,
        ];
    }

    /**
     * Obtiene estadísticas demográficas
     */
    public function obtenerEstadisticasDemograficas()
    {
        $empleadosActivos = Empleado::activos()->get();

        $totalEmpleados = $empleadosActivos->count();
        
        $distribucionSexo = Empleado::activos()
            ->select('sexo', DB::raw('count(*) as total'))
            ->groupBy('sexo')
            ->get()
            ->mapWithKeys(function ($item) use ($totalEmpleados) {
                return [$item->sexo => [
                    'total' => $item->total,
                    'porcentaje' => $totalEmpleados > 0 ? round(($item->total / $totalEmpleados) * 100, 1) : 0
                ]];
            });

        // Clasificar puestos directivos vs operativos
        $puestosDirectivos = ['Gerente', 'Director', 'CTO', 'Jefe', 'Coordinador'];
        
        $empleadosDirectivos = $empleadosActivos->filter(function ($empleado) use ($puestosDirectivos) {
            foreach ($puestosDirectivos as $cargo) {
                if (stripos($empleado->puesto, $cargo) !== false) {
                    return true;
                }
            }
            return false;
        });

        $empleadosOperativos = $empleadosActivos->filter(function ($empleado) use ($puestosDirectivos) {
            foreach ($puestosDirectivos as $cargo) {
                if (stripos($empleado->puesto, $cargo) !== false) {
                    return false;
                }
            }
            return true;
        });

        return [
            'edad_promedio' => round($empleadosActivos->avg('edad'), 1),
            'edad_minima' => $empleadosActivos->min('edad'),
            'edad_maxima' => $empleadosActivos->max('edad'),
            'distribucion_sexo' => $distribucionSexo,
            'total_empleados' => $totalEmpleados,
            'empleados_activos' => Empleado::activos()->count(),
            'empleados_inactivos' => Empleado::inactivos()->count(),
            'edad_promedio_directivos' => $empleadosDirectivos->count() > 0 ? round($empleadosDirectivos->avg('edad'), 1) : 0,
            'edad_promedio_operativos' => $empleadosOperativos->count() > 0 ? round($empleadosOperativos->avg('edad'), 1) : 0,
            'total_directivos' => $empleadosDirectivos->count(),
            'total_operativos' => $empleadosOperativos->count(),
        ];
    }

    /**
     * Obtiene estadísticas de desempeño
     */
    public function obtenerEstadisticasDesempeno()
    {
        $empleadosActivosCollection = Empleado::activos()->get();

        // Calcular correlación entre salario y desempeño
        $correlacionSalarioDesempeno = $this->calcularCorrelacion(
            $empleadosActivosCollection->pluck('salario_base')->toArray(),
            $empleadosActivosCollection->pluck('evaluacion_desempeno')->toArray()
        );

        // Evaluación promedio por departamento
        $evaluacionPorDepartamento = Empleado::activos()
            ->select('departamento', DB::raw('ROUND(AVG(evaluacion_desempeno), 2) as evaluacion_promedio'))
            ->groupBy('departamento')
            ->orderBy('evaluacion_promedio', 'desc')
            ->get();

        // Contar empleados por categoría usando la colección
        $empleadosExcelentes = $empleadosActivosCollection->filter(function($emp) {
            return $emp->evaluacion_desempeno >= 95;
        })->count();
        
        $empleadosBuenos = $empleadosActivosCollection->filter(function($emp) {
            return $emp->evaluacion_desempeno >= 80 && $emp->evaluacion_desempeno < 95;
        })->count();
        
        $empleadosRegulares = $empleadosActivosCollection->filter(function($emp) {
            return $emp->evaluacion_desempeno >= 70 && $emp->evaluacion_desempeno < 80;
        })->count();
        
        $empleadosDeficientes = $empleadosActivosCollection->filter(function($emp) {
            return $emp->evaluacion_desempeno < 70;
        })->count();

        $totalEmpleados = $empleadosActivosCollection->count();

        return [
            'evaluacion_promedio' => round($empleadosActivosCollection->avg('evaluacion_desempeno'), 2),
            'evaluacion_minima' => round($empleadosActivosCollection->min('evaluacion_desempeno'), 2),
            'evaluacion_maxima' => round($empleadosActivosCollection->max('evaluacion_desempeno'), 2),
            'empleados_excelentes' => $empleadosExcelentes,
            'empleados_buenos' => $empleadosBuenos,
            'empleados_regulares' => $empleadosRegulares,
            'empleados_deficientes' => $empleadosDeficientes,
            'porcentaje_sobre_70' => $totalEmpleados > 0 ? round((($empleadosExcelentes + $empleadosBuenos + $empleadosRegulares) / $totalEmpleados) * 100, 1) : 0,
            'correlacion_salario_desempeno' => round($correlacionSalarioDesempeno, 2),
            'evaluacion_por_departamento' => $evaluacionPorDepartamento,
        ];
    }

    /**
     * Obtiene estadísticas de antigüedad
     */
    public function obtenerEstadisticasAntiguedad()
    {
        $empleadosActivos = Empleado::activos()->get();

        $empleadosConMas10Anos = $empleadosActivos->filter(function ($empleado) {
            return $empleado->antiguedad >= 10;
        })->count();

        $totalEmpleados = $empleadosActivos->count();

        // Calcular correlación entre antigüedad y salario
        $correlacionAntiguedadSalario = $this->calcularCorrelacion(
            $empleadosActivos->pluck('antiguedad')->toArray(),
            $empleadosActivos->pluck('salario_base')->toArray()
        );

        // Tiempo promedio de permanencia es igual a antigüedad promedio
        $tiempoPromedioPermanencia = round($empleadosActivos->avg('antiguedad'), 1);

        return [
            'antiguedad_promedio' => round($empleadosActivos->avg('antiguedad'), 1),
            'antiguedad_minima' => $empleadosActivos->min('antiguedad'),
            'antiguedad_maxima' => $empleadosActivos->max('antiguedad'),
            'empleados_mas_10_anos' => $empleadosConMas10Anos,
            'porcentaje_mas_10_anos' => $totalEmpleados > 0 ? round(($empleadosConMas10Anos / $totalEmpleados) * 100, 1) : 0,
            'correlacion_antiguedad_salario' => round($correlacionAntiguedadSalario, 2),
            'tiempo_promedio_permanencia' => $tiempoPromedioPermanencia,
        ];
    }

    /**
     * Obtiene estadísticas por departamento
     */
    public function obtenerEstadisticasPorDepartamento()
    {
        return Empleado::activos()
            ->select(
                'departamento',
                DB::raw('COUNT(*) as total_empleados'),
                DB::raw('ROUND(AVG(salario_base), 2) as promedio_salario'),
                DB::raw('ROUND(AVG(evaluacion_desempeno), 2) as promedio_evaluacion'),
                DB::raw('ROUND(AVG(TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE())), 1) as edad_promedio')
            )
            ->groupBy('departamento')
            ->orderBy('promedio_salario', 'desc')
            ->get();
    }

    /**
     * Obtiene datos para el gráfico de salario vs desempeño
     */
    public function obtenerDatosSalarioDesempeno()
    {
        return Empleado::activos()
            ->select('nombre', 'salario_base', 'evaluacion_desempeno', 'departamento')
            ->orderBy('salario_base')
            ->get();
    }

    /**
     * Obtiene todas las estadísticas generales
     */
    public function obtenerEstadisticasGenerales()
    {
        return [
            'financieras' => $this->obtenerEstadisticasFinancieras(),
            'demograficas' => $this->obtenerEstadisticasDemograficas(),
            'desempeno' => $this->obtenerEstadisticasDesempeno(),
            'antiguedad' => $this->obtenerEstadisticasAntiguedad(),
        ];
    }

    /**
     * Obtiene todas las estadísticas completas incluyendo por departamento
     */
    public function obtenerEstadisticasCompletas()
    {
        return [
            'financieras' => $this->obtenerEstadisticasFinancieras(),
            'demograficas' => $this->obtenerEstadisticasDemograficas(),
            'desempeno' => $this->obtenerEstadisticasDesempeno(),
            'antiguedad' => $this->obtenerEstadisticasAntiguedad(),
            'por_departamento' => $this->obtenerEstadisticasPorDepartamento(),
            'salario_desempeno' => $this->obtenerDatosSalarioDesempeno(),
            'evolucion_salario' => $this->obtenerEvolucionSalario(),
            'datos_dispersion' => $this->obtenerDatosDispersion(),
        ];
    }

    /**
     * Obtiene datos para gráficos
     */
    public function obtenerDatosGraficos()
    {
        $departamentos = $this->obtenerEstadisticasPorDepartamento();
        
        return [
            'salario_por_departamento' => [
                'labels' => $departamentos->pluck('departamento'),
                'data' => $departamentos->pluck('promedio_salario'),
            ],
            'empleados_por_departamento' => [
                'labels' => $departamentos->pluck('departamento'),
                'data' => $departamentos->pluck('total_empleados'),
            ],
            'desempeno_por_departamento' => [
                'labels' => $departamentos->pluck('departamento'),
                'data' => $departamentos->pluck('promedio_evaluacion'),
            ],
        ];
    }

    /**
     * Obtiene evolución de salario promedio (simulado por departamento)
     */
    public function obtenerEvolucionSalario()
    {
        // Simular evolución histórica basada en datos actuales
        $departamentos = $this->obtenerEstadisticasPorDepartamento();
        $promedioActual = $departamentos->avg('promedio_salario');
        
        // Simular evolución con crecimiento del 5% anual
        return [
            'labels' => ['2021', '2022', '2023', '2024', '2025'],
            'data' => [
                round($promedioActual / 1.2155, 2), // 2021
                round($promedioActual / 1.1576, 2), // 2022
                round($promedioActual / 1.1025, 2), // 2023
                round($promedioActual / 1.05, 2),   // 2024
                round($promedioActual, 2),          // 2025
            ]
        ];
    }

    /**
     * Obtiene datos para gráfico de dispersión salario vs desempeño
     */
    public function obtenerDatosDispersion()
    {
        return Empleado::activos()
            ->select('salario_base', 'evaluacion_desempeno', 'departamento')
            ->get()
            ->map(function ($empleado) {
                return [
                    'x' => (float) $empleado->salario_base,
                    'y' => (float) $empleado->evaluacion_desempeno,
                    'departamento' => $empleado->departamento,
                ];
            });
    }

    /**
     * Calcula el coeficiente de correlación de Pearson entre dos variables
     */
    private function calcularCorrelacion($x, $y)
    {
        $n = count($x);
        
        if ($n === 0 || $n !== count($y)) {
            return 0;
        }

        $sumX = array_sum($x);
        $sumY = array_sum($y);
        $sumXY = 0;
        $sumX2 = 0;
        $sumY2 = 0;

        for ($i = 0; $i < $n; $i++) {
            $sumXY += $x[$i] * $y[$i];
            $sumX2 += $x[$i] * $x[$i];
            $sumY2 += $y[$i] * $y[$i];
        }

        $numerador = ($n * $sumXY) - ($sumX * $sumY);
        $denominador = sqrt((($n * $sumX2) - ($sumX * $sumX)) * (($n * $sumY2) - ($sumY * $sumY)));

        if ($denominador == 0) {
            return 0;
        }

        return $numerador / $denominador;
    }
}
