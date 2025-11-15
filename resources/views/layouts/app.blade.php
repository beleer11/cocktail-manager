<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Gestión de Cócteles</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    {{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        body {
            background: #f5f6fa;
        }

        .navbar {
            background: #0d6efd !important;
        }

        .card {
            border-radius: 12px;
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- NAV --}}
    <nav class="navbar navbar-dark px-4">
        <span class="navbar-brand">Cocktail Manager</span>

        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-light btn-sm">Cerrar sesión</button>
            </form>
        @endauth
    </nav>

    {{-- CONTENT --}}
    <div class="container py-4">
        @yield('content')
    </div>

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    @stack('scripts')
</body>

</html>
