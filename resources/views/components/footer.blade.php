<footer class="bg-primary-900 border-t-2 border-accent-orange mt-12">
    <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <div>
                <h3 class="text-accent-orange font-bold text-lg mb-4">Critical Dice</h3>
                <p class="text-gray-400 text-sm">
                    La plataforma definitiva para jugadores de rol. Crea, comparte y vive aventuras épicas.
                </p>
            </div>

            <div>
                <h3 class="text-accent-orange font-bold text-lg mb-4">Enlaces</h3>
                <ul class="space-y-2 text-sm">
                    <li>
                        <a href="{{ url('/') }}" class="text-gray-400 hover:text-accent-orange transition">
                            Inicio
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/character') }}" class="text-gray-400 hover:text-accent-orange transition">
                            Crear Personaje
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/register') }}" class="text-gray-400 hover:text-accent-orange transition">
                            Registrarse
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="text-accent-orange font-bold text-lg mb-4">Síguenos</h3>
                <div class="flex gap-4">
                    <a href="#" class="text-gray-400 hover:text-accent-orange transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-accent-orange transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 002.856-3.51 10 10 0 01-2.856.956 5 5 0 002.19-2.75 10 10 0 01-3.19 1.22 5 5 0 10-8.54 4.56 14 14 0 01-10.19-5.15 5 5 0 001.54 6.67 5 5 0 01-2.26-.62v.06a5 5 0 004.01 4.9 5 5 0 01-2.25.09 5 5 0 004.67 3.47 10 10 0 01-6.2 2.14 14 14 0 0010.18 2.94c12.22 0 18.88-10.14 18.88-18.92 0-.28 0-.56-.02-.84a13.4 13.4 0 003.28-3.42z"></path>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-accent-orange transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.633 7.997c.013.175.013.349.013.523 0 5.325-4.053 11.461-11.46 11.461-2.282 0-4.402-.661-6.186-1.809.324.037.636.05.973.05a8.07 8.07 0 005.001-1.729 4.032 4.032 0 01-3.757-2.794c.194.037.469.061.745.061.229 0 .456-.029.674-.087a4.025 4.025 0 01-3.23-3.953v-.05c.537.299 1.159.486 1.821.511a4.022 4.022 0 01-1.796-3.354c0-.748.199-1.434.548-2.032a11.457 11.457 0 008.306 4.21c-.062-.3-.1-.611-.1-.923a4.026 4.026 0 014.028-4.028c1.16 0 2.207.486 2.943 1.272a7.957 7.957 0 002.556-.973 4.02 4.02 0 01-1.771 2.22 8.073 8.073 0 002.319-.624 8.645 8.645 0 01-2.019 2.083z"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-primary-700 pt-8">
            <p class="text-center text-gray-500 text-sm">
                &copy; 2025 Critical Dice. Todos los derechos reservados. | Política de Privacidad | Términos de Servicio
            </p>
        </div>
    </div>
</footer>
