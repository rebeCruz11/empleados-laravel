<?php

namespace Database\Factories;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empleado>
 */
class EmpleadoFactory extends Factory
{
    protected $model = Empleado::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departamentos = ['Ventas', 'Producción', 'RRHH', 'Finanzas', 'TI', 'Marketing', 'Logística', 'Calidad'];
        
        $puestos = [
            'Ventas' => ['Gerente de Ventas', 'Vendedor', 'Supervisor de Ventas', 'Ejecutivo de Cuentas'],
            'Producción' => ['Gerente de Producción', 'Operario', 'Supervisor', 'Técnico'],
            'RRHH' => ['Gerente de RRHH', 'Reclutador', 'Analista de RRHH', 'Especialista en Compensaciones'],
            'Finanzas' => ['Director Financiero', 'Contador', 'Analista Financiero', 'Tesorero'],
            'TI' => ['CTO', 'Desarrollador', 'Analista de Sistemas', 'Soporte Técnico'],
            'Marketing' => ['Gerente de Marketing', 'Community Manager', 'Diseñador', 'Especialista SEO'],
            'Logística' => ['Gerente de Logística', 'Coordinador', 'Almacenista', 'Chofer'],
            'Calidad' => ['Gerente de Calidad', 'Inspector', 'Auditor', 'Analista de Calidad']
        ];

        $departamento = $this->faker->randomElement($departamentos);
        $puesto = $this->faker->randomElement($puestos[$departamento]);
        
        // Generar fechas coherentes
        $fechaNacimiento = $this->faker->dateTimeBetween('-65 years', '-22 years');
        $fechaContratacion = $this->faker->dateTimeBetween('-25 years', '-1 month');
        
        // Asegurar que la fecha de contratación sea después del nacimiento + 18 años mínimo
        $edadMinima = (clone $fechaNacimiento)->modify('+18 years');
        if ($fechaContratacion < $edadMinima) {
            $fechaContratacion = $this->faker->dateTimeBetween($edadMinima, 'now');
        }

        $salarioBase = $this->faker->randomFloat(2, 8000, 50000);

        return [
            'nombre' => $this->faker->name(),
            'departamento' => $departamento,
            'puesto' => $puesto,
            'salario_base' => $salarioBase,
            'bonificacion' => $this->faker->randomFloat(2, 0, $salarioBase * 0.3),
            'descuento' => $this->faker->randomFloat(2, 0, $salarioBase * 0.15),
            'fecha_contratacion' => $fechaContratacion,
            'fecha_nacimiento' => $fechaNacimiento,
            'sexo' => $this->faker->randomElement(['M', 'F', 'O']),
            'evaluacion_desempeno' => $this->faker->randomFloat(2, 50, 100),
            'estado' => $this->faker->randomElement([1, 1, 1, 1, 0]) // 80% activos, 20% inactivos
        ];
    }

    /**
     * Indicate that the employee is active.
     */
    public function activo(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => 1,
        ]);
    }

    /**
     * Indicate that the employee is inactive.
     */
    public function inactivo(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => 0,
        ]);
    }
}
