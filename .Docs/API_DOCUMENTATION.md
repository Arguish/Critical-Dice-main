# Documentación API - Critical Dice v1.0

## Base URL
```
http://localhost:8000/api/v1
```

## Autenticación
Todos los endpoints requieren autenticación con **Laravel Sanctum**. Debes pasar el token en el header:
```
Authorization: Bearer YOUR_API_TOKEN
```

### Obtener Token
1. Regístrate en la aplicación web
2. Ve a tu perfil y crea un nuevo token API
3. Copia el token y úsalo en tus requests

---

## Endpoints

### 1. Listar Personajes del Usuario
**GET** `/characters`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Response (200 OK):**
```json
{
  "data": [
    {
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
  ]
}
```

---

### 2. Obtener un Personaje Específico
**GET** `/characters/{id}`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Response (200 OK):**
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

### 3. Crear un Nuevo Personaje
**POST** `/characters`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Body (JSON):**
```json
{
  "system": "dnd",
  "playerName": "María López",
  "characterName": "Elara Moonwhisper",
  "race": "Elf",
  "class": "Wizard",
  "background": "Scholar",
  "strength": 8,
  "dexterity": 14,
  "constitution": 12,
  "intelligence": 18,
  "wisdom": 15,
  "charisma": 13,
  "appliedModifiers": "+1 Intelligence"
}
```

**Campos obligatorios:**
- `system` (string): `dnd`, `pathfinder` o `other`
- `playerName` (string): 2-100 caracteres
- `characterName` (string): 2-100 caracteres
- `race` (string): 2-100 caracteres
- `class` (string): 2-100 caracteres
- `background` (string): 2-255 caracteres
- `strength` (integer): 1-20
- `dexterity` (integer): 1-20
- `constitution` (integer): 1-20
- `intelligence` (integer): 1-20
- `wisdom` (integer): 1-20
- `charisma` (integer): 1-20

**Campos opcionales:**
- `appliedModifiers` (string): máximo 500 caracteres, nullable

**Response (201 Created):**
```json
{
  "data": {
    "id": 2,
    "userId": 1,
    "system": "dnd",
    "playerName": "María López",
    "characterName": "Elara Moonwhisper",
    "race": "Elf",
    "class": "Wizard",
    "background": "Scholar",
    "attributes": {
      "strength": 8,
      "dexterity": 14,
      "constitution": 12,
      "intelligence": 18,
      "wisdom": 15,
      "charisma": 13
    },
    "appliedModifiers": "+1 Intelligence",
    "createdAt": "2025-02-10T16:45:00Z",
    "updatedAt": "2025-02-10T16:45:00Z"
  }
}
```

---

### 4. Actualizar un Personaje
**PUT/PATCH** `/characters/{id}`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Body (JSON)** - Solo enviar los campos a modificar:
```json
{
  "strength": 19,
  "characterName": "Elara the Powerful"
}
```

**Response (200 OK):**
```json
{
  "data": {
    "id": 2,
    "userId": 1,
    "system": "dnd",
    "playerName": "María López",
    "characterName": "Elara the Powerful",
    "race": "Elf",
    "class": "Wizard",
    "background": "Scholar",
    "attributes": {
      "strength": 19,
      "dexterity": 14,
      "constitution": 12,
      "intelligence": 18,
      "wisdom": 15,
      "charisma": 13
    },
    "appliedModifiers": "+1 Intelligence",
    "createdAt": "2025-02-10T16:45:00Z",
    "updatedAt": "2025-02-10T17:00:00Z"
  }
}
```

---

### 5. Eliminar un Personaje
**DELETE** `/characters/{id}`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Response (204 No Content):**
```
[Cuerpo vacío]
```

---

## Códigos de Estado HTTP

| Código | Significado |
|--------|-------------|
| **200** | OK - Solicitud exitosa (GET, PUT, PATCH) |
| **201** | Created - Recurso creado exitosamente (POST) |
| **204** | No Content - Recurso eliminado exitosamente (DELETE) |
| **400** | Bad Request - Error en la solicitud |
| **401** | Unauthorized - Token inválido o no proporcionado |
| **403** | Forbidden - No tienes permiso para acceder a este recurso |
| **404** | Not Found - El personaje no existe |
| **422** | Unprocessable Entity - Error de validación |
| **500** | Internal Server Error - Error del servidor |

---

## Validación y Errores

### Ejemplo: Error de Validación (422)
```json
{
  "message": "The playerName field is required.",
  "errors": {
    "playerName": [
      "El nombre del jugador es obligatorio."
    ],
    "strength": [
      "La fuerza debe ser al menos 1.",
      "La fuerza no puede exceder 20."
    ]
  }
}
```

### Ejemplo: No Autorizado (401)
```json
{
  "message": "Unauthenticated."
}
```

### Ejemplo: Forbidden (403)
```json
{
  "message": "This action is unauthorized."
}
```

---

## Instrucciones para Pruebas Cruzadas

1. **Importa esta documentación en Thunder Client o Postman**
2. **Crea una variable de entorno:**
   - `baseUrl`: `http://localhost:8000/api/v1`
   - `token`: Tu token de API
   - `characterId`: ID de un personaje existente (lo obtendrás al crear uno)

3. **Pruebas recomendadas:**
   - ✅ Crear un personaje con datos válidos
   - ❌ Intentar crear un personaje sin campos obligatorios (debe fallar con 422)
   - ❌ Intentar crear un personaje con atributos fuera de rango (1-20)
   - ✅ Listar tus personajes
   - ✅ Obtener un personaje específico
   - ✅ Actualizar un campo del personaje
   - ❌ Intentar actualizar un personaje que no existe (404)
   - ❌ Intentar actualizar un personaje de otro usuario (403)
   - ✅ Eliminar un personaje
   - ❌ Intentar acceder sin token (401)

4. **Documenta tus hallazgos:**
   - ¿Los códigos HTTP son correctos?
   - ¿La estructura JSON es clara y profesional?
   - ¿Los mensajes de error son útiles?
   - ¿Funcionan todas las validaciones?

---

## Ejemplo de Uso con cURL

```bash
# Crear un personaje
curl -X POST http://localhost:8000/api/v1/characters \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "system": "dnd",
    "playerName": "Test Player",
    "characterName": "Test Character",
    "race": "Human",
    "class": "Rogue",
    "background": "Criminal",
    "strength": 10,
    "dexterity": 16,
    "constitution": 12,
    "intelligence": 14,
    "wisdom": 13,
    "charisma": 15
  }'

# Listar personajes
curl -X GET http://localhost:8000/api/v1/characters \
  -H "Authorization: Bearer YOUR_TOKEN"

# Obtener un personaje
curl -X GET http://localhost:8000/api/v1/characters/1 \
  -H "Authorization: Bearer YOUR_TOKEN"

# Actualizar un personaje
curl -X PATCH http://localhost:8000/api/v1/characters/1 \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"strength": 20}'

# Eliminar un personaje
curl -X DELETE http://localhost:8000/api/v1/characters/1 \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## Notas Importantes

- 🔒 **Seguridad**: Cada usuario solo puede ver, editar y eliminar sus propios personajes.
- 📦 **Transformación de datos**: Los campos `snake_case` de la base de datos se transforman a `camelCase` en los responses.
- ✨ **Atributos**: Los atributos (strength, dexterity, etc.) se agrupan bajo la clave `attributes` en el response.
- 🔄 **Sincronización**: Los campos `createdAt` y `updatedAt` utilizan formato ISO 8601.

---

**Desarrollado por:** Critical Dice Team  
**Fecha:** Febrero 2025  
**Versión API:** v1.0
