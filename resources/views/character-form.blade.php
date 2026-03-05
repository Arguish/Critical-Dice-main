<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Personaje - Critical Dice</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/character-creator.js'])
</head>

<body class="bg-primary-900 text-gray-100 flex flex-col min-h-screen">
    <!-- Header -->
    <x-header />

    <!-- Contenido Principal -->
    <main class="flex-1">
        <div class="max-w-2xl mx-auto px-4 py-12">
            <!-- Título -->
            <section class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-2">
                    Crear Personaje
                </h1>
                <p class="text-lg text-gray-300">
                    Dungeons & Dragons 5e
                </p>
            </section>

            @if ($errors->any())
            <div class="bg-red-900 border-2 border-red-600 rounded-lg p-6 mb-8">
                <h3 class="text-red-300 font-bold mb-4">Errores en el formulario:</h3>
                <ul class="space-y-2">
                    @foreach ($errors->all() as $error)
                    <li class="text-red-200 text-sm">• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Formulario de Personaje -->
            <form method="POST" action="{{ url('/character/create') }}" class="bg-primary-800 border-2 border-accent-orange rounded-lg p-8 space-y-6">
                @csrf

                <!-- Campo Oculto: Juego -->
                <input type="hidden" name="game" value="{{ $game }}">

                <!-- Sección: Información Básica -->
                <fieldset class="space-y-4">
                    <legend class="text-xl font-bold text-accent-orange mb-4">Información Básica</legend>

                    <!-- Nombre del Jugador (PRIMERO) -->
                    <div>
                        <label for="player_name" class="block text-gray-300 font-semibold mb-2">
                            Nombre del Jugador *
                        </label>
                        <input
                            id="player_name"
                            type="text"
                            name="player_name"
                            required
                            value="{{ old('player_name') }}"
                            placeholder="Tu nombre"
                            class="w-full px-4 py-3 bg-primary-700 text-white border-2 border-primary-600 rounded-lg focus:outline-none focus:border-accent-orange focus:ring-1 focus:ring-accent-orange">
                        <p class="text-gray-400 text-xs mt-1 italic">💡 Si dejas vacío el nombre del personaje, se generará uno automáticamente basado en tu nombre</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nombre del Personaje -->
                        <div>
                            <label for="name" class="block text-gray-300 font-semibold mb-2">
                                Nombre del Personaje *
                            </label>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                required
                                value="{{ old('name') }}"
                                placeholder="Se generará automáticamente..."
                                class="w-full px-4 py-3 bg-primary-700 text-white border-2 border-primary-600 rounded-lg focus:outline-none focus:border-accent-orange focus:ring-1 focus:ring-accent-orange">
                        </div>

                        <!-- Género -->
                        <div>
                            <label for="gender" class="block text-gray-300 font-semibold mb-2">
                                Género *
                            </label>
                            <select
                                id="gender"
                                name="gender"
                                required
                                value="{{ old('gender') }}"
                                class="w-full px-4 py-3 bg-primary-700 text-white border-2 border-primary-600 rounded-lg focus:outline-none focus:border-accent-orange focus:ring-1 focus:ring-accent-orange">
                                <option value="">-- Selecciona un género --</option>
                                <option value="masculino" @selected(old('gender')==='masculino' )>Masculino</option>
                                <option value="femenino" @selected(old('gender')==='femenino' )>Femenino</option>
                                <option value="otro" @selected(old('gender')==='otro' )>Otro</option>
                            </select>
                        </div>
                    </div>
                </fieldset>

                <!-- Sección: Raza, Clase y Trasfondo -->
                <fieldset class="space-y-4">
                    <legend class="text-xl font-bold text-accent-orange mb-4">Características del Personaje</legend>

                    <div id="race-art" class="border border-primary-600 rounded-lg bg-primary-900/50 p-4">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-semibold text-gray-200">Arte de criatura</h3>
                            <span id="race-art-status" class="text-xs text-gray-400">Selecciona una raza para ver arte</span>
                        </div>
                        <div class="aspect-[5/3] w-full overflow-hidden rounded-md bg-primary-700">
                            <img
                                id="race-art-image"
                                src=""
                                alt=""
                                class="h-full w-full object-cover opacity-0 transition-opacity duration-300" />
                        </div>
                        <p id="race-art-caption" class="mt-2 text-xs text-gray-400"></p>
                    </div>

                    <!-- Raza -->
                    <div>
                        <label for="race" class="block text-gray-300 font-semibold mb-2">
                            Raza *
                        </label>
                        <select
                            id="race"
                            name="race"
                            required
                            value="{{ old('race') }}"
                            class="w-full px-4 py-3 bg-primary-700 text-white border-2 border-primary-600 rounded-lg focus:outline-none focus:border-accent-orange focus:ring-1 focus:ring-accent-orange">
                            <option value="">-- Selecciona una raza --</option>
                            @foreach ($gameOptions['races'] as $key => $label)
                            <option value="{{ $key }}" @selected(old('race')===$key)>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Clase -->
                    <div>
                        <label for="class" class="block text-gray-300 font-semibold mb-2">
                            Clase *
                        </label>
                        <select
                            id="class"
                            name="class"
                            required
                            value="{{ old('class') }}"
                            class="w-full px-4 py-3 bg-primary-700 text-white border-2 border-primary-600 rounded-lg focus:outline-none focus:border-accent-orange focus:ring-1 focus:ring-accent-orange">
                            <option value="">-- Selecciona una clase --</option>
                            @foreach ($gameOptions['classes'] as $key => $label)
                            <option value="{{ $key }}" @selected(old('class')===$key)>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Trasfondo -->
                    <div>
                        <label for="background" class="block text-gray-300 font-semibold mb-2">
                            Trasfondo *
                        </label>
                        <select
                            id="background"
                            name="background"
                            required
                            value="{{ old('background') }}"
                            class="w-full px-4 py-3 bg-primary-700 text-white border-2 border-primary-600 rounded-lg focus:outline-none focus:border-accent-orange focus:ring-1 focus:ring-accent-orange">
                            <option value="">-- Selecciona un trasfondo --</option>
                            @foreach ($gameOptions['backgrounds'] as $key => $label)
                            <option value="{{ $key }}" @selected(old('background')===$key)>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nivel -->
                    <div>
                        <label for="level" class="block text-gray-300 font-semibold mb-2">
                            Nivel (1-20) *
                        </label>
                        <input
                            id="level"
                            type="number"
                            name="level"
                            required
                            value="{{ old('level', 1) }}"
                            min="1"
                            max="20"
                            class="w-full px-4 py-3 bg-primary-700 text-white border-2 border-primary-600 rounded-lg focus:outline-none focus:border-accent-orange focus:ring-1 focus:ring-accent-orange">
                    </div>
                </fieldset>

                <!-- Sección: Estadísticas de Atributos (D&D 5e) -->
                <fieldset class="space-y-4">
                    <legend class="text-xl font-bold text-accent-orange mb-4">
                        Estadísticas de Atributos (3-20)
                    </legend>
                    <p class="text-gray-400 text-sm mb-4">
                        Ingresa los valores de tus atributos base. Los bonificadores raciales se aplicarán automáticamente al seleccionar tu raza.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Fuerza -->
                        <div>
                            <label for="strength" class="block text-gray-300 font-semibold mb-2">
                                Fuerza *
                            </label>
                            <input
                                id="strength"
                                type="number"
                                name="strength"
                                required
                                value="{{ old('strength', 10) }}"
                                min="3"
                                max="20"
                                class="w-full px-4 py-3 bg-primary-700 text-white border-2 border-primary-600 rounded-lg focus:outline-none focus:border-accent-orange focus:ring-1 focus:ring-accent-orange">
                        </div>

                        <!-- Destreza -->
                        <div>
                            <label for="dexterity" class="block text-gray-300 font-semibold mb-2">
                                Destreza *
                            </label>
                            <input
                                id="dexterity"
                                type="number"
                                name="dexterity"
                                required
                                value="{{ old('dexterity', 10) }}"
                                min="3"
                                max="20"
                                class="w-full px-4 py-3 bg-primary-700 text-white border-2 border-primary-600 rounded-lg focus:outline-none focus:border-accent-orange focus:ring-1 focus:ring-accent-orange">
                        </div>

                        <!-- Constitución -->
                        <div>
                            <label for="constitution" class="block text-gray-300 font-semibold mb-2">
                                Constitución *
                            </label>
                            <input
                                id="constitution"
                                type="number"
                                name="constitution"
                                required
                                value="{{ old('constitution', 10) }}"
                                min="3"
                                max="20"
                                class="w-full px-4 py-3 bg-primary-700 text-white border-2 border-primary-600 rounded-lg focus:outline-none focus:border-accent-orange focus:ring-1 focus:ring-accent-orange">
                        </div>

                        <!-- Inteligencia -->
                        <div>
                            <label for="intelligence" class="block text-gray-300 font-semibold mb-2">
                                Inteligencia *
                            </label>
                            <input
                                id="intelligence"
                                type="number"
                                name="intelligence"
                                required
                                value="{{ old('intelligence', 10) }}"
                                min="3"
                                max="20"
                                class="w-full px-4 py-3 bg-primary-700 text-white border-2 border-primary-600 rounded-lg focus:outline-none focus:border-accent-orange focus:ring-1 focus:ring-accent-orange">
                        </div>

                        <!-- Sabiduría -->
                        <div>
                            <label for="wisdom" class="block text-gray-300 font-semibold mb-2">
                                Sabiduría *
                            </label>
                            <input
                                id="wisdom"
                                type="number"
                                name="wisdom"
                                required
                                value="{{ old('wisdom', 10) }}"
                                min="3"
                                max="20"
                                class="w-full px-4 py-3 bg-primary-700 text-white border-2 border-primary-600 rounded-lg focus:outline-none focus:border-accent-orange focus:ring-1 focus:ring-accent-orange">
                        </div>

                        <!-- Carisma -->
                        <div>
                            <label for="charisma" class="block text-gray-300 font-semibold mb-2">
                                Carisma *
                            </label>
                            <input
                                id="charisma"
                                type="number"
                                name="charisma"
                                required
                                value="{{ old('charisma', 10) }}"
                                min="3"
                                max="20"
                                class="w-full px-4 py-3 bg-primary-700 text-white border-2 border-primary-600 rounded-lg focus:outline-none focus:border-accent-orange focus:ring-1 focus:ring-accent-orange">
                        </div>
                    </div>
                </fieldset>

                <!-- Botones de Acción -->
                <div class="flex gap-4 pt-6">
                    <button
                        type="submit"
                        class="flex-1 bg-accent-orange hover:bg-accent-darkOrange text-white font-bold py-3 px-4 rounded-lg transition">
                        Crear Personaje
                    </button>
                    <a
                        href="{{ url('/character') }}"
                        class="flex-1 text-center bg-primary-700 hover:bg-primary-600 text-gray-300 font-bold py-3 px-4 rounded-lg transition border border-gray-600">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <x-footer />
</body>

</html>