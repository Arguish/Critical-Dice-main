<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Registro Exitoso | Critical Dice</title>
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

        .success-icon {
            width: 80px;
            height: 80px;
            background: #111;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem
        }

        .success-icon svg {
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

        p {
            margin: 0 0 1.5rem;
            color: #555;
            line-height: 1.6
        }

        .user-info {
            background: #f7f7f7;
            padding: 1.25rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            text-align: left;
            border: 1px solid #e0e0e0
        }

        .user-info p {
            margin: 0.5rem 0;
            color: #333;
            font-size: 0.95rem
        }

        .user-info strong {
            color: #111
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
        <div class="success-icon">
            <svg viewBox="0 0 52 52">
                <polyline points="14 27 22 35 38 19" />
            </svg>
        </div>

        <h1>¡Registro Exitoso!</h1>
        <p>Tu cuenta ha sido creada correctamente. Ya puedes empezar a disfrutar de Critical Dice.</p>

        @if(session('user_data'))
        <div class="user-info">
            <p><strong>Nombre:</strong> {{ session('user_data')['name'] }}</p>
            <p><strong>Email:</strong> {{ session('user_data')['email'] }}</p>
            <p><strong>Tipo de perfil:</strong> {{ ucfirst(session('user_data')['profile_type']) }}</p>
        </div>
        @endif

        <div class="button-group">
            <a href="/" class="btn btn-primary">Ir al Dashboard</a>
            <a href="/register" class="btn btn-secondary">Registrar Otro Usuario</a>
        </div>
    </div>
</body>

</html>