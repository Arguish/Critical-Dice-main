<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registro | Critical Dice</title>
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-primary-900 text-gray-100 flex flex-col min-h-screen">
	<!-- Header -->
	<x-header />

	<!-- Contenido Principal -->
	<main class="flex-1 bg-gradient-to-b from-primary-900 to-primary-900 py-12">
		<div class="w-full max-w-md mx-auto px-4">
			<!-- Contenedor principal -->
			<div class="bg-primary-800 rounded-lg shadow-xl border border-accent-orange p-8">
				<!-- Header -->
				<div class="text-center mb-8">
					<h1 class="text-3xl font-bold text-accent-orange mb-2">Crear cuenta</h1>
					<p class="text-gray-400">Comienza tu aventura en Critical Dice</p>
				</div>

				<!-- Formulario -->
				<form method="POST" action="{{ url('/register') }}" class="space-y-5">
					@csrf

					<!-- Campo Nombre -->
					<div>
						<label for="name" class="block text-gray-300 font-semibold mb-2">Nombre</label>
						<input 
							id="name" 
							type="text" 
							name="name" 
							required 
							placeholder="Tu nombre"
							class="w-full px-4 py-2 bg-primary-700 text-white border border-primary-600 rounded-lg focus:outline-none focus:border-accent-orange focus:ring-1 focus:ring-accent-orange transition"
						>
					</div>

					<!-- Campo Email -->
					<div>
						<label for="email" class="block text-gray-300 font-semibold mb-2">Email</label>
						<input 
							id="email" 
							type="email" 
							name="email" 
							required 
							placeholder="correo@ejemplo.com"
							class="w-full px-4 py-2 bg-primary-700 text-white border border-primary-600 rounded-lg focus:outline-none focus:border-accent-orange focus:ring-1 focus:ring-accent-orange transition"
						>
					</div>

					<!-- Campo Contraseña -->
					<div>
						<label for="password" class="block text-gray-300 font-semibold mb-2">Contraseña</label>
						<input 
							id="password" 
							type="password" 
							name="password" 
							required 
							placeholder="Contraseña"
							class="w-full px-4 py-2 bg-primary-700 text-white border border-primary-600 rounded-lg focus:outline-none focus:border-accent-orange focus:ring-1 focus:ring-accent-orange transition"
						>
					</div>

					<!-- Selector de Perfil -->
					<div class="bg-primary-700 rounded-lg p-4 border border-primary-600">
						<p class="text-gray-300 font-semibold mb-4">¿Qué perfil quieres crear?</p>
						<div class="space-y-3">
							<label class="flex items-center cursor-pointer hover:text-accent-orange transition">
								<input 
									type="radio" 
									name="profile_type" 
									value="master" 
									required
									class="w-4 h-4 accent-accent-orange"
								>
								<span class="ml-3 text-gray-300">Master</span>
							</label>
							<label class="flex items-center cursor-pointer hover:text-accent-orange transition">
								<input 
									type="radio" 
									name="profile_type" 
									value="jugador" 
									required
									class="w-4 h-4 accent-accent-orange"
								>
								<span class="ml-3 text-gray-300">Jugador</span>
							</label>
						</div>
					</div>

					<!-- Botón Registrarse -->
					<button 
						type="submit"
						class="w-full bg-accent-orange hover:bg-accent-darkOrange text-white font-bold py-2 px-4 rounded-lg transition transform hover:scale-105"
					>
						Registrarse
					</button>
				</form>

				<!-- Link de regreso -->
				<div class="text-center mt-6">
					<a 
						href="{{ url('/') }}" 
						class="text-accent-orange hover:text-accent-lightOrange font-semibold text-sm transition"
					>
						← Volver al inicio
					</a>
				</div>
			</div>
		</div>
	</main>

	<!-- Footer -->
	<x-footer />
</body>
</html>
