<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-primary-800 border-2 border-accent-orange overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold text-white mb-4">
                    ¡Bienvenido, {{ Auth::user()->name }}!
                </h3>

                <p class="text-gray-300 mb-6">
                    Estás autenticado correctamente con Jetstream. Aquí puedes gestionar tus personajes y perfil.
                </p>

                <div class="grid md:grid-cols-2 gap-6">
                    <a href="{{ route('character.selector') }}" class="block p-6 bg-accent-orange hover:bg-accent-darkOrange text-white rounded-lg shadow-lg transition">
                        <h4 class="text-xl font-bold mb-2">Crear Personaje</h4>
                        <p class="text-orange-100">Crea un nuevo personaje para tus aventuras</p>
                    </a>

                    <a href="{{ route('characters.index') }}" class="block p-6 bg-primary-700 hover:bg-primary-600 border-2 border-accent-orange text-white rounded-lg shadow-lg transition">
                        <h4 class="text-xl font-bold mb-2">Mis Personajes</h4>
                        <p class="text-gray-300">Ver y gestionar tus personajes creados</p>
                    </a>

                    <a href="{{ route('profile.show') }}" class="block p-6 bg-primary-700 hover:bg-primary-600 border-2 border-accent-orange text-white rounded-lg shadow-lg transition">
                        <h4 class="text-xl font-bold mb-2">Mi Perfil</h4>
                        <p class="text-gray-300">Edita tu información personal</p>
                    </a>

                    <div class="block p-6 bg-primary-700 border-2 border-gray-600 rounded-lg shadow-lg">
                        <h4 class="text-xl font-bold mb-2 text-white">Estado de la cuenta</h4>
                        <p class="text-gray-300">Email: <span class="font-semibold text-accent-orange">{{ Auth::user()->email }}</span></p>
                        <p class="text-gray-300">Miembro desde: <span class="font-semibold text-accent-orange">{{ Auth::user()->created_at->format('d/m/Y') }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>