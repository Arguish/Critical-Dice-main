# 📖 Critical Dice API - Índice de Documentación

## 🎯 Comienza Aquí

1. **[README.md](README.md)** - Visión general del proyecto
2. **[API_QUICK_REFERENCE.md](API_QUICK_REFERENCE.md)** - Referencia rápida (2 minutos)

---

## 📚 Documentación de la API

### Para Usuarios Finales (Pruebas Cruzadas)
- **[COMO_CREAR_TOKEN.md](COMO_CREAR_TOKEN.md)** ← EMPEZAR AQUÍ
  - Cómo registrarse
  - Cómo crear un token API
  - Ejemplos de uso
  
- **[API_TESTING_CHECKLIST.md](API_TESTING_CHECKLIST.md)**
  - Checklist de pruebas completas
  - Casos de prueba exitosos y de error
  - Matriz de evaluación
  - Formato de reporte

- **[Critical_Dice_API_Postman.json](Critical_Dice_API_Postman.json)**
  - Colección lista para importar en Postman/Thunder Client
  - Tests automáticos
  - Variables de entorno pre-configuradas

### Para Desarrolladores
- **[API_DOCUMENTATION.md](API_DOCUMENTATION.md)**
  - Referencia técnica completa
  - Todos los endpoints detallados
  - Ejemplos cURL
  - Mensajes de error documentados
  - Notas de seguridad

- **[IMPLEMENTATION_SUMMARY.md](IMPLEMENTATION_SUMMARY.md)**
  - Resumen técnico de la implementación
  - Estructura de archivos creada
  - Características implementadas
  - Mejores prácticas aplicadas

---

## 🏗️ Estructura Técnica

### Controllers (API)
```
app/Http/Controllers/Api/V1/
└── CharacterController.php
    - index()    → GET /characters
    - show()     → GET /characters/{id}
    - store()    → POST /characters
    - update()   → PATCH /characters/{id}
    - destroy()  → DELETE /characters/{id}
```

### Form Requests (Validación)
```
app/Http/Requests/Api/V1/
├── StoreCharacterRequest.php
│   ├── authorize(): Verifica auth
│   └── rules(): Validaciones crear
└── UpdateCharacterRequest.php
    ├── authorize(): Verifica auth
    └── rules(): Validaciones parciales
```

### Resources (Transformación)
```
app/Http/Resources/
└── CharacterResource.php
    - Convierte snake_case → camelCase
    - Agrupa atributos
    - Formatea timestamps ISO 8601
```

### Policies (Autorización)
```
app/Policies/
└── CharacterPolicy.php
    - view(): Puedo ver?
    - update(): Puedo editar?
    - delete(): Puedo eliminar?
```

### Routes (Rutas)
```
routes/api.php
└── Prefijo v1/ con middleware auth:sanctum
    └── apiResource('characters', CharacterController)
```

---

## 🔌 Endpoints Rápidos

| Método | Ruta | Body | Response |
|--------|------|------|----------|
| **GET** | `/characters` | - | 200: Array de personajes |
| **GET** | `/characters/{id}` | - | 200: Un personaje / 404 |
| **POST** | `/characters` | JSON completo | 201: Personaje creado |
| **PATCH** | `/characters/{id}` | JSON parcial | 200: Actualizado / 422 |
| **DELETE** | `/characters/{id}` | - | 204: Sin contenido |

---

## 📋 Campos Disponibles

### Obligatorios (todos)
- `system`: dnd / pathfinder / other
- `playerName`: texto 2-100 caracteres
- `characterName`: texto 2-100 caracteres
- `race`: texto 2-100 caracteres
- `class`: texto 2-100 caracteres
- `background`: texto 2-255 caracteres
- `strength, dexterity, constitution, intelligence, wisdom, charisma`: 1-20 cada uno

### Opcional
- `appliedModifiers`: texto max 500 caracteres, puede ser null

