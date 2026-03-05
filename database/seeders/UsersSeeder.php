<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear o actualizar usuario administrador
        User::updateOrCreate(
            ['email' => 'admin@criticaldice.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        // Crear o actualizar usuario normal
        User::updateOrCreate(
            ['email' => 'user@criticaldice.com'],
            [
                'name' => 'Usuario Normal',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );

        // Crear algunos usuarios adicionales para pruebas
        User::updateOrCreate(
            ['email' => 'elena@criticaldice.com'],
            [
                'name' => 'Elena Martínez',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'carlos@criticaldice.com'],
            [
                'name' => 'Carlos Ruiz',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'maria@criticaldice.com'],
            [
                'name' => 'María López',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );
    }
}
