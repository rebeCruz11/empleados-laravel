# 🚀 Guía de Inicio Rápido - Sistema de Gestión de Empleados

## ✅ Estado Actual del Sistema

**¡El sistema está completamente instalado y funcionando!**

🌐 **URL del sistema**: http://127.0.0.1:8000

## 📋 Lo que ya está configurado:

✅ Base de datos creada y migrada
✅ 105 empleados de prueba generados
✅ Servidor de desarrollo corriendo
✅ Todas las rutas funcionando
✅ Validaciones implementadas
✅ Estadísticas calculadas

## 🎯 Accede al Sistema

### 1. Dashboard Principal
```
http://127.0.0.1:8000/dashboard
```
Aquí verás:
- 📊 Estadísticas financieras
- 👥 Análisis demográfico
- ⭐ Métricas de desempeño
- 📈 Gráficos interactivos
- 📋 Tabla por departamento

### 2. Lista de Empleados
```
http://127.0.0.1:8000/empleados
```
Funciones disponibles:
- 🔍 Buscar por nombre
- 🏢 Filtrar por departamento
- ✅ Filtrar por estado
- 👁️ Ver detalles
- ✏️ Editar
- 🗑️ Eliminar

### 3. Crear Nuevo Empleado
```
http://127.0.0.1:8000/empleados/create
```

## 🧪 Prueba Estas Funcionalidades

### ✅ Validaciones que puedes probar:

1. **Crear empleado menor de 18 años**
   - El sistema lo rechazará ❌

2. **Fecha de contratación futura**
   - El sistema lo rechazará ❌

3. **Antigüedad mayor a 80 años**
   - El sistema lo rechazará ❌

4. **Evaluación fuera de rango (0-100)**
   - El sistema lo rechazará ❌

5. **Campos vacíos**
   - El sistema mostrará errores específicos ❌

6. **Edad al contratar menor a 18 años**
   - El sistema lo rechazará ❌

### ✅ Filtros disponibles:

1. **Por Departamento**: Ventas, Producción, RRHH, Finanzas, TI, Marketing, Logística, Calidad
2. **Por Estado**: Activos / Inactivos
3. **Por Nombre**: Búsqueda flexible

## 📊 Datos de Ejemplo Incluidos

El sistema incluye empleados de ejemplo en todos los departamentos:

### 👔 Empleados Destacados:
- **María García Rodríguez** - Gerente RRHH (Evaluación: 95.50)
- **Juan Carlos Martínez** - CTO (Evaluación: 98.75)
- **Ana Sofía Pérez** - Gerente Ventas (Evaluación: 92.30)
- **Roberto Sánchez** - Operario Producción (Evaluación: 78.50)
- **Laura Fernández** - Community Manager (Inactiva)

## 🎨 Características del Dashboard

### Tarjetas de Estadísticas:
1. **Financieras**
   - Promedio salario base
   - Total bonificaciones
   - Total descuentos
   - Total nómina mensual

2. **Demográficas**
   - Edad promedio: ~36 años
   - Total empleados activos
   - Distribución por sexo
   - Porcentajes M/F/O

3. **Desempeño**
   - Evaluación promedio
   - Empleados excelentes (>95)
   - Personal sobre 70 puntos
   - Empleados deficientes

4. **Antigüedad**
   - Antigüedad promedio
   - Personal con +10 años
   - Distribución temporal

### Gráficos Disponibles:
- 📊 Salario promedio por departamento (Barras)
- 📈 Evaluación promedio por departamento (Línea)
- 🎯 Comparativa dual interactiva

## 🔧 Comandos Útiles

### Si necesitas reiniciar la base de datos:
```bash
php artisan migrate:fresh --seed
```

### Si el servidor se detuvo:
```bash
php artisan serve
```

### Limpiar caché (si hay problemas):
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Generar más empleados:
```bash
php artisan tinker
>>> App\Models\Empleado::factory()->count(50)->create();
```

## 📱 Interfaz Responsive

El sistema funciona perfectamente en:
- 💻 Escritorio (1920x1080 y superiores)
- 📱 Tablet (768px - 1024px)
- 📱 Móvil (320px - 767px)

