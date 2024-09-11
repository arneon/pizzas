<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CASFID - Pizzas section | Menú</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .pizza-card {
            margin-bottom: 20px;
        }
        .pizza-img {
            max-width: 100%;
            height: auto;
        }
        .pizza-ingredients {
            list-style: none;
            padding: 0;
        }
        .pizza-ingredients li {
            margin-bottom: 5px;
            font-size: 11px;
        }
    </style>
</head>
<body>
<!-- Header -->
<header class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="{{ $server_fqdn }}/logo.jpg" alt="Logo" width="100">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto">
                    <a href="/api/pizzas/manage" class="btn btn-primary">Admin. Pizzas</a>
                </div>
            </div>
        </div>
    </nav>
</header>

<div class="container mt-4">
    <h1 class="text-center">Menú</h1>

    <div class="row" id="pizza-list">
        @foreach($pizzas as $pizza)
            <div class="col-md-4 pizza-card">
                <div class="card">
                    <img src="{{ $pizza['image'] }}" class="card-img-top pizza-img" alt="{{ $pizza['name'] }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $pizza['name'] }}</h5>
                        <p class="card-text"><strong>Precio:</strong> {{ $pizza['price'] }}</p>
                        <p class="card-text"><strong>Descripción:</strong> {{ $pizza['description'] }}</p>
                        <h6>Ingredientes:</h6>
                        <ul class="pizza-ingredients">
                            @foreach($pizza['ingredients'] as $ingredient)
                                <li>{{ $ingredient }}</li>
                            @endforeach
                        </ul>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-light text-center py-3 mt-auto">
    <div class="container">
        <p>&copy; 2024 CASFID - Pizzas section. All rights reserved.</p>
    </div>
</footer>

<script>
    $(document).ready(function() {
        console.log('CASFID - Pizzas section');
    });
</script>
</body>
</html>
