<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CASFID - Pizzas section</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<!-- Header -->
<header class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
               <img src="{{ isset($server_fqdn) ? $server_fqdn : 'http://localhost' }}/logo.jpg" alt="Logo" width="100">
            </a>

            <!-- Mobile Buttons -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Menú -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/api/pizzas/manage">Pizzas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/api/pizzas/ingredients">Ingredients</a>
                    </li>

                    @if (Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/api/users/login">Login</a>
                        </li>
                    @endif
                </ul>

                <!-- Select para cambiar de idioma -->
                <!-- <div class="text-center mb-4"> -->
                    <select id="languageSelect" class="flag-select form-select">
                        <option value="">Seleccione</option>
                        <option value="/lang/es" class="flag-option">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/9/9a/Flag_of_Spain.svg" alt="España"> Español
                        </option>
                        <option value="/lang/en" class="flag-option">
                            <img src="https://upload.wikimedia.org/wikipedia/en/a/ae/Flag_of_the_United_Kingdom.svg" alt="Inglaterra"> English
                        </option>
                        <option value="/lang/it" class="flag-option">
                            <img src="https://upload.wikimedia.org/wikipedia/en/0/03/Flag_of_Italy.svg" alt="Italia"> Italiano
                        </option>
                    </select>
                <!-- </div> -->

            </div>
        </div>
    </nav>
</header>

<!-- Main Content -->
<main class="container mt-4">
    <div class="row">
        <div class="col">
            @yield('content')
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="bg-dark text-light text-center py-3 mt-auto">
    <div class="container">
        <p>&copy; 2024 CASFID - Pizzas section. All rights reserved.</p>
    </div>
</footer>

<script>
    $(document).ready(function() {
        console.log('CASFID - Pizzas section');

        document.getElementById('languageSelect').addEventListener('change', function() {
            var selectedLanguage = this.value;
            window.location.href = selectedLanguage;
        });
    });
</script>
</body>
</html>
