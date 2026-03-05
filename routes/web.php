<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\CharacterListController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\ApiTokenController;

Route::get('/', function () {
    return view('landing');
});

// ===================================================
// RUTAS ANTIGUAS DE REGISTRO (Renombradas para no conflictuar con Jetstream)
// Si quieres mantener tu registro antiguo, usa /old-register
// Si no, puedes eliminar estas rutas completamente
// ===================================================
Route::get('/old-register', [UserController::class, 'register'])->name('old.register');
Route::post('/old-register', [UserController::class, 'store'])->name('old.register.store');

Route::get('/old-register/success', [UserController::class, 'success'])
    ->middleware('check.session:user_data,/old-register')
    ->name('old.register.success');

Route::get('/old-register/error', [UserController::class, 'error'])
    ->middleware('check.session:error|errors,/old-register')
    ->name('old.register.error');

// ===================================================
// RUTAS DE PERSONAJES (Protegidas para usuarios autenticados)
// ===================================================
Route::middleware(['auth:sanctum', config('jetstream.auth_session')])->group(function () {
    Route::get('/character', [CharacterController::class, 'selector'])->name('character.selector');
    Route::get('/character/form', [CharacterController::class, 'form'])->name('character.form');
    Route::post('/character/create', [CharacterController::class, 'store'])->name('character.store');
    Route::get('/character/success', [CharacterController::class, 'success'])
        ->middleware('check.session:character_data,/character')
        ->name('character.success');

    Route::get('/characters', [CharacterListController::class, 'index'])->name('characters.index');

    // API Tokens
    Route::resource('api-tokens', ApiTokenController::class)->only(['index', 'create', 'store', 'destroy']);
});

// ===================================================
// RUTAS DE JETSTREAM (Dashboard protegido)
// ===================================================
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard-admin');
    })->name('dashboard');

    // Rutas de administración (solo para admins)
    Route::middleware('can:is-admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserManagementController::class);
    });
});
