# Guía de Instalación y Configuración de Laravel Jetstream en Critical Dice

## 📋 Tabla de Contenidos

1. [Instalación Inicial](#instalación-inicial)
2. [Archivos y Estructuras Creadas](#archivos-y-estructuras-creadas)
3. [Configuración de Jetstream](#configuración-de-jetstream)
4. [Configuración de Fortify](#configuración-de-fortify)
5. [Modelos y Traits](#modelos-y-traits)
6. [Vistas y Componentes](#vistas-y-componentes)
7. [Autenticación y Seguridad](#autenticación-y-seguridad)
8. [Conflictos con AdminLTE y Soluciones](#conflictos-con-adminlte-y-soluciones)
9. [Ejemplos de Código](#ejemplos-de-código)

---

## 🚀 Instalación Inicial

### Paso 1: Instalar Jetstream via Composer

```bash
composer require laravel/jetstream
```

**Versión instalada en el proyecto:** `^5.3`

Ver en `composer.json`:

```json
{
    "require": {
        "laravel/jetstream": "^5.3",
        "laravel/sanctum": "^4.0",
        "livewire/livewire": "^3.6.4"
    }
}
```

### Paso 2: Instalar el stack de Livewire

```bash
php artisan jetstream:install livewire
```

**Opciones disponibles:**

-   `livewire` - Stack con Livewire (Alpine.js + Blade)
-   `inertia` - Stack con Inertia.js (Vue.js o React)

**En nuestro proyecto elegimos:** `livewire`

### Paso 3: Instalar dependencias NPM y compilar assets

```bash
npm install
npm run build
```

### Paso 4: Ejecutar migraciones

```bash
php artisan migrate
```

---

## 📂 Archivos y Estructuras Creadas

### 1. Archivos de Configuración

```
config/
├── fortify.php                  # ✅ Configuración de autenticación
└── jetstream.php                # ✅ Configuración de Jetstream
```

### 2. Providers (Service Providers)

```
app/Providers/
├── FortifyServiceProvider.php   # ✅ Configuración de Fortify (login, register, etc.)
└── JetstreamServiceProvider.php # ✅ Configuración de Jetstream
```

### 3. Actions (Lógica de negocio)

```
app/Actions/
├── Fortify/
│   ├── CreateNewUser.php              # ✅ Crear nuevo usuario
│   ├── ResetUserPassword.php          # ✅ Restablecer contraseña
│   ├── UpdateUserPassword.php         # ✅ Actualizar contraseña
│   └── UpdateUserProfileInformation.php # ✅ Actualizar perfil
└── Jetstream/
    └── DeleteUser.php                 # ✅ Eliminar usuario
```

### 4. Migraciones de Base de Datos

```
database/migrations/
├── 2025_11_13_162306_add_two_factor_columns_to_users_table.php  # ✅ 2FA
└── 2025_11_13_162340_create_personal_access_tokens_table.php    # ✅ API Tokens
```

### 5. Vistas de Autenticación

```
resources/views/
├── auth/
│   ├── login.blade.php                    # ✅ Vista de login
│   ├── register.blade.php                 # ✅ Vista de registro
│   ├── forgot-password.blade.php          # ✅ Olvidé mi contraseña
│   ├── reset-password.blade.php           # ✅ Restablecer contraseña
│   ├── verify-email.blade.php             # ✅ Verificar email
│   ├── confirm-password.blade.php         # ✅ Confirmar contraseña
│   └── two-factor-challenge.blade.php     # ✅ Desafío 2FA
├── profile/
│   ├── show.blade.php                          # ✅ Página de perfil
│   ├── update-profile-information-form.blade.php  # Actualizar info
│   ├── update-password-form.blade.php          # Cambiar contraseña
│   ├── two-factor-authentication-form.blade.php # Configurar 2FA
│   ├── logout-other-browser-sessions-form.blade.php # Cerrar otras sesiones
│   └── delete-user-form.blade.php              # Eliminar cuenta
└── layouts/
    ├── app.blade.php                      # ✅ Layout principal (autenticado)
    └── guest.blade.php                    # ✅ Layout para invitados
```

### 6. Componentes Blade (X-Components)

```
resources/views/components/
├── authentication-card.blade.php           # Card de autenticación
├── authentication-card-logo.blade.php      # Logo en auth
├── application-logo.blade.php              # Logo de la app
├── application-mark.blade.php              # Marca de la app
├── button.blade.php                        # Botón primario
├── danger-button.blade.php                 # Botón de peligro
├── secondary-button.blade.php              # Botón secundario
├── checkbox.blade.php                      # Checkbox
├── input.blade.php                         # Input de texto
├── input-error.blade.php                   # Error de validación
├── label.blade.php                         # Label de formulario
├── validation-errors.blade.php             # Lista de errores
├── modal.blade.php                         # Modal base
├── dialog-modal.blade.php                  # Modal de diálogo
├── confirmation-modal.blade.php            # Modal de confirmación
├── dropdown.blade.php                      # Dropdown
├── dropdown-link.blade.php                 # Link del dropdown
├── nav-link.blade.php                      # Link de navegación
├── responsive-nav-link.blade.php           # Link responsive
├── banner.blade.php                        # Banner de notificaciones
├── form-section.blade.php                  # Sección de formulario
├── action-section.blade.php                # Sección de acción
├── section-border.blade.php                # Borde de sección
├── section-title.blade.php                 # Título de sección
├── action-message.blade.php                # Mensaje de acción
└── confirms-password.blade.php             # Confirmar contraseña
```

### 7. Livewire Components

```
app/Livewire/
└── NavigationMenu.php                     # ✅ Menú de navegación (generado)

resources/views/
└── navigation-menu.blade.php              # ✅ Vista del menú
```

---

## ⚙️ Configuración de Jetstream

Archivo: `config/jetstream.php`

### 1. Stack Seleccionado

```php
// config/jetstream.php

'stack' => 'livewire',  // ✅ Usamos Livewire (no Inertia)
```

### 2. Middleware

```php
// config/jetstream.php

'middleware' => ['web'],  // Middleware de las rutas de Jetstream

'auth_session' => AuthenticateSession::class,  // Middleware de sesión autenticada
```

### 3. Guard de Autenticación

```php
// config/jetstream.php

'guard' => 'sanctum',  // ✅ Usamos Sanctum para autenticación
```

### 4. Features (Características Habilitadas)

```php
// config/jetstream.php

'features' => [
    // Features::termsAndPrivacyPolicy(),    // ❌ Deshabilitado
    // Features::profilePhotos(),            // ❌ Deshabilitado
    // Features::api(),                      // ❌ Deshabilitado (API tokens)
    // Features::teams(['invitations' => true]),  // ❌ Deshabilitado (equipos)
    Features::accountDeletion(),             // ✅ HABILITADO - Eliminar cuenta
],
```

**Características que deshabilitamos:**

-   **Terms and Privacy Policy** - No requerimos aceptar términos
-   **Profile Photos** - No usamos fotos de perfil personalizadas
-   **API** - No necesitamos tokens de API por ahora
-   **Teams** - No necesitamos funcionalidad de equipos

**Características que mantuvimos:**

-   **Account Deletion** - Permitir a usuarios eliminar su cuenta

### 5. Disco de Fotos de Perfil

```php
// config/jetstream.php

'profile_photo_disk' => 'public',  // Disco para almacenar fotos
```

---

## ⚙️ Configuración de Fortify

Archivo: `config/fortify.php`

Laravel Fortify es el backend de autenticación que usa Jetstream.

### 1. Guard y Password Broker

```php
// config/fortify.php

'guard' => 'web',  // ✅ Guard de autenticación

'passwords' => 'users',  // ✅ Broker de contraseñas
```

### 2. Username y Email

```php
// config/fortify.php

'username' => 'email',  // ✅ Campo de usuario (email)

'email' => 'email',  // ✅ Campo de email

'lowercase_usernames' => true,  // ✅ Convertir emails a minúsculas
```

### 3. Home Path (Redirección después de login)

```php
// config/fortify.php

'home' => '/dashboard',  // ✅ Redirigir al dashboard después de login
```

### 4. Prefijo y Dominio de Rutas

```php
// config/fortify.php

'prefix' => '',  // Sin prefijo (las rutas están en la raíz)

'domain' => null,  // Sin subdominio específico
```

### 5. Middleware

```php
// config/fortify.php

'middleware' => ['web'],  // Middleware de las rutas de Fortify
```

### 6. Rate Limiting (Límites de Intentos)

```php
// config/fortify.php

'limiters' => [
    'login' => 'login',        // ✅ Límite de intentos de login
    'two-factor' => 'two-factor',  // ✅ Límite de intentos 2FA
],
```

**Configurado en `FortifyServiceProvider`:**

```php
// app/Providers/FortifyServiceProvider.php

RateLimiter::for('login', function (Request $request) {
    $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

    return Limit::perMinute(5)->by($throttleKey);  // ✅ 5 intentos por minuto
});

RateLimiter::for('two-factor', function (Request $request) {
    return Limit::perMinute(5)->by($request->session()->get('login.id'));
});
```

### 7. Vistas Habilitadas

```php
// config/fortify.php

'views' => true,  // ✅ Habilitar rutas que retornan vistas
```

### 8. Features (Características)

```php
// config/fortify.php

'features' => [
    Features::registration(),           // ✅ Registro de usuarios
    Features::resetPasswords(),         // ✅ Restablecer contraseña
    // Features::emailVerification(),   // ❌ Verificación de email (deshabilitado)
    Features::updateProfileInformation(), // ✅ Actualizar información de perfil
    Features::updatePasswords(),        // ✅ Actualizar contraseña
    Features::twoFactorAuthentication([  // ✅ Autenticación de dos factores
        'confirm' => true,              // Requiere confirmación
        'confirmPassword' => true,      // Requiere confirmar contraseña
        // 'window' => 0,
    ]),
],
```

---

## 👤 Modelos y Traits

### Modelo User

Archivo: `app/Models/User.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;  // ✅ Trait de 2FA
use Laravel\Jetstream\HasProfilePhoto;         // ✅ Trait de foto de perfil
use Laravel\Sanctum\HasApiTokens;              // ✅ Trait de API tokens

class User extends Authenticatable
{
    use HasApiTokens;                    // ✅ Para tokens de API (Sanctum)
    use HasFactory;                      // ✅ Para factories
    use HasProfilePhoto;                 // ✅ Para fotos de perfil
    use Notifiable;                      // ✅ Para notificaciones
    use TwoFactorAuthenticatable;        // ✅ Para autenticación 2FA

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',  // ✅ Campo personalizado para administradores
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',  // ✅ Códigos de recuperación 2FA
        'two_factor_secret',          // ✅ Secreto 2FA
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [
        'profile_photo_url',  // ✅ URL de la foto de perfil
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación con personajes
     */
    public function characters()
    {
        return $this->hasMany(Character::class);
    }
}
```

### Traits Importantes

#### 1. HasProfilePhoto

-   Proporciona el método `profile_photo_url`
-   Genera avatar predeterminado con iniciales
-   Soporta fotos de perfil personalizadas

#### 2. TwoFactorAuthenticatable

-   Añade soporte para 2FA
-   Gestiona secretos y códigos de recuperación
-   Integrado con Fortify

#### 3. HasApiTokens

-   Permite crear tokens de API con Sanctum
-   Control de permisos por token
-   Útil para APIs REST

---

## 🎨 Vistas y Componentes

### Layouts Principales

#### 1. Layout de Aplicación (Autenticado)

Archivo: `resources/views/layouts/app.blade.php`

```php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Critical Dice</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body class="font-sans antialiased bg-primary-900 text-gray-100">
    <x-banner />

    <div class="min-h-screen bg-primary-900">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-primary-800 shadow border-b-2 border-accent-orange">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts
</body>
</html>
```

**Características:**

-   Incluye `@livewireStyles` y `@livewireScripts`
-   Banner de notificaciones con `<x-banner />`
-   Navegación con Livewire: `@livewire('navigation-menu')`
-   Stack de modales: `@stack('modals')`
-   Personalizado con colores de Critical Dice

#### 2. Layout de Invitado (Sin autenticar)

Archivo: `resources/views/layouts/guest.blade.php`

```php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Autenticación</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body class="bg-primary-900 text-gray-100 min-h-screen flex flex-col">
    <!-- Header simple para páginas de autenticación -->
    <header class="bg-primary-800 border-b-2 border-accent-orange">
        <div class="max-w-6xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                    <!-- Logo SVG -->
                    <svg class="w-7 h-7 fill-accent-orange" viewBox="0 0 512 512">
                        <!-- ... path del dado ... -->
                    </svg>
                    <span class="text-2xl font-bold text-accent-orange">
                        Critical Dice
                    </span>
                </a>
                <a href="{{ url('/') }}" class="text-gray-300 hover:text-accent-orange">
                    ← Volver al inicio
                </a>
            </div>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="flex-1 flex items-center justify-center p-4">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
```

**Características:**

-   Header personalizado con logo de Critical Dice
-   Centrado verticalmente para formularios de auth
-   Botón para volver al inicio
-   Tema oscuro con acentos naranja

---

## 🔐 Autenticación y Seguridad

### Providers de Servicios

#### FortifyServiceProvider

Archivo: `app/Providers/FortifyServiceProvider.php`

```php
<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // ✅ Registrar las Actions personalizadas
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // ✅ Rate limiting para login (5 intentos por minuto)
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(
                Str::lower($request->input(Fortify::username())) . '|' . $request->ip()
            );

            return Limit::perMinute(5)->by($throttleKey);
        });

        // ✅ Rate limiting para 2FA
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // ✅ IMPORTANTE: Especificar las vistas personalizadas de Fortify
        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });
    }
}
```

**Funciones clave:**

-   Define qué Actions usar para cada operación
-   Configura rate limiting para seguridad
-   **CRÍTICO**: Define las vistas de login y register

### Migraciones de Base de Datos

#### 1. Columnas de Two-Factor Authentication

Archivo: `database/migrations/2025_11_13_162306_add_two_factor_columns_to_users_table.php`

```php
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->text('two_factor_secret')
            ->after('password')
            ->nullable();

        $table->text('two_factor_recovery_codes')
            ->after('two_factor_secret')
            ->nullable();

        $table->timestamp('two_factor_confirmed_at')
            ->after('two_factor_recovery_codes')
            ->nullable();
    });
}
```

**Columnas añadidas:**

-   `two_factor_secret` - Secreto encriptado para 2FA
-   `two_factor_recovery_codes` - Códigos de recuperación
-   `two_factor_confirmed_at` - Timestamp de confirmación

#### 2. Tabla de Personal Access Tokens

Archivo: `database/migrations/2025_11_13_162340_create_personal_access_tokens_table.php`

```php
public function up(): void
{
    Schema::create('personal_access_tokens', function (Blueprint $table) {
        $table->id();
        $table->morphs('tokenable');  // ✅ Relación polimórfica
        $table->text('name');         // ✅ Nombre del token
        $table->string('token', 64)->unique();  // ✅ Token único
        $table->text('abilities')->nullable();  // ✅ Permisos del token
        $table->timestamp('last_used_at')->nullable();
        $table->timestamp('expires_at')->nullable()->index();
        $table->timestamps();
    });
}
```

---

## ⚠️ Conflictos con AdminLTE y Soluciones

Cuando instalamos AdminLTE **DESPUÉS** de Jetstream, se produjeron varios conflictos que tuvimos que resolver.

### 🔴 Problema 1: Rutas de Autenticación Pisadas

#### Síntoma:

Las rutas `/login` y `/register` dejaron de funcionar o mostraban vistas de AdminLTE en lugar de las de Jetstream.

#### Causa:

AdminLTE publica sus propias rutas de autenticación que sobrescriben las de Fortify/Jetstream.

#### ✅ Solución:

**Paso 1:** NO publicar las vistas de AdminLTE para autenticación

```bash
# ❌ NO EJECUTAR ESTO:
php artisan vendor:publish --tag=adminlte-views
```

**Paso 2:** Asegurarse de que `FortifyServiceProvider` especifique las vistas correctas

```php
// app/Providers/FortifyServiceProvider.php

public function boot(): void
{
    // ... otras configuraciones ...

    // ✅ CRÍTICO: Especificar las vistas de Jetstream
    Fortify::loginView(function () {
        return view('auth.login');  // Vista de Jetstream
    });

    Fortify::registerView(function () {
        return view('auth.register');  // Vista de Jetstream
    });
}
```

**Paso 3:** Verificar que las rutas de Fortify se carguen ANTES que las de AdminLTE

```php
// routes/web.php

// ✅ Las rutas de Fortify se cargan automáticamente
// NO necesitas definir manualmente /login, /register, etc.

// Rutas de AdminLTE solo para el dashboard
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard-admin');  // ✅ Vista con AdminLTE
    })->name('dashboard');
});
```

### 🔴 Problema 2: Rutas de Registro Duplicadas

#### Síntoma:

Teníamos rutas antiguas de registro (`/old-register`) que conflictuaban.

#### ✅ Solución:

Renombramos las rutas antiguas para mantener compatibilidad:

```php
// routes/web.php

// ===================================================
// RUTAS ANTIGUAS DE REGISTRO (Renombradas)
// ===================================================
Route::get('/old-register', [UserController::class, 'register'])->name('old.register');
Route::post('/old-register', [UserController::class, 'store'])->name('old.register.store');

Route::get('/old-register/success', [UserController::class, 'success'])
    ->middleware('check.session:user_data,/old-register')
    ->name('old.register.success');
```

### 🔴 Problema 3: Middleware de Autenticación

#### Síntoma:

Las rutas protegidas no funcionaban correctamente o redirigían mal.

#### ✅ Solución:

Usar el middleware completo de Jetstream:

```php
// routes/web.php

// ✅ CORRECTO: Middleware completo de Jetstream
Route::middleware([
    'auth:sanctum',                      // Sanctum para autenticación
    config('jetstream.auth_session'),    // Sesión autenticada de Jetstream
    'verified',                          // Email verificado (opcional)
])->group(function () {
    // Rutas protegidas aquí
});
```

### 🔴 Problema 4: Configuración de `home` en Fortify

#### Síntoma:

Después de login, redirigía a una página incorrecta.

#### ✅ Solución:

```php
// config/fortify.php

'home' => '/dashboard',  // ✅ Redirigir al dashboard después de login
```

### 🔴 Problema 5: Assets y Estilos Mezclados

#### Síntoma:

Estilos de Jetstream y AdminLTE se mezclaban en las vistas.

#### ✅ Solución:

**Separar claramente las vistas:**

```
resources/views/
├── auth/                    # ✅ Vistas de Jetstream (Tailwind CSS)
│   ├── login.blade.php
│   └── register.blade.php
├── dashboard-admin.blade.php  # ✅ Vista con AdminLTE
└── admin/
    └── users/              # ✅ Vistas con AdminLTE
        ├── index.blade.php
        ├── create.blade.php
        └── ...
```

**En las vistas de AdminLTE:**

```php
@extends('adminlte::page')  // ✅ Layout de AdminLTE

@section('css')
<link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
@stop
```

**En las vistas de Jetstream:**

```php
<x-guest-layout>  {{-- ✅ Layout de Jetstream --}}
    {{-- Contenido con Tailwind CSS --}}
</x-guest-layout>
```

### 🔴 Problema 6: Redirección después de Logout

#### Síntoma:

Después de logout, no redirigía correctamente.

#### ✅ Solución:

```php
// config/adminlte.php

'logout_url' => 'logout',  // ✅ URL de logout (manejada por Fortify)
'login_url' => 'login',    // ✅ URL de login (manejada por Fortify)
```

### 📝 Resumen de Conflictos y Soluciones

| Problema                  | Causa                         | Solución                                                                       |
| ------------------------- | ----------------------------- | ------------------------------------------------------------------------------ |
| Rutas de auth pisadas     | AdminLTE sobrescribe rutas    | NO publicar vistas de AdminLTE, especificar vistas en `FortifyServiceProvider` |
| Middleware incorrecto     | Falta middleware de Jetstream | Usar `auth:sanctum` + `config('jetstream.auth_session')`                       |
| Home path mal configurado | Redirige a URL incorrecta     | Configurar `'home' => '/dashboard'` en `fortify.php`                           |
| Estilos mezclados         | Layouts compartidos           | Separar vistas: Jetstream usa Tailwind, AdminLTE usa Bootstrap                 |
| Rutas duplicadas          | Sistema antiguo de registro   | Renombrar rutas antiguas con prefijo `/old-`                                   |

---

## 💻 Ejemplos de Código

### 1. Vista de Login

Archivo: `resources/views/auth/login.blade.php`

```php
<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        {{-- Errores de validación --}}
        <x-validation-errors class="mb-4" />

        {{-- Mensaje de estado (ej: "Contraseña restablecida") --}}
        @session('status')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ $value }}
        </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Campo: Email --}}
            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email"
                         class="block mt-1 w-full"
                         type="email"
                         name="email"
                         :value="old('email')"
                         required
                         autofocus
                         autocomplete="username" />
            </div>

            {{-- Campo: Password --}}
            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password"
                         class="block mt-1 w-full"
                         type="password"
                         name="password"
                         required
                         autocomplete="current-password" />
            </div>

            {{-- Checkbox: Remember me --}}
            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            {{-- Botones y enlaces --}}
            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900"
                   href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
```

### 2. Vista de Registro

Archivo: `resources/views/auth/register.blade.php`

```php
<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Campo: Name --}}
            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name"
                         class="block mt-1 w-full"
                         type="text"
                         name="name"
                         :value="old('name')"
                         required
                         autofocus
                         autocomplete="name" />
            </div>

            {{-- Campo: Email --}}
            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email"
                         class="block mt-1 w-full"
                         type="email"
                         name="email"
                         :value="old('email')"
                         required
                         autocomplete="username" />
            </div>

            {{-- Campo: Password --}}
            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password"
                         class="block mt-1 w-full"
                         type="password"
                         name="password"
                         required
                         autocomplete="new-password" />
            </div>

            {{-- Campo: Confirm Password --}}
            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation"
                         class="block mt-1 w-full"
                         type="password"
                         name="password_confirmation"
                         required
                         autocomplete="new-password" />
            </div>

            {{-- Términos y condiciones (si está habilitado) --}}
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline">'.__('Terms of Service').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            {{-- Botones --}}
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900"
                   href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
```

### 3. Action de Crear Usuario

Archivo: `app/Actions/Fortify/CreateNewUser.php`

```php
<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     */
    public function create(array $input): User
    {
        // ✅ Validación de datos
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature()
                ? ['accepted', 'required']
                : '',
        ])->validate();

        // ✅ Crear usuario
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
```

### 4. Rutas Protegidas con Jetstream

Archivo: `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;

// Landing page pública
Route::get('/', function () {
    return view('landing');
});

// ===================================================
// RUTAS DE PERSONAJES (Protegidas con Jetstream)
// ===================================================
Route::middleware([
    'auth:sanctum',                      // ✅ Autenticación con Sanctum
    config('jetstream.auth_session'),    // ✅ Middleware de sesión de Jetstream
])->group(function () {
    Route::get('/character', [CharacterController::class, 'selector'])->name('character.selector');
    Route::get('/character/form', [CharacterController::class, 'form'])->name('character.form');
    Route::post('/character/create', [CharacterController::class, 'store'])->name('character.store');

    Route::get('/characters', [CharacterListController::class, 'index'])->name('characters.index');
});

// ===================================================
// DASHBOARD (Protegido con Jetstream + Email Verificado)
// ===================================================
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',                          // ✅ Email verificado (opcional)
])->group(function () {
    // Dashboard con AdminLTE
    Route::get('/dashboard', function () {
        return view('dashboard-admin');
    })->name('dashboard');

    // Rutas de administración (solo admins)
    Route::middleware('can:is-admin')
         ->prefix('admin')
         ->name('admin.')
         ->group(function () {
        Route::resource('users', UserManagementController::class);
    });
});
```

### 5. Verificar si un Usuario está Autenticado

```php
// En cualquier controlador o vista

// ✅ Verificar si está autenticado
if (auth()->check()) {
    // Usuario está autenticado
}

// ✅ Obtener el usuario actual
$user = auth()->user();

// ✅ Obtener el ID del usuario
$userId = auth()->id();

// ✅ Verificar si es admin (usando nuestro campo personalizado)
if (auth()->user()->is_admin) {
    // Es administrador
}

// ✅ Verificar con Gate (definido en AppServiceProvider)
if (auth()->user()->can('is-admin')) {
    // Es administrador
}
```

### 6. Usar Componentes de Jetstream

```php
{{-- Botón primario --}}
<x-button>
    Guardar
</x-button>

{{-- Botón de peligro --}}
<x-danger-button>
    Eliminar
</x-danger-button>

{{-- Input con label --}}
<div>
    <x-label for="name" value="Nombre" />
    <x-input id="name" type="text" name="name" />
</div>

{{-- Checkbox --}}
<x-checkbox name="remember" />

{{-- Errores de validación --}}
<x-validation-errors class="mb-4" />

{{-- Error individual --}}
<x-input-error for="email" />

{{-- Modal de confirmación --}}
<x-confirmation-modal wire:model="confirmingUserDeletion">
    <x-slot name="title">
        Confirmar Eliminación
    </x-slot>

    <x-slot name="content">
        ¿Estás seguro de eliminar este usuario?
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="$set('confirmingUserDeletion', false)">
            Cancelar
        </x-secondary-button>

        <x-danger-button wire:click="deleteUser">
            Eliminar
        </x-danger-button>
    </x-slot>
</x-confirmation-modal>
```

---

## 📌 Resumen

### ✅ Lo que Jetstream nos proporciona:

1. **Autenticación completa** - Login, registro, reset de contraseña
2. **Two-Factor Authentication (2FA)** - Seguridad adicional
3. **Gestión de perfil** - Actualizar nombre, email, contraseña
4. **Gestión de sesiones** - Ver y cerrar sesiones en otros dispositivos
5. **API Tokens (Sanctum)** - Autenticación para APIs
6. **Componentes Blade reutilizables** - Botones, inputs, modales, etc.
7. **Layouts pre-configurados** - `app.blade.php` y `guest.blade.php`

### ✅ Features que habilitamos:

-   ✅ Registration (Registro)
-   ✅ Reset Passwords (Restablecer contraseña)
-   ✅ Update Profile Information (Actualizar perfil)
-   ✅ Update Passwords (Cambiar contraseña)
-   ✅ Two-Factor Authentication (2FA)
-   ✅ Account Deletion (Eliminar cuenta)

### ❌ Features que deshabilitamos:

-   ❌ Email Verification (Verificación de email)
-   ❌ Profile Photos (Fotos de perfil personalizadas)
-   ❌ API (Tokens de API)
-   ❌ Teams (Equipos)
-   ❌ Terms and Privacy Policy (Términos y condiciones)

### 🔧 Personalizaciones realizadas:

1. **Campo `is_admin`** en el modelo User
2. **Layouts personalizados** con tema oscuro y colores naranja
3. **Integración con AdminLTE** para el dashboard
4. **Separación clara** entre vistas de Jetstream (auth) y AdminLTE (admin)

### ⚠️ Problemas resueltos con AdminLTE:

1. ✅ Rutas de autenticación no pisadas
2. ✅ Middleware correcto en todas las rutas
3. ✅ Vistas de auth usando Jetstream, no AdminLTE
4. ✅ Redirección correcta después de login/logout
5. ✅ Estilos separados (Tailwind vs Bootstrap)

---

## 📚 Documentación Oficial

-   **Laravel Jetstream**: https://jetstream.laravel.com/
-   **Laravel Fortify**: https://laravel.com/docs/fortify
-   **Laravel Sanctum**: https://laravel.com/docs/sanctum
-   **Livewire**: https://livewire.laravel.com/

---

**Autor**: Critical Dice Team  
**Fecha**: Diciembre 2025  
**Versión Jetstream**: 5.3  
**Versión Laravel**: 12.0  
**Stack**: Livewire
