<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Error en Registro | Critical Dice</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f7f7f7;
            color: #111;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem
        }

        .container {
            text-align: center;
            padding: 2.5rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            max-width: 520px;
            width: 90%
        }

        .error-icon {
            width: 80px;
            height: 80px;
            background: #111;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem
        }

        .error-icon svg {
            width: 40px;
            height: 40px;
            stroke: #fff;
            stroke-width: 3;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none
        }

        h1 {
            margin: 0 0 0.5rem;
            font-size: 2rem;
            color: #111
        }

        .error-message {
            margin: 0 0 1.5rem;
            color: #555;
            line-height: 1.6
        }

        .error-details {
            background: #f7f7f7;
            border-left: 4px solid #111;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
            text-align: left
        }

        .error-details p {
            color: #333;
            font-size: 0.9rem;
            margin: 0.3rem 0
        }

        .button-group {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 1.5rem
        }

        .btn {
            padding: 0.6rem 1.25rem;
            font-size: 0.95rem;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s ease;
            font-weight: 500
        }

        .btn-primary {
            background: #111;
            color: #fff;
            border: 1px solid #111
        }

        .btn-primary:hover {
            background: #333
        }

        .btn-secondary {
            background: #fff;
            color: #333;
            border: 1px solid #ccc
        }

        .btn-secondary:hover {
            background: #f7f7f7
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="error-icon">
            <svg viewBox="0 0 52 52">
                <line x1="16" y1="16" x2="36" y2="36" />
                <line x1="36" y1="16" x2="16" y2="36" />
            </svg>
        </div>

        <h1>¡Ups! Algo salió mal</h1>
        <p class="error-message">No pudimos completar tu registro. Por favor, revisa los datos e intenta nuevamente.</p>

        @if(session('error'))
        <div class="error-details">
            <p><strong>Detalles del error:</strong></p>
            <p>{{ session('error') }}</p>
        </div>
        @endif

        @if(session('errors'))
        <div class="error-details">
            <p><strong>Errores de validación:</strong></p>
            @foreach(session('errors') as $error)
            <p>• {{ $error }}</p>
            @endforeach
        </div>
        @endif

        <div class="button-group">
            <a href="/register" class="btn btn-primary">Intentar de Nuevo</a>
            <a href="/" class="btn btn-secondary">Volver al Inicio</a>
        </div>
    </div>
</body>

</html>