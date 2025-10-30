<?php

namespace Database\Seeders;

use App\Models\Empleado;
use Illuminate\Database\Seeder;

class EmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear 100 empleados de prueba
        Empleado::factory()->count(100)->create();

        // Crear algunos empleados específicos para pruebas
        Empleado::create([
            'nombre' => 'María García Rodríguez',
            'departamento' => 'RRHH',
            'puesto' => 'Gerente de RRHH',
            'salario_base' => 45000.00,
            'bonificacion' => 8000.00,
            'descuento' => 2000.00,
            'fecha_contratacion' => '2010-01-15',
            'fecha_nacimiento' => '1985-05-20',
            'sexo' => 'F',
            'evaluacion_desempeno' => 95.50,
            'estado' => 1
        ]);

        Empleado::create([
            'nombre' => 'Juan Carlos Martínez López',
            'departamento' => 'TI',
            'puesto' => 'CTO',
            'salario_base' => 60000.00,
            'bonificacion' => 12000.00,
            'descuento' => 1500.00,
            'fecha_contratacion' => '2005-03-10',
            'fecha_nacimiento' => '1980-08-15',
            'sexo' => 'M',
            'evaluacion_desempeno' => 98.75,
            'estado' => 1
        ]);

        Empleado::create([
            'nombre' => 'Ana Sofía Pérez Torres',
            'departamento' => 'Ventas',
            'puesto' => 'Gerente de Ventas',
            'salario_base' => 42000.00,
            'bonificacion' => 15000.00,
            'descuento' => 800.00,
            'fecha_contratacion' => '2015-06-20',
            'fecha_nacimiento' => '1990-12-05',
            'sexo' => 'F',
            'evaluacion_desempeno' => 92.30,
            'estado' => 1
        ]);

        Empleado::create([
            'nombre' => 'Roberto Sánchez Gómez',
            'departamento' => 'Producción',
            'puesto' => 'Operario',
            'salario_base' => 12000.00,
            'bonificacion' => 1500.00,
            'descuento' => 500.00,
            'fecha_contratacion' => '2022-08-01',
            'fecha_nacimiento' => '1998-03-25',
            'sexo' => 'M',
            'evaluacion_desempeno' => 78.50,
            'estado' => 1
        ]);

        // Empleado inactivo para probar filtros
        Empleado::create([
            'nombre' => 'Laura Fernández Díaz',
            'departamento' => 'Marketing',
            'puesto' => 'Community Manager',
            'salario_base' => 18000.00,
            'bonificacion' => 2000.00,
            'descuento' => 300.00,
            'fecha_contratacion' => '2018-11-12',
            'fecha_nacimiento' => '1995-07-18',
            'sexo' => 'F',
            'evaluacion_desempeno' => 65.00,
            'estado' => 0
        ]);
    }
}
