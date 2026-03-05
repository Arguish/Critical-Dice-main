# Implementación API REST - Critical Dice 🎲

## ✅ Resumen Ejecutivo

Se ha implementado un **API REST completa y profesional** siguiendo estándares RESTFUL para la entidad **Character** (Personaje) en tu aplicación Laravel.

### Características Implementadas

| Requisito | Estado | Detalles |
|-----------|--------|----------|
| **Estructura de Archivos** | ✅ | Carpetas creadas bajo `app/Http/Controllers/Api/V1/` |
| **Rutas API** | ✅ | Registradas en `routes/api.php` bajo prefijo `/api/v1` |
| **CRUD Completo** | ✅ | Index, Show, Store, Update, Destroy implementados |
| **Eloquent Resource** | ✅ | CharacterResource para transformar datos snake_case → camelCase |
| **Form Requests** | ✅ | StoreCharacterRequest y UpdateCharacterRequest con validaciones |
| **Códigos HTTP** | ✅ | 201 (Create), 200 (OK), 204 (Delete), 422 (Validation), 401 (Auth), 403 (Forbidden) |
| **Autenticación** | ✅ | Sanctum tokens con middleware `auth:sanctum` |
| **Autorización** | ✅ | CharacterPolicy para validar propiedad sobre personajes |
| **Documentación** | ✅ | Tres archivos de documentación completos |
| **Colección Postman/Thunder** | ✅ | JSON ready-to-import |

---

## 📁 Estructura de Archivos Creada

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       └── V1/
│   │           └── CharacterController.php          [5 métodos CRUD]
│   ├── Requests/
│   │   └── Api/
│   │       └── V1/
│   │           ├── StoreCharacterRequest.php        [Validación crear]
│   │           └── UpdateCharacterRequest.php       [Validación actualizar]
│   └── Resources/
│       └── CharacterResource.php                     [Transformación datos]
└── Policies/
    └── CharacterPolicy.php                           [Autorización]

routes/
└── api.php                                            [Rutas actualizadas]

documentation/
├── API_DOCUMENTATION.md                              [Documental completa]
├── API_TESTING_CHECKLIST.md                          [Checklist pruebas]
└── Critical_Dice_API_Postman.json                    [Colección Postman]
```

---

## 🔌 Endpoints Disponibles

Todos requieren autenticación: `Authorization: Bearer {token}`

### ✅ Listar Personajes
```
GET /api/v1/characters
Response: 200 OK
```

### ✅ Obtener un Personaje
```
GET /api/v1/characters/{id}
Response: 200 OK | 404 Not Found | 403 Forbidden
```

### ✅ Crear un Personaje
```
POST /api/v1/characters
Body: JSON con system, playerName, characterName, race, class, background, stats
Response: 201 Created | 422 Unprocessable Entity
```

### ✅ Actualizar un Personaje
```
PATCH /api/v1/characters/{id}
Body: JSON parcial (solo campos a actualizar)
Response: 200 OK | 422 Unprocessable Entity | 403 Forbidden
```

### ✅ Eliminar un Personaje
```
DELETE /api/v1/characters/{id}
Response: 204 No Content | 403 Forbidden | 404 Not Found
```

---

## 🎯 Validaciones Implementadas

### Campos Obligatorios (Create)
- `system`: string | enum(dnd, pathfinder, other)
- `playerName`: string, 2-100 caracteres
- `characterName`: string, 2-100 caracteres
- `race`: string, 2-100 caracteres
- `class`: string, 2-100 caracteres
- `background`: string, 2-255 caracteres
- `strength, dexterity, constitution, intelligence, wisdom, charisma`: integer, 1-20 cada uno

### Campos Opcionales
- `appliedModifiers`: string nullable, max 500 caracteres

### Respuestas de Error (422)
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "fieldName": ["mensaje de error en español"]
  }
}
```

---

## 🔐 Características de Seguridad

- ✅ **Autenticación Sanctum**: Todos los endpoints requieren token válido
- ✅ **Autorización**: Users solo pueden acceder a sus propios personajes
- ✅ **Policy**: CharacterPolicy valida `user_id`
- ✅ **Códigos HTTP correctos**: 401 sin autenticación, 403 sin autorización
- ✅ **No expone datos internos**: Passwords y timestamps del sistema no se retornan

---

## 🔄 Transformación de Datos

La API transforma automáticamente:
- **Input** (camelCase): `characterName`, `playerName`, `appliedModifiers`
- **Storage** (snake_case): `character_name`, `player_name`, `applied_modifiers`
- **Output** (camelCase + Resources): Response profesional y consistente
- **Atributos agrupados**: Todos los stats bajo clave `attributes`

### Ejemplo Response
```json
{
  "data": {
    "id": 1,
    "userId": 1,
    "system": "dnd",
    "playerName": "Juan García",
    "characterName": "Thorin Ironforge",
    "race": "Dwarf",
    "class": "Fighter",
    "background": "Soldier",
    "attributes": {
      "strength": 18,
      "dexterity": 10,
      "constitution": 16,
      "intelligence": 12,
      "wisdom": 14,
      "charisma": 10
    },
    "appliedModifiers": "+2 Constitution",
    "createdAt": "2025-02-10T15:30:00Z",
    "updatedAt": "2025-02-10T15:30:00Z"
  }
}
```

