# 📊 Consultas SQL Útiles - Sistema de Gestión de Empleados

Este documento contiene consultas SQL útiles para análisis avanzados del sistema de empleados.

## 📈 Consultas de Análisis Financiero

### 1. Salario Bruto por Empleado
```sql
SELECT 
    id_empleado,
    nombre,
    departamento,
    salario_base,
    bonificacion,
    (salario_base + bonificacion) AS salario_bruto
FROM empleados
WHERE estado = 1
ORDER BY salario_bruto DESC;
```

### 2. Salario Neto por Empleado
```sql
SELECT 
    id_empleado,
    nombre,
    departamento,
    salario_base,
    bonificacion,
    descuento,
    ((salario_base + bonificacion) - descuento) AS salario_neto
FROM empleados
WHERE estado = 1
ORDER BY salario_neto DESC;
```

### 3. Top 10 Empleados Mejor Pagados
```sql
SELECT 
    nombre,
    departamento,
    puesto,
    ((salario_base + bonificacion) - descuento) AS salario_neto
FROM empleados
WHERE estado = 1
ORDER BY salario_neto DESC
LIMIT 10;
```

### 4. Promedio de Salario por Departamento
```sql
SELECT 
    departamento,
    COUNT(*) as total_empleados,
    ROUND(AVG(salario_base), 2) as promedio_salario_base,
    ROUND(AVG(bonificacion), 2) as promedio_bonificacion,
    ROUND(AVG((salario_base + bonificacion) - descuento), 2) as promedio_salario_neto
FROM empleados
WHERE estado = 1
GROUP BY departamento
ORDER BY promedio_salario_neto DESC;
```

### 5. Total de Nómina Mensual por Departamento
```sql
SELECT 
    departamento,
    COUNT(*) as empleados,
    ROUND(SUM(salario_base), 2) as total_salarios_base,
    ROUND(SUM(bonificacion), 2) as total_bonificaciones,
    ROUND(SUM(descuento), 2) as total_descuentos,
    ROUND(SUM((salario_base + bonificacion) - descuento), 2) as total_nomina
FROM empleados
WHERE estado = 1
GROUP BY departamento
ORDER BY total_nomina DESC;
```

### 6. Empleados con Mayores Descuentos
```sql
SELECT 
    nombre,
    departamento,
    salario_base,
    descuento,
    ROUND((descuento / salario_base * 100), 2) as porcentaje_descuento
FROM empleados
WHERE estado = 1 AND descuento > 0
ORDER BY descuento DESC
LIMIT 10;
```

## 👥 Consultas de Análisis Demográfico

### 7. Distribución de Empleados por Edad
```sql
SELECT 
    CASE 
        WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) < 25 THEN '< 25 años'
        WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) BETWEEN 25 AND 35 THEN '25-35 años'
        WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) BETWEEN 36 AND 45 THEN '36-45 años'
        WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) BETWEEN 46 AND 55 THEN '46-55 años'
        ELSE '> 55 años'
    END as rango_edad,
    COUNT(*) as total_empleados
FROM empleados
WHERE estado = 1
GROUP BY rango_edad
ORDER BY rango_edad;
```

### 8. Edad Promedio por Departamento y Sexo
```sql
SELECT 
    departamento,
    sexo,
    COUNT(*) as total,
    ROUND(AVG(TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE())), 1) as edad_promedio
FROM empleados
WHERE estado = 1
GROUP BY departamento, sexo
ORDER BY departamento, sexo;
```

### 9. Distribución por Sexo
```sql
SELECT 
    sexo,
    COUNT(*) as total,
    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM empleados WHERE estado = 1)), 1) as porcentaje
FROM empleados
WHERE estado = 1
GROUP BY sexo;
```

### 10. Empleados por Departamento
```sql
SELECT 
    departamento,
    COUNT(*) as total_empleados,
    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM empleados WHERE estado = 1)), 1) as porcentaje
FROM empleados
WHERE estado = 1
GROUP BY departamento
ORDER BY total_empleados DESC;
```

## ⭐ Consultas de Análisis de Desempeño

### 11. Clasificación de Empleados por Desempeño
```sql
SELECT 
    CASE 
        WHEN evaluacion_desempeno >= 95 THEN 'Excelente (95-100)'
        WHEN evaluacion_desempeno >= 80 THEN 'Bueno (80-94)'
        WHEN evaluacion_desempeno >= 70 THEN 'Regular (70-79)'
        ELSE 'Deficiente (< 70)'
    END as clasificacion,
    COUNT(*) as total_empleados,
    ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM empleados WHERE estado = 1)), 1) as porcentaje
FROM empleados
WHERE estado = 1
GROUP BY clasificacion
ORDER BY MIN(evaluacion_desempeno) DESC;
```

### 12. Top 10 Empleados con Mejor Desempeño
```sql
SELECT 
    nombre,
    departamento,
    puesto,
    evaluacion_desempeno,
    TIMESTAMPDIFF(YEAR, fecha_contratacion, CURDATE()) as antiguedad
FROM empleados
WHERE estado = 1
ORDER BY evaluacion_desempeno DESC, antiguedad DESC
LIMIT 10;
```

### 13. Relación Desempeño/Salario por Departamento
```sql
SELECT 
    departamento,
    ROUND(AVG(evaluacion_desempeno), 2) as evaluacion_promedio,
    ROUND(AVG(salario_base), 2) as salario_promedio,
    ROUND(AVG(evaluacion_desempeno / salario_base), 4) as relacion_desempeno_salario
FROM empleados
WHERE estado = 1
GROUP BY departamento
ORDER BY relacion_desempeno_salario DESC;
```

### 14. Empleados con Bajo Desempeño y Alto Salario
```sql
SELECT 
    nombre,
    departamento,
    evaluacion_desempeno,
    salario_base,
    ((salario_base + bonificacion) - descuento) as salario_neto
FROM empleados
WHERE estado = 1 
    AND evaluacion_desempeno < 70 
    AND salario_base > (SELECT AVG(salario_base) FROM empleados WHERE estado = 1)
ORDER BY salario_base DESC;
```

### 15. Correlación Antigüedad-Desempeño
```sql
SELECT 
    CASE 
        WHEN TIMESTAMPDIFF(YEAR, fecha_contratacion, CURDATE()) < 2 THEN '< 2 años'
        WHEN TIMESTAMPDIFF(YEAR, fecha_contratacion, CURDATE()) BETWEEN 2 AND 5 THEN '2-5 años'
        WHEN TIMESTAMPDIFF(YEAR, fecha_contratacion, CURDATE()) BETWEEN 6 AND 10 THEN '6-10 años'
        ELSE '> 10 años'
    END as rango_antiguedad,
    COUNT(*) as total_empleados,
    ROUND(AVG(evaluacion_desempeno), 2) as evaluacion_promedio
FROM empleados
WHERE estado = 1
GROUP BY rango_antiguedad
ORDER BY rango_antiguedad;
```

## 📅 Consultas de Análisis de Antigüedad

### 16. Distribución por Antigüedad
```sql
SELECT 
    CASE 
        WHEN TIMESTAMPDIFF(YEAR, fecha_contratacion, CURDATE()) < 1 THEN 'Menos de 1 año'
        WHEN TIMESTAMPDIFF(YEAR, fecha_contratacion, CURDATE()) BETWEEN 1 AND 3 THEN '1-3 años'
        WHEN TIMESTAMPDIFF(YEAR, fecha_contratacion, CURDATE()) BETWEEN 4 AND 7 THEN '4-7 años'
        WHEN TIMESTAMPDIFF(YEAR, fecha_contratacion, CURDATE()) BETWEEN 8 AND 15 THEN '8-15 años'
        ELSE 'Más de 15 años'
    END as rango_antiguedad,
    COUNT(*) as total_empleados
FROM empleados
WHERE estado = 1
GROUP BY rango_antiguedad
ORDER BY MIN(TIMESTAMPDIFF(YEAR, fecha_contratacion, CURDATE()));
```

### 17. Empleados Veteranos (>10 años)
```sql
SELECT 
    nombre,
    departamento,
    puesto,
    fecha_contratacion,
    TIMESTAMPDIFF(YEAR, fecha_contratacion, CURDATE()) as antiguedad,
    evaluacion_desempeno
FROM empleados
WHERE estado = 1 
    AND TIMESTAMPDIFF(YEAR, fecha_contratacion, CURDATE()) >= 10
ORDER BY antiguedad DESC;
```

### 18. Promedio de Antigüedad por Departamento
```sql
SELECT 
    departamento,
    COUNT(*) as total_empleados,
    ROUND(AVG(TIMESTAMPDIFF(YEAR, fecha_contratacion, CURDATE())), 1) as antiguedad_promedio,
    MIN(TIMESTAMPDIFF(YEAR, fecha_contratacion, CURDATE())) as antiguedad_minima,
    MAX(TIMESTAMPDIFF(YEAR, fecha_contratacion, CURDATE())) as antiguedad_maxima
FROM empleados
WHERE estado = 1
GROUP BY departamento
ORDER BY antiguedad_promedio DESC;
```

### 19. Empleados Nuevos (último año)
```sql
SELECT 
    nombre,
    departamento,
    puesto,
    fecha_contratacion,
    TIMESTAMPDIFF(MONTH, fecha_contratacion, CURDATE()) as meses_antiguedad
FROM empleados
WHERE estado = 1 
    AND fecha_contratacion >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
ORDER BY fecha_contratacion DESC;
```

## 🎯 Consultas Combinadas y Avanzadas

### 20. Dashboard Completo de Departamento
```sql
SELECT 
    departamento,
    COUNT(*) as total_empleados,
    ROUND(AVG(TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE())), 1) as edad_promedio,
    ROUND(AVG(TIMESTAMPDIFF(YEAR, fecha_contratacion, CURDATE())), 1) as antiguedad_promedio,
    ROUND(AVG(salario_base), 2) as salario_base_promedio,
    ROUND(AVG(evaluacion_desempeno), 2) as evaluacion_promedio,
    ROUND(SUM((salario_base + bonificacion) - descuento), 2) as nomina_total,
    COUNT(CASE WHEN sexo = 'M' THEN 1 END) as hombres,
    COUNT(CASE WHEN sexo = 'F' THEN 1 END) as mujeres,
    COUNT(CASE WHEN sexo = 'O' THEN 1 END) as otros
FROM empleados
WHERE estado = 1
GROUP BY departamento;
```

### 21. Empleados de Alto Valor (Alto desempeño + Antigüedad)
```sql
SELECT 
    nombre,
    departamento,
    puesto,
    evaluacion_desempeno,
    TIMESTAMPDIFF(YEAR, fecha_contratacion, CURDATE()) as antiguedad,
    ((salario_base + bonificacion) - descuento) as salario_neto
FROM empleados
WHERE estado = 1 
    AND evaluacion_desempeno >= 80
    AND TIMESTAMPDIFF(YEAR, fecha_contratacion, CURDATE()) >= 5
ORDER BY evaluacion_desempeno DESC, antiguedad DESC;
```

### 22. Análisis de Rotación Potencial (Bajo desempeño reciente)
```sql
SELECT 
    nombre,
    departamento,
    puesto,
    evaluacion_desempeno,
    TIMESTAMPDIFF(YEAR, fecha_contratacion, CURDATE()) as antiguedad,
    salario_base
FROM empleados
WHERE estado = 1 
    AND evaluacion_desempeno < 70
    AND TIMESTAMPDIFF(YEAR, fecha_contratacion, CURDATE()) < 3
ORDER BY evaluacion_desempeno ASC;
```

### 23. Análisis de Compensación vs Mercado
```sql
SELECT 
    departamento,
    puesto,
    COUNT(*) as num_empleados,
    ROUND(AVG(salario_base), 2) as salario_promedio,
    ROUND(MIN(salario_base), 2) as salario_minimo,
    ROUND(MAX(salario_base), 2) as salario_maximo,
    ROUND(STDDEV(salario_base), 2) as desviacion_estandar
FROM empleados
WHERE estado = 1
GROUP BY departamento, puesto
HAVING num_empleados >= 2
ORDER BY departamento, salario_promedio DESC;
```

### 24. Resumen Ejecutivo General
```sql
SELECT 
    'Total Empleados Activos' as metrica,
    COUNT(*) as valor
FROM empleados WHERE estado = 1
UNION ALL
SELECT 
    'Promedio Edad',
    ROUND(AVG(TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE())), 1)
FROM empleados WHERE estado = 1
UNION ALL
SELECT 
    'Promedio Antigüedad',
    ROUND(AVG(TIMESTAMPDIFF(YEAR, fecha_contratacion, CURDATE())), 1)
FROM empleados WHERE estado = 1
UNION ALL
SELECT 
    'Promedio Salario Base',
    ROUND(AVG(salario_base), 2)
FROM empleados WHERE estado = 1
UNION ALL
SELECT 
    'Promedio Evaluación',
    ROUND(AVG(evaluacion_desempeno), 2)
FROM empleados WHERE estado = 1
UNION ALL
SELECT 
    'Nómina Total Mensual',
    ROUND(SUM((salario_base + bonificacion) - descuento), 2)
FROM empleados WHERE estado = 1;
```

### 25. Empleados Próximos a Jubilación (>60 años)
```sql
SELECT 
    nombre,
    departamento,
    puesto,
    fecha_nacimiento,
    TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) as edad_actual,
    TIMESTAMPDIFF(YEAR, fecha_contratacion, CURDATE()) as antiguedad,
    evaluacion_desempeno
FROM empleados
WHERE estado = 1 
    AND TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) >= 60
ORDER BY edad_actual DESC;
```

## 🔍 Consultas de Auditoría

### 26. Empleados Inactivos
```sql
SELECT 
    id_empleado,
    nombre,
    departamento,
    puesto,
    fecha_contratacion,
    updated_at as fecha_desactivacion
FROM empleados
WHERE estado = 0
ORDER BY updated_at DESC;
```

### 27. Cambios Recientes (últimos 30 días)
```sql
SELECT 
    id_empleado,
    nombre,
    departamento,
    updated_at,
    DATEDIFF(CURDATE(), updated_at) as dias_desde_cambio
FROM empleados
WHERE updated_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
ORDER BY updated_at DESC;
```

## 💡 Uso de las Consultas

### En Laravel Tinker:
```bash
php artisan tinker
>>> DB::select("SELECT ...");
```

### En el Controlador:
```php
use Illuminate\Support\Facades\DB;

$resultados = DB::select("SELECT ...");
```

### En MySQL/MariaDB Client:
```bash
mysql -u root -p empleados_db
mysql> SELECT ...;
```

---

**Nota**: Todas las consultas están optimizadas y utilizan los índices creados en la migración para mejor rendimiento.
