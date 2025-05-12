<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;


// Reemplaza la ruta welcome por una redirección al login
Route::redirect('/', '/login');

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

// Muestra el prompt de verificación
Route::get('/email/verify', EmailVerificationPromptController::class)
     ->middleware('auth'):
// Envía el email de verificación
Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
     ->middleware(['auth', 'throttle:6,1'])
     ->name('verification.send');

require __DIR__.'/auth.php';