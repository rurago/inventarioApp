<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;

// Ruta pública
Route::get('/', function () {
    return view('welcome'); // o cualquier vista pública que quieras mostrar
})->name('welcome');


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/usuarios/roles', [UsuarioController::class, 'editarRoles'])->name('usuarios.roles');
    Route::post('/usuarios/roles/{user}', [UsuarioController::class, 'actualizarRol'])->name('usuarios.roles.actualizar');
});

// Ruta protegida por autenticación
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Inventario: Ver inventario
    Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');
    Route::get('/inventario/crear', [InventarioController::class, 'create'])->name('inventario.create');
    Route::post('/inventario', [InventarioController::class, 'store'])->name('inventario.store');

    // Entrada de productos
    Route::get('/inventario/entrada', [InventarioController::class, 'entradaForm'])->name('inventario.entrada');
    Route::post('/inventario/entrada', [InventarioController::class, 'entradaStore'])->name('inventario.entrada.store');
    

    Route::resource('productos', ProductoController::class);
    Route::post('/productos/{producto}/baja', [ProductoController::class, 'baja'])->name('productos.baja');
    Route::post('/productos/{producto}/activar', [ProductoController::class, 'activar'])->name('productos.activar');

    // Salida de productos
    Route::get('/inventario/salida', [InventarioController::class, 'salidaForm'])->name('inventario.salida');
    Route::post('/inventario/salida', [InventarioController::class, 'salidaStore'])->name('inventario.salida.store');

    // Dar de baja o reactivar productos
    Route::post('/inventario/{id}/baja', [InventarioController::class, 'baja'])->name('inventario.baja');
    Route::post('/inventario/{id}/toggle', [InventarioController::class, 'toggleStatus'])->name('inventario.toggle');

    // Historial de movimientos
    Route::get('/movimientos', [MovimientoController::class, 'index'])->name('movimientos.index');
    Route::get('/movimientos/resumen', [MovimientoController::class, 'resumen'])->name('movimientos.resumen');


});

require __DIR__.'/auth.php';
