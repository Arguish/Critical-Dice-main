# Guía: Cómo Crear un Token API en Critical Dice

Para hacer pruebas en la API, primero debes crear un token de autenticación. Sigue estos pasos:

## Paso 1: Registrarse / Iniciar Sesión
1. Ve a `http://localhost:8000/register`
2. Completa los campos:
   - **Name**: Tu nombre
   - **Email**: Tu correo
   - **Password**: Tu contraseña
   - **Confirm Password**: Confirma
3. Click en **Register**

*Si ya tienes cuenta, ve a `http://localhost:8000/login`*

## Paso 2: Acceder al Perfil
1. Une vez logueado, ve a tu **Perfil** (generalmente en la esquina superior derecha)
2. O ve a `http://localhost:8000/profile`

## Paso 3: Crear Token API
1. En tu perfil, busca la sección **API Tokens**
   - Nombre: "API Token Testing" (o el que prefieras)
   - Las capacidades sugeridas son:
     - `read` - Leer datos (GET)
     - `create` - Crear datos (POST)
     - `update` - Actualizar datos (PUT/PATCH)
     - `delete` - Eliminar datos (DELETE)
2. Click en **Create API Token**
3. **COPIA EL TOKEN** que aparece (solo se mostrará una vez)

## Paso 4: Usar el Token

### En Postman
1. Abre Postman
2. Importa la colección: `Critical_Dice_API_Postman.json`
3. En la pestaña **Variables**:
   - `api_token`: Pega tu token aquí
   - `base_url`: `http://localhost:8000/api/v1`
4. Listo, ya puedes hacer requests

### En Thunder Client
1. Abre Thunder Client
2. Crea una nueva request o importa la colección
3. En el header **Authorization**:
   ```
   Bearer {tu_token_aquí}
   ```
4. O en la sección **Auth**, selecciona **Bearer Token** y pega tu token

### Con cURL
```bash
curl -X GET http://localhost:8000/api/v1/characters \
  -H "Authorization: Bearer {tu_token_aquí}"
```

## Paso 5: Probar la Conexión

### Request Inicial
```
GET http://localhost:8000/api/v1/characters
Header: Authorization: Bearer {token}
```

**Respuesta esperada:**
```json
{
  "data": []
}
```

Si obtienes un array vacío `[]`, ¡tu token funciona! 🎉

---

## ⚠️ Notas Importantes

- **Seguridad**: No compartas tu token con nadie
- **Cambio de contraseña**: Si cambias tu contraseña, tendrás que crear un nuevo token
- **Token perdido**: Si pierdes el token, puedes crear uno nuevo (aparecerá nuevamente)
- **Revocación**: Puedes eliminar un token en cualquier momento desde tu perfil

---

## Troubleshooting

### "401 Unauthorized"
- ❌ Token no configurado
- ❌ Token expirado o revocado
- ❌ Header mal escrito
- ✅ Verifica: `Authorization: Bearer {token}` (con espacio después de Bearer)

### "403 Forbidden"
- ❌ Intentas acceder a un personaje de otro usuario
- ✅ Solo puedes ver/editar/eliminar tus propios personajes

### "422 Unprocessable Entity"
- ❌ Faltan campos obligatorios
- ❌ Atributos fuera de rango (1-20)
- ✅ Revisa el mensaje de error

---

**¡Ya estás listo para hacer pruebas!** 🚀
