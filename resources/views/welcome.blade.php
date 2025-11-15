<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cocktail Manager - Inicio</title>
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

        .hero-section {
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 2rem 0;
        }

        .hero-title {
            font-size: clamp(2.5rem, 5vw, 3.5rem);
            font-weight: 700;
            background: linear-gradient(135deg, var(--neon-primary), var(--neon-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: clamp(1rem, 2vw, 1.2rem);
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 2.5rem;
            line-height: 1.6;
        }

        .cta-button {
            background: linear-gradient(135deg, var(--neon-primary), var(--neon-secondary));
            border: none;
            color: #000;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            font-size: 1rem;
            margin: 0.5rem 0.5rem 0.5rem 0;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 234, 255, 0.4);
            color: #000;
        }

        .cta-button.outline {
            background: transparent;
            border: 2px solid var(--neon-primary);
            color: white;
        }

        .feature-card {
            background: var(--card-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 2rem 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
            margin-bottom: 1.5rem;
        }

        .feature-card:hover {
            border-color: var(--neon-primary);
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: clamp(2.5rem, 5vw, 3rem);
            background: linear-gradient(135deg, var(--neon-primary), var(--neon-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1.5rem;
        }

        .feature-card h4 {
            font-size: 1.25rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .feature-card p {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
            margin: 0;
        }

        .hero-image {
            max-height: 400px;
            width: auto;
            object-fit: contain;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-section {
                min-height: auto;
                padding: 4rem 0 2rem;
                text-align: center;
            }

            .hero-title {
                margin-bottom: 1rem;
            }

            .hero-subtitle {
                margin-bottom: 2rem;
            }

            .cta-button {
                display: block;
                width: 100%;
                max-width: 300px;
                margin: 0.5rem auto;
            }

            .cta-buttons {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .feature-card {
                padding: 1.5rem 1rem;
                margin-bottom: 1rem;
            }

            .hero-image {
                max-height: 300px;
                margin-top: 2rem;
            }
        }

        @media (max-width: 576px) {
            .hero-section {
                padding: 3rem 0 1rem;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .feature-card {
                padding: 1.25rem 0.75rem;
            }

            .feature-icon {
                font-size: 2.5rem;
            }

            .feature-card h4 {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 400px) {
            .cta-button {
                padding: 10px 20px;
                font-size: 0.9rem;
            }

            .hero-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>
    <div class="neon-glow"></div>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 order-2 order-lg-1">
                    <h1 class="hero-title">Descubre el Arte de los Cócteles</h1>
                    <p class="hero-subtitle">
                        Explora cientos de recetas, crea tus propias mezclas y comparte
                        tus creaciones con la comunidad de mixólogos.
                    </p>
                    <div class="cta-buttons">
                        <a href="/login" class="cta-button">
                            <i class="bi bi-cup-straw me-2"></i>Explorar Cócteles
                        </a>
                        <a href="/register" class="cta-button outline">
                            <i class="bi bi-person-plus me-2"></i>Unirse
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 text-center">
                    <img src="build/assets/images/cocktel.png" alt="Cóctel premium" class="img-fluid hero-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="hero-title">¿Por Qué Elegirnos?</h2>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-collection"></i>
                        </div>
                        <h4>Recetas Ilimitadas</h4>
                        <p>Accede a miles de recetas de cócteles de todo el mundo, desde clásicos hasta creaciones
                            innovadoras.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <h4>Tutoriales en Video</h4>
                        <p>Aprende técnicas profesionales con nuestros tutoriales paso a paso guiados por expertos
                            mixólogos.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h4>Comunidad Activa</h4>
                        <p>Comparte tus creaciones, recibe feedback y conecta con amantes de los cócteles de todo el
                            mundo.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
