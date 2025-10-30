<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id('id_empleado');
            $table->string('nombre', 100);
            $table->string('departamento', 50);
            $table->string('puesto', 50);
            $table->decimal('salario_base', 10, 2);
            $table->decimal('bonificacion', 10, 2)->default(0.00);
            $table->decimal('descuento', 10, 2)->default(0.00);
            $table->date('fecha_contratacion');
            $table->date('fecha_nacimiento');
            $table->char('sexo', 1);
            $table->decimal('evaluacion_desempeno', 5, 2)->default(0.00);
            $table->tinyInteger('estado')->default(1)->comment('0: Inactivo, 1: Activo');
            $table->timestamps();
            
            // Índices para mejorar el rendimiento
            $table->index('departamento');
            $table->index('puesto');
            $table->index('estado');
            $table->index('fecha_contratacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
