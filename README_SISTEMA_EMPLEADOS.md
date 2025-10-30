# Sistema de Gestión de Empleados

Sistema completo de gestión de empleados desarrollado con Laravel, que incluye análisis estadísticos, validaciones robustas y visualizaciones interactivas.

## 🚀 Características Principales

### ✅ Gestión Completa de Empleados
- **CRUD Completo**: Crear, leer, actualizar y eliminar empleados
- **Validaciones Robustas**: Campos obligatorios y restricciones de negocio
- **Búsqueda y Filtros**: Por nombre, departamento y estado

### 📊 Análisis y Estadísticas

#### Estadísticas Financieras
- Promedio de salario base por departamento
- Total de bonificaciones mensuales
- Total de descuentos mensuales
- Cálculo de salario neto y salario bruto
- Rango salarial (mínimo y máximo)

#### Estadísticas Demográficas
- Edad promedio del personal
- Distribución por sexo (M/F/O)
- Total de empleados activos e inactivos
- Edad promedio por departamento

#### Estadísticas de Desempeño
- Evaluación promedio por departamento
- Clasificación de empleados por nivel de desempeño
- Porcentaje de personal con evaluación > 70
- Relación desempeño/salario

#### Estadísticas de Antigüedad
- Antigüedad promedio en años
- Personal con más de 10 años de servicio
- Distribución de antigüedad

### 📈 Visualizaciones
- Gráfico de salario promedio por departamento
- Gráfico de evaluación de desempeño
- Dashboard interactivo con Chart.js

## 🗄️ Estructura de la Base de Datos

### Tabla: empleados

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id_empleado | INT | Identificador único (PK) |
| nombre | VARCHAR(100) | Nombre completo del empleado |
| departamento | VARCHAR(50) | Área o departamento |
| puesto | VARCHAR(50) | Cargo o función |
| salario_base | DECIMAL(10,2) | Sueldo base mensual |
| bonificacion | DECIMAL(10,2) | Incentivo económico adicional |
| descuento | DECIMAL(10,2) | Descuentos aplicados |
| fecha_contratacion | DATE | Fecha de contratación |
| fecha_nacimiento | DATE | Fecha de nacimiento |
| sexo | CHAR(1) | Sexo del empleado (M/F/O) |
| evaluacion_desempeno | DECIMAL(5,2) | Evaluación 0-100 |
| estado | TINYINT | 0: Inactivo, 1: Activo |

### Índices
- `departamento`: Índice para búsquedas por departamento
- `puesto`: Índice para búsquedas por puesto
- `estado`: Índice para filtrar por estado
- `fecha_contratacion`: Índice para ordenamiento temporal

## 🔒 Validaciones Implementadas

### Campos Obligatorios
- Nombre (mínimo 3 caracteres)
- Departamento
- Puesto
- Salario base
- Fecha de contratación
- Fecha de nacimiento
- Sexo
- Estado

### Restricciones de Negocio

#### Validaciones de Edad
- ✅ Edad mínima: 18 años al momento actual
- ✅ Edad mínima al contratar: 18 años
- ✅ Edad máxima al contratar: 65 años
- ✅ Fechas no pueden ser anteriores a 1900

#### Validaciones de Fechas
- ✅ Fecha de contratación no puede ser futura
- ✅ Fecha de contratación no puede superar 80 años de antigüedad
- ✅ El empleado debe tener al menos 18 años al momento de contratación

#### Validaciones Financieras
- ✅ Salario base mínimo: 0
- ✅ Salario base máximo: 99,999,999.99
- ✅ Bonificación y descuento no negativos
- ✅ Evaluación de desempeño: 0-100

#### Validaciones de Estado
- ✅ Empleados inactivos no cuentan en estadísticas activas
- ✅ Estado debe ser 0 (inactivo) o 1 (activo)

#### Validaciones de Sexo
- ✅ Solo valores permitidos: M, F, O

## 📐 Cálculos Automáticos

El sistema calcula automáticamente:

```php
// Salario Bruto
salario_bruto = salario_base + bonificacion

// Salario Neto
salario_neto = (salario_base + bonificacion) - descuento

// Edad
edad = TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE())

// Antigüedad
antiguedad = TIMESTAMPDIFF(YEAR, fecha_contratacion, CURDATE())

// Relación Desempeño/Salario
relacion = evaluacion_desempeno / salario_base
```

## 🚀 Instalación y Configuración

### Requisitos Previos
- PHP >= 8.1
- Composer
- MySQL / MariaDB
- Node.js (opcional, para compilar assets)

### Pasos de Instalación

1. **Configurar Base de Datos**
   ```bash
   # Crear base de datos
   mysql -u root -p
   CREATE DATABASE empleados_db;
   ```

2. **Configurar .env**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=empleados_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. **Ejecutar Migraciones y Seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```

4. **Iniciar Servidor**
   ```bash
   php artisan serve
   ```

5. **Acceder al Sistema**
   ```
   http://localhost:8000
   ```

## 📂 Estructura del Proyecto

```
app/
├── Http/
│   └── Controllers/
│       └── EmpleadoController.php    # Controlador principal
├── Models/
│   └── Empleado.php                  # Modelo con accesorios
└── Services/
    └── EstadisticasEmpleadosService.php  # Lógica de negocio

database/
├── factories/
│   └── EmpleadoFactory.php           # Factory para datos de prueba
├── migrations/
│   └── 2025_10_29_000000_create_empleados_table.php
└── seeders/
    └── EmpleadoSeeder.php            # Seeder con 105 empleados

