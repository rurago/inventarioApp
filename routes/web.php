<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome'); // O tu vista personalizada
});

// Grupo de rutas protegidas por autenticación
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('productos', ProductoController::class)->middleware('auth');
    Route::resource('movimientos', MovimientoController::class)->middleware('auth');
    Route::get('/historico', [MovimientoController::class, 'historico'])->middleware('auth');

});

Route::middleware(['auth', 'rol:admin'])->group(function () {
    Route::resource('productos', ProductoController::class);
    // otras rutas exclusivas
});

Route::middleware(['auth', 'rol:almacenista'])->group(function () {
    Route::resource('movimientos', MovimientoController::class);
});


require __DIR__.'/auth.php';