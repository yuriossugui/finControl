<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'finControl')</title>

    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">

    {{-- Bootstrap (importado via laravel/ui) --}}
    @vite('resources/sass/app.scss')

    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: row;
        }

        .sidebar {
            min-width: 250px;
            max-width: 250px;
            background-color: #343a40;
            color: white;
            transition: all 0.3s;
        }

        .sidebar a {
            color: #adb5bd;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background-color: #495057;
            color: #fff;
        }

        .content {
            flex-grow: 1;
            background-color: #f8f9fa;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                height: 100%;
                z-index: 999;
                left: -250px;
            }

            .sidebar.active {
                left: 0;
            }

            .content {
                padding-top: 60px;
            }
        }

        .toggle-btn {
            display: none;
            position: absolute;
            top: 15px;
            left: 15px;
            background-color: #343a40;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
        }

        .sidebar ion-icon {
            font-size: 1.5em;
            margin-right: 0.5em;
        }

        @media (max-width: 768px) {
            .toggle-btn {
                display: block;
            }
        }
    </style>
</head>
<body>
    @auth
        {{-- Botão de abrir/fechar sidebar (mobile) --}}
        <button class="toggle-btn" id="toggleSidebar">☰</button>

        {{-- Sidebar --}}
        @include('partials.sidebar')

        {{-- Conteúdo principal --}}
        <main class="content">
            @yield('content')
        </main>

        @vite('resources/js/app.js')

        {{-- importacao do datatables --}}
        <script src="{{ asset('js/datatables.min.js') }}"></script>

        {{-- importacao do ionicons --}}
        <script type="module" src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.esm.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
        <script>
            // Toggle sidebar em telas pequenas
            document.getElementById('toggleSidebar').addEventListener('click', function() {
                document.querySelector('.sidebar').classList.toggle('active');
            });
        </script>
    @endauth
</body>
</html>
