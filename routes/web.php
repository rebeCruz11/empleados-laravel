<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;

Route::get('/', function () {
    return redirect()->route('empleados.dashboard');
});

// Ruta del dashboard con estadísticas
Route::get('/dashboard', [EmpleadoController::class, 'dashboard'])->name('empleados.dashboard');

// Ruta del reporte de empleados
Route::get('/reporte', [EmpleadoController::class, 'reporte'])->name('empleados.reporte');

// Rutas del recurso Empleados
Route::resource('empleados', EmpleadoController::class);

Route::get('/empleados/{id}/pdf', [EmpleadoController::class, 'generarPdf'])
    ->name('empleados.pdf');

