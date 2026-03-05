# Inicialización del Proyecto - Critical Dice

## Setup Rápido

```bash
# Instalar dependencias
composer install
npm install

# Configurar entorno
cp .env.example .env
# Editar .env con credenciales de BD

# Generar key
php artisan key:generate

# Base de datos
# Crear BD: critical_dice en MySQL/MariaDB
php artisan migrate --seed

# Iniciar desarrollo
php artisan dev
```

## Usuarios de Prueba

| Email                  | Password | Rol   |
| ---------------------- | -------- | ----- |
| admin@criticaldice.com | password | Admin |
| user@criticaldice.com  | password | User  |

## Comandos Útiles

```bash
# Resetear BD
php artisan migrate:fresh --seed

# Limpiar caché
php artisan optimize:clear

# Ver rutas
php artisan route:list
```

---

**Laravel 12.0** | **PHP 8.2+**
