# Guía del CRUD de Usuarios y Sistema de Administradores en Critical Dice

## 📋 Tabla de Contenidos

1. [Sistema de Roles (is_admin)](#sistema-de-roles-is_admin)
2. [Migración de Base de Datos](#migración-de-base-de-datos)
3. [Modelo User](#modelo-user)
4. [Gate de Permisos](#gate-de-permisos)
5. [Controlador CRUD](#controlador-crud)
6. [Vistas del Panel de Admin](#vistas-del-panel-de-admin)
7. [Rutas Protegidas](#rutas-protegidas)
8. [Convertir Usuario a Admin](#convertir-usuario-a-admin)
9. [Puenteo para Revisión del Profesor](#puenteo-para-revisión-del-profesor)
10. [Ejemplos de Código Completo](#ejemplos-de-código-completo)

---

## 👤 Sistema de Roles (is_admin)

En Critical Dice implementamos un sistema simple de roles con un solo campo booleano `is_admin` en la tabla de usuarios.

### ¿Por qué no usamos un sistema complejo de roles?

Por los requisitos del proyecto:

-   Solo necesitamos 2 tipos de usuarios: **Administradores** y **Usuarios normales**
-   Un campo booleano es suficiente y más eficiente
-   Evitamos la complejidad de paquetes como Spatie Permission
-   Fácil de entender y mantener

### Diferencias entre Roles

| Característica           | Usuario Normal | Administrador |
| ------------------------ | -------------- | ------------- |
| Ver Dashboard            | ✅ Sí          | ✅ Sí         |
| Crear Personajes         | ✅ Sí          | ✅ Sí         |
| Ver sus Personajes       | ✅ Sí          | ✅ Sí         |
| Gestionar Usuarios       | ❌ No          | ✅ Sí         |
| Crear Usuarios           | ❌ No          | ✅ Sí         |
| Editar Usuarios          | ❌ No          | ✅ Sí         |
| Eliminar Usuarios        | ❌ No          | ✅ Sí         |
| Ver todos los Personajes | ❌ No          | ✅ Sí         |
| Acceso a `/admin/*`      | ❌ No          | ✅ Sí         |

---

## 🗄️ Migración de Base de Datos

### Estructura de la Tabla Users

Archivo: `database/migrations/0001_01_01_000000_create_users_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_admin')->default(false);  // ✅ CAMPO CLAVE
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
```

### Características del Campo `is_admin`

```php
$table->boolean('is_admin')->default(false);
```

-   **Tipo:** `boolean` (tinyint en MySQL)
-   **Valor por defecto:** `false` (0)
-   **No nullable:** Siempre tiene un valor
-   **Índice:** No necesita índice (pocas consultas)

---

## 📦 Modelo User

Archivo: `app/Models/User.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',  // ✅ IMPORTANTE: Permitir asignación masiva
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',  // ✅ IMPORTANTE: Cast a booleano
        ];
    }

    /**
     * Relationship: A user can have many characters.
     */
    public function characters()
    {
        return $this->hasMany(Character::class);
    }
}
```

### Puntos Clave del Modelo

1. **Fillable**: `is_admin` está en `$fillable` para permitir asignación masiva
2. **Cast**: Se convierte automáticamente a booleano (`true`/`false`)
3. **Sin hidden**: `is_admin` NO está oculto (no es sensible)

---

## 🔐 Gate de Permisos

Los **Gates** de Laravel son la forma de definir autorizaciones. Los configuramos en `AppServiceProvider`.

### Configuración del Gate

Archivo: `app/Providers/AppServiceProvider.php`

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ✅ Gate para verificar si un usuario es administrador
        Gate::define('is-admin', function ($user) {
            return $user->is_admin === true;
        });
    }
}
```

### ¿Cómo funciona el Gate?

```php
Gate::define('is-admin', function ($user) {
    return $user->is_admin === true;
});
```

-   **Nombre del Gate**: `'is-admin'`
-   **Closure**: Recibe el usuario autenticado (`$user`)
-   **Retorna**: `true` si es admin, `false` si no lo es
-   **Uso**: Se usa en rutas, vistas y middleware

### Usar el Gate en Código

```php
// En un controlador o vista
if (auth()->user()->can('is-admin')) {
    // Es administrador
}

// Abreviado
if (auth()->user()->is_admin) {
    // Es administrador (acceso directo)
}

// En middleware de rutas
Route::middleware('can:is-admin')->group(function () {
    // Solo admins
});

// En Blade
@can('is-admin')
    <!-- Solo visible para admins -->
@endcan

// En AdminLTE config (menu)
'can' => 'is-admin',  // Solo admins ven este item
'can' => '!is-admin', // Solo NO-admins ven este item
```

---

## 🎮 Controlador CRUD

Creamos un controlador dedicado para la gestión de usuarios por parte de administradores.

### Ubicación y Namespace

```
app/Http/Controllers/Admin/UserManagementController.php
```

Namespace: `App\Http\Controllers\Admin`

### Código Completo del Controlador

Archivo: `app/Http/Controllers/Admin/UserManagementController.php`

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * Muestra todos los usuarios con el conteo de personajes.
     */
    public function index()
    {
        // ✅ Eager loading con conteo de relación
        $users = User::withCount('characters')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * Guarda un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        // ✅ Validación de datos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'sometimes|boolean',
        ]);

        // ✅ Hash de la contraseña
        $validated['password'] = Hash::make($validated['password']);

        // ✅ IMPORTANTE: Convertir checkbox a booleano
        // Si el checkbox está marcado, is_admin = true
        // Si no está marcado, is_admin = false
        $validated['is_admin'] = $request->has('is_admin');

        // ✅ Crear usuario
        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * Muestra los detalles de un usuario específico.
     */
    public function show(User $user)
    {
        // ✅ Eager loading de personajes
        $user->load('characters');

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * Muestra el formulario para editar un usuario.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * Actualiza los datos de un usuario existente.
     */
    public function update(Request $request, User $user)
    {
        // ✅ Validación (email único excepto el actual)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'is_admin' => 'sometimes|boolean',
        ]);

        // ✅ Solo actualizar contraseña si se proporciona una nueva
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // ✅ Actualizar is_admin
        $validated['is_admin'] = $request->has('is_admin');

        // ✅ Actualizar usuario
        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * Elimina un usuario de la base de datos.
     */
    public function destroy(User $user)
    {
        // ✅ IMPORTANTE: No permitir eliminar al propio usuario
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'No puedes eliminar tu propio usuario.');
        }

        // ✅ Eliminar usuario (esto también eliminará sus personajes si hay CASCADE)
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}
```

### Puntos Clave del Controlador

#### 1. **Conversión de Checkbox a Boolean**

```php
$validated['is_admin'] = $request->has('is_admin');
```

-   `has()` retorna `true` si el checkbox está marcado
-   Retorna `false` si no está marcado
-   Perfecto para convertir checkbox HTML a boolean

#### 2. **Validación de Email Único**

```php
'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
```

-   En `store`: Email debe ser único en toda la tabla
-   En `update`: Email debe ser único EXCEPTO para el usuario actual

#### 3. **Password Opcional en Edición**

```php
if ($request->filled('password')) {
    $validated['password'] = Hash::make($validated['password']);
} else {
    unset($validated['password']);
}
```

-   Si se proporciona contraseña, se hashea y actualiza
-   Si está vacía, no se modifica la contraseña actual

#### 4. **Protección contra Auto-eliminación**

```php
if ($user->id === auth()->id()) {
    return redirect()->route('admin.users.index')
        ->with('error', 'No puedes eliminar tu propio usuario.');
}
```

-   Evita que un admin se elimine a sí mismo
-   Previene quedarse sin acceso al sistema

#### 5. **Eager Loading y Conteos**

```php
$users = User::withCount('characters')->paginate(15);
```

-   `withCount('characters')`: Añade `characters_count` a cada usuario
-   `paginate(15)`: 15 usuarios por página
-   Eficiente: Solo 1 query adicional para los conteos

---

## 🎨 Vistas del Panel de Admin

### Estructura de Carpetas

```
resources/views/admin/
└── users/
    ├── index.blade.php      # ✅ Lista de usuarios
    ├── create.blade.php     # ✅ Formulario de creación
    ├── edit.blade.php       # ✅ Formulario de edición
    └── show.blade.php       # ✅ Detalles del usuario
```

### 1. Vista de Lista (index.blade.php)

Archivo: `resources/views/admin/users/index.blade.php`

```php
@extends('adminlte::page')

@section('title', 'Gestión de Usuarios')

@section('content_header')
    <h1>Gestión de Usuarios</h1>
@stop

@section('content')
    {{-- Mensajes flash --}}
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
                                {{-- ✅ Badge según el rol --}}
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
                                {{-- ✅ Conteo de personajes (withCount) --}}
                                <span class="badge badge-info">{{ $user->characters_count }}</span>
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                {{-- Botones de acción --}}
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="btn btn-info btn-sm"
                                   title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="btn btn-warning btn-sm"
                                   title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- ✅ No permitir eliminar al usuario actual --}}
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}"
                                          method="POST"
                                          style="display: inline-block;"
                                          onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                title="Eliminar">
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

        {{-- ✅ Paginación --}}
        <div class="card-footer clearfix">
            {{ $users->links('pagination::bootstrap-4') }}
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
@stop
```

### 2. Vista de Creación (create.blade.php)

Archivo: `resources/views/admin/users/create.blade.php`

```php
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

                {{-- ✅ Campo: ¿Es Administrador? (Switch/Checkbox) --}}
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

### 3. Vista de Edición (edit.blade.php)

Archivo: `resources/views/admin/users/edit.blade.php`

```php
@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
    <h1>Editar Usuario: {{ $user->name }}</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                {{-- Campo: Nombre --}}
                <div class="form-group">
                    <label for="name">Nombre *</label>
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           id="name"
                           name="name"
                           value="{{ old('name', $user->name) }}"
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
                           value="{{ old('email', $user->email) }}"
                           required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo: Nueva Contraseña (opcional) --}}
                <div class="form-group">
                    <label for="password">Nueva Contraseña</label>
                    <input type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           id="password"
                           name="password">
                    <small class="form-text text-muted">
                        Deja en blanco si no deseas cambiar la contraseña
                    </small>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo: Confirmar Nueva Contraseña --}}
                <div class="form-group">
                    <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                    <input type="password"
                           class="form-control"
                           id="password_confirmation"
                           name="password_confirmation">
                </div>

                {{-- ✅ Campo: ¿Es Administrador? --}}
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox"
                               class="custom-control-input"
                               id="is_admin"
                               name="is_admin"
                               value="1"
                               {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_admin">
                            <i class="fas fa-crown text-warning"></i> Usuario Administrador
                        </label>
                    </div>
                    <small class="form-text text-muted">
                        Los administradores tienen acceso completo al sistema
                    </small>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar Usuario
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

### 4. Vista de Detalles (show.blade.php)

Archivo: `resources/views/admin/users/show.blade.php`

```php
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
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                             src="{{ $user->profile_photo_url }}"
                             alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                    <p class="text-muted text-center">
                        {{-- ✅ Badge de rol --}}
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

---

## 🛣️ Rutas Protegidas

### Configuración de Rutas

Archivo: `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserManagementController;

// ===================================================
// RUTAS DE JETSTREAM (Dashboard protegido)
// ===================================================
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard (accesible para todos los usuarios autenticados)
    Route::get('/dashboard', function () {
        return view('dashboard-admin');
    })->name('dashboard');

    // ✅ Rutas de administración (SOLO para admins)
    Route::middleware('can:is-admin')
         ->prefix('admin')
         ->name('admin.')
         ->group(function () {
        // CRUD completo de usuarios
        Route::resource('users', UserManagementController::class);
    });
});
```

### Rutas Generadas por `resource`

```php
Route::resource('users', UserManagementController::class);
```

Esto crea automáticamente 7 rutas:

| Verbo     | URI                        | Action  | Nombre de Ruta      |
| --------- | -------------------------- | ------- | ------------------- |
| GET       | `/admin/users`             | index   | admin.users.index   |
| GET       | `/admin/users/create`      | create  | admin.users.create  |
| POST      | `/admin/users`             | store   | admin.users.store   |
| GET       | `/admin/users/{user}`      | show    | admin.users.show    |
| GET       | `/admin/users/{user}/edit` | edit    | admin.users.edit    |
| PUT/PATCH | `/admin/users/{user}`      | update  | admin.users.update  |
| DELETE    | `/admin/users/{user}`      | destroy | admin.users.destroy |

### Middleware Aplicado

```php
Route::middleware('can:is-admin')
```

-   **Tipo**: Gate middleware
-   **Gate**: `is-admin` (definido en AppServiceProvider)
-   **Efecto**: Solo usuarios con `is_admin = true` pueden acceder
-   **Si falla**: Redirige a página de error 403 (Forbidden)

---

## 🔄 Convertir Usuario a Admin

### Método 1: Usando Tinker (Desarrollo)

```bash
php artisan tinker
```

```php
// Buscar usuario por email
$user = App\Models\User::where('email', 'usuario@example.com')->first();

// Convertir a admin
$user->is_admin = true;
$user->save();

// Verificar
echo $user->is_admin ? 'Es admin' : 'No es admin';
```

### Método 2: Usando el Panel de Admin

1. Iniciar sesión como administrador
2. Ir a `/admin/users`
3. Hacer clic en "Editar" del usuario
4. Marcar el checkbox "Usuario Administrador"
5. Guardar cambios

### Método 3: Directamente en Base de Datos (MySQL)

```sql
-- Ver usuarios
SELECT id, name, email, is_admin FROM users;

-- Convertir usuario a admin
UPDATE users SET is_admin = 1 WHERE email = 'usuario@example.com';

-- Quitar permisos de admin
UPDATE users SET is_admin = 0 WHERE id = 5;
```

### Método 4: Crear Seeder (Producción)

Crear archivo: `database/seeders/AdminSeeder.php`

```php
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ Crear usuario administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@criticaldice.com',
            'password' => Hash::make('password'),
            'is_admin' => true,  // ✅ ADMIN
            'email_verified_at' => now(),
        ]);

        // ✅ Crear usuario normal
        User::create([
            'name' => 'Usuario Normal',
            'email' => 'user@criticaldice.com',
            'password' => Hash::make('password'),
            'is_admin' => false,  // ✅ NO ADMIN
            'email_verified_at' => now(),
        ]);
    }
}
```

Ejecutar seeder:

```bash
php artisan db:seed --class=AdminSeeder
```

### Método 5: Comando Artisan Personalizado (Opcional)

Crear comando: `app/Console/Commands/MakeUserAdmin.php`

```php
<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeUserAdmin extends Command
{
    protected $signature = 'user:make-admin {email}';
    protected $description = 'Convertir un usuario en administrador';

    public function handle()
    {
        $email = $this->argument('email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Usuario con email {$email} no encontrado.");
            return 1;
        }

        if ($user->is_admin) {
            $this->info("El usuario {$user->name} ya es administrador.");
            return 0;
        }

        $user->is_admin = true;
        $user->save();

        $this->info("Usuario {$user->name} convertido en administrador.");
        return 0;
    }
}
```

Usar comando:

```bash
php artisan user:make-admin usuario@example.com
```

---

## 🛠️ Puenteo para Revisión del Profesor

Durante el desarrollo del proyecto, necesitábamos que **todos los usuarios** pudieran ver el panel de administración para la revisión del profesor. Implementamos un "puenteo" temporal.

### El Problema

-   El sistema normal solo muestra el panel de admin a usuarios con `is_admin = true`
-   El profesor necesitaba ver todo el panel sin tener una cuenta de admin
-   No queríamos modificar la base de datos solo para la demo

### La Solución: Puenteo en el Dashboard

Archivo: `resources/views/dashboard-admin.blade.php`

```php
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
                {{-- ✅ LÍNEA ORIGINAL (Comentada temporalmente) --}}
                <!-- @if(auth()->user()->is_admin) -->

                {{-- ⚠️ PUENTEO TEMPORAL: Forzar modo admin para TODOS --}}
                {{-- TEMPORAL: Forzar modo admin para todos los usuarios (requisito del profesor) --}}
                @php
                $isAdmin = true;  // ✅ FUERZA MODO ADMIN
                @endphp

                @if($isAdmin)
                {{-- Contenido para administradores --}}
                <div class="alert alert-info">
                    <i class="fas fa-crown"></i> Panel de Administrador (MODO DEMO)
                </div>

                <div class="row">
                    {{-- Widgets de estadísticas --}}
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

                    {{-- ... más widgets ... --}}
                </div>
                @else
                {{-- Contenido para usuarios normales --}}
                <div class="alert alert-success">
                    <i class="fas fa-dice-d20"></i> Panel de Usuario
                </div>

                {{-- ... contenido de usuario ... --}}
                @endif
            </div>
        </div>
    </div>
