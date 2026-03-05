<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Personajes - Critical Dice</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-primary-900 text-gray-100 flex flex-col min-h-screen">
    <x-header />

    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <section class="text-center mb-12">
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-4">
                    Mis Personajes
                </h1>
                <p class="text-lg text-gray-300">
                    Visualiza todos tus personajes creados
                </p>
            </section>

            @if (empty($characters))
                <div class="text-center bg-primary-800 border-2 border-accent-orange rounded-lg p-12">
                    <p class="text-gray-400 text-lg mb-6">
                        Aún no has creado ningún personaje.
                    </p>
                    <a href="{{ url('/character') }}" class="inline-block px-6 py-3 bg-accent-orange hover:bg-accent-darkOrange text-white font-bold rounded-lg transition">
                        Crear Mi Primer Personaje
                    </a>
                </div>
            @else
                <div class="bg-primary-800 border-2 border-accent-orange rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-primary-700 border-b-2 border-accent-orange">
                                    <th class="px-6 py-4 text-left font-semibold text-accent-orange">Personaje</th>
                                    <th class="px-6 py-4 text-left font-semibold text-accent-orange">Jugador</th>
                                    <th class="px-6 py-4 text-left font-semibold text-accent-orange">Género</th>
                                    <th class="px-6 py-4 text-left font-semibold text-accent-orange">Raza</th>
                                    <th class="px-6 py-4 text-left font-semibold text-accent-orange">Clase</th>
                                    <th class="px-6 py-4 text-left font-semibold text-accent-orange">Trasfondo</th>
                                    <th class="px-6 py-4 text-center font-semibold text-accent-orange">Nivel</th>
                                    <th class="px-6 py-4 text-center font-semibold text-accent-orange">Estadísticas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($characters as $character)
                                    <tr class="border-b border-primary-600 hover:bg-primary-700 transition">
                                        <td class="px-6 py-4 font-semibold text-white">{{ $character['name'] }}</td>
                                        <td class="px-6 py-4 text-gray-300">{{ $character['player_name'] }}</td>
                                        <td class="px-6 py-4 text-gray-300">{{ ucfirst($character['gender']) }}</td>
                                        <td class="px-6 py-4 text-gray-300">{{ $character['race'] }}</td>
                                        <td class="px-6 py-4 text-gray-300">{{ $character['class'] }}</td>
                                        <td class="px-6 py-4 text-gray-300">{{ $character['background'] }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-block px-3 py-1 bg-accent-orange text-white font-bold rounded-lg">
                                                {{ $character['level'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <button onclick="showStats({{ json_encode($character) }})" class="px-4 py-2 bg-primary-600 hover:bg-primary-500 text-accent-orange font-semibold rounded-lg transition border border-accent-orange">
                                                Ver
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-8 text-center">
                    <a href="{{ url('/character') }}" class="inline-block px-6 py-3 bg-accent-orange hover:bg-accent-darkOrange text-white font-bold rounded-lg transition">
                        Crear Nuevo Personaje
                    </a>
                </div>
            @endif
        </div>
    </main>

    <div id="statsModal" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4">
        <div class="bg-primary-800 rounded-lg shadow-xl max-w-md w-full p-8 border-2 border-accent-orange">
            <h2 id="modalTitle" class="text-2xl font-bold text-accent-orange mb-6">Estadísticas</h2>
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="text-center p-3 bg-primary-700 rounded-lg">
                    <p class="text-gray-500 text-sm mb-1">FUE</p>
                    <p id="statFUE" class="text-2xl font-bold text-accent-orange">--</p>
                </div>
                <div class="text-center p-3 bg-primary-700 rounded-lg">
                    <p class="text-gray-500 text-sm mb-1">DES</p>
                    <p id="statDES" class="text-2xl font-bold text-accent-orange">--</p>
                </div>
                <div class="text-center p-3 bg-primary-700 rounded-lg">
                    <p class="text-gray-500 text-sm mb-1">CON</p>
                    <p id="statCON" class="text-2xl font-bold text-accent-orange">--</p>
                </div>
                <div class="text-center p-3 bg-primary-700 rounded-lg">
                    <p class="text-gray-500 text-sm mb-1">INT</p>
                    <p id="statINT" class="text-2xl font-bold text-accent-orange">--</p>
                </div>
                <div class="text-center p-3 bg-primary-700 rounded-lg">
                    <p class="text-gray-500 text-sm mb-1">SAB</p>
                    <p id="statSAB" class="text-2xl font-bold text-accent-orange">--</p>
                </div>
                <div class="text-center p-3 bg-primary-700 rounded-lg">
                    <p class="text-gray-500 text-sm mb-1">CAR</p>
                    <p id="statCAR" class="text-2xl font-bold text-accent-orange">--</p>
                </div>
            </div>
            <button onclick="closeStats()" class="w-full bg-accent-orange hover:bg-accent-darkOrange text-white font-bold py-2 rounded-lg transition">
                Cerrar
            </button>
        </div>
    </div>

    <x-footer />

    <script>
        function showStats(character) {
            document.getElementById('modalTitle').textContent = `Estadísticas - ${character.name}`;
            document.getElementById('statFUE').textContent = character.strength;
            document.getElementById('statDES').textContent = character.dexterity;
            document.getElementById('statCON').textContent = character.constitution;
            document.getElementById('statINT').textContent = character.intelligence;
            document.getElementById('statSAB').textContent = character.wisdom;
            document.getElementById('statCAR').textContent = character.charisma;
            document.getElementById('statsModal').classList.remove('hidden');
        }

        function closeStats() {
            document.getElementById('statsModal').classList.add('hidden');
        }

        document.getElementById('statsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeStats();
            }
        });
    </script>
</body>
</html>
