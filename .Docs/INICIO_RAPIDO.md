# 🚀 Guía de Inicio Rápido - Para Otros Grupos

## 5 Minutos para Empezar

### 1️⃣ Registrarse (1 minuto)
1. Abre [http://localhost:8000/register](http://localhost:8000/register)
2. Completa e-mail y contraseña
3. Click en "Register"

### 2️⃣ Crear Token (1 minuto)
1. Ve a tu perfil (esquina superior derecha)
2. Busca "API Tokens"
3. Click "Create API Token"
4. Copia el token (solo aparece una vez) 📋

### 3️⃣ Copiar Token (30 segundos)
Guarda algo como:
```
Mi Token: sk_live_abc123def456ghi789
```

### 4️⃣ Descargar Postman (1 minuto)
Ve a archivo: **`Critical_Dice_API_Postman.json`**

### 5️⃣ Importar en Postman (1 minuto 30 segundos)
1. Abre Postman
2. Click **Import**
3. Selecciona el JSON
4. En Variables, pega tu token en `api_token`
5. ¡Listo! 🎉

---

## Ahora Prueba

```bash
# Clic en "List All Characters"
# Debería devolver 200 OK
```

---

## Crear un Personaje

```json
{
  "system": "dnd",
  "playerName": "Tu Nombre",
  "characterName": "Nombre Personaje",
  "race": "Human",
  "class": "Fighter",
  "background": "Soldier",
  "strength": 15,
  "dexterity": 14,
  "constitution": 13,
  "intelligence": 12,
  "wisdom": 11,
  "charisma": 10
}
```

**POST** → Click en "Create Character" → Envía

---

## Lo Básico

| Qué | URL |
|-----|-----|
| Listar | `GET /api/v1/characters` |
| Ver uno | `GET /api/v1/characters/1` |
| Crear | `POST /api/v1/characters` |
| Editar | `PATCH /api/v1/characters/1` |
| Borrar | `DELETE /api/v1/characters/1` |

---

## Respuestas Esperadas

**Éxito**: 200, 201, 204 ✅  
**Error**: 400, 401, 403, 404, 422 ❌

---

## ¿Si Algo Falla?

1. ¿Tienes token? → Ve a paso 2
2. ¿Token correcto? → Copia nuevamente
3. ¿Header Authorization? → Postman lo agrega automático
4. ¿Campos obligatorios? → Ver lista en JSON

---

## ¿Necesitas Más?

- 📖 **Referencia rápida:** [API_QUICK_REFERENCE.md](API_QUICK_REFERENCE.md)
- 📚 **Documentación completa:** [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
- 🧪 **Cosas para probar:** [API_TESTING_CHECKLIST.md](API_TESTING_CHECKLIST.md)
- 🔑 **Ayuda con tokens:** [COMO_CREAR_TOKEN.md](COMO_CREAR_TOKEN.md)

---

### 🎯 Eso es todo para empezar. ¡Adelante! 🚀