</div>
@stop
```

### Cómo Funciona el Puenteo

#### Código Original (Correcto)

```php
@if(auth()->user()->is_admin)
    {{-- Solo admins ven esto --}}
@endif
```

#### Puenteo Temporal (Para Demo)

```php
<!-- @if(auth()->user()->is_admin) -->  {{-- Comentada --}}
@php
$isAdmin = true;  // ✅ FUERZA TODOS A ADMIN
@endphp

@if($isAdmin)
    {{-- TODOS ven esto ahora --}}
@endif
```

### Advertencia en la Vista

```php
<div class="alert alert-info">
    <i class="fas fa-crown"></i> Panel de Administrador (MODO DEMO)
</div>
```

-   Muestra claramente que es modo demo
-   Evita confusión durante la revisión

### Deshacer el Puenteo (Después de la Revisión)

Para volver al funcionamiento normal:

```php
{{-- ✅ RESTAURAR: Descomentar la línea original --}}
@if(auth()->user()->is_admin)

{{-- ❌ ELIMINAR: Quitar el puenteo temporal --}}
@php
// $isAdmin = true;  // ELIMINAR ESTA LÍNEA
@endphp

{{-- ❌ CAMBIAR: Volver a la condición original --}}
@if($isAdmin)  // CAMBIAR A: @if(auth()->user()->is_admin)
```

### ¿Por Qué Hicimos el Puenteo?

1. **Requisito del Profesor**: Necesitaba ver todo el panel de administración
2. **Sin Modificar BD**: No queríamos cambiar `is_admin` de usuarios reales
3. **Fácil de Deshacer**: Solo comentar/descomentar líneas
4. **Claramente Marcado**: Comentarios explican que es temporal
5. **No Afecta Producción**: Se remueve fácilmente antes de deploy

---

## 💡 Ejemplos de Código Completo

### Verificar si el Usuario Actual es Admin

```php
// Método 1: Acceso directo al atributo
if (auth()->user()->is_admin) {
    // Es administrador
}

