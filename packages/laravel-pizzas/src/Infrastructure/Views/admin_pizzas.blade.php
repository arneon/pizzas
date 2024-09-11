<!-- resources/views/pizzas.blade.php -->
@extends('layouts.app')
@section('content')
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
        .selected-ingredients {
            margin-top: 10px;
        }
        .modal-backdrop.show {
            z-index: 1040; /* Make sure modals are on top */
        }
        .modal.show {
            z-index: 1050; /* Make sure modals are on top */
        }
    </style>
<body>
<div class="container mt-4">
    <h1 class="text-center">Admin. Pizzas</h1>

    <div class="text-end mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#pizzaModal" id="addPizzaBtn">Add new pizza</button>
        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addIngredientModal" id="addIngredientBtn">Add new ingredient</button>
    </div>

    <div class="row" id="pizza-list">
        @foreach($pizzas as $pizza)
            <div class="col-md-4 pizza-card">
                <div class="card">
                    <img src="{{ $pizza['image'] }}" class="card-img-top pizza-img" alt="{{ $pizza['name'] }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $pizza['name'] }}</h5>
                        <p class="card-text"><strong>Price:</strong> {{ $pizza['price'] }}</p>
                        <p class="card-text"><strong>Description:</strong> {{ $pizza['description'] }}</p>
                        <h6>Ingredients:</h6>
                        <ul class="pizza-ingredients">
                            @foreach($pizza['ingredients'] as $ingredient)
                                <li>{{ $ingredient }}</li>
                            @endforeach
                        </ul>
                        <button class="btn btn-primary editPizzaBtn buttonLoadFormEditPizza"  data-bs-toggle="modal" data-bs-target="#pizzaModal"
                                data-id="{{ $pizza['id'] }}"
                                data-name="{{ $pizza['name'] }}"
                                data-description="{{ $pizza['description'] }}"
                                data-image="{{ $pizza['image'] }}"
                                data-ingredients="{{ json_encode($pizza['ingredients']) }}"
                                data-ingredientsIds="{{ json_encode($pizza['ingredients']) }}">
                            Edit
                        </button>

                        <button class="btn btn-danger buttonDeletePizza"
                                data-id="{{ $pizza['id'] }}"
                                data-name="{{ $pizza['name'] }}"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="modal fade" id="pizzaModal" tabindex="-1" aria-labelledby="pizzaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pizzaModalLabel">Agregar / Editar Pizza</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="pizzaForm">
                    @csrf
                    <input type="hidden" id="pizzaId" name="pizzaId">
                    <input type="hidden" id="pizzaIngredientsIds" name="pizzaIngredientsIds">

                    <div class="mb-3">
                        <label for="pizzaName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="pizzaName" name="pizzaName" required>
                    </div>
                    <div class="mb-3">
                        <label for="pizzaImage" class="form-label">Image URL</label>
                        <input type="text" class="form-control" id="pizzaImage" name="pizzaImage">
                    </div>
                    <div class="mb-3">
                        <label for="pizzaDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="pizzaDescription" name="pizzaDescription" rows="2" ></textarea>
                    </div>

                    <button type="button" class="btn btn-secondary" id="showIngredientsForm" data-bs-toggle="modal" data-bs-target="#ingredientsModal">Select Ingredients</button>

                    <div id="selectedIngredients" class="selected-ingredients"></div>

                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ingredientsModal" tabindex="-1" aria-labelledby="ingredientsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ingredientsModalLabel">Select Ingredients</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ingredientsForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Available ingredients</label>
                        <div class="list-group">
                            @foreach($ingredients as $ingredient)
                                <label class="list-group-item">
                                    <input class="form-check-input me-1 ingredient-checkbox" type="checkbox" value="{{ $ingredient['id'] }}" data-name="{{ $ingredient['name'] }}" data-price="{{ $ingredient['price'] }}">
                                    {{ $ingredient['name'] }} - {{ $ingredient['price'] }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" id="selectIngredientsBtn">Add new ingredients</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addIngredientModal" tabindex="-1" aria-labelledby="addIngredientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addIngredientModalLabel">Add new ingredient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ingredientForm">
                    @csrf
                    <div class="mb-3">
                        <label for="ingredientName" class="form-label">Ingredient name</label>
                        <input type="text" class="form-control" id="ingredientName" name="ingredientName" required>
                    </div>
                    <div class="mb-3">
                        <label for="ingredientPrice" class="form-label">Ingredient price</label>
                        <input type="text" class="form-control" id="ingredientPrice" name="ingredientPrice" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Error: <span id="errorMessage"></span></p>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $(".buttonDeletePizza").on('click', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var pizzaData = {
                _token: $('input[name="_token"]').val(),
                name: $(this).data('name'),
                id: $(this).data('id'),
            };

            if(confirm("Are you sure to delete \"" + name + "\""))
            {
                //Delete Pizza
                $.ajax({
                    url: '/api/pizzas/'+id,
                    method: 'DELETE',
                    data: JSON.stringify(pizzaData),
                    contentType: 'application/json',
                    success: function(response) {
                        console.log('Pizza deleted:', response);
                        location.reload();
                    },
                    error: function(error) {
                        alert(error.responseJSON.errors.message);
                        console.error('Error:', error.responseJSON.errors.message);
                    }
                });
            }
        });

        $("#showIngredientsForm").on('click', function(){
            let ingredientsArray = $('#pizzaIngredientsIds').val().split(",");

            $('.ingredient-checkbox').prop('checked', false);

            $('.ingredient-checkbox').each(function() {
                let ingredientId = parseInt($(this).val(), 10) - 1;

                if (ingredientsArray.includes($(this).val())) {
                    $('.ingredient-checkbox').eq(ingredientId).prop('checked', true);
                }
            });
        });

        $("#addPizzaBtn").on('click', function(){
            $('#pizzaModalLabel').text('Add Pizza');
            $('#pizzaId').val('');
            $('#pizzaName').val('');
            $('#pizzaImage').val('');
            $('#pizzaDescription').val('');
            $('#pizzaIngredientsIds').val('');
            $('#selectedIngredients').html('');
        });

        $(".buttonLoadFormEditPizza").on('click', function(){
            var id = $(this).data('id');
            var name = $(this).data('name');
            var description = $(this).data('description');
            var image = $(this).data('image');

            $.ajax({
                url: '/api/pizzas/find-by-id/' + id,
                method: 'GET',
                contentType: 'application/json',
                success: function(response) {
                    console.log('Pizza found:', response.data.ingredients);
                    $('#pizzaIngredientsIds').val(response.data.ingredients.map(i => i.id).join(','));

                    $('#selectedIngredients').html(response.data.ingredients.map(i => `
                    <div> ${i.id} - ${i.name} - ${i.price} </div>
                    `).join(''));
                },
                error: function(error) {
                    alert(error.responseJSON.errors.message);
                    console.error('Error:', error.responseJSON.errors.message);
                }
            });

            $('#pizzaModalLabel').text('Edit Pizza');
            $('#pizzaId').val(id);
            $('#pizzaName').val(name);
            $('#pizzaImage').val(image);
            $('#pizzaDescription').val(description);
        });

        $('#selectIngredientsBtn').on('click', function(event){
            event.preventDefault();
            var selectedIngredients = [];
            var ingredientIds = [];

            $('.ingredient-checkbox:checked').each(function(){
                var ingredientName = $(this).data('name');
                var ingredientId = $(this).val();
                var ingredientPrice = $(this).data('price');
                selectedIngredients.push({ id: ingredientId, name: ingredientName, price: ingredientPrice });
                ingredientIds.push(ingredientId);
            });

            $('#pizzaIngredientsIds').val(ingredientIds.join(','));


            $('#selectedIngredients').html(selectedIngredients.map(i => `
                <div> ${i.id} - ${i.name} - ${i.price} </div>
            `).join(''));

            $('#ingredientsModal').modal('hide');
            $('#pizzaModal').modal('show');
        });

        $('#pizzaForm').on('submit', function(event){
            event.preventDefault();
            var pizzaId = $('#pizzaId').val();

            var pizzaData = {
                _token: $('input[name="_token"]').val(),
                name: $('#pizzaName').val(),
                image: $('#pizzaImage').val(),
                description: $('#pizzaDescription').val(),
                ingredients: $('#pizzaIngredientsIds').val().split(',')
            };

            if(!pizzaId)
            {
                //Create Pizza
                $.ajax({
                    url: '/api/pizzas',
                    method: 'POST',
                    data: JSON.stringify(pizzaData),
                    contentType: 'application/json',
                    success: function(response) {
                        console.log('Pizza updated:', response);
                        $('#pizzaModal').modal('hide');
                        location.reload();
                    },
                    error: function(error) {
                        alert(error.responseJSON.errors.message);
                        console.error('Error:', error.responseJSON.errors.message);
                    }
                });
            }
            else
            {
                //Update Pizza
                $.ajax({
                    url: '/api/pizzas/'+pizzaId,
                    method: 'PUT',
                    data: JSON.stringify(pizzaData),
                    contentType: 'application/json',
                    success: function(response) {
                        console.log('Pizza updated successfully:', response);
                        $('#pizzaModal').modal('hide');
                        location.reload();
                    },
                    error: function(error) {
                        alert(error.responseJSON.errors.message);
                        console.error('Error:', error.responseJSON.errors.message);
                    }
                });
            }
        });

        $('#ingredientForm').on('submit', function(event){
            event.preventDefault();
            var name = $('#ingredientName').val();
            var price = $('#ingredientPrice').val();
            var token = $('input[name="_token"]').val();

            $.ajax({
                url: '/api/pizzas/ingredients',
                method: 'POST',
                data: JSON.stringify({ name: name, price: price, _token: token }),
                contentType: 'application/json',
                success: function(response) {
                    console.log('Ingredient added:', response);
                    alert('Ingredient added successfully');
                    $('#ingredientName').val('');
                    $('#ingredientPrice').val('');
                    $('#addIngredientModal').modal('hide');
                    location.reload();
                },
                error: function(error) {
                    alert(error.responseJSON.errors.message);
                    console.error('Error:', error.responseJSON.errors.message);
                }
            });
        });
    });
</script>
@endsection