---

## 📖 Documentación para Pruebas Cruzadas

### 1. **API_DOCUMENTATION.md**
- Referencia completa de todos los endpoints
- Ejemplos de request/response
- Códigos HTTP esperados
- Ejemplos cURL
- Notas de seguridad

### 2. **API_TESTING_CHECKLIST.md**
- Guía paso a paso para pruebas
- Casos de prueba exitosos y de error
- Validaciones a verificar
- Preguntas de evaluación
- Formato de reporte de bugs

### 3. **Critical_Dice_API_Postman.json**
- Colección lista para importar en Postman/Thunder Client
- Tests automáticos para validar respuestas
- Variables de entorno (baseUrl, token, characterId)
- Casos de prueba error incluidos

---

## 🚀 Cómo Usar

### Para Otros Grupos (Pruebas Cruzadas)

1. **Descargar archivos de doc**:
   - `API_DOCUMENTATION.md` - Referencia técnica
   - `API_TESTING_CHECKLIST.md` - Guía de pruebas
   - `Critical_Dice_API_Postman.json` - Colección Postman

2. **Preparar credenciales**:
   - Registrarse en la web
   - Crear token API en perfil
   - Copiar token

3. **Importar en Postman/Thunder**:
   - Abrir Postman
   - Collections → Import → Seleccionar JSON
   - Configurar variable `api_token`

4. **Ejecutar pruebas**:
   - Seguir checklist
   - Documentar resultados
   - Reportar cualquier error

### Para Mantener/Extender

```php
// Agregar nuevo modelo siguiendo este patrón:
// 1. ApiController en app/Http/Controllers/Api/V1/
// 2. StoreRequest y UpdateRequest en app/Http/Requests/Api/V1/
// 3. Resource en app/Http/Resources/
// 4. Policy en app/Policies/
// 5. Registrar en AppServiceProvider $policies
// 6. Agregar ruta en routes/api.php
```

---

## ✨ Mejores Prácticas Implementadas

- ✅ Separación de responsabilidades (SOLID)
- ✅ Namespaces organizados
- ✅ Form Requests para validación
- ✅ Resources para transformación
- ✅ Policies para autorización
- ✅ Mensajes de error en español
- ✅ Códigos HTTP semánticos
- ✅ Documentación profesional
- ✅ Estructura escalable

---

## 🧪 Testing Recomendados

```bash
# Crear personaje
POST /api/v1/characters
{ "system": "dnd", "playerName": "Test", ... }

# Listar
GET /api/v1/characters

# Obtener uno
GET /api/v1/characters/1

# Actualizar
PATCH /api/v1/characters/1
{ "strength": 19 }

# Eliminar
DELETE /api/v1/characters/1

# Error validación
POST /api/v1/characters
{ "playerName": "Test" }  # Faltan campos

# Sin autenticación
GET /api/v1/characters
# Sin header Authorization
```

---

## 📊 Códigos HTTP Implementados

| Método | Endpoint | Código | Significado |
|--------|----------|--------|-------------|
| GET | /characters | 200 | Lista de personajes |
| GET | /characters/{id} | 200 | Personaje encontrado |
| GET | /characters/{id} | 404 | No existe |
| GET | /characters/{id} | 403 | No es dueño |
| GET | /characters | 401 | Sin autenticación |
| POST | /characters | 201 | Creado |
| POST | /characters | 422 | Validación fallida |
| PATCH | /characters/{id} | 200 | Actualizado |
| PATCH | /characters/{id} | 422 | Validación fallida |
| PATCH | /characters/{id} | 403 | No autorizado |
| DELETE | /characters/{id} | 204 | Eliminado |
| DELETE | /characters/{id} | 403 | No autorizado |

---

## 🎓 Requisitos Cumplidos

- ✅ Controlador específico en `app/Http/Controllers/Api/V1/`
- ✅ Rutas bajo prefijo `v1` en `routes/api.php`
- ✅ Métodos index y show (GET)
- ✅ Eloquent Resource para transformación
- ✅ Métodos store y update (POST/PATCH) con Form Requests
- ✅ Método destroy con 204 No Content
- ✅ Validaciones robustas con mensajes legibles
- ✅ Response 422 en errores de validación
- ✅ Documentación para pruebas cruzadas
- ✅ Colección Postman/Thunder ready

---

## 📝 Notas Finales

- La API está lista para recibir pruebas de otros grupos
- Todos los mensajes de error están en español
- La estructura JSON es clara y profesional
- Los tokens se generan desde el perfil de usuario en la web
- Cada usuario solo ve/modifica/elimina sus propios personajes

---

**Implementado:** Febrero 2025  
**Versión API:** 1.0  
**Status:** ✅ Listo para pruebas
