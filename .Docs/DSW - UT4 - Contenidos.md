# Introducción a la autenticación en Laravel

<!-- TOC tocDepth:2..3 chapterDepth:2..6 -->

- [1. **¿Qué significa “autenticación”?**](#1-¿qué-significa-“autenticación”)
- [2. **Opciones que ofrece Laravel para implementar autenticación**](#2-opciones-que-ofrece-laravel-para-implementar-autenticación)
- [3. **¿Qué es Laravel Jetstream?**](#3-¿qué-es-laravel-jetstream)
- [4. **¿Qué es Laravel Fortify?**](#4-¿qué-es-laravel-fortify)
- [5. **¿Qué motor de interfaz gráfica usamos?**](#5-¿qué-motor-de-interfaz-gráfica-usamos)
- [6. **¿Cómo instalar Jetstream?**](#6-¿cómo-instalar-jetstream)
- [7. **¿Qué genera Jetstream al instalarlo?**](#7-¿qué-genera-jetstream-al-instalarlo)
- [8. **Comando route:list y las rutas de Fortify**](#8-comando-routelist-y-las-rutas-de-fortify)
- [9. **Comprobación del sistema**](#9-comprobación-del-sistema)
- [10. **¿Dónde se almacenan los usuarios?**](#10-¿dónde-se-almacenan-los-usuarios)
    - [10.1. **¿Qué es auth?**](#101-¿qué-es-auth)
    - [10.2. **¿Cómo proteger una ruta con auth?**](#102-¿cómo-proteger-una-ruta-con-auth)
    - [10.3. **También puedes proteger rutas individuales:**](#103-también-puedes-proteger-rutas-individuales)
    - [10.4. **Detalles importantes**](#104-detalles-importantes)
- [11. **Ideas clave**](#11-ideas-clave)
- [12. **¿Qué es AdminLTE?**](#12-¿qué-es-adminlte)
- [13. **¿Para qué sirve?**](#13-¿para-qué-sirve)
- [14. **¿Por qué usar AdminLTE en Laravel?**](#14-¿por-qué-usar-adminlte-en-laravel)
- [15. **Instalación de AdminLTE en Laravel**](#15-instalación-de-adminlte-en-laravel)
    - [15.1. **Pasos para instalar AdminLTE con Composer**](#151-pasos-para-instalar-adminlte-con-composer)
- [16. **Documentación oficial**](#16-documentación-oficial)

<!-- /TOC -->

# Introducción a la autenticación en Laravel

## 1. **¿Qué significa “autenticación”?**

En el desarrollo web, **autenticación** (authentication) es el proceso por el cual una aplicación comprueba si un usuario es quien dice ser.

- Generalmente se realiza mediante **usuario y contraseña**.

- Se diferencia de la **autorización o gestión de permisos**, que controla qué puede hacer ese usuario una vez ha iniciado sesión.

- Laravel incluye de forma nativa un **sistema de autenticación** robusto que puede integrarse fácilmente.

---

## 2. **Opciones que ofrece Laravel para implementar autenticación**

Laravel ofrece varias formas de incorporar autenticación a una aplicación:

| Opción              | Descripción                                                                                                                     | Nivel de complejidad |
| ------------------- | ------------------------------------------------------------------------------------------------------------------------------- | -------------------- |
| make:auth (antiguo) | Comando que generaba un sistema básico de login (ya no está disponible en versiones modernas)                                   | Bajo                 |
| **Fortify**         | Backend de autenticación sin frontend                                                                                           | Medio                |
| **Jetstream**       | Sistema completo con autenticación, frontend y funcionalidades extra como verificación de email, gestión de sesiones, 2FA, etc. | Medio-alto           |
| Breeze              | Alternativa más sencilla a Jetstream con menos funcionalidades                                                                  | Medio                |
| Sanctum / Passport  | Sistemas de autenticación para APIs (usado con aplicaciones móviles o SPA)                                                      | Avanzado             |

Nosotros vamos a usar **Jetstream**, porque:

- Está **oficialmente mantenido por Laravel**.

- Incluye frontend (Livewire o Inertia).

- Está basado en **Fortify** como backend de autenticación.

- Nos permitirá introducir poco a poco funcionalidades como gestión de perfiles, sesiones activas, verificación de email, etc.

---

## 3. **¿Qué es Laravel Jetstream?**

Laravel Jetstream es un conjunto de herramientas y funcionalidades avanzadas que Laravel nos ofrece para implementar un sistema de autenticación completo en nuestras aplicaciones. Con Jetstream, podemos:

- Crear y gestionar usuarios.
- Implementar el inicio de sesión y registro de usuarios.
- Recuperar contraseñas y verificar correos.
- Administrar sesiones activas de usuario y, opcionalmente, habilitar equipos y autenticación en dos factores.

Jetstream se construye sobre **Laravel Fortify**, que proporciona las rutas y funcionalidades de autenticación. Jetstream utiliza estas funciones y añade una interfaz que se puede personalizar fácilmente para crear sistemas de autenticación robustos y listos para usarse.

## Jetstream no es una “plantilla visual” como AdminLTE, sino una **base funcional completa** sobre la que construir una aplicación con usuarios registrados.

## 4. **¿Qué es Laravel Fortify?**

Fortify es el sistema de autenticación "sin interfaz" de Laravel. Esto significa que gestiona toda la lógica de autenticación (iniciar sesión, registro, verificación, etc.) sin crear vistas o pantallas. En cambio, Jetstream se encarga de proporcionar estas vistas y las herramientas para que el usuario interactúe con la autenticación de Fortify.

Internamente, las partes de autenticación de Jetstream son impulsadas por Laravel Fortify, que es un backend de autenticación independiente y sin interfaz gráfica para Laravel.

Fortify registra las rutas y controladores necesarios para implementar todas las funciones de autenticación de Laravel, incluyendo inicio de sesión, registro, restablecimiento de contraseña, verificación de correo electrónico, y más. Después de instalar Fortify, puedes ejecutar el comando route:list de Artisan para ver las rutas que ha registrado.

Dado que Fortify no proporciona su propia interfaz de usuario, está diseñado para emparejarse con una interfaz de usuario personalizada que realice solicitudes a las rutas que registra. Laravel Jetstream es nuestra implementación oficial de una interfaz de usuario construida sobre el backend de autenticación de Fortify.

Laravel Fortify es el **motor de autenticación** que está detrás de Jetstream. Proporciona las **rutas, controladores y validaciones** para el login, registro, restablecimiento de contraseña, etc.

Jetstream usa Fortify como “motor” y le añade una interfaz.

Por ejemplo:

- Fortify define /login, /register, /logout, etc.

- Jetstream genera los formularios y vistas que usan esas rutas.

---

## 5. **¿Qué motor de interfaz gráfica usamos?**

Cuando instalamos Laravel Jetstream, podemos elegir entre dos opciones para la interfaz: **Livewire** o **Inertia.js**. Para esta actividad, trabajaremos con **Livewire**, que utiliza el motor de plantillas **Blade** (que ya conocemos) para permitir una interfaz dinámica sin necesidad de JavaScript adicional.

Livewire nos permite hacer que las páginas se actualicen en tiempo real sin tener que recargar la página. Por ejemplo, si actualizamos algo en el perfil de usuario, podemos ver los cambios sin necesidad de recargar.

Jetstream ofrece dos opciones de interfaz:

| Opción         | Descripción                                              |
| -------------- | -------------------------------------------------------- |
| **Livewire**   | Usa componentes de Blade y Livewire                      |
| Inertia \+ Vue | Usa Vue.js como frontend (más complejo, orientado a SPA) |

## Nosotros usaremos la opción **Livewire**, que se basa en Blade y es más fácil de entender para en este momento del curso.

## 6. **¿Cómo instalar Jetstream?**

Para instalar Jetstream debemos tener Composer instalado (ya lo explicamos en UT3).

Pasos:

```
# Instala Jetstream
composer require laravel/jetstream

# Instala Jetstream con Livewire
php artisan jetstream:install livewire

# Ejecuta las migraciones (si la base de datos está configurada)
php artisan migrate

# Instala las dependencias frontales (solo si vamos a compilar assets)
npm install && npm run build
```

Si **no tienes configurado NPM**, puedes evitar el último paso. Jetstream funciona igualmente con sus vistas ya generadas.

## Puedes descargar node y npm en [https://nodejs.org/es](https://nodejs.org/es)

## 7. **¿Qué genera Jetstream al instalarlo?**

Al ejecutar el comando php artisan jetstream:install livewire, se generan:

📁 Nuevas rutas:

- /login

- /register

- /dashboard

- /user/profile

📁 Nuevos archivos:

- resources/views/auth/...: vistas para login, registro, etc.

- resources/views/dashboard.blade.php: vista inicial tras el login.

- resources/views/profile/...: gestión del perfil.

📁 Nuevas migraciones:

- Añade campos a la tabla users para autenticación.

📁 Nuevos componentes Livewire:

- Manejan la interacción de formularios y gestión del perfil.

📁 Middleware:

- Jetstream añade protección para rutas (auth, verified, etc.)

📁 Configuración de **fortify**:

**config/fortify.php**: Cuando Jetstream se instala, se crea un archivo de configuración config/fortify.php en tu aplicación. Dentro de este archivo de configuración, puedes personalizar varios aspectos del comportamiento de Fortify, como el guard de autenticación que se debe usar, a dónde deben redirigirse los usuarios después de la autenticación, y más.

Dentro del archivo de configuración de Fortify, también puedes desactivar características completas de Fortify, como la capacidad de actualizar la información de perfil o las contraseñas.

## 8. **Comando route:list y las rutas de Fortify**

Laravel Fortify registra automáticamente las rutas para la autenticación. Puedes ver todas las rutas disponibles en tu proyecto usando el siguiente comando en la terminal:

Copiar

```
php artisan route:list
```

Este comando muestra una lista de todas las rutas en la aplicación, incluyendo las que Fortify registra para el inicio de sesión, registro, restablecimiento de contraseñas, etc. Al ejecutar este comando, podrás identificar las rutas para cada funcionalidad de autenticación en tu proyecto.

---

## 9. **Comprobación del sistema**

Una vez instalado:

1. Accede a http://localhost:8000

2. Verás la opción para **registrarte** o **iniciar sesión**

3. Puedes **crear un nuevo usuario**, iniciar sesión y acceder al dashboard.

---

## 10. **¿Dónde se almacenan los usuarios?**

Los usuarios se almacenan en la **tabla users** de la base de datos, que contiene:

- id

- name

- email

- password (encriptada)

- created_at, updated_at

Puedes ver los registros usando herramientas como:

- DB Browser for SQLite (ya que de momento estamos usando SQLite)

- PhpMyAdmin (más adelante)

### 10.1. **¿Qué es auth?**

Es un **middleware** que Laravel aplica a una ruta para **verificar que el usuario ha iniciado sesión**.

Si no lo ha hecho:

- Laravel lo **redirige automáticamente** a la página de login (/login).

---

### 10.2. **¿Cómo proteger una ruta con auth?**

Supongamos que ya tienes en tu web.php algo como:

```
Route::get('/mensajes', [MensajeController::class, 'index'])->name('mensaje.index');
```

Y quieres que solo los usuarios autenticados puedan acceder. Entonces simplemente le aplicas el middleware así:

```
Route::middleware(['auth'])->group(function () {
    Route::get('/mensajes', [MensajeController::class, 'index'])->name('mensaje.index');
    Route::get('/mensajes/create', [MensajeController::class, 'create'])->name('mensaje.create');
    Route::post('/mensajes', [MensajeController::class, 'store'])->name('mensaje.store');
});
```

---

### 10.3. **También puedes proteger rutas individuales:**

```
Route::get('/mensajes', [MensajeController::class, 'index'])
    ->middleware('auth')
    ->name('mensaje.index');
```

---

### 10.4. **Detalles importantes**

- Jetstream **ya viene con auth registrado** como middleware, no necesitas hacer nada extra.

- Esto también funciona con los middlewares verified (requiere verificación de email), admin (si los creas tú) o combinaciones.

- Para proteger una **vista o fragmento de código Blade**, también puedes usar la directiva @auth:

```
@auth
    <a href="{{ route('mensaje.create') }}">Nuevo mensaje</a>
@endauth
```

---

---

## 11. **Ideas clave**

- Laravel Jetstream ofrece un **sistema de autenticación completo** con pocas líneas de configuración.

- Usa Fortify para el backend y Livewire para el frontend.

- Permite **registrar, autenticar y gestionar usuarios** de forma profesional.

- Les evita tener que **implementar desde cero** todo el sistema de login.

# AdminLTE

# AdminLTE

## 12. **¿Qué es AdminLTE?**

AdminLTE es una plantilla de administración basada en Bootstrap que facilita la creación de paneles de administración o interfaces de usuario para aplicaciones web. Ofrece una gran variedad de componentes de interfaz, como tablas, gráficos, formularios y widgets, que podemos integrar fácilmente en nuestras aplicaciones Laravel. Su diseño moderno y funcional nos permite tener una interfaz de administración atractiva sin necesidad de desarrollar elementos visuales desde cero.

Permite incorporar rápidamente:

- Tableros o dashboards con estadísticas
- Gestión de usuarios y roles
- Menús laterales desplegables
- Formularios, tablas, gráficos, alertas, notificaciones, etc.

AdminLTE es ampliamente utilizado en entornos profesionales por su versatilidad, documentación ycomunidad.

## 13. **¿Para qué sirve?**

AdminLTE nos permite agregar rápidamente una interfaz de administración completa y profesional en Laravel. Esto es ideal cuando necesitamos un panel de control para gestionar datos, reportes o cualquier funcionalidad administrativa. AdminLTE ahorra tiempo al evitar que diseñemos desde cero, permitiéndonos enfocarnos en la lógica de nuestra aplicación.

## 14. **¿Por qué usar AdminLTE en Laravel?**

Laravel no trae una plantilla visual por defecto, solo una estructura base. **AdminLTE** nos permite:

- Añadir una interfaz de administración moderna sin diseñarla desde cero.
- Enfocarnos en el desarrollo del backend sin perder tiempo con el diseño.
- Personalizar con facilidad menús, secciones y estilos visuales.
- Aplicarlo como **panel de administración para usuarios con rol “admin”**.

## 15. **Instalación de AdminLTE en Laravel**

### 15.1. **Pasos para instalar AdminLTE con Composer**

A continuación, se detalla el procedimiento paso a paso:

---

#### 15.1.1. **1\. Instalar el paquete**

```
composer require jeroennoten/laravel-adminlte
```

---

#### 15.1.2. **2\. Publicar los archivos de configuración y vistas**

```
php artisan adminlte:install
```

Esto creará:

- **config/adminlte.php** → Configuración del panel (menús, plugins…)

- Vistas de autenticación (si no tienes Jetstream o Breeze)

- Vistas base extendibles con @extends('adminlte::page')

---

#### 15.1.3. **3\. Configurar AdminLTE**

Después de instalarlo, podemos personalizar AdminLTE en el archivo config/adminlte.php. Aquí configuramos el título, el logo, el menú, y otros elementos de la interfaz.

Por ejemplo, añadimos un enlace al Dashboard

| 'menu' \=\> \[ // Navbar items: \[ 'type' \=\> 'navbar-search', 'text' \=\> 'search', 'topnav_right' \=\> true, \], \[ 'type' \=\> 'fullscreen-widget', 'topnav_right' \=\> true, \], // Sidebar items: \[ 'type' \=\> 'sidebar-menu-search', 'text' \=\> 'search', \], \[ 'text' \=\> 'Dashboard', 'url' \=\> 'admin/dashboard', 'icon' \=\> 'fas fa-fw fa-home', \], |
| :--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |

---

#### 15.1.4. **4\. (Opcional) Instalar los plugins y assets**

```
npm install
npm run build
```

Esto compilará los assets si quieres personalizar estilos o incluir plugins como Chart.js, SweetAlert2, DataTables, etc.

---

#### 15.1.5. **5\. Crear una vista con AdminLTE**

```
{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Bienvenido al Panel de Administración</h1>
@endsection

@section('content')
    <p>Este es un panel de administración usando AdminLTE.</p>
@endsection
```

---

#### 15.1.6. **5\. Definir rutas y controlador**

```
// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
});
```

```
// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
}
```

---

## 16. **Documentación oficial**

[https://github.com/jeroennoten/Laravel-AdminLTE/wiki/](https://github.com/jeroennoten/Laravel-AdminLTE/wiki/)

# Personalización del idioma

# **Personalización del idioma**

Para configurar el idioma en un proyecto Laravel y utilizar el archivo es.json para las traducciones en español, seguiremos estos pasos:

**Creamos la carpeta donde se alojarán los archivos de traducción de de Laravel**

- Primero, creamos manualmente la carpeta resources/lang/

**Crear el archivo es.json para traducciones personalizadas**

- En resources/lang/, creamos un archivo llamado es.json. Este archivo nos permitirá almacenar nuestras traducciones en formato JSON. Podemos añadir las claves y valores que necesitamos traducir. Por ejemplo:
- Copiar

```

{
 "Welcome": "Bienvenido",
 "Login": "Iniciar sesión",
 "Logout": "Cerrar sesión"
}
```

- Cada clave representa un texto que se traducirá al español.

**Configurar el idioma predeterminado en Laravel**

- Vamos al fichero .env y cambiamos la opción LOCALE de en a es, de modo que el español sea el idioma predeterminado de nuestra aplicación:
- Copiar

```

APP_LOCALE=es
APP_FALLBACK_LOCALE=es
APP_FAKER_LOCALE=es_ES
```

**Usar las traducciones en nuestras vistas**

- Para utilizar las traducciones en nuestras vistas, empleamos el helper \_\_('clave') o el método @lang('clave') de Blade. Laravel buscará la clave en el archivo es.json si el idioma configurado es el español.
- Ejemplo en una vista Blade:
- Copiar

```

<h1>{{ __('Welcome') }}</h1>
<a href="{{ route('login') }}">{{ __('Login') }}</a>
```

- Con esto, los textos se mostrarán en español usando las traducciones definidas en el archivo es.json.

Siguiendo estos pasos, tendremos nuestro proyecto Laravel configurado para usar el idioma español.

Podemos utilizar el siguiente fichero es.json para disponer de un gran número de traducciones, varias de ellas utilizadas por Jetstream.

````json

{
    "API Token": "Token API",
    "API Tokens": "Tokens API",
    "API tokens allow third-party services to authenticate with our application on your behalf.": "Los tokens API permiten que servicios de terceros se autentiquen con nuestra aplicación en su nombre.",
    "Add Team Member": "Añadir miembro al equipo",
    "Add": "Añadir",
    "Added.": "Añadido.",
    "Administrator": "Administrador",
    "All of the people that are part of this team.": "Todas las personas que forman parte de este equipo.",
    "Already registered?": "¿Ya estás registrado?",
    "Browser Sessions": "Sesiones del navegador",
    "Cancel": "Cancelar",
    "Close": "Cerrar",
    "Code": "Código",
    "Confirm Password": "Confirmar contraseña",
    "Confirm": "Confirmar",
    "Create Account": "Crear cuenta",
    "Create API Token": "Crear token API",
    "Create New Team": "Crear nuevo equipo",
    "Create Team": "Crear equipo",
    "Create": "Crear",
    "Created.": "Creado.",
    "Current Password": "Contraseña actual",
    "Dashboard": "Panel",
    "Delete Account": "Eliminar cuenta",
    "Delete API Token": "Eliminar token API",
    "Delete Team": "Eliminar equipo",
    "Delete": "Eliminar",
    "Disable": "Deshabilitar",
    "Done.": "Hecho.",
    "Editor": "Editor",
    "Email Password Reset Link": "Enviar enlace de restablecimiento",
    "Email": "Email",
    "Enable": "Habilitar",
    "Ensure your account is using a long, random password to stay secure.": "Asegúrese de que su cuenta esté usando una contraseña larga y aleatoria para mantenerse seguro.",
    "For your security, please confirm your password to continue.": "Por su seguridad, confirme su contraseña para continuar.",
    "Forgot your password?": "¿Olvidaste tu contraseña?",
    "Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.": "¿Olvidaste tu contraseña? No hay problema. Simplemente déjanos saber tu dirección de correo electrónico y te enviaremos un enlace para restablecer la contraseña que te permitirá elegir una nueva.",
    "I agree to the :terms_of_service and :privacy_policy": "Acepto los :terms_of_service y la :privacy_policy",
    "If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.": "Si es necesario, puede cerrar sesión en todas sus otras sesiones de navegador en todos sus dispositivos. Algunas de sus sesiones recientes se enumeran a continuación; sin embargo, esta lista puede no ser exhaustiva. Si cree que su cuenta se ha visto comprometida, también debe actualizar su contraseña.",
    "Last active": "Última actividad",
    "Last used": "Último uso",
    "Leave Team": "Abandonar equipo",
    "Leave": "Abandonar",
    "Log in": "Iniciar sesión",
    "Log Out Other Browser Sessions": "Cerrar sesiones en otros navegadores",
    "Log Out": "Cerrar sesión",
    "Manage Account": "Administrar cuenta",
    "Manage and log out your active sessions on other browsers and devices.": "Administre y cierre sus sesiones activas en otros navegadores y dispositivos.",
    "Manage API Tokens": "Administrar tokens API",
    "Manage Role": "Administrar rol",
    "Manage Team": "Administrar equipo",
    "Name": "Nombre",
    "Nevermind": "Cancelar",
    "New Password": "Nueva contraseña",
    "Not Found": "No encontrado",
    "Oh no": "Oh no",
    "Once a team is deleted, all of its resources and data will be permanently deleted. Before deleting this team, please download any data or information regarding this team that you wish to retain.": "Una vez que se elimina un equipo, todos sus recursos y datos se eliminarán de forma permanente. Antes de eliminar este equipo, descargue cualquier dato o información sobre este equipo que desee conservar.",
    "Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.": "Una vez que se elimine su cuenta, todos sus recursos y datos se eliminarán de forma permanente. Antes de eliminar su cuenta, descargue cualquier dato o información que desee conservar.",
    "Password": "Contraseña",
    "Permanently delete this team.": "Eliminar este equipo de forma permanente.",
    "Permanently delete your account.": "Eliminar su cuenta de forma permanente.",
    "Permissions": "Permisos",
    "Photo": "Foto",
    "Please confirm access to your account by entering the authentication code provided by your authenticator application.": "Confirme el acceso a su cuenta ingresando el código de autenticación proporcionado por su aplicación de autenticación.",
    "Please confirm your password before continuing.": "Confirme su contraseña antes de continuar.",
    "Privacy Policy": "Política de privacidad",
    "Profile Information": "Información de perfil",
    "Profile": "Perfil",
    "Recovery Code": "Código de recuperación",
    "Regenerate Recovery Codes": "Regenerar códigos de recuperación",
    "Register": "Registrarse",
    "Remember me": "Recuérdame",
    "Remove Photo": "Eliminar foto",
    "Remove Team Member": "Eliminar miembro del equipo",
    "Remove": "Eliminar",
    "Resend Verification Email": "Reenviar correo de verificación",
    "Reset Password Notification": "Notificación de restablecimiento de contraseña",
    "Reset Password": "Restablecer contraseña",
    "Save": "Guardar",
    "Saved.": "Guardado.",
    "Select A New Photo": "Seleccionar una nueva foto",
    "Server Error": "Error del servidor",
    "Service Agreement": "Acuerdo de servicio",
    "Show Recovery Codes": "Mostrar códigos de recuperación",
    "Switch Teams": "Cambiar de equipo",
    "Team Details": "Detalles del equipo",
    "Team Members": "Miembros del equipo",
    "Team Name": "Nombre del equipo",
    "Team Owner": "Propietario del equipo",
    "Team Settings": "Configuración del equipo",
    "Terms of Service": "Términos de servicio",
    "Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.": "¡Gracias por registrarte! Antes de comenzar, ¿podría verificar su dirección de correo electrónico haciendo clic en el enlace que le acabamos de enviar? Si no recibió el correo electrónico, con gusto le enviaremos otro.",
    "The :attribute must be at least :length characters and contain at least one number.": "La :attribute debe tener al menos :length caracteres y contener al menos un número.",
    "The :attribute must be at least :length characters and contain at least one special character and one number.": "La :attribute debe tener al menos :length caracteres y contener al menos un carácter especial y un número.",
    "The :attribute must be at least :length characters and contain at least one special character.": "La :attribute debe tener al menos :length caracteres y contener al menos un carácter especial.",
    "The :attribute must be at least :length characters and contain at least one uppercase character and one number.": "La :attribute debe tener al menos :length caracteres y contener al menos una mayúscula y un número.",
    "The :attribute must be at least :length characters and contain at least one uppercase character and one special character.": "La :attribute debe tener al menos :length caracteres y contener al menos una mayúscula y un carácter especial.",
    "The :attribute must be at least :length characters and contain at least one uppercase character, one number, and one special character.": "La :attribute debe tener al menos :length caracteres y contener al menos una mayúscula, un número y un carácter especial.",
    "The :attribute must be at least :length characters and contain at least one uppercase character.": "La :attribute debe tener al menos :length caracteres y contener al menos una mayúscula.",
    "The :attribute must be at least :length characters.": "La :attribute debe tener al menos :length caracteres.",
    "The provided password does not match your current password.": "La contraseña proporcionada no coincide con su contraseña actual.",
    "The provided password was incorrect.": "La contraseña proporcionada no es correcta.",
    "The provided two factor authentication code was invalid.": "El código de autenticación de dos factores proporcionado no es válido.",
    "The team's name and owner information.": "Nombre del equipo e información del propietario.",
    "This device": "Este dispositivo",
    "This is a secure area of the application. Please confirm your password before continuing.": "Esta es un área segura de la aplicación. Confirme su contraseña antes de continuar.",
    "This password does not match our records.": "Esta contraseña no coincide con nuestros registros.",
    "This password reset link will expire in :count minutes.": "Este enlace de restablecimiento de contraseña caducará en :count minutos.",
    "This user already belongs to the team.": "Este usuario ya pertenece al equipo.",
    "This user has already been invited to the team.": "Este usuario ya ha sido invitado al equipo.",
    "Token Name": "Nombre del token",
    "Two Factor Authentication": "Autenticación de dos factores",
    "Two factor authentication is now enabled. Scan the following QR code using your phone's authenticator application.": "La autenticación de dos factores ahora está habilitada. Escanee el siguiente código QR usando la aplicación de autenticación de su teléfono.",
    "Update Password": "Actualizar contraseña",
    "Update your account's profile information and email address.": "Actualice la información de perfil y la dirección de correo electrónico de su cuenta.",
    "Use a recovery code": "Usar un código de recuperación",
    "Use an authentication code": "Usar un código de autenticación",
    "We were unable to find a registered user with this email address.": "No pudimos encontrar un usuario registrado con esta dirección de correo electrónico.",
    "When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application.": "Cuando la autenticación de dos factores está habilitada, se le solicitará un token seguro y aleatorio durante la autenticación. Puede recuperar este token desde la aplicación Google Authenticator de su teléfono.",
    "Whoops! Something went wrong.": "¡Ups! Algo salió mal.",
    "You are logged in!": "¡Has iniciado sesión!",
    "You have enabled two factor authentication.": "Has habilitado la autenticación de dos factores.",
    "You have not enabled two factor authentication.": "No has habilitado la autenticación de dos factores.",
    "You may delete any of your existing tokens if they are no longer needed.": "Puede eliminar cualquiera de sus tokens existentes si ya no los necesita.",
    "You may not delete your personal team.": "No puede eliminar su equipo personal.",
    "You may not leave a team that you created.": "No puede abandonar un equipo que usted creó."
 }

```

````

También podemos generar el fichero de traducción utilizando el paquete “laravel-lang”. Pueden consultar la documentación en [https://laravel-lang.com/basic-usage.html](https://laravel-lang.com/basic-usage.html)

# Migraciones

# Migraciones

Las migraciones de Laravel nos proporcionan una especie de "control de versiones" para nuestra base de datos. A través de ellas podremos crear y modificar las diferentes tablas que la conforman.

Para crear una migración en Laravel tenemos que ejecutar:

Copiar

```
php artisan make:migration create_users_table
```

El comando anterior creará una migración de la tabla de horarios en la carpeta "database/migrations". Cada migración tiene asociada un timestamp que permite determinar su orden.

El fichero generado contendrá una clase con dos métodos: "up" y "down". El método "up" se usará para añadir nuevas tablas, columnas o índices a nuestra base de datos. El comando "down" hace lo contrario.

El método "up" que se genera tiene, por defecto, el siguiente código:

```
Schema::create('products', function (Blueprint $table) {
   $table->id();
   $table->timestamps();
});
```

Nosotros deberíamos editar dicho método, mantener los campos actuales y añadir las columnas correctas junto a su tipo siguiendo el formato:

```
$table-><tipo>("<nombredelcampo>");
```

Por ejemplo:

```
$table->string("username");
```

El método "timestamps" creará las columnas "created_at" y "updated_at".

Podemos conocer todos los tipos de campos en [https://laravel.com/docs/11.x/migrations\#available-column-tfacaypes](https://laravel.com/docs/11.x/migrations#available-column-tfacaypes)

Además de [crear tablas](https://laravel.com/docs/10.x/migrations#creating-tables), como en el ejemplo anterior, podemos [modificarlas](https://laravel.com/docs/10.x/migrations#updating-tables) y [renombrarlas/borrarlas](https://laravel.com/docs/10.x/migrations#renaming-and-dropping-tables).

## **Configuración de la BD a través del fichero .env**

Para ejecutar las migraciones tenemos que modificar el fichero .env alojado en la carpeta principal del proyecto. En él debemos especificar el nombre de la BD, el usuario y la contraseña.

## **Ejecución de migraciones**

Para ejecutar las migraciones debemos lanzar el siguiente comando:

Copiar

```
php artisan migrate
```

Si quisiéramos revertir una migración anterior tendríamos que ejecutar:

php artisan migrate:rollback

Esto afectaría al último lote de migraciones ejecutado. Por cada ejecución del comando anterior se deshace un nuevo lote.

Podemos consultar las migraciones que se han ejecutado consultando la tabla "migrations" de la base de datos.

Nunca deberíamos eliminar ni modificar ficheros de migraciones que se hayan ejecutado. En todo caso, deberíamos hacer un rollback del lote donde se haya ejecutado la migración y después modificaríamos/eliminaríamos el fichero.

Si quisiéramos borrar las tablas de todas las migraciones y ejecutarlas de nuevo, podríamos ejecutar el comando:

php artisan migrate:fresh

También podemos ejecutar un comando que invoca al método down() de todas las migraciones y posteriormente las ejecuta:

php artisan migrate:refresn

Sin embargo, este comando no nos resuelve el problema en todos los casos, dado que elimina todas las tablas y las crea nuevamente. Si queremos realizar una pequeña modificación lo más conveniente es utilizar este tipo de migraciones:

php artisan make:migration add_campo_to_tabla_table

En este caso, en el método up() crearemos el nuevo campo siguiendo la misma sintaxis, y en el método down() la eliminaremos con una invocación similar a esta:

$table-\>dropColumn('columna');

Podemos encontrar la documentación oficial sobre las modificaciones de campos en el [siguiente enlace](https://laravel.com/docs/10.x/migrations#column-modifiers).

# Seeders

Un **seeder** en Laravel es una clase que se utiliza para poblar la base de datos con datos iniciales o de prueba. Es particularmente útil cuando estás desarrollando una aplicación y necesitas un conjunto de datos consistente para probar funcionalidades sin tener que ingresar manualmente la información cada vez.

## **¿Cómo funcionan los seeders en Laravel?**

- **Creación de seeders**: Los seeders se crean utilizando el comando Artisan de Laravel. Un seeder es básicamente una clase que tiene un método run() en el que defines qué datos quieres insertar en la base de datos.
- Para crear un seeder, usas el siguiente comando:
- Copiar

```
php artisan make:seeder NombreDelSeeder
```

- Esto creará un archivo en la carpeta database/seeders.
- **Definición de datos**: Dentro del método run() del seeder, puedes usar los métodos de los modelos de Laravel, como DB::table() o el uso de los modelos directamente, para insertar los datos en la base de datos. Un ejemplo sencillo de un seeder sería:
- Copiar

```
<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Message;
class UsersTableSeeder extends Seeder
{
   public function run()
   {
       $messages = [
           [
               "text" => "Primer mensaje",
           ],
           [
               "text" => "Segundo mensaje",
           ],
       ];
       foreach ($messages as $message) {
           Message::create($message);
       }
   }
}
```

- En este ejemplo, el seeder está insertando un usuario en la tabla users.
- **Ejecución de seeders**: Una vez que hayas creado y configurado tu seeder, puedes ejecutarlo usando el siguiente comando:
- Copiar

```
php artisan db:seed --class=UsersTableSeeder
```

- También puedes ejecutar todos los seeders a la vez (si has configurado varios en el archivo DatabaseSeeder):
- Copiar

```
php artisan db:seed
```

- **OPCIONAL: Uso de Factories**: Laravel también ofrece una manera más avanzada de poblar la base de datos mediante el uso de **factories**. Los factories permiten generar datos aleatorios para poblar la base de datos con ejemplos de registros. Puedes usarlos en los seeders para generar múltiples registros de manera automática y con datos variados. Un ejemplo sería:
- Copiar

```
public function run()
{
 \App\Models\User::factory(10)->create();
}
```

Este código creará 10 usuarios aleatorios usando el factory del modelo User. Por lo tanto, es fundamental crear previamente el modelo antes de utilizar los Factories.  
También es necesario crear la Factory con el siguiente comando:

php artisan make:factory DoubtFactory \--model=Doubt

- En el método definition() deberías incluir algo como esto:

Copiar

```
   return [
       'email' => $this->faker->unique()->safeEmail,
       'module' => $this->faker->word, // Genera una palabra
       'subject' => $this->faker->sentence(6),  // Genera un título o asunto de la duda
 	 'description' => $this->faker->paragraph(3),  // Genera un texto para la descripción de la duda
       'created_at' => now(),
       'updated_at' => now(),
];
```

#### **Resumen del flujo de trabajo:**

- Creas un seeder con php artisan make:seeder.
- Definir los datos que quieres insertar en el método run().
- Ejecutas el seeder con php artisan db:seed o php artisan db:seed \--class=NombreDelSeeder.
- Opcionalmente, puedes combinar seeders con factories para generar datos de prueba automáticamente.

# Modelos

# **Modelos**

En Laravel la interacción con la base de datos se lleva a cabo a través de un _object-relational mapper_ denominado **Eloquent**. Cuando usamos Eloquent, cada tabla de nuestra base de datos tiene un modelo correspondiente que se utiliza para interactuar con la tabla. Eloquent nos permitirá también insertar, actualizar y borrar registros.

Los modelos en Laravel están alojados en "app/Http/Models".

Para crear un modelo tenemos que ejecutar:

```php
php artisan make:model Product
```

Consideraciones importantes respecto al modelo:

- Eloquent asume que cada modelo está asociado a una tabla que tiene una clave primaria denominada "id". Por lo tanto, en todas nuestras migraciones usaremos el método "id" que crea dicho campo.
- Eloquent asume que el modelo "Client" guarda sus registros en una table denominada "Clients". Esto funciona correctamente con los nombres de las tablas en inglés, pero en español puede generar algún problema. Posteriormente veremos cómo resolverlo. Más información sobre los nombres de las tablas en el [siguiente enlace](https://laravel.com/docs/10.x/eloquent#table-names).
- Por defecto, Eloquent espera que estén creados los campos "created_at" y "updated_at". Por lo tanto, en todas nuestras migraciones utilizaremos el método "timestamps()" visto anteriormente.

Eloquent proporciona a nuestros modelos los siguientes métodos:

- Product::**all**(): devuelve todos los productos.
- Product::**pluck**("name", "id"): extrae una lista de valores de una columna específica. En el primer argumento indicamos la columna cuyos valores queremos extraer. El segundo, la columna que se usará como clave en el array resultante.
- Product::**find**(1): devuelve el producto con id=1.
- Product::**findOrFail**(1): igual que el anterior pero devuelve una excepción si no encuentra el registro.
- Product::**create**(\['name' \=\> 'TV', ...\]): crea un nuevo registro en la base de datos.
- Product::**destroy**(1): elimina el registro con id=1.

El siguiente ejemplo muestra cómo podemos acceder al resultado de uno de los métodos anteriores:

Copiar

```
$product = Product::findOrFail(1);
echo $product->name; # prints the product’s name
echo $product["name"]; # prints the product’s name
```

Eloquent almacena los atributos del modelo en un atributo de la clase (un array) denominado $attributes.

Para utilizar un modelo determinado en nuestros controladores deberemos insertar la siguiente línea de código al comienzo del fichero correspondiente:

```php
use App\Models\Product;
```

## **Relaciones**

Pueden encontrar información sobre las relaciones en Laravel [en la documentación oficial](https://laravel.com/docs/11.x/eloquent-relationships).

# ANEXO: Gestión de ramas con git

# ANEXO: Gestión de ramas

## **Guía rápida: trabajar con ramas en Git (GitHub Flow)**

Cuando trabajamos con nuevas funcionalidades —como la instalación de Jetstream—, lo ideal es hacerlo en una **rama independiente**. Así mantenemos el código estable en main mientras experimentamos en otra rama.

---

### **Consultar ramas**

```
git branch
```

Muestra todas las ramas locales.

La rama actual se indica con un asterisco \*.

Para ver también las ramas remotas:

```
git branch -a
```

---

### **Saber en qué rama estoy**

```
git status
```

Git muestra la rama actual en la primera línea (por ejemplo, On branch main).

---

### **Crear una nueva rama**

```
git checkout -b feature/instalacion-jetstream
```

**Recomendación de nombre** (según GitHub Flow):

- feature/nombre-descriptivo → para nuevas funcionalidades

    Ejemplo: feature/instalacion-jetstream

- bugfix/nombre-descriptivo → para corregir errores

    Ejemplo: bugfix/error-login

- improvement/nombre-descriptivo → para mejoras

    Ejemplo: improvement/validaciones-formulario

## ⚠️ Usa guiones (-) para separar palabras, no espacios ni mayúsculas.

### **Subir la nueva rama al repositorio remoto (GitHub)**

```
git push -u origin feature/instalacion-jetstream
```

El parámetro \-u establece el _tracking_, para que luego git push y git pull funcionen sin argumentos.

---

### **Traer los últimos cambios de main a tu rama**

A veces otros compañeros actualizan main mientras trabajas.

Para sincronizar tu rama:

```
git checkout main
git pull origin main
git checkout feature/instalacion-jetstream
git merge main
```

Esto **fusiona los cambios más recientes de main** en tu rama.

---

### **Combinar tu rama con main (tras finalizar y validar la instalación)**

1. Cambia a la rama main:

```
git checkout main
```

1. Asegúrate de tener la versión más reciente:

```
git pull
```

2. Fusiona tu rama:

```
git merge feature/instalacion-jetstream
```

3. Sube los cambios a GitHub:

```
git push
```

---

### **Eliminar la rama cuando ya no se necesite**

Una vez que se ha fusionado con main y validado todo:

```
git branch -d feature/instalacion-jetstream
```

Y también en remoto (opcional):

```
git push origin --delete feature/instalacion-jetstream
```

---

### **Si necesitas llevar cambios puntuales a main durante el desarrollo**

Si quieres pasar algo a main sin esperar a terminar toda la rama, puedes:

1. Confirmar los cambios en tu rama con git add . y git commit \-m "mensaje".

2. Hacer git push origin feature/instalacion-jetstream.

3. Abrir un **Pull Request** en GitHub → desde la interfaz web → “Compare & Pull Request”.

Así otros pueden revisar y aprobar el cambio antes de fusionarlo.

---

### **⚙️ Resumen visual del flujo**

```
main
 ├── (crear rama) → feature/instalacion-jetstream
 │      ├── trabajar, probar, validar
 │      ├── merge main → mantener actualizada
 │      └── merge → main (cuando esté validada)
 └── main actualizada con Jetstream instalado
```

# ANEXO: Mailtrap

# ANEXO: Mailtrap

### **¿Qué es Mailtrap?**

Mailtrap es un servicio en línea que nos permite **simular el envío de correos electrónicos desde nuestras aplicaciones Laravel** sin necesidad de utilizar una cuenta real de correo (como Gmail, Outlook, etc.).

En lugar de enviar los correos a direcciones reales, **Mailtrap los intercepta en un entorno seguro** y nos muestra su contenido en una bandeja virtual.

Esto resulta muy útil en la fase de desarrollo porque:

- Evita enviar correos reales mientras probamos la funcionalidad.

- Permite visualizar el mensaje exactamente como lo recibiría un usuario (asunto, cuerpo, adjuntos, formato HTML, etc.).

- Nos ayuda a depurar posibles errores de configuración o de formato en los mensajes.

---

### **Registro y configuración inicial**

1. **Accedemos a la web de Mailtrap**

    Vamos a [https://mailtrap.io](https://mailtrap.io) y hacemos clic en **Sign up** para crear una cuenta gratuita.

    Podemos registrarnos con una cuenta de Google o con un correo electrónico cualquiera.

2. **Accedemos a los datos de configuración (Integrations)**

    Durante el proceso de creación, escogemos el tipo de producto “Email Sandbox”. Tras finalizar dicho proceso accederemos a un panel de control donde tendremos la posibilidad de acceder a “Sandboxes”.  
    Veremos un listado de ejemplos de configuración para distintos lenguajes y frameworks.  
    Elegimos **Laravel X** (el más reciente que aparezca) y copiamos los parámetros de configuración para pasarlos a nuestro fichero .env

---

### **Configuración en el proyecto Laravel**

1. **Abrimos el archivo .env del proyecto Laravel.**

2. **Localizamos las siguientes líneas** (si no existen, las añadimos al final):

```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu_usuario
MAIL_PASSWORD=tu_contraseña
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="no-reply@midominio.com"
MAIL_FROM_NAME="${APP_NAME}"
```

2. ⚠️ Sustituimos los datos de configuración actuales por los que nos muestre la web de Mailtrap en la sección **Integrations** de Mailtrap.

3. **Guardamos el archivo** y actualizamos la configuración del entorno ejecutando:

```
php artisan config:clear
php artisan cache:clear
```

---

### **Prueba de envío de correo**

Podemos realizar una prueba rápida con el comando **Tinker** de Laravel o enviando un correo desde un _Mailable_ que hayamos creado.

Ejemplo de prueba desde Tinker:

```
php artisan tinker
```

Y dentro del intérprete:

```
Mail::raw('Este es un correo de prueba desde Laravel', function ($message) {
    $message->to('usuario@ejemplo.com')
            ->subject('Prueba de Mailtrap');
});
```

Luego vamos a nuestra bandeja en Mailtrap y veremos el mensaje recibido.

Aunque el destinatario sea “usuario@ejemplo.com”, **Mailtrap interceptará el correo y lo mostrará solo en nuestro entorno de pruebas**.

---

### **Ventajas principales**

- Es gratuito para pruebas básicas.

- No requiere servidores de correo ni configuración compleja.

- Permite probar tanto texto plano como HTML, plantillas y adjuntos.

- Ideal para entornos de desarrollo y prácticas educativas.

# ANEXO: Limpieza de caché

## **Limpieza de caché y configuración en Laravel**

### **¿Por qué a veces Laravel no aplica los cambios en el archivo .env?**

Laravel utiliza un sistema de **caché** que guarda temporalmente muchos datos de configuración, incluyendo las variables definidas en el archivo .env.

Esto hace que la aplicación cargue más rápido, pero tiene un pequeño inconveniente:

Si modificamos el archivo .env (por ejemplo, para cambiar las credenciales de la base de datos o del servidor de correo), **Laravel puede seguir usando los valores antiguos almacenados en la caché**.

Por eso, aunque actualicemos .env, los cambios pueden no tener efecto inmediato hasta que limpiemos la caché.

---

### **Comandos para limpiar la configuración y la caché**

Laravel proporciona dos comandos muy útiles que debemos conocer:

```
php artisan config:clear
php artisan cache:clear
```

- **php artisan config:clear**

    Elimina la caché de configuración.

    Obliga a Laravel a volver a leer los valores actuales del archivo .env y de los ficheros de configuración del proyecto.

- **php artisan cache:clear**

    Limpia la caché general de la aplicación (no solo la de configuración).

    Es útil para evitar que se guarden datos antiguos en memoria mientras desarrollamos.

---

### **Cuándo debemos ejecutarlos**

| Situación                                                                                                                    | ¿Es necesario limpiar la caché? | Motivo                                              |
| ---------------------------------------------------------------------------------------------------------------------------- | ------------------------------- | --------------------------------------------------- |
| Hemos cambiado datos en .env (por ejemplo, las credenciales de Mailtrap, la base de datos, el nombre de la aplicación, etc.) | ✅ Sí                           | Para que Laravel lea los nuevos valores.            |
| No hemos modificado nada en .env ni en los archivos de configuración                                                         | ❌ No                           | Laravel ya está usando los valores correctos.       |
| Notamos comportamientos extraños o errores al conectar con servicios externos                                                | ✅ Sí                           | Puede haber valores antiguos guardados en la caché. |

---

### **Ejemplo práctico**

Después de configurar el envío de correos con Mailtrap, debemos asegurarnos de que Laravel reconozca los nuevos valores del archivo .env.

Para ello, ejecutamos en la terminal del proyecto:

```
php artisan config:clear
php artisan cache:clear
```

Tras esto, Laravel volverá a leer toda la configuración actualizada, y los cambios en .env surtirán efecto inmediatamente.

---

### **En resumen**

- Laravel guarda en caché la configuración para mejorar el rendimiento.

- Si modificamos el archivo .env, los cambios pueden no aplicarse hasta limpiar la caché.

- Los comandos config:clear y cache:clear son seguros y se pueden ejecutar siempre que tengamos dudas.

- Es una **buena práctica** usarlos después de cualquier cambio en la configuración durante el desarrollo.

# ANEXO: GitHub Flow

# GitHub Flow

**GitHub Flow** es un flujo de trabajo sencillo, ideal para proyectos en equipo donde cada integrante trabaja en distintas funcionalidades o correcciones sin afectar al trabajo de los demás. Siguiendo estos pasos, podrán colaborar de forma ordenada, revisando y discutiendo los cambios antes de integrarlos al proyecto principal.

Entre sus ventajas destacamos las siguientes:

- **Simplicidad**: Solo requiere una rama principal (main) y ramas de características o correcciones de bugs (feature o bugfix), lo cual facilita su comprensión y uso.
- **Trabajo independiente**: Cada desarrollador puede crear su propia rama para desarrollar una nueva funcionalidad o solucionar un bug. Esto permite que trabajen de forma paralela sin interferir en el trabajo de los demás.
- **Proceso de Integración**: Una vez que un alumno completa su trabajo, puede crear un pull request para revisar y discutir el código antes de fusionarlo en la rama principal, promoviendo buenas prácticas de revisión.
- **Fácil de Escalar**: Si deseas implementar un entorno de integración continua, GitHub Flow se adapta muy bien, lo que facilita futuras implementaciones y pruebas automáticas.

A continuación detallamos los pasos que seguiremos en nuestros desarrollos para implementar GitHub Flow.

### **Paso 1: Crear una nueva rama**

1. Antes de empezar a trabajar en una nueva funcionalidad, corrección o mejora, **crea una nueva rama** desde la rama main.
2. Usa una convención de nombres clara y descriptiva. Por ejemplo:
    - Para una nueva funcionalidad: feature/nombre-descriptivo
    - Para corregir un error: bugfix/descripcion-error
    - Para mejorar el rendimiento o la experiencia: improvement/nombre-mejora
    - Para tareas de mantenimiento: chore/nombre-tarea
3. **Ejemplos**:
    - feature/autenticacion-usuarios
    - bugfix/error-login
    - improvement/optimizar-consultas
    - chore/actualizar-librerias

### **Sugerencias prácticas para nombrar las ramas**

- **Usa guiones**: Emplea guiones (\-) para separar palabras en lugar de espacios.
- **Sé breve y claro**: El nombre de la rama debe describir en pocas palabras el propósito del trabajo.
- **Mantén la consistencia**: Todos deben seguir el mismo formato de nombres para evitar confusiones.

### **Paso 2: Hacer cambios en la rama nueva**

- Trabaja en la nueva rama y realiza tus cambios de manera independiente.
- Asegúrate de probar el código localmente antes de pasar al siguiente paso.
- Realiza commits frecuentemente para documentar el avance de tu trabajo.

### **Paso 3: Crear un pull request**

Cuando hayas terminado tus cambios en la rama, crea un **pull request**. Este es el proceso de proponer tus cambios para que el resto del equipo pueda revisarlos y discutirlos.

1. Ve a la plataforma GitHub y selecciona **Pull Request**.
2. Escribe una **descripción clara** del cambio realizado y su propósito.
3. Los compañeros o el profesorado pueden **revisar y comentar** tu código en el pull request.

### **Paso 4: Revisar, comentar y ajustar el pull request**

1. **Revisión del Código**: Los miembros del equipo revisan el pull request y dejan comentarios si es necesario.
2. **Realizar Ajustes**: Si recibes comentarios, puedes hacer ajustes adicionales en la misma rama y los cambios se reflejarán automáticamente en el pull request.
3. **Aprobación**: Una vez que todos estén de acuerdo, el pull request se aprueba para integrarse en main.

### **Paso 5: Fusionar (Merge) los cambios en la rama main**

1. Tras la aprobación, fusiona la rama en main.
2. **Elimina la rama** que ya no necesites, ya que el cambio ha sido integrado.

**GitHub Flow** ayuda a que el equipo trabaje de forma organizada y evite que el código en main se vea afectado por cambios no revisados.

## **Uso de etiquetas**

En GitHub Flow, el uso de **etiquetas (tags)** no es un requisito formal, pero vamos a incluirlas para llevar un registro claro de las versiones del proyecto, especialmente cuando alcancemos hitos importantes o deseemos tener puntos de referencia en el tiempo.

En concreto las usaremos en estos casos:

1. **Etiquetas para versiones de lanzamiento**:
    - Crearemos etiquetas en la rama main cada vez que se alcance una nueva versión (Por ejemplov1.0, v1.1, etc.). El momento en que se alcance una nueva versión lo decidiremos nosotros, aunque lo más conveniente será que se ajuste a cada uno de los hitos que definamos en la planificación del proyecto.
2. **Etiquetas de hitos importantes**:
    - Podemos emplear etiquetas para marcar momentos específicos del desarrollo, como la finalización de la administración de usuarios o la implementación de una corrección importante, pero que no necesariamente impliquen la creación de una nueva versión.
    - Estas etiquetas permiten al equipo referenciar el estado del proyecto en puntos específicos, facilitando la organización y el control de versiones.

Aunque GitHub Flow no incluye etiquetas de manera estricta, usarlas siguiendo todos estas pautas puede mejorar la trazabilidad y el control del proyecto.

# ANEXO: Política de ejecución de Windows

# Política de ejecución de Windows

Si intentas ejecutar “npm” y Windows genera un error indicando que no se puede cargar el archivo, debes hacer lo siguiente para resolver el problema:

- Ejecuta PowerShell como administrador
- Escribe el siguiente comando y presiona ENTER:

```shell
Set-ExecutionPolicy RemoteSigned
```

- Confirma escribiendo “S”

# ANEXO: Respuesta a una solicitud POST

### **Respuesta a una solicitud POST en el controlador**

Cuando un usuario envía un formulario (solicitud POST), el navegador espera una respuesta del servidor. En este caso, lo ideal es redirigir a otra ruta usando redirect().

Copiar

```
return redirect()->route('doubt.form')->with('success', 'Su duda ha sido enviada correctamente.');
```

De esta forma:

- El servidor responde con una redirección a una ruta específica.
- El navegador realiza una nueva solicitud GET a esa ruta.
- Si el usuario refresca la página, solo recarga la página actual (la ruta redirigida), sin reenviar los datos del formulario.

Por otro lado:

- **with('success', 'Mensaje')**:
    - Permite pasar datos de la sesión de una solicitud a otra.
    - En la vista, podemos acceder a estos mensajes utilizando session('success').
- **Beneficio**: Podemos informar al usuario sobre el resultado de su acción sin exponer datos sensibles.

**Este patrón de funcionamiento se denomina patrón PRG (Post/Redirect/Get)**

El patrón **PRG** (Post/Redirect/Get) es un patrón de diseño en desarrollo web que se utiliza para mejorar la experiencia del usuario y prevenir problemas como la duplicación de envíos de formularios. Este patrón es especialmente útil para evitar que, al actualizar una página después de enviar un formulario, el navegador vuelva a enviar los datos, lo que podría causar acciones no deseadas como transacciones duplicadas.

¿Cómo funciona el patrón PRG?

- **Post (Enviar):** El usuario completa un formulario en una página web y lo envía. Esto genera una solicitud HTTP **POST** al servidor con los datos ingresados.
- **Redirect (Redireccionar):** Después de procesar la solicitud, en lugar de responder directamente con una página web, el servidor envía una respuesta HTTP **302** (Found) o **303** (See Other) que indica al navegador que debe redirigir a una nueva URL.
- **Get (Obtener):** El navegador sigue la redirección y realiza una solicitud HTTP **GET** a la nueva URL. El servidor responde con la página resultante que se muestra al usuario.

Beneficios del patrón PRG:

- **Prevención de duplicados:** Evita que, al refrescar la página, el navegador vuelva a enviar el formulario, lo que podría causar acciones duplicadas.
- **Mejora de la usabilidad:** Proporciona URLs únicas para cada estado de la aplicación, lo que facilita la navegación y el uso de botones de atrás y adelante.
- **Mejora de la seguridad:** Reduce el riesgo de reenvíos no intencionados de datos sensibles o transacciones críticas.

Ejemplo práctico:

Imagina que estás realizando una compra en línea:

- Al confirmar la compra (POST), el servidor procesa el pago.
- En lugar de mostrar directamente la confirmación, el servidor redirige a una página de confirmación de pedido (Redirect).
- El navegador carga la página de confirmación (GET), mostrando los detalles del pedido sin riesgo de volver a procesar el pago si se actualiza la página.
