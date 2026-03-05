<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selector de Juego - Critical Dice</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-primary-900 text-gray-100 flex flex-col min-h-screen">
    <!-- Header -->
    <x-header />

    <!-- Contenido Principal -->
    <main class="flex-1">
        <div class="max-w-6xl mx-auto px-4 py-12">
            <!-- Título -->
            <section class="text-center mb-12">
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-4">
                    Crear Personaje
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto">
                    Selecciona el sistema de juego para crear tu personaje
                </p>
            </section>

            <!-- Selectores de Juego -->
            <section class="max-w-4xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Opción D&D 5e -->
                    <div class="bg-primary-800 border-2 border-accent-orange rounded-lg p-8 hover:shadow-lg hover:shadow-accent-orange transition cursor-pointer transform hover:scale-105"
                         onclick="selectGame('dnd')">
                        <div class="text-center">
                            <h2 class="text-3xl font-bold text-accent-orange mb-4">
                                Dungeons & Dragons 5e
                            </h2>
                            <p class="text-gray-300 mb-6">
                                El sistema más popular de rol. Crea un héroe y vive aventuras épicas en mundos de fantasía.
                            </p>
                            <div class="space-y-2 mb-6">
                                <p class="text-sm text-gray-400">✓ 9 Razas disponibles</p>
                                <p class="text-sm text-gray-400">✓ 12 Clases disponibles</p>
                                <p class="text-sm text-gray-400">✓ 14 Trasfondos disponibles</p>
                                <p class="text-sm text-gray-400">✓ Sistema de estadísticas completo</p>
                            </div>
                            <button class="w-full bg-accent-orange hover:bg-accent-darkOrange text-white font-bold py-3 rounded-lg transition">
                                Crear en D&D 5e
                            </button>
                        </div>
                    </div>

                    <!-- Opción Futura -->
                    <div class="bg-primary-800 border-2 border-gray-600 rounded-lg p-8 opacity-50 cursor-not-allowed">
                        <div class="text-center">
                            <h2 class="text-3xl font-bold text-gray-500 mb-4">
                                Próximamente
                            </h2>
                            <p class="text-gray-400 mb-6">
                                Más sistemas de juego estarán disponibles pronto.
                            </p>
                            <div class="space-y-2 mb-6">
                                <p class="text-sm text-gray-500">🔒 Pathfinder</p>
                                <p class="text-sm text-gray-500">🔒 Warhammer RPG</p>
                                <p class="text-sm text-gray-500">🔒 Call of Cthulhu</p>
                                <p class="text-sm text-gray-500">🔒 Y más...</p>
                            </div>
                            <button class="w-full bg-gray-600 text-gray-400 font-bold py-3 rounded-lg cursor-not-allowed">
                                Próximamente
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Botón Volver -->
            <section class="text-center mt-12">
                <a href="{{ url('/') }}" class="inline-block px-6 py-3 bg-primary-700 hover:bg-primary-600 text-gray-300 font-semibold rounded-lg transition border border-gray-600">
                    ← Volver al Inicio
                </a>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <x-footer />

    <script>
        function selectGame(game) {
            window.location.href = `/character/form?game=${game}`;
        }
    </script>
</body>
</html>