---

## ✨ Validaciones

```json
// Error 422 - Validación Fallida
{
  "message": "The given data was invalid.",
  "errors": {
    "strength": ["La fuerza no puede exceder 20."],
    "playerName": ["El nombre del jugador es obligatorio."]
  }
}
```

---

## 🔐 Flujo de Seguridad

1. **Autenticación (401)**
   - Sin token → Unauthorized
   - Token inválido → Unauthorized

2. **Autorización (403)**
   - Intentar acceder a personaje ajeno → Forbidden
   - Solo se ven/editan/eliminan propios personajes

3. **Validación (422)**
   - Datos incompletos o inválidos
   - Mensajes descriptivos en español

4. **Códigos HTTP Semánticos**
   ```
   200 OK
   201 Created
   204 No Content
   400 Bad Request
   401 Unauthorized
   403 Forbidden
   404 Not Found
   422 Unprocessable Entity
   ```

---

## 🚀 Cómo Empezar (Pasos Rápidos)

### Paso 1: Registrarse
```
1. Ir a http://localhost:8000/register
2. Llenar formulario
3. Crear cuenta
```

### Paso 2: Crear Token
```
1. Ir a perfil
2. Buscar "API Tokens"
3. Crear nuevo token
4. Copiar (solo aparece una vez)
```

### Paso 3: Probar API
```bash
curl -H "Authorization: Bearer TOKEN" \
  http://localhost:8000/api/v1/characters
```

### Paso 4: Usar Postman (Opcional)
```
1. Importar: Critical_Dice_API_Postman.json
2. Configurar variable api_token
3. Ejecutar requests
```

---

## 🧪 Matrix de Pruebas

| Test | Endpoint | Método | Esperar |
|------|----------|--------|---------|
| Crear | /characters | POST | 201 |
| Listar | /characters | GET | 200 |
| Ver uno | /characters/1 | GET | 200 o 404 |
| Actualizar | /characters/1 | PATCH | 200 o 422 |
| Eliminar | /characters/1 | DELETE | 204 |
| Sin auth | /characters | GET | 401 |
| Ajeno | /characters/999 | GET | 403 |
| Inválido | /characters | POST | 422 |

---

## 📞 Soporte

Para dudas sobre:
- **API Usage** → Ver [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
- **Pruebas** → Ver [API_TESTING_CHECKLIST.md](API_TESTING_CHECKLIST.md)
- **Tokens** → Ver [COMO_CREAR_TOKEN.md](COMO_CREAR_TOKEN.md)
- **Implementación** → Ver [IMPLEMENTATION_SUMMARY.md](IMPLEMENTATION_SUMMARY.md)

---

## 📊 Archivos Clave

| Archivo | Ubicación | Propósito |
|---------|-----------|----------|
| CharacterController | `app/Http/Controllers/Api/V1/` | 5 métodos CRUD |
| CharacterResource | `app/Http/Resources/` | Transforma JSON |
| Store/UpdateRequest | `app/Http/Requests/Api/V1/` | Validaciones |
| CharacterPolicy | `app/Policies/` | Autorización |
| api.php | `routes/` | Rutas API |
| AppServiceProvider | `app/Providers/` | Regista policies |

---

## ⚡ Resumen de Ejecución

✅ **Implementado completo y listo para pruebas**

- [x] Estructura de carpetas creada
- [x] 5 métodos CRUD implementados
- [x] Validaciones robustas (422)
- [x] Transformación de datos (camelCase)
- [x] Autenticación Sanctum
- [x] Autorización Policies
- [x] Documentación completa (4 archivos)
- [x] Colección Postman
- [x] Checklist de pruebas
- [x] Guía de tokens
- [x] Códigos HTTP semánticos
- [x] Mensajes de error en español

---

**API Version:** 1.0  
**Status:** ✅ Ready for Cross-Testing  
**Last Updated:** February 2025
