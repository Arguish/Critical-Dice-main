# Critical Dice API - Quick Reference 📋

## 🎯 Endpoints

```
Base URL: http://localhost:8000/api/v1
Auth: Authorization: Bearer {token}
```

| Método | Endpoint | Descripción | Respuesta |
|--------|----------|-------------|----------|
| **GET** | /characters | Listar tus personajes | 200 |
| **POST** | /characters | Crear uno nuevo | 201 |
| **GET** | /characters/{id} | Ver uno específico | 200 / 404 |
| **PATCH** | /characters/{id} | Actualizar uno | 200 / 422 |
| **DELETE** | /characters/{id} | Eliminar uno | 204 |

---

## 📦 Create / Update Body

```json
{
  "system": "dnd",              // Obligatorio: dnd|pathfinder|other
  "playerName": "Tu Nombre",    // Obligatorio: 2-100
  "characterName": "Nombre",    // Obligatorio: 2-100
  "race": "Raza",               // Obligatorio: 2-100
  "class": "Clase",             // Obligatorio: 2-100
  "background": "Trasfondo",    // Obligatorio: 2-255
  "strength": 15,               // Obligatorio: 1-20
  "dexterity": 14,              // Obligatorio: 1-20
  "constitution": 13,           // Obligatorio: 1-20
  "intelligence": 12,           // Obligatorio: 1-20
  "wisdom": 11,                 // Obligatorio: 1-20
  "charisma": 10,               // Obligatorio: 1-20
  "appliedModifiers": "+2 Con"  // Opcional: max 500
}
```

---

## 📤 Response Format

```json
{
  "data": {
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
    "appliedModifiers": "+2 Con",
    "createdAt": "2025-02-10T15:30:00Z",
    "updatedAt": "2025-02-10T15:30:00Z"
  }
}
```

---

## ⚠️ Error Response

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "strength": ["La fuerza no puede exceder 20."]
  }
}
```

---

## 🔑 HTTP Codes

| Código | Significado |
|--------|------------|
| **200** | OK ✅ |
| **201** | Created ✅ |
| **204** | No Content (Delete) ✅ |
| **400** | Bad Request ❌ |
| **401** | Unauthorized (sin token) ❌ |
| **403** | Forbidden (no es tuyo) ❌ |
| **404** | Not Found ❌ |
| **422** | Validation Error ❌ |

---

## 💡 Ejemplos Rápidos

### listar
```bash
curl -H "Authorization: Bearer TOKEN" \
  http://localhost:8000/api/v1/characters
```

### Crear
```bash
curl -X POST http://localhost:8000/api/v1/characters \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "system":"dnd",
    "playerName":"Test",
    "characterName":"Hero",
    "race":"Human",
    "class":"Fighter",
    "background":"Soldier",
    "strength":15,"dexterity":14,"constitution":13,
    "intelligence":12,"wisdom":11,"charisma":10
  }'
```

### Actualizar
```bash
curl -X PATCH http://localhost:8000/api/v1/characters/1 \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"strength":18}'
```

### Eliminar
```bash
curl -X DELETE http://localhost:8000/api/v1/characters/1 \
  -H "Authorization: Bearer TOKEN"
```

---

## 🔐 Security Rules

- ✅ Solo tú ves tus personajes
- ✅ Solo tú puedes editar los tuyos
- ✅ Solo tú puedes eliminar los tuyos
- ❌ Sin token → 401
- ❌ Token ajeno → 403

---

## 📚 Full Docs

- **API_DOCUMENTATION.md** - Referencia completa
- **API_TESTING_CHECKLIST.md** - Guía de pruebas
- **COMO_CREAR_TOKEN.md** - Crear credenciales
- **IMPLEMENTATION_SUMMARY.md** - Resumen técnico

---

**API v1.0** | Feb 2025