// Método 2: Usando Gate
if (auth()->user()->can('is-admin')) {
    // Es administrador
}

// Método 3: En Blade
@if(auth()->user()->is_admin)
    <p>Eres administrador</p>
@endif

// Método 4: Con Gate en Blade
@can('is-admin')
    <p>Eres administrador</p>
@endcan
```

### Contar Usuarios Administradores

```php
// En controlador o vista
$adminCount = User::where('is_admin', true)->count();

// Con scope personalizado (opcional en el modelo)
$adminCount = User::admins()->count();
```

### Scope Personalizado (Opcional)

Añadir al modelo `User`:

```php
// app/Models/User.php

/**
 * Scope para obtener solo administradores
 */
public function scopeAdmins($query)
{
    return $query->where('is_admin', true);
}

/**
 * Scope para obtener solo usuarios normales
 */
public function scopeRegularUsers($query)
{
    return $query->where('is_admin', false);
}

// Uso
$admins = User::admins()->get();
$users = User::regularUsers()->paginate(15);
```

### Ocultar Menú según Rol (AdminLTE Config)

```php
// config/adminlte.php

'menu' => [
    // Dashboard (visible para todos)
    [
        'text' => 'Dashboard',
        'url' => 'dashboard',
        'icon' => 'fas fa-fw fa-tachometer-alt',
    ],

    // ✅ Solo para usuarios NO-admin
    [
        'text' => 'Mis Personajes',
        'url' => 'characters',
        'icon' => 'fas fa-fw fa-users',
        'can' => '!is-admin',  // ✅ Negación: solo NO-admin
    ],

    // ✅ Solo para administradores
    ['header' => 'Administración', 'can' => 'is-admin'],
    [
        'text' => 'Gestión de Usuarios',
        'url' => 'admin/users',
        'icon' => 'fas fa-fw fa-users-cog',
        'can' => 'is-admin',  // ✅ Solo admin
    ],
],
```

---

## 📌 Resumen

### ✅ Sistema Implementado

1. **Campo `is_admin`** en la tabla `users` (booleano, default false)
2. **Gate `is-admin`** en AppServiceProvider para autorización
3. **Controlador CRUD** completo en `Admin/UserManagementController`
4. **4 vistas AdminLTE**: index, create, edit, show
5. **Rutas protegidas** con middleware `can:is-admin`
6. **Validaciones** en formularios con manejo de errores
7. **Paginación** de usuarios (15 por página)
8. **Eager loading** de relaciones (characters)
9. **Protección** contra auto-eliminación

### ✅ Características del CRUD

-   ✅ Listar usuarios con paginación
-   ✅ Crear nuevos usuarios (con opción de admin)
-   ✅ Editar usuarios existentes
-   ✅ Ver detalles de usuario (con personajes)
-   ✅ Eliminar usuarios (excepto el propio)
-   ✅ Contraseña opcional en edición
-   ✅ Validación de email único
-   ✅ Hash automático de contraseñas
-   ✅ Mensajes flash de éxito/error

### ✅ Seguridad Implementada

-   ✅ Middleware de autenticación (Sanctum)
-   ✅ Gate de autorización (is-admin)
-   ✅ Protección CSRF (@csrf)
-   ✅ Validación de formularios
-   ✅ Hash de contraseñas (bcrypt)
-   ✅ Confirmación antes de eliminar
-   ✅ No eliminar usuario actual

### 🔧 Puenteo Temporal

-   ⚠️ Dashboard forzado a modo admin para revisión
-   ⚠️ Claramente marcado como temporal
-   ⚠️ Fácil de deshacer después de la demo

---

## 📚 Comandos Útiles

```bash
# Crear migración
php artisan make:migration add_is_admin_to_users_table

