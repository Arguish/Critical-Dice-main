<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Personaje Creado! - Critical Dice</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-primary-900 text-gray-100 flex flex-col min-h-screen">
    <!-- Header -->
    <x-header />

    <!-- Contenido Principal -->
    <main class="flex-1">
        <div class="max-w-2xl mx-auto px-4 py-12">
            <!-- Mensaje de Éxito -->
            <section class="text-center mb-12">
                <div class="inline-block mb-8">
                    <svg class="w-24 h-24 text-accent-orange" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                    </svg>
                </div>
                <h1 class="text-5xl md:text-6xl font-bold text-accent-orange mb-4">
                    ¡Personaje Creado!
                </h1>
                <p class="text-xl text-gray-300 mb-8">
                    Tu personaje ha sido registrado exitosamente en el sistema.
                </p>
            </section>

            <!-- Información del Personaje -->
            @if (session('character_data'))
                <div class="bg-primary-800 border-2 border-accent-orange rounded-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-accent-orange mb-6">
                        Detalles de tu Personaje
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Información Básica -->
                        <div class="space-y-3">
                            <h3 class="text-lg font-semibold text-gray-300 mb-4">Información Básica</h3>
                            <div>
                                <p class="text-gray-500 text-sm">Nombre del Personaje</p>
                                <p class="text-white font-semibold">{{ session('character_data')['name'] }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">Nombre del Jugador</p>
                                <p class="text-white font-semibold">{{ session('character_data')['player_name'] }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">Género</p>
                                <p class="text-white font-semibold">{{ session('character_data')['gender'] }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">Nivel</p>
                                <p class="text-white font-semibold">{{ session('character_data')['level'] }}</p>
                            </div>
                        </div>

                        <!-- Características -->
                        <div class="space-y-3">
                            <h3 class="text-lg font-semibold text-gray-300 mb-4">Características</h3>
                            <div>
                                <p class="text-gray-500 text-sm">Raza</p>
                                <p class="text-white font-semibold">{{ session('character_data')['race'] }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">Clase</p>
                                <p class="text-white font-semibold">{{ session('character_data')['class'] }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">Trasfondo</p>
                                <p class="text-white font-semibold">{{ session('character_data')['background'] }}</p>
                            </div>
                        </div>

                        <!-- Estadísticas -->
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-semibold text-gray-300 mb-4">Estadísticas de Atributos</h3>
                            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                                <div class="text-center">
                                    <p class="text-gray-500 text-xs mb-2">FUE</p>
                                    <p class="text-2xl font-bold text-accent-orange">{{ session('character_data')['strength'] }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-gray-500 text-xs mb-2">DES</p>
                                    <p class="text-2xl font-bold text-accent-orange">{{ session('character_data')['dexterity'] }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-gray-500 text-xs mb-2">CON</p>
                                    <p class="text-2xl font-bold text-accent-orange">{{ session('character_data')['constitution'] }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-gray-500 text-xs mb-2">INT</p>
                                    <p class="text-2xl font-bold text-accent-orange">{{ session('character_data')['intelligence'] }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-gray-500 text-xs mb-2">SAB</p>
                                    <p class="text-2xl font-bold text-accent-orange">{{ session('character_data')['wisdom'] }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-gray-500 text-xs mb-2">CAR</p>
                                    <p class="text-2xl font-bold text-accent-orange">{{ session('character_data')['charisma'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Botones de Acción -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a
                    href="{{ url('/') }}"
                    class="flex-1 text-center bg-accent-orange hover:bg-accent-darkOrange text-white font-bold py-3 px-4 rounded-lg transition"
                >
                    Volver al Inicio
                </a>
                <a
                    href="{{ url('/character') }}"
                    class="flex-1 text-center bg-primary-700 hover:bg-primary-600 text-gray-300 font-bold py-3 px-4 rounded-lg transition border border-gray-600"
                >
                    Crear Otro Personaje
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <x-footer />
</body>
</html>
