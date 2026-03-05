# Guía de Instalación y Configuración de AdminLTE en Critical Dice

## 📋 Tabla de Contenidos

1. [Instalación Inicial](#instalación-inicial)
2. [Archivos Creados por Defecto](#archivos-creados-por-defecto)
3. [Archivos que Mantenemos](#archivos-que-mantenemos)
4. [Archivos que Eliminamos](#archivos-que-eliminamos)
5. [Configuración del Dashboard](#configuración-del-dashboard)
6. [Personalización de Estilos](#personalización-de-estilos)
7. [Estructura de Vistas](#estructura-de-vistas)
8. [Ejemplos de Código](#ejemplos-de-código)

---

## 🚀 Instalación Inicial

### Paso 1: Instalar el paquete via Composer

```bash
composer require jeroennoten/laravel-adminlte
```

**Versión instalada en el proyecto:** `^3.15`

Ver en `composer.json`:

```json
{
    "require": {
        "jeroennoten/laravel-adminlte": "^3.15"
    }
}
```

### Paso 2: Publicar los assets y configuración

```bash
# Publicar todos los recursos
php artisan adminlte:install


---

## 📂 Archivos Creados por Defecto

AdminLTE crea varios archivos y carpetas al instalarse:

### Archivos de Configuración
```

config/
└── adminlte.php # ✅ MANTENER - Configuración principal

```

### Assets Públicos
```

public/
└── vendor/
└── adminlte/
├── dist/
│ ├── css/
│ │ └── adminlte.min.css # ✅ MANTENER - Estilos base
│ └── js/
│ └── adminlte.min.js # ✅ MANTENER - Scripts base
├── plugins/ # ⚠️ PARCIAL - Solo lo necesario
│ ├── bootstrap/ # ✅ MANTENER
│ ├── fontawesome-free/ # ✅ MANTENER
│ ├── jquery/ # ✅ MANTENER
│ ├── overlayScrollbars/ # ✅ MANTENER
│ └── popper/ # ✅ MANTENER
└── plugins/ (otros) # ❌ ELIMINAR si no se usan
├── chart.js/ # ❌ No usado
├── datatables/ # ❌ No usado (por ahora)
├── select2/ # ❌ No usado
└── sweetalert2/ # ❌ No usado

```

### Archivos de Idioma
```

lang/
└── vendor/
└── adminlte/
├── en/ # ✅ MANTENER (inglés)
├── es/ # ✅ MANTENER (español)
├── ar/ # ❌ Otros idiomas no necesarios
├── de/
├── fr/
└── ... (25+ idiomas) # ❌ ELIMINAR si no se usan

```

### Vistas (Blade Templates)
```

resources/views/vendor/adminlte/ # ❌ NO PUBLICAR
├── page.blade.php # Layout principal
├── master.blade.php # Template maestro
├── auth/ # Vistas de autenticación
└── components/ # Componentes reutilizables

```

> **NOTA IMPORTANTE:** En nuestro proyecto **NO publicamos las vistas** de AdminLTE.
> Usamos las vistas del paquete directamente mediante `@extends('adminlte::page')`

---

## ✅ Archivos que Mantenemos

### 1. Configuración Principal
- **`config/adminlte.php`** - Configuración completa del dashboard

### 2. Assets Esenciales
```

public/vendor/adminlte/
├── dist/ # Core AdminLTE (CSS y JS)
└── plugins/ # Solo los necesarios:
├── bootstrap/
├── fontawesome-free/
├── jquery/
├── overlayScrollbars/
└── popper/

```

### 3. Idiomas Necesarios
```

lang/vendor/adminlte/
├── en/ # Inglés
└── es/ # Español

```

### 4. Nuestros Assets Personalizados
```

public/
├── css/
│ └── adminlte-custom.css # ✅ Estilos personalizados
└── dice-twenty-faces-twenty-svgrepo-com.svg # ✅ Logo del proyecto

````

---

## ❌ Archivos que Eliminamos

### Plugins No Utilizados
```bash
# Estos NO se instalaron o se pueden eliminar si no se usan:
public/vendor/adminlte/plugins/
├── chart.js/              # Para gráficas (no usado)
├── datatables/            # Para tablas avanzadas (no usado aún)
├── select2/               # Selectores mejorados (no usado)
├── sweetalert2/           # Alertas bonitas (no usado)
├── pace/                  # Loader (no usado)
└── otros...
````

### Idiomas Innecesarios

```bash
# Eliminar todos excepto 'en' y 'es':
lang/vendor/adminlte/
├── ar/    ❌
├── bn/    ❌
├── ca/    ❌
├── de/    ❌
├── fa/    ❌
├── fr/    ❌
├── hr/    ❌
# ... (20+ idiomas más)
```

---

## ⚙️ Configuración del Dashboard

El archivo `config/adminlte.php` es el corazón de la personalización. Aquí están las configuraciones más importantes:

### 1. Información Básica

```php
// config/adminlte.php

return [
    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    */
    'title' => 'Critical Dice',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    */
    'logo' => '<b>Critical</b>Dice',
    'logo_img' => 'dice-twenty-faces-twenty-svgrepo-com.svg',
    'logo_img_class' => 'brand-image elevation-3',
    'logo_img_alt' => 'Critical Dice Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    */
    'auth_logo' => [
        'enabled' => true,
        'img' => [
            'path' => 'dice-twenty-faces-twenty-svgrepo-com.svg',
            'alt' => 'Critical Dice',
            'class' => '',
            'width' => 80,
            'height' => 80,
        ],
    ],
];
```

### 2. Preloader (Pantalla de Carga)

```php
// config/adminlte.php

'preloader' => [
    'enabled' => true,
    'mode' => 'fullscreen',
    'img' => [
        'path' => 'dice-twenty-faces-twenty-svgrepo-com.svg',
        'alt' => 'Critical Dice',
        'effect' => 'animation__shake',  // Efecto de temblor
        'width' => 80,
        'height' => 80,
    ],
],
```

### 3. Layout y Dark Mode

```php
// config/adminlte.php

// Layout fijo
'layout_fixed_sidebar' => true,
'layout_fixed_navbar' => true,
'layout_fixed_footer' => null,
'layout_dark_mode' => true,        // ✅ Modo oscuro activado

// Clases personalizadas
'classes_body' => 'dark-mode',
'classes_brand' => 'bg-dark',
'classes_brand_text' => 'text-orange',
'classes_content_wrapper' => 'bg-dark',
'classes_content_header' => 'bg-dark',
'classes_content' => 'bg-dark',
'classes_sidebar' => 'sidebar-dark-orange elevation-4',
'classes_topnav' => 'navbar-dark navbar-dark',
```

### 4. Clases de Autenticación (Login/Register)

```php
// config/adminlte.php

// Estilos oscuros con acento naranja
'classes_auth_card' => 'card-outline card-orange bg-dark',
'classes_auth_header' => 'bg-dark text-orange',
'classes_auth_body' => 'bg-dark',
'classes_auth_footer' => 'bg-dark',
'classes_auth_icon' => 'text-orange',
'classes_auth_btn' => 'btn-flat btn-orange',
```

### 5. Menú de Navegación

```php
// config/adminlte.php

'menu' => [
    // Widget de pantalla completa en navbar
    [
        'type' => 'fullscreen-widget',
        'topnav_right' => true,
    ],

    // Dashboard (visible para todos)
    [
        'text' => 'Dashboard',
        'url' => 'dashboard',
        'icon' => 'fas fa-fw fa-tachometer-alt',
    ],

    // Menú para usuarios normales (NO administradores)
    [
        'text' => 'Mis Personajes',
        'url' => 'characters',
        'icon' => 'fas fa-fw fa-users',
        'can' => '!is-admin',  // ✅ Negación: solo NO-admin
    ],
    [
        'text' => 'Crear Personaje',
        'url' => 'character/form',
        'icon' => 'fas fa-fw fa-plus-circle',
        'can' => '!is-admin',
    ],

    // Menú para administradores
    ['header' => 'Administración', 'can' => 'is-admin'],
    [
        'text' => 'Gestión de Usuarios',
        'url' => 'admin/users',
        'icon' => 'fas fa-fw fa-users-cog',
        'can' => 'is-admin',  // ✅ Solo administradores
    ],
    [
        'text' => 'Nuevo Usuario',
        'url' => 'admin/users/create',
        'icon' => 'fas fa-fw fa-user-plus',
        'can' => 'is-admin',
    ],
    [
        'text' => 'Todos los Personajes',
        'url' => 'admin/characters',
        'icon' => 'fas fa-fw fa-dice-d20',
        'can' => 'is-admin',
    ],
],
```

### 6. Filtros de Menú

```php
// config/adminlte.php

'filters' => [
    JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,     // ✅ Para 'can'
    JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
    JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
    JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
    JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
    JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
    JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
],
```

### 7. Control de Permisos (Gate)

En `app/Providers/AppServiceProvider.php`:

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // ✅ Gate para verificar si un usuario es administrador
        Gate::define('is-admin', function ($user) {
            return $user->is_admin === true;
        });
    }
}
```

### 8. Plugins (Desactivados por ahora)

```php
// config/adminlte.php

'plugins' => [
    'Datatables' => [
        'active' => false,  // ❌ No usado aún
    ],
    'Select2' => [
        'active' => false,  // ❌ No usado
    ],
    'Chartjs' => [
        'active' => false,  // ❌ No usado
    ],
    'Sweetalert2' => [
        'active' => false,  // ❌ No usado
    ],
    'Pace' => [
        'active' => false,  // ❌ No usado
    ],
],
```

---

## 🎨 Personalización de Estilos

Creamos un archivo CSS personalizado: `public/css/adminlte-custom.css`

### Paleta de Colores

```css
/* public/css/adminlte-custom.css */

/* === Variables de colores === */
:root {
    --primary-900: #0a0a0a; /* Negro más oscuro */
    --primary-800: #1a1a1a; /* Negro oscuro */
    --primary-700: #2d2d2d; /* Gris muy oscuro */
    --primary-600: #404040; /* Gris oscuro */
    --accent-orange: #ff6b35; /* Naranja principal */
    --accent-dark-orange: #e55a2b; /* Naranja oscuro (hover) */
    --accent-light-orange: #ff8c5a; /* Naranja claro */
}
```

### Fondo Principal

```css
/* public/css/adminlte-custom.css */

/* === Colores de fondo principales === */
.dark-mode .content-wrapper,
.dark-mode .main-footer,
.dark-mode .main-header,
body.dark-mode {
    background-color: var(--primary-900) !important;
    color: #e0e0e0 !important;
}
```

### Sidebar

```css
/* public/css/adminlte-custom.css */

/* === Sidebar === */
.dark-mode .main-sidebar,
.sidebar-dark-orange {
    background-color: var(--primary-800) !important;
}

/* Link activo en sidebar */
.sidebar-dark-orange .nav-sidebar > .nav-item > .nav-link.active,
.sidebar-dark-orange .nav-sidebar > .nav-item > .nav-link:hover {
    background-color: var(--primary-700) !important;
    color: var(--accent-orange) !important;
}

.sidebar-dark-orange .nav-link {
    color: #c2c7d0 !important;
}
```

### Cards y Contenedores

```css
/* public/css/adminlte-custom.css */

/* === Cards y Contenedores === */
.dark-mode .card,
.dark-mode .info-box,
.dark-mode .small-box {
    background-color: var(--primary-800) !important;
    color: #e0e0e0 !important;
    border-color: var(--primary-700) !important;
}

.dark-mode .card-header,
.dark-mode .card-footer {
    background-color: var(--primary-700) !important;
    border-color: var(--primary-600) !important;
}
```

### Tablas

```css
/* public/css/adminlte-custom.css */

/* === Tablas === */
.dark-mode .table {
    color: #e0e0e0 !important;
    background-color: var(--primary-800) !important;
}

.dark-mode .table thead th {
    background-color: var(--primary-700) !important;
    border-color: var(--primary-600) !important;
    color: var(--accent-orange) !important; /* ✅ Cabecera en naranja */
}

.dark-mode .table-hover tbody tr:hover {
    background-color: var(--primary-700) !important;
}

.dark-mode .table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(255, 255, 255, 0.02) !important;
}
```

### Botones

```css
/* public/css/adminlte-custom.css */

/* === Botones === */
.btn-orange,
.btn-primary {
    background-color: var(--accent-orange) !important;
    border-color: var(--accent-orange) !important;
    color: white !important;
}

.btn-orange:hover,
.btn-primary:hover {
    background-color: var(--accent-dark-orange) !important;
    border-color: var(--accent-dark-orange) !important;
}
```

### Logo con Filtro SVG

```css
/* public/css/adminlte-custom.css */

/* Logo SVG en naranja */
.dark-mode .brand-link .brand-image {
    filter: brightness(0) saturate(100%) invert(56%) sepia(89%) saturate(2175%) hue-rotate(
            337deg
        )
        brightness(102%) contrast(101%) !important;
}

.brand-link .brand-image {
    filter: brightness(0) saturate(100%) invert(56%) sepia(89%) saturate(2175%) hue-rotate(
            337deg
        )
        brightness(102%) contrast(101%) !important;
}
```

### Formularios

```css
/* public/css/adminlte-custom.css */

/* === Forms === */
.dark-mode .form-control,
.dark-mode .custom-select {
    background-color: var(--primary-700) !important;
    border-color: var(--primary-600) !important;
    color: #e0e0e0 !important;
}

.dark-mode .form-control:focus,
.dark-mode .custom-select:focus {
    background-color: var(--primary-700) !important;
    border-color: var(
        --accent-orange
    ) !important; /* ✅ Borde naranja al focus */
    color: #e0e0e0 !important;
    box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25) !important;
}
```

### Scrollbar Personalizado

```css
/* public/css/adminlte-custom.css */

/* === Scrollbar personalizado === */
.dark-mode ::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

.dark-mode ::-webkit-scrollbar-track {
    background: var(--primary-800);
}

.dark-mode ::-webkit-scrollbar-thumb {
    background: var(--primary-600);
    border-radius: 4px;
}

.dark-mode ::-webkit-scrollbar-thumb:hover {
    background: var(--accent-orange); /* ✅ Naranja al hover */
}
```

---

## 📁 Estructura de Vistas

### Vistas que Usan AdminLTE

```
resources/views/
├── dashboard-admin.blade.php           # ✅ Dashboard principal
└── admin/
    └── users/
        ├── index.blade.php             # ✅ Lista de usuarios
        ├── create.blade.php            # ✅ Crear usuario
        ├── edit.blade.php              # ✅ Editar usuario
        └── show.blade.php              # ✅ Ver detalles de usuario
```

### Vistas que NO Usan AdminLTE

```
resources/views/
├── landing.blade.php                   # Landing page pública
├── character-form.blade.php            # Formulario de personaje
├── character-selector.blade.php        # Selector de sistema
├── character-success.blade.php         # Éxito al crear personaje
└── characters-list.blade.php           # Lista simple de personajes
```

---

## 💻 Ejemplos de Código

### 1. Estructura Básica de una Vista AdminLTE

```php
{{-- resources/views/dashboard-admin.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard - Critical Dice')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bienvenido, {{ auth()->user()->name }}</h3>
                </div>
                <div class="card-body">
                    {{-- Contenido aquí --}}
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Estilos personalizados --}}
    <link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
@stop

@section('js')
    <script>
        console.log('Dashboard de Critical Dice cargado');
    </script>
@stop
```

### 2. Small Boxes (Widgets del Dashboard)

```php
{{-- resources/views/dashboard-admin.blade.php --}}

<div class="row">
    {{-- Widget de Usuarios --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ \App\Models\User::count() }}</h3>
                <p>Usuarios Totales</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                Gestionar usuarios <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    {{-- Widget de Personajes --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ \App\Models\Character::count() }}</h3>
                <p>Personajes Totales</p>
            </div>
            <div class="icon">
                <i class="fas fa-dice-d20"></i>
            </div>
            <a href="{{ route('characters.index') }}" class="small-box-footer">
                Ver todos <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    {{-- Widget de Administradores --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ \App\Models\User::where('is_admin', true)->count() }}</h3>
                <p>Administradores</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                Ver detalles <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>
```

### 3. Tabla con Acciones (Lista de Usuarios)

```php
{{-- resources/views/admin/users/index.blade.php --}}

@extends('adminlte::page')

@section('title', 'Gestión de Usuarios')

@section('content_header')
    <h1>Gestión de Usuarios</h1>
@stop

@section('content')
    {{-- Mensajes de éxito/error --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('error') }}
        </div>
    @endif

    {{-- Card con tabla --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Usuarios</h3>
            <div class="card-tools">
                <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Crear Usuario
                </a>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Personajes</th>
                        <th>Fecha Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->is_admin)
                                    <span class="badge badge-danger">
                                        <i class="fas fa-crown"></i> Admin
                                    </span>
                                @else
                                    <span class="badge badge-primary">
                                        <i class="fas fa-user"></i> Usuario
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $user->characters_count }}</span>
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                {{-- Botones de acción --}}
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="btn btn-info btn-sm" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- No permitir eliminar usuario actual --}}
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}"
                                          method="POST"
                                          style="display: inline-block;"
                                          onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay usuarios registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="card-footer clearfix">
            {{ $users->links('pagination::bootstrap-4') }}
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
@stop
```

### 4. Formulario de Creación

```php
{{-- resources/views/admin/users/create.blade.php --}}

@extends('adminlte::page')

@section('title', 'Crear Usuario')

@section('content_header')
    <h1>Crear Nuevo Usuario</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="card-body">
                {{-- Campo: Nombre --}}
                <div class="form-group">
                    <label for="name">Nombre *</label>
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo: Email --}}
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo: Contraseña --}}
                <div class="form-group">
                    <label for="password">Contraseña *</label>
                    <input type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           id="password"
                           name="password"
                           required>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo: Confirmar Contraseña --}}
                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña *</label>
                    <input type="password"
                           class="form-control"
                           id="password_confirmation"
                           name="password_confirmation"
                           required>
                </div>

                {{-- Campo: ¿Es Admin? (Switch) --}}
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox"
                               class="custom-control-input"
                               id="is_admin"
                               name="is_admin"
                               value="1"
                               {{ old('is_admin') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_admin">
                            <i class="fas fa-crown text-warning"></i> Usuario Administrador
                        </label>
                    </div>
                    <small class="form-text text-muted">
                        Los administradores tienen acceso completo al sistema
                    </small>
                </div>
            </div>

            {{-- Footer con botones --}}
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Crear Usuario
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-default">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
@stop
```

### 5. Vista de Detalles (Profile Box)

```php
{{-- resources/views/admin/users/show.blade.php --}}

@extends('adminlte::page')

@section('title', 'Detalles del Usuario')

@section('content_header')
    <h1>Detalles del Usuario</h1>
@stop

@section('content')
    <div class="row">
        {{-- Columna izquierda: Perfil --}}
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    {{-- Avatar --}}
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                             src="{{ $user->profile_photo_url }}"
                             alt="User profile picture">
                    </div>

                    {{-- Nombre --}}
                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                    {{-- Rol --}}
                    <p class="text-muted text-center">
                        @if($user->is_admin)
                            <span class="badge badge-danger">
                                <i class="fas fa-crown"></i> Administrador
                            </span>
                        @else
                            <span class="badge badge-primary">
                                <i class="fas fa-user"></i> Usuario
                            </span>
                        @endif
                    </p>

                    {{-- Información --}}
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Email</b> <a class="float-right">{{ $user->email }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Personajes</b> <a class="float-right">{{ $user->characters->count() }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Registro</b> <a class="float-right">{{ $user->created_at->format('d/m/Y') }}</a>
                        </li>
                    </ul>

                    {{-- Botón de editar --}}
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-block">
                        <i class="fas fa-edit"></i> Editar Usuario
                    </a>
                </div>
            </div>
        </div>

        {{-- Columna derecha: Personajes --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users"></i> Personajes del Usuario
                    </h3>
                </div>
                <div class="card-body p-0">
                    @if($user->characters->count() > 0)
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Raza</th>
                                    <th>Clase</th>
                                    <th>Sistema</th>
                                    <th>Creado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->characters as $character)
                                    <tr>
                                        <td>{{ $character->character_name }}</td>
                                        <td>{{ $character->race }}</td>
                                        <td>{{ $character->class }}</td>
                                        <td>
                                            <span class="badge badge-info">
                                                {{ strtoupper($character->system) }}
                                            </span>
                                        </td>
                                        <td>{{ $character->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center p-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Este usuario no tiene personajes creados</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Botón de volver --}}
    <div class="row">
        <div class="col-12">
            <a href="{{ route('admin.users.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> Volver a la Lista
            </a>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
@stop
```

### 6. Rutas con Middleware

```php
<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserManagementController;

// Dashboard protegido por autenticación
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard principal
    Route::get('/dashboard', function () {
        return view('dashboard-admin');
    })->name('dashboard');

    // Rutas de administración (solo para admins)
    Route::middleware('can:is-admin')
         ->prefix('admin')
         ->name('admin.')
         ->group(function () {
        // CRUD completo de usuarios
        Route::resource('users', UserManagementController::class);
        /*
         * Esto crea automáticamente:
         * - GET    /admin/users           -> index
         * - GET    /admin/users/create    -> create
         * - POST   /admin/users           -> store
         * - GET    /admin/users/{user}    -> show
         * - GET    /admin/users/{user}/edit -> edit
         * - PUT    /admin/users/{user}    -> update
         * - DELETE /admin/users/{user}    -> destroy
         */
    });
});
```

---

## 📌 Resumen

### ✅ Lo que mantuvimos de AdminLTE:

1. **Configuración principal** (`config/adminlte.php`)
2. **Assets esenciales** (CSS, JS, Bootstrap, FontAwesome, jQuery)
3. **Idiomas**: Solo inglés y español
4. **Layout del dashboard** mediante `@extends('adminlte::page')`

### ✅ Lo que personalizamos:

1. **Tema oscuro** con colores naranja (`adminlte-custom.css`)
2. **Menú dinámico** basado en roles (admin vs usuario normal)
3. **Logo personalizado** (dado de 20 caras)
4. **Widgets del dashboard** (small boxes con estadísticas)
5. **Vistas CRUD** para gestión de usuarios

### ❌ Lo que NO usamos/eliminamos:

1. Plugins innecesarios (Datatables, Select2, Chart.js, etc.)
2. Idiomas no utilizados (20+ idiomas)
3. Vistas publicadas (usamos las del paquete)

### 🎯 Objetivo principal:

**Solo queríamos la parte del dashboard**, así que:

-   Mantuvimos el layout base de AdminLTE
-   Personalizamos solo los estilos necesarios
-   Usamos las vistas del paquete sin modificarlas
-   Integramos el sistema de permisos con Gates de Laravel

---

## 📚 Documentación Oficial

-   **Laravel AdminLTE**: https://github.com/jeroennoten/Laravel-AdminLTE
-   **AdminLTE Template**: https://adminlte.io/
-   **Documentación Laravel**: https://laravel.com/docs

---

**Autor**: Critical Dice Team  
**Fecha**: Diciembre 2025  
**Versión AdminLTE**: 3.15  
**Versión Laravel**: 12.0
