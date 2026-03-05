<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        // Validar datos
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'password' => 'required|string|min:6',
                'profile_type' => 'required|in:master,jugador',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Redirigir a página de error con los errores de validación
            return redirect('/register/error')
                ->with('errors', $e->validator->errors()->all());
        }

        // Preparar línea CSV
        $line = sprintf(
            "\"%s\";\"%s\";\"%s\";\"%s\"\n",
            str_replace('"', '""', $data['name']),
            str_replace('"', '""', $data['email']),
            str_replace('"', '""', bcrypt($data['password'])), // opcional: cifrar contraseña
            str_replace('"', '""', $data['profile_type'])
        );

        // Guardar en storage/app/private/registrations.csv usando el Storage facade
        try {
            $dir = 'private';
            $path = $dir . '/registrations.csv';

            // Asegurar que exista el directorio
            if (!Storage::disk('local')->exists($dir)) {
                Storage::disk('local')->makeDirectory($dir);
            }

            // Añadir línea (Storage::append crea el archivo si no existe)
            Storage::disk('local')->append($path, rtrim($line, "\n"));

            // Redirigir a página de éxito con los datos del usuario
            return redirect('/register/success')
                ->with('user_data', [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'profile_type' => $data['profile_type']
                ]);
        } catch (\Exception $e) {
            // Registrar el error y redirigir a página de error
            Log::error('Error al guardar CSV de usuarios: ' . $e->getMessage());
            return redirect('/register/error')
                ->with('error', 'No se pudo guardar la información. Error técnico: ' . $e->getMessage());
        }
    }

    public function success()
    {
        // El middleware ya verificó la sesión
        return view('register-success');
    }

    public function error()
    {
        // El middleware ya verificó la sesión
        return view('register-error');
    }
}
