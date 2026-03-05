<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Critical Dice - El mundo de la fantasía y el rol</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-primary-900 text-gray-100 flex flex-col min-h-screen overflow-x-hidden">
    <!-- Header -->
    <x-header />

    <!-- Contenido Principal -->
    <main class="flex-1 bg-gradient-to-b from-primary-900 to-primary-900">
        <div class="max-w-6xl mx-auto px-4 py-12">
            <!-- Sección de Título y Descripción -->
            <section class="text-center mb-12">
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-4">
                    Critical Dice
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto">
                    Bienvenido al mundo de la fantasía, el rol y la aventura. Únete a nuestra comunidad de jugadores y maestros.
                </p>
            </section>

            <!-- Carrusel de Imágenes (Reducido) -->
            <section class="w-full max-w-4xl mx-auto">
                <div x-data="carousel()" class="relative w-full rounded-lg overflow-hidden shadow-xl border-2 border-accent-orange">
                    <!-- Contenedor de imágenes -->
                    <div class="relative w-full h-96 md:h-96">
                        <template x-for="(image, index) in images" :key="index">
                            <div
                                x-show="currentSlide === index"
                                class="absolute inset-0 transition-opacity duration-1000"
                                :class="currentSlide === index ? 'opacity-100' : 'opacity-0'">
                                <img
                                    :src="image.url"
                                    :alt="image.alt"
                                    class="w-full h-full object-cover">
                            </div>
                        </template>
                    </div>

                    <!-- Controles del carrusel -->
                    <button
                        @click="prev()"
                        class="absolute left-3 top-1/2 -translate-y-1/2 z-20 bg-black bg-opacity-60 hover:bg-opacity-80 text-white p-2 rounded-full transition"
                        aria-label="Imagen anterior">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button
                        @click="next()"
                        class="absolute right-3 top-1/2 -translate-y-1/2 z-20 bg-black bg-opacity-60 hover:bg-opacity-80 text-white p-2 rounded-full transition"
                        aria-label="Siguiente imagen">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>

                    <!-- Indicadores (dots) -->
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex gap-2">
                        <template x-for="(image, index) in images" :key="index">
                            <button
                                @click="currentSlide = index"
                                class="w-2 h-2 rounded-full transition"
                                :class="currentSlide === index ? 'bg-accent-orange w-6' : 'bg-gray-400 hover:bg-gray-300'"
                                :aria-label="`Ir a imagen ${index + 1}`"></button>
                        </template>
                    </div>

                    <!-- Auto-play -->
                    <div x-init="restartAutoplay()"></div>
                </div>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <x-footer />

    <script>
        // Carrusel con Alpine.js
        function carousel() {
            return {
                currentSlide: 0,
                autoplayInterval: null,
                images: [{
                        url: 'https://images.unsplash.com/photo-1696197819145-dbcf7e97cbdc?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=870',
                        alt: 'Dados'
                    },
                    {
                        url: 'https://plus.unsplash.com/premium_photo-1695781234402-0ce670b89d82?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=1032',
                        alt: 'Mamzmorra'
                    },
                    {
                        url: 'https://images8.alphacoders.com/137/thumb-1920-1371384.jpeg',
                        alt: 'Dragón'
                    },
                    {
                        url: 'https://i.pinimg.com/1200x/fb/72/c6/fb72c6c30b5cb8f6bcef9ea9fe9d840a.jpg',
                        alt: 'Batalla épica'
                    },
                    {
                        url: 'https://wallpapers.com/images/hd/dungeons-and-dragons-heroes-camping-lc8g36d5b1fxn4ka.jpg',
                        alt: 'Mundo de fantasía'
                    }
                ],
                restartAutoplay() {
                    clearInterval(this.autoplayInterval);
                    this.autoplayInterval = setInterval(() => this.next(), 3000);
                },
                next() {
                    this.currentSlide = (this.currentSlide + 1) % this.images.length;
                    this.restartAutoplay();
                },
                prev() {
                    this.currentSlide = (this.currentSlide - 1 + this.images.length) % this.images.length;
                    this.restartAutoplay();
                }
            };
        }
    </script>
</body>

</html>