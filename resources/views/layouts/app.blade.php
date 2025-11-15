<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cocktail Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="icon" type="image/png" href="build/assets/images/cocktel.png">

    <style>
        body {
            font-family: "Inter", sans-serif;
            background: radial-gradient(circle at top, #1a1a1a, #0d0d0d);
            color: #fff;
            overflow-x: hidden;
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            background: #0c0f16;
            border-right: 2px solid rgba(0, 255, 255, 0.15);
            padding: 20px 0;
            color: white;
            transition: all 0.3s ease;
            z-index: 1000;
            backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
            transform: translateX(0);
        }

        .sidebar.collapsed {
            width: 80px;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .sidebar.mobile-open {
                transform: translateX(0);
                box-shadow: 10px 0 30px rgba(0, 0, 0, 0.5);
            }

            .sidebar.collapsed {
                width: 280px;
                transform: translateX(-100%);
            }

            .sidebar.collapsed.mobile-open {
                transform: translateX(0);
            }

            .content {
                margin-left: 0 !important;
                padding: 20px;
            }

            .content.collapsed {
                margin-left: 0 !important;
            }

            .mobile-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.7);
                backdrop-filter: blur(5px);
                z-index: 999;
            }

            .mobile-overlay.active {
                display: block;
            }

            .mobile-menu-btn {
                display: block !important;
                position: fixed;
                top: 20px;
                left: 20px;
                z-index: 1001;
                background: #00eaff;
                color: #000;
                border: none;
                border-radius: 8px;
                padding: 10px 12px;
                font-size: 1.2rem;
                box-shadow: 0 0 15px rgba(0, 234, 255, 0.5);
                transition: all 0.3s ease;
            }

            .mobile-menu-btn:hover {
                transform: scale(1.1);
            }

            .sidebar.mobile-open .toggle-btn {
                display: none;
            }

            .sidebar .toggle-btn {
                display: block;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .sidebar {
                width: 220px;
            }

            .sidebar.collapsed {
                width: 70px;
            }

            .content {
                margin-left: 220px;
                padding: 30px;
            }

            .content.collapsed {
                margin-left: 70px;
            }
        }

        @media (min-width: 1025px) {
            .mobile-menu-btn {
                display: none !important;
            }

            .mobile-overlay {
                display: none !important;
            }
        }

        .sidebar .brand {
            font-size: 1.5rem;
            font-weight: 700;
            padding: 0 25px;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #00eaff;
            text-shadow: 0 0 8px #00eaff;
        }

        .sidebar .menu-content {
            flex: 1;
        }

        .sidebar .menu-item {
            padding: 14px 25px;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 14px;
            color: #c8e6ff;
            cursor: pointer;
            transition: 0.25s ease;
            text-decoration: none;
            position: relative;
        }

        .sidebar .menu-item:hover {
            background: rgba(0, 255, 255, 0.12);
            color: #00eaff;
            padding-left: 35px;
        }

        .sidebar .menu-item.active {
            background: rgba(0, 255, 255, 0.2);
            color: #00eaff;
            border-right: 3px solid #00eaff;
        }

        .sidebar .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: #00eaff;
            box-shadow: 0 0 10px #00eaff;
        }

        .sidebar.collapsed .menu-text {
            display: none;
        }

        .toggle-btn {
            position: absolute;
            right: -15px;
            top: 25px;
            background: #00eaff;
            color: #000;
            border-radius: 50%;
            padding: 7px 10px;
            cursor: pointer;
            border: 3px solid #0c0f16;
            box-shadow: 0 0 12px #00eaff;
            transition: 0.3s ease;
        }

        .toggle-btn:hover {
            transform: scale(1.1);
        }

        .content {
            margin-left: 260px;
            padding: 40px;
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        .content.collapsed {
            margin-left: 80px;
        }

        .logout-section {
            margin-top: auto;
            padding: 20px;
            border-top: 1px solid rgba(0, 255, 255, 0.1);
        }

        .logout-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.15);
            border: none;
            color: #fff;
            transition: 0.2s;
            border-radius: 8px;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
        }

        .sidebar.collapsed .logout-btn span {
            display: none;
        }

        .sidebar,
        .content {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mobile-close-btn {
            display: none;
            position: absolute;
            top: 20px;
            right: 20px;
            background: none;
            border: none;
            color: #00eaff;
            font-size: 1.5rem;
            cursor: pointer;
            z-index: 1002;
        }

        @media (max-width: 768px) {
            .mobile-close-btn {
                display: block;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <div id="sidebar" class="sidebar">
        <button class="mobile-close-btn" id="mobileCloseBtn">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="menu-content">
            <div class="brand">
                <i class="bi bi-cup-straw"></i>
                <span class="menu-text">Cocktail Bar</span>
            </div>

            <a href="{{ route('cocktails.api') }}"
                class="menu-item {{ request()->routeIs('cocktails.api') ? 'active' : '' }}">
                <i class="bi bi-list-stars"></i>
                <span class="menu-text">Cócteles API</span>
            </a>

            <a href="{{ route('cocktails.stored') }}"
                class="menu-item {{ request()->routeIs('cocktails.stored') ? 'active' : '' }}">
                <i class="bi bi-collection"></i>
                <span class="menu-text">Guardados</span>
            </a>
        </div>

        @auth
            <div class="logout-section">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Cerrar sesión</span>
                    </button>
                </form>
            </div>
        @endauth

        <div class="toggle-btn mobileMenuBtn" id="toggleSidebar">
            <i class="bi bi-chevron-left"></i>
        </div>
    </div>

    <div id="content" class="content">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            const sidebar = $("#sidebar");
            const content = $("#content");
            const mobileMenuBtn = $(".mobileMenuBtn");
            const mobileCloseBtn = $("#mobileCloseBtn");
            const mobileOverlay = $("#mobileOverlay");
            const toggleBtn = $("#toggleSidebar");

            toggleBtn.on("click", function() {
                if (window.innerWidth > 768) {
                    sidebar.toggleClass("collapsed");
                    content.toggleClass("collapsed");
                    $(this).find("i").toggleClass("bi-chevron-left bi-chevron-right");
                }
            });

            mobileMenuBtn.on("click", function() {
                sidebar.addClass("mobile-open");
                mobileOverlay.addClass("active");
                $('body').css('overflow', 'hidden');
            });

            function closeMobileSidebar() {
                sidebar.removeClass("mobile-open");
                mobileOverlay.removeClass("active");
                $('body').css('overflow', 'auto');
            }

            mobileCloseBtn.on("click", closeMobileSidebar);
            mobileOverlay.on("click", closeMobileSidebar);

            $('.menu-item').on('click', function() {
                if (window.innerWidth <= 768) {
                    closeMobileSidebar();
                }
            });

            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeMobileSidebar();
                }
            });

            $(window).on('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.removeClass("mobile-open");
                    mobileOverlay.removeClass("active");
                    $('body').css('overflow', 'auto');

                    toggleBtn.show();
                } else {
                    if (!sidebar.hasClass("mobile-open")) {
                        sidebar.removeClass("collapsed");
                        content.removeClass("collapsed");
                    }
                }
            });

            if (window.innerWidth <= 768) {
                sidebar.removeClass("collapsed");
                content.removeClass("collapsed");
            }
        });
    </script>

    @stack('scripts')

</body>

</html>
