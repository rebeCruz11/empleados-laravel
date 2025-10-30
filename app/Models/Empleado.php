<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';
    protected $primaryKey = 'id_empleado';

    protected $fillable = [
        'nombre',
        'departamento',
        'puesto',
        'salario_base',
        'bonificacion',
        'descuento',
        'fecha_contratacion',
        'fecha_nacimiento',
        'sexo',
        'evaluacion_desempeno',
        'estado'
    ];

    protected $casts = [
        'salario_base' => 'decimal:2',
        'bonificacion' => 'decimal:2',
        'descuento' => 'decimal:2',
        'evaluacion_desempeno' => 'decimal:2',
        'fecha_contratacion' => 'date',
        'fecha_nacimiento' => 'date',
        'estado' => 'integer'
    ];

    // Accesorios (Getters)

    /**
     * Calcula el salario bruto (salario_base + bonificacion)
     */
    public function getSalarioBrutoAttribute()
    {
        return $this->salario_base + $this->bonificacion;
    }

    /**
     * Calcula el salario neto ((salario_base + bonificacion) - descuento)
     */
    public function getSalarioNetoAttribute()
    {
        return ($this->salario_base + $this->bonificacion) - $this->descuento;
    }

    /**
     * Calcula la edad actual del empleado en años
     */
    public function getEdadAttribute()
    {
        return $this->fecha_nacimiento->diffInYears(Carbon::now());
    }

    /**
     * Calcula la antigüedad del empleado en años
     */
    public function getAntiguedadAttribute()
    {
        return $this->fecha_contratacion->diffInYears(Carbon::now());
    }

    /**
     * Calcula la relación desempeño/salario
     */
    public function getRelacionDesempenoSalarioAttribute()
    {
        if ($this->salario_base == 0) {
            return 0;
        }
        return round($this->evaluacion_desempeno / $this->salario_base, 4);
    }

    /**
     * Retorna el estado como texto
     */
    public function getEstadoTextoAttribute()
    {
        return $this->estado == 1 ? 'Activo' : 'Inactivo';
    }

    /**
     * Retorna el sexo completo
     */
    public function getSexoCompletoAttribute()
    {
        return match($this->sexo) {
            'M' => 'Masculino',
            'F' => 'Femenino',
            'O' => 'Otro',
            default => 'No especificado'
        };
    }

    // Scopes

    /**
     * Scope para obtener solo empleados activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 1);
    }

    /**
     * Scope para obtener solo empleados inactivos
     */
    public function scopeInactivos($query)
    {
        return $query->where('estado', 0);
    }

    /**
     * Scope para filtrar por departamento
     */
    public function scopePorDepartamento($query, $departamento)
    {
        return $query->where('departamento', $departamento);
    }

    /**
     * Scope para filtrar por rango de evaluación
     */
    public function scopeConEvaluacionMinima($query, $minima)
    {
        return $query->where('evaluacion_desempeno', '>=', $minima);
    }
}