# Ejecutar migraciones
php artisan migrate

# Crear controlador con resource
php artisan make:controller Admin/UserManagementController --resource

# Crear seeder
php artisan make:seeder UsersSeeder

# Ejecutar seeder específico
php artisan db:seed --class=UsersSeeder

# Ejecutar todos los seeders
php artisan db:seed

# Ver rutas
php artisan route:list --name=admin

# Tinker (consola interactiva)
php artisan tinker
```

---

## 🌱 Seeders en Laravel

### ¿Qué son los Seeders?

Los **seeders** son clases que se usan para poblar la base de datos con datos de prueba o iniciales. En Critical Dice, creamos un `UsersSeeder` para tener usuarios predefinidos.

### ¿Cuándo se ejecutan?

**Los seeders NO se ejecutan automáticamente**. Debes ejecutarlos manualmente cuando los necesites.

### Comandos para Seeders

#### 1. Ejecutar todos los seeders (DatabaseSeeder)

```bash
php artisan db:seed
```

Ejecuta `DatabaseSeeder.php` que llama a otros seeders como `UsersSeeder`.

#### 2. Ejecutar un seeder específico

```bash
php artisan db:seed --class=UsersSeeder
```

Ejecuta solo el seeder especificado.

#### 3. Migrar y hacer seed en un solo comando

```bash
php artisan migrate --seed
```

Ejecuta las migraciones y luego los seeders.

#### 4. Refrescar base de datos y hacer seed

```bash
php artisan migrate:fresh --seed
```

⚠️ **Cuidado**: Borra todas las tablas, recrea las migraciones y ejecuta los seeders. Elimina todos los datos existentes.

### ¿Cuándo usar Seeders?

-   **Desarrollo local**: Para tener datos de prueba y no empezar con tablas vacías
-   **Testing**: Para crear escenarios de prueba predecibles
-   **Después de `migrate:fresh`**: Para volver a poblar la base de datos
-   **Demos**: Para mostrar el proyecto con datos de ejemplo

### Usuarios Creados por el Seeder

El `UsersSeeder` crea los siguientes usuarios de prueba:

| Email                   | Nombre         | Contraseña | Admin |
| ----------------------- | -------------- | ---------- | ----- |
| admin@criticaldice.com  | Administrador  | password   | ✅ Sí |
| user@criticaldice.com   | Usuario Normal | password   | ❌ No |
| elena@criticaldice.com  | Elena Martínez | password   | ❌ No |
| carlos@criticaldice.com | Carlos Ruiz    | password   | ❌ No |
| maria@criticaldice.com  | María López    | password   | ❌ No |

### Código del UsersSeeder

Archivo: `database/seeders/UsersSeeder.php`

```php
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Usar updateOrCreate para evitar duplicados
        User::updateOrCreate(
            ['email' => 'admin@criticaldice.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@criticaldice.com'],
            [
                'name' => 'Usuario Normal',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );

        // Más usuarios de prueba...
    }
}
```

### DatabaseSeeder

Archivo: `database/seeders/DatabaseSeeder.php`

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
        ]);
    }
}
```

**Nota**: Usamos `updateOrCreate` en lugar de `create` para que si ejecutas el seeder múltiples veces, no intente crear usuarios duplicados.

---

**Autor**: Critical Dice Team  
**Fecha**: Diciembre 2025  
**Versión Laravel**: 12.0  
**Panel Admin**: AdminLTE 3.15
