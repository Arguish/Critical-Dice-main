<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $sessionKeys  La(s) clave(s) de sesión que debe(n) existir (separadas por |)
     * @param  string  $redirectRoute  Ruta a la que redirigir si falla (por defecto '/register')
     */
    public function handle(Request $request, Closure $next, string $sessionKeys = 'user_data', string $redirectRoute = '/register'): Response
    {
        // Si estamos en modo diseño, permitir acceso directo
        if (env('DESIGN_MODE', false) || env('SKIP_SESSION_VALIDATIONS', false)) {
            return $next($request);
        }

        // Soportar múltiples claves separadas por |
        $keys = explode('|', $sessionKeys);

        // Verificar si existe al menos una de las claves
        $hasAnyKey = false;
        foreach ($keys as $key) {
            if (session()->has(trim($key))) {
                $hasAnyKey = true;
                break;
            }
        }

        if (!$hasAnyKey) {
            return redirect($redirectRoute);
        }

        return $next($request);
    }
}