resources/
└── views/
    ├── layouts/
    │   └── app.blade.php             # Layout principal
    └── empleados/
        ├── dashboard.blade.php       # Dashboard con estadísticas
        ├── index.blade.php           # Lista de empleados
        ├── create.blade.php          # Formulario de creación
        ├── edit.blade.php            # Formulario de edición
        └── show.blade.php            # Detalles del empleado

routes/
└── web.php                           # Rutas del sistema
```

## 🎯 Rutas Disponibles

| Método | Ruta | Acción | Descripción |
|--------|------|--------|-------------|
| GET | `/` | - | Redirige al dashboard |
| GET | `/dashboard` | dashboard | Dashboard con estadísticas |
| GET | `/empleados` | index | Lista de empleados |
| GET | `/empleados/create` | create | Formulario de creación |
| POST | `/empleados` | store | Guardar nuevo empleado |
| GET | `/empleados/{id}` | show | Ver detalles |
| GET | `/empleados/{id}/edit` | edit | Formulario de edición |
| PUT | `/empleados/{id}` | update | Actualizar empleado |
| DELETE | `/empleados/{id}` | destroy | Eliminar empleado |

## 🎨 Interfaz de Usuario

### Dashboard
- 📊 Estadísticas financieras en tiempo real
- 👥 Análisis demográfico del personal
- ⭐ Métricas de desempeño
- 📈 Gráficos interactivos con Chart.js
- 📋 Tabla resumen por departamento

### Lista de Empleados
- 🔍 Búsqueda por nombre
- 🏢 Filtro por departamento
- ✅ Filtro por estado (activo/inactivo)
- 📄 Paginación automática
- 🎯 Acciones rápidas (ver, editar, eliminar)

### Formularios
- ✅ Validación en tiempo real con JavaScript
- 🔴 Campos obligatorios marcados
- 💡 Ayudas contextuales
- ⚠️ Mensajes de error descriptivos
- 🎨 Diseño responsive con Bootstrap 5

## 🔧 Funcionalidades Técnicas

### Modelo Empleado
```php
// Accesorios (Getters)
$empleado->salario_bruto      // Calcula automáticamente
$empleado->salario_neto        // Calcula automáticamente
$empleado->edad                // Calcula automáticamente
$empleado->antiguedad          // Calcula automáticamente
$empleado->relacion_desempeno_salario  // Calcula automáticamente

// Scopes
Empleado::activos()            // Solo empleados activos
Empleado::inactivos()          // Solo empleados inactivos
Empleado::porDepartamento($dept)  // Filtrar por departamento
```

### Servicio de Estadísticas
```php
$service = new EstadisticasEmpleadosService();

// Obtener todas las estadísticas
$estadisticas = $service->obtenerEstadisticasCompletas();

// Estadísticas específicas
$financieras = $service->obtenerEstadisticasFinancieras();
$demograficas = $service->obtenerEstadisticasDemograficas();
$desempeno = $service->obtenerEstadisticasDesempeno();
$antiguedad = $service->obtenerEstadisticasAntiguedad();
```

## 📊 Datos de Prueba

El seeder genera:
- **100 empleados aleatorios** con datos realistas
- **5 empleados específicos** para demostración
- Distribución realista por departamentos:
  - Ventas
  - Producción
  - RRHH
  - Finanzas
  - TI
  - Marketing
  - Logística
  - Calidad

## 🎓 Departamentos y Puestos

### Ventas
- Gerente de Ventas
- Vendedor
- Supervisor de Ventas
- Ejecutivo de Cuentas

### Producción
- Gerente de Producción
- Operario
- Supervisor
- Técnico

### RRHH
- Gerente de RRHH
- Reclutador
- Analista de RRHH
- Especialista en Compensaciones

### TI
- CTO
- Desarrollador
- Analista de Sistemas
- Soporte Técnico

### Marketing
- Gerente de Marketing
- Community Manager
- Diseñador
- Especialista SEO

## 🔐 Seguridad

- ✅ Protección CSRF en todos los formularios
- ✅ Validación en servidor y cliente
- ✅ Sanitización de entradas
- ✅ Mensajes de error seguros
- ✅ Confirmación para acciones destructivas

## 📱 Responsive Design

El sistema es totalmente responsive y funciona en:
- 💻 Desktop
- 📱 Tablet
- 📱 Mobile

## 🎨 Tecnologías Utilizadas

- **Backend**: Laravel 11
- **Frontend**: Bootstrap 5, Blade Templates
- **Gráficos**: Chart.js
- **Iconos**: Bootstrap Icons
- **Base de Datos**: MySQL/MariaDB
- **Estilos**: CSS3 personalizado

## 📈 Métricas del Sistema

### Rendimiento
- Índices en campos clave
- Consultas optimizadas
- Paginación automática
- Carga diferida de relaciones

### Escalabilidad
- Separación de responsabilidades
- Servicio de estadísticas independiente
- Factory para generación masiva de datos
- Scopes reutilizables en el modelo

## 🐛 Solución de Problemas

### Error: Tabla no existe
```bash
php artisan migrate:fresh --seed
```

### Error: Clase no encontrada
```bash
composer dump-autoload
```

### Error: Permisos
```bash
# En Windows PowerShell
icacls storage /grant Users:F /T
icacls bootstrap/cache /grant Users:F /T
```

## 📝 Licencia

Sistema de Gestión de Empleados © 2025 | Base de datos con análisis integral.

## 👨‍💻 Autor

Desarrollado con ❤️ usando Laravel

---

**¡Sistema listo para usar!** 🚀

Para cualquier consulta o mejora, no dudes en contactar.
