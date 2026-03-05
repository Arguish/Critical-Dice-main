# 🎲 Critical Dice - Character Creator API

**Critical Dice** es una aplicación Laravel lista para crear y gestionar personajes de D&D, Pathfinder y otros sistemas de RPG. Ahora incluye una **API REST profesional** para consultar, crear, modificar y eliminar personajes.

## 🚀 Características

### Web Application

- ✅ Interfaz web para crear personajes
- ✅ Generador de características (stats)
- ✅ Almacenamiento en base de datos
- ✅ Gestión de usuario con Jetstream
- ✅ Autenticación segura con Fortify

### REST API (v1.0)

- ✅ CRUD completo para personajes
- ✅ Autenticación con Laravel Sanctum
- ✅ Validaciones robustas
- ✅ Transformación de datos con Resources
- ✅ Documentación profesional
- ✅ Colección Postman/Thunder lista

## 📚 Documentación de la API

Para consultar la API, ver los siguientes archivos:

| Documento                                                            | Descripción                             |
| -------------------------------------------------------------------- | --------------------------------------- |
| **[API_QUICK_REFERENCE.md](API_QUICK_REFERENCE.md)**                 | Referencia rápida (endpoints, ejemplos) |
| **[API_DOCUMENTATION.md](API_DOCUMENTATION.md)**                     | Documentación completa y detallada      |
| **[API_TESTING_CHECKLIST.md](API_TESTING_CHECKLIST.md)**             | Guía para pruebas cruzadas              |
| **[COMO_CREAR_TOKEN.md](COMO_CREAR_TOKEN.md)**                       | Paso a paso crear tokens API            |
| **[IMPLEMENTATION_SUMMARY.md](IMPLEMENTATION_SUMMARY.md)**           | Resumen técnico de la implementación    |
| **[Critical_Dice_API_Postman.json](Critical_Dice_API_Postman.json)** | Colección Postman/Thunder client        |

## 🔌 Endpoints Principales

```
Base URL: http://localhost:8000/api/v1/
Autenticación: Bearer Token (Sanctum)

GET    /characters              Listar tus personajes
POST   /characters              Crear uno nuevo
GET    /characters/{id}         Ver uno específico
PATCH  /characters/{id}         Actualizar
DELETE /characters/{id}         Eliminar
```

## 🛠️ Instalación y Configuración

### Requisitos

- PHP 8.2+
- Composer
- MySQL/SQLite
- Node.js (opcional, para assets)

### Setup Inicial

```bash
# 1. Instalar dependencias
composer install

# 2. Copiar archivo .env
cp .env.example .env

# 3. Generar clave
php artisan key:generate

# 4. Ejecutar migraciones
php artisan migrate

# 5. Iniciar servidor
php artisan serve
```

La aplicación estará en: `http://localhost:8000`

## 🔐 Obtener Token API

1. Regístrate en `http://localhost:8000/register`
2. Ve a tu perfil
3. Busca "API Tokens" y crea uno nuevo
4. Usa el token en el header: `Authorization: Bearer {token}`

## 📋 Estructura del Proyecto

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Api/V1/
│   │   │   └── CharacterController.php      [API CRUD]
│   │   ├── CharacterController.php          [Web]
│   │   └── ...más controladores
│   ├── Requests/
│   │   ├── Api/V1/
│   │   │   ├── StoreCharacterRequest.php
│   │   │   └── UpdateCharacterRequest.php
│   ├── Resources/
│   │   └── CharacterResource.php            [Transformación JSON]
│   └── Middleware/
│
├── Models/
│   ├── Character.php                        [Modelo principal]
│   └── User.php
│
├── Policies/
│   └── CharacterPolicy.php                  [Autorización]
│
├── Providers/
│   └── AppServiceProvider.php               [Registro de policies]
│
└── Database/
    ├── migrations/
    │   └── ...create_characters_table.php
    └── seeders/
```

## 🧪 Testing (Pruebas Cruzadas)

La API está lista para pruebas de otros grupos:

### Opción 1: Usar Postman

```bash
# Importar colección
File → Import → Critical_Dice_API_Postman.json
```

### Opción 2: Usar Thunder Client

```bash
# Importar JSON en Thunder Client
# O crear manualmente los requests siguiendo API_DOCUMENTATION.md
```

### Opción 3: Usar cURL

```bash
curl -X GET http://localhost:8000/api/v1/characters \
  -H "Authorization: Bearer YOUR_TOKEN"
```

## ✨ Validaciones Implementadas

- ✅ Sistema (dnd, pathfinder, other)
- ✅ Nombre de jugador/personaje (2-100 caracteres)
- ✅ Atributos (strength, dexterity, etc.) 1-20
- ✅ Raza, clase, trasfondo (textos validados)
- ✅ Errores en español con messages claros
- ✅ Response 422 en fallos de validación

## 🔐 Seguridad

- ✅ Autenticación Sanctum requerida
- ✅ Usuarios solo ven sus personajes
- ✅ Policies para autorización
- ✅ Códigos HTTP semánticos (401, 403, 404)
- ✅ Validación de entrada robusta

## 📊 Códigos HTTP

| Código  | Caso de Uso               |
| ------- | ------------------------- |
| **200** | Request exitoso           |
| **201** | Recurso creado            |
| **204** | Eliminado (sin contenido) |
| **400** | Error en request          |
| **401** | Sin autenticación         |
| **403** | Sin autorización          |
| **404** | No encontrado             |
| **422** | Validación fallida        |

## 🎯 Tecnologías Usadas

- **Framework**: Laravel 11
- **ORM**: Eloquent
- **Auth**: Fortify + Sanctum API
- **Validación**: Form Requests
- **Transformación**: Eloquent Resources
- **Autorización**: Policies
- **Frontend**: Blade templates + Tailwind CSS

## 📝 Licencia

Este proyecto es de la clase de DAW/DAM. Uso educativo.

---

**Versión API:** 1.0 | **Actualizado:** Febrero 2025
