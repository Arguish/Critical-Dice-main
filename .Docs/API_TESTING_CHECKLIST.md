# Critical Dice API - Guía Rápida para Pruebas Cruzadas

## 🎯 Objetivo
Validar que la API REST de Critical Dice funcione correctamente en operaciones CRUD para la entidad **Character** (Personaje).

---

## 📋 Checklist de Pruebas

### Configuración Inicial
- [ ] Registra una cuenta en la aplicación web
- [ ] Crea un token API desde tu perfil (API Tokens)
- [ ] Descarga la colección Postman: `Critical_Dice_API_Postman.json`
- [ ] Importa en Postman/Thunder Client
- [ ] Configura la variable `api_token` con tu token

### Pruebas Funcionales - CRUD Completo

#### 1. **CREATE (POST)** - Crear un Personaje
**Endpoint:** `POST /api/v1/characters`

```json
{
  "system": "dnd",
  "playerName": "Tu Nombre",
  "characterName": "Nombre del Personaje",
  "race": "Raza",
  "class": "Clase",
  "background": "Trasfondo",
  "strength": 15,
  "dexterity": 14,
  "constitution": 13,
  "intelligence": 12,
  "wisdom": 11,
  "charisma": 10
}
```

**Validar:**
- [ ] Status Code: **201 Created** ✅
- [ ] Response contiene `data` con los campos transformados (camelCase)
- [ ] El `id` se genera automáticamente
- [ ] Los `attributes` están agrupados correctamente
- [ ] Los timestamps están en ISO 8601

---

#### 2. **READ (GET)** - Listar Personajes
**Endpoint:** `GET /api/v1/characters`

**Validar:**
- [ ] Status Code: **200 OK** ✅
- [ ] Response es un array de personajes
- [ ] Solo contiene personajes del usuario autenticado
- [ ] Puedes ver todos los que creaste

---

#### 3. **READ (GET)** - Obtener un Personaje Específico
**Endpoint:** `GET /api/v1/characters/{id}`

**Validar:**
- [ ] Status Code: **200 OK** ✅
- [ ] Devuelve un único personaje
- [ ] La estructura es idéntica a los del listado

---

#### 4. **UPDATE (PUT/PATCH)** - Actualizar un Personaje
**Endpoint:** `PATCH /api/v1/characters/{id}`

```json
{
  "strength": 18,
  "characterName": "Nuevo Nombre"
}
```

**Validar:**
- [ ] Status Code: **200 OK** ✅
- [ ] Los campos se actualizan correctamente
- [ ] Los campos no enviados se mantienen igual
- [ ] El `updatedAt` se actualiza
- [ ] El `createdAt` permanece igual

---

#### 5. **DELETE** - Eliminar un Personaje
**Endpoint:** `DELETE /api/v1/characters/{id}`

**Validar:**
- [ ] Status Code: **204 No Content** ✅
- [ ] El body de la respuesta está vacío
- [ ] El personaje no aparece al listar después

---

### Pruebas de Validación (Deben Fallar con 422)

**Test 1: Campo Obligatorio Faltante**
```json
{
  "playerName": "Test",
  "characterName": "Test"
  // Faltan los demás campos
}
```
- [ ] Status: **422** ✅
- [ ] `errors` contiene las validaciones fallidas
- [ ] Los mensajes están en español

**Test 2: Atributo Fuera de Rango**
```json
{
  "system": "dnd",
  "playerName": "Test",
  "characterName": "Test",
  "race": "Elf",
  "class": "Wizard",
  "background": "Scholar",
  "strength": 25,      // Máx es 20 ❌
  "dexterity": 0,      // Mín es 1 ❌
  "constitution": 14,
  "intelligence": 18,
  "wisdom": 15,
  "charisma": 13
}
```
- [ ] Status: **422** ✅
- [ ] Errores específicos para `strength` y `dexterity`

**Test 3: Sistema Inválido**
```json
{
  "system": "unknown",  // Solo permite: dnd, pathfinder, other
  ...resto de campos válidos
}
```
- [ ] Status: **422** ✅

**Test 4: Texto Muy Corto**
```json
{
  "playerName": "A",    // Mínimo 2
  ...resto de campos
}
```
- [ ] Status: **422** ✅

---

### Pruebas de Seguridad

#### Test 1: Sin Token (Autenticación)
**Endpoint:** `GET /api/v1/characters`
Sin header `Authorization`

- [ ] Status: **401 Unauthorized** ✅
- [ ] Mensaje: "Unauthenticated."

#### Test 2: Token Inválido
**Header:** `Authorization: Bearer invalid_token_123`

- [ ] Status: **401 Unauthorized** ✅

#### Test 3: Acceso a Personaje de Otro Usuario
Si logras el ID de un personaje de otro usuario:
**Endpoint:** `GET /api/v1/characters/{otro_usuario_id}`

- [ ] Status: **403 Forbidden** ✅
- [ ] Mensaje: "This action is unauthorized."

#### Test 4: Actualizar Personaje de Otro Usuario
**Endpoint:** `PATCH /api/v1/characters/{otro_usuario_id}`

- [ ] Status: **403 Forbidden** ✅

#### Test 5: Eliminar Personaje que No Existe
**Endpoint:** `DELETE /api/v1/characters/99999`

- [ ] Status: **404 Not Found** ✅

---

## 📊 Estructura de Response Esperada

### Listado (200 OK)
```json
{
  "data": [
    {
      "id": 1,
      "userId": 1,
      "system": "dnd",
      "playerName": "Juan",
      "characterName": "Thorin",
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

### Error de Validación (422 Unprocessable Entity)
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "strength": [
      "La fuerza no puede exceder 20."
    ],
    "playerName": [
      "El nombre del jugador es obligatorio."
    ]
  }
}
```

---

## 🔄 Flujo Completo de Prueba Recomendado

1. **Crea un personaje** → Guarda el ID
2. **Lista todos los personajes** → Verifica que aparezca
3. **Obtén el personaje específico** → Verifica detalles
4. **Actualiza algunos campos** → Verifica cambios
5. **Intenta validaciones inválidas** → Verifica errores 422
6. **Intenta acceso sin token** → Verifica error 401
7. **Elimina el personaje** → Verifica 204 y que desaparezca del listado

---

## 📝 Notas Importantes

| Aspecto | Detalles |
|---------|----------|
| **Autenticación** | Bearer Token (Sanctum) |
| **Content-Type** | application/json |
| **Transformación** | snake_case → camelCase |
| **Atributos** | 1-20 (obligatorio) |
| **Strings** | Longitud validada |
| **Timestamps** | ISO 8601 (createdAt, updatedAt) |
| **Propiedad** | Solo tu usuario puede ver/editar/eliminar sus personajes |

---

## ❓ Preguntas para Evaluar

1. ¿Los códigos HTTP son correctos en todos los casos?
2. ¿La estructura JSON es clara y profesional?
3. ¿Los errores de validación son específicos y útiles?
4. ¿Los mensajes de error están bien escritos (español)?
5. ¿La agrupación de atributos es lógica?
6. ¿La seguridad funciona correctamente (no puedes acceder a personajes ajenos)?

---

## 🐛 Reporte de Errores

Si encuentras problemas, documenta:

```
- Endpoint probado: [GET/POST/PATCH/DELETE] /api/v1/characters/...
- Status Code esperado vs recibido: 
- Request body (si aplica):
- Response recibida:
- Descripción del error:
```

---

**Desarrollado por:** Critical Dice Team  
**Fecha:** Febrero 2025  
**Versión:** 1.0
