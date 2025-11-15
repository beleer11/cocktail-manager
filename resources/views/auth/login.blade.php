<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cocktail Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="build/assets/images/cocktel.png">
    <style>
        :root {
            --neon-primary: #00eaff;
            --neon-secondary: #ff0080;
            --dark-bg: #0a0a0a;
            --card-bg: rgba(15, 15, 20, 0.9);
        }

        body {
            background: var(--dark-bg);
            color: #ffffff;
            font-family: 'Instrument Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .neon-glow {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
            opacity: 0.1;
        }

        .neon-glow::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, var(--neon-primary) 0%, transparent 70%);
            animation: pulse-glow 8s ease-in-out infinite alternate;
        }

        .neon-glow::after {
            content: '';
            position: absolute;
            bottom: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, var(--neon-secondary) 0%, transparent 70%);
            animation: pulse-glow 10s ease-in-out infinite alternate-reverse;
        }

        @keyframes pulse-glow {
            0% {
                opacity: 0.05;
                transform: scale(1);
            }

            100% {
                opacity: 0.15;
                transform: scale(1.1);
            }
        }

        .login-container {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            padding: 2rem;
        }

        .login-card {
            background: var(--card-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 2.5rem 2rem;
            backdrop-filter: blur(10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .login-title {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--neon-primary), var(--neon-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            color: #ffffff;
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-input {
            width: 100%;
            background: rgba(20, 20, 30, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 12px 16px;
            color: #ffffff;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--neon-primary);
            box-shadow: 0 0 0 2px rgba(0, 234, 255, 0.2);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .remember-checkbox {
            width: 18px;
            height: 18px;
            background: rgba(20, 20, 30, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            margin-right: 8px;
            cursor: pointer;
        }

        .remember-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--neon-primary), var(--neon-secondary));
            border: none;
            color: #000;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 234, 255, 0.4);
            color: #000;
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid var(--neon-primary);
            color: var(--neon-primary);
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-secondary:hover {
            background: rgba(0, 234, 255, 0.1);
            color: var(--neon-primary);
            transform: translateY(-2px);
        }

        .forgot-password {
            color: var(--neon-primary);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: var(--neon-secondary);
            text-decoration: underline;
        }

        .error-message {
            color: #ff4444;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        .back-button {
            position: absolute;
            top: 2rem;
            left: 2rem;
            color: var(--neon-primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            color: var(--neon-secondary);
            transform: translateX(-5px);
        }

        @media (max-width: 768px) {
            .login-container {
                padding: 1rem;
            }

            .login-card {
                padding: 2rem 1.5rem;
            }

            .back-button {
                top: 1rem;
                left: 1rem;
            }
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 1.5rem 1rem;
            }

            .login-title {
                font-size: 1.75rem;
            }
        }
    </style>
</head>

<body>
    <div class="neon-glow"></div>
    <a href="{{ url('/') }}" class="back-button">
        <i class="bi bi-arrow-left"></i>
        <span>Volver al Inicio</span>
    </a>
    <div class="login-container">
        <div class="login-card">
            <h1 class="login-title">Iniciar Sesión</h1>
            <p class="login-subtitle">Accede a tu cuenta de Cocktail Manager</p>

            @if (session('status'))
                <div class="alert alert-success mb-3">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}"
                        required autofocus autocomplete="username">
                    @if ($errors->has('email'))
                        <div class="error-message">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <input id="password" class="form-input" type="password" name="password" required
                        autocomplete="current-password">
                    @if ($errors->has('password'))
                        <div class="error-message">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>

                <div class="remember-me">
                    <input id="remember_me" type="checkbox" class="remember-checkbox" name="remember">
                    <label for="remember_me" class="remember-label">Recordarme</label>
                </div>

                @if (Route::has('password.request'))
                    <div class="text-center mb-3">
                        <a class="forgot-password" href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                @endif

                <button type="submit" class="btn-primary">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                </button>

                <a href="{{ url('/') }}" class="btn-secondary">
                    <i class="bi bi-house me-2"></i>Volver al Inicio
                </a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