## 🎯 Casos de Uso Comunes

### 1. Agregar un nuevo empleado
1. Ir a "Nuevo Empleado" en el menú
2. Completar todos los campos requeridos
3. El sistema validará automáticamente
4. Click en "Guardar Empleado"

### 2. Ver estadísticas del departamento TI
1. Ir al Dashboard
2. Buscar "TI" en la tabla de departamentos
3. Ver salario promedio, evaluación y edad

### 3. Buscar empleados con baja evaluación
1. Ir a "Lista de Empleados"
2. Los empleados con evaluación < 70 tendrán badge rojo
3. Click en el badge para ordenar

### 4. Desactivar un empleado
1. Ir a la lista de empleados
2. Click en "Editar" (icono lápiz)
3. Cambiar estado a "Inactivo"
4. Guardar cambios
5. El empleado ya no contará en estadísticas activas

### 5. Ver historial completo de un empleado
1. Click en el icono de ojo 👁️
2. Ver todos los detalles calculados:
   - Edad actual
   - Antigüedad
   - Salario bruto
   - Salario neto
   - Relación desempeño/salario
   - Análisis de desempeño

## ⚡ Atajos de Teclado (en formularios)

- **Tab**: Navegar entre campos
- **Enter**: Enviar formulario
- **Esc**: Cancelar (volver atrás)

## 🎨 Códigos de Color

### Estados:
- 🟢 **Verde**: Activo, Excelente (>95), Éxito
- 🟡 **Amarillo**: Regular (70-79), Advertencia
- 🔴 **Rojo**: Deficiente (<70), Eliminado, Inactivo
- 🔵 **Azul**: Información, Bueno (80-94)

### Departamentos:
- Cada departamento tiene un badge distintivo
- Los colores ayudan a identificar rápidamente

## 📋 Checklist de Validaciones Implementadas

- ✅ Nombre: mínimo 3 caracteres
- ✅ Edad mínima: 18 años
- ✅ Edad máxima al contratar: 65 años
- ✅ Fecha contratación: no futura
- ✅ Antigüedad máxima: 80 años
- ✅ Salario: valores positivos
- ✅ Evaluación: 0-100
- ✅ Sexo: M, F u O
- ✅ Estado: 0 o 1
- ✅ Empleados inactivos: no cuentan en estadísticas

## 🎓 Tips de Uso

1. **Usa los filtros combinados**: Puedes buscar por nombre Y departamento simultáneamente
2. **Ordena por columnas**: Click en los encabezados de la tabla
3. **Paginación automática**: 15 empleados por página
4. **Confirmación de eliminación**: Siempre pide confirmación antes de eliminar
5. **Mensajes de éxito**: Verás notificaciones verdes al guardar correctamente
6. **Errores descriptivos**: Los mensajes de error te dicen exactamente qué corregir

## 🔍 ¿Dónde está cada cosa?

### Backend:
- **Controlador**: `app/Http/Controllers/EmpleadoController.php`
- **Modelo**: `app/Models/Empleado.php`
- **Servicio**: `app/Services/EstadisticasEmpleadosService.php`
- **Migraciones**: `database/migrations/`
- **Seeders**: `database/seeders/`

### Frontend:
- **Layout**: `resources/views/layouts/app.blade.php`
- **Dashboard**: `resources/views/empleados/dashboard.blade.php`
- **Lista**: `resources/views/empleados/index.blade.php`
- **Crear**: `resources/views/empleados/create.blade.php`
- **Editar**: `resources/views/empleados/edit.blade.php`
- **Ver**: `resources/views/empleados/show.blade.php`

### Rutas:
- **Web**: `routes/web.php`

## 🎉 ¡Ya puedes usar el sistema!

Abre tu navegador en: **http://127.0.0.1:8000**

---

## 📞 Soporte

Si encuentras algún problema:

1. Verifica que el servidor esté corriendo
2. Revisa que la base de datos esté configurada
3. Limpia cachés con los comandos listados arriba
4. Consulta el README principal para más detalles

**¡Disfruta del Sistema de Gestión de Empleados!** 🚀
