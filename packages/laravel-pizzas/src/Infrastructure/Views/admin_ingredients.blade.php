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
        /* Custom styling for select with flags */
        .flag-select {
            margin-bottom: 20px;
            width: 200px;
            padding: 10px;
            font-size: 16px;
        }
        .flag-option {
            display: flex;
            align-items: center;
        }
        .flag-option img {
            width: 25px;
            margin-right: 10px;
        }
    </style>
<body>
<div class="container mt-4">



    <h1 class="text-center">{{ Lang::has('laravel-pizzas::messages.Admin. Ingredients')
        ?  __('laravel-pizzas::messages.Admin. Ingredients', [], Session::get('locale'))
         : 'Admin. Ingredients' }}</h1>

    <div class="text-end mb-3">
        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addIngredientModal" id="addIngredientBtn">
            {{ Lang::has('laravel-pizzas::messages.Add new ingredient')
        ?  __('laravel-pizzas::messages.Add new ingredient', [], Session::get('locale'))
         : 'Add new ingredient' }}
            </button>
    </div>

    <div class="row" id="pizza-list">
        @foreach($ingredients as $ingredient)
            <div class="col-md-4 pizza-card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            {{ Lang::has('laravel-pizzas::messages.'.$ingredient['name'])
                            ?  __('laravel-pizzas::messages.'.$ingredient['name'], [], Session::get('locale'))
                             : $ingredient['name'] }}
                            </h5>
                        <p class="card-text"><strong>
                                {{ Lang::has('laravel-pizzas::messages.Price')
                            ?  __('laravel-pizzas::messages.Price', [], Session::get('locale'))
                             : 'Price' }}
                                :</strong> {{ $ingredient['price'] }}</p>
                        <button class="btn btn-primary editPizzaBtn buttonLoadFormEditPizza"  data-bs-toggle="modal" data-bs-target="#pizzaModal"
                                data-id="{{ $ingredient['id'] }}"
                                data-name="{{ $ingredient['name'] }}"
                                data-price="{{ $ingredient['price'] }}">
                            {{ Lang::has('laravel-pizzas::messages.Edit')
                            ?  __('laravel-pizzas::messages.Edit', [], Session::get('locale'))
                             : 'Edit' }}
                        </button>

                        <button class="btn btn-danger buttonDeletePizza"
                                data-id="{{ $ingredient['id'] }}"
                                data-name="{{ $ingredient['name'] }}"
                        >
                            {{ Lang::has('laravel-pizzas::messages.Delete')
                            ?  __('laravel-pizzas::messages.Delete', [], Session::get('locale'))
                             : 'Delete' }}
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
                <h5 class="modal-title" id="pizzaModalLabel">Add / Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="pizzaForm">
                    @csrf
                    <input type="hidden" id="pizzaId" name="pizzaId">

                    <div class="mb-3">
                        <label for="pizzaName" class="form-label">{{ Lang::has('laravel-pizzas::messages.Ingredient name')
                        ?  __('laravel-pizzas::messages.Ingredient name', [], Session::get('locale'))
                         : 'Ingredient name' }}</label>
                        <input type="text" class="form-control" id="pizzaName" name="pizzaName" required>
                    </div>
                    <div class="mb-3">
                        <label for="pizzaImage" class="form-label">
                            {{ Lang::has('laravel-pizzas::messages.Ingredient Price')
                        ?  __('laravel-pizzas::messages.Ingredient Price', [], Session::get('locale'))
                         : 'Ingredient Price' }}
                            </label>
                        <input type="text" class="form-control" id="pizzaPrice" name="pizzaPrice">
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">
                        {{ Lang::has('laravel-pizzas::messages.Save')
                        ?  __('laravel-pizzas::messages.Save', [], Session::get('locale'))
                         : 'Save' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ingredientsModal" tabindex="-1" aria-labelledby="ingredientsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ingredientsModalLabel">Seleccionar Ingredientes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ingredientsForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Ingredientes Disponibles</label>
                        <div class="list-group">
                            <!-- Listado de ingredientes con checkbox -->
                            @foreach($ingredients as $ingredient)
                                <label class="list-group-item">
                                    <input class="form-check-input me-1 ingredient-checkbox" type="checkbox" value="{{ $ingredient['id'] }}" data-name="{{ $ingredient['name'] }}" data-price="{{ $ingredient['price'] }}">
                                    {{ $ingredient['name'] }} - {{ $ingredient['price'] }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" id="selectIngredientsBtn">
                        {{ Lang::has('laravel-pizzas::messages.Add Ingredient')
                        ?  __('laravel-pizzas::messages.Add Ingredient', [], Session::get('locale'))
                         : 'Add Ingredient' }}
                        </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addIngredientModal" tabindex="-1" aria-labelledby="addIngredientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addIngredientModalLabel">
                    {{ Lang::has('laravel-pizzas::messages.Add Ingredient')
                        ?  __('laravel-pizzas::messages.Add Ingredient', [], Session::get('locale'))
                         : 'Add Ingredient' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ingredientForm">
                    @csrf
                    <div class="mb-3">
                        <label for="ingredientName" class="form-label">
                            {{ Lang::has('laravel-pizzas::messages.Ingredient name')
                            ?  __('laravel-pizzas::messages.Ingredient name', [], Session::get('locale'))
                             : 'Ingredient name' }}
                            </label>
                        <input type="text" class="form-control" id="ingredientName" name="ingredientName" required>
                    </div>
                    <div class="mb-3">
                        <label for="ingredientPrice" class="form-label">
                            {{ Lang::has('laravel-pizzas::messages.Ingredient Price')
                            ?  __('laravel-pizzas::messages.Ingredient Price', [], Session::get('locale'))
                             : 'Ingredient Price' }}
                             </label>
                        <input type="text" class="form-control" id="ingredientPrice" name="ingredientPrice" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        {{ Lang::has('laravel-pizzas::messages.Add')
                            ?  __('laravel-pizzas::messages.Add', [], Session::get('locale'))
                             : 'Add' }}
                        </button>
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
                //Delete Ingredient
                $.ajax({
                    url: '/api/pizzas/ingredients/'+id,
                    method: 'DELETE',
                    data: JSON.stringify(pizzaData),
                    contentType: 'application/json',
                    success: function(response) {
                        console.log('Ingredient delete successfully:', response);
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
            $('#pizzaModalLabel').text('Add Ingredient');
            $('#pizzaId').val('');
            $('#pizzaName').val('');
            $('#pizzaPrice').val('');
        });

        $(".buttonLoadFormEditPizza").on('click', function(){
            var id = $(this).data('id');
            var name = $(this).data('name');
            var price = $(this).data('price');

            $('#pizzaModalLabel').text('{{ Lang::has('laravel-pizzas::messages.Edit Ingredient')
                        ?  __('laravel-pizzas::messages.Edit Ingredient', [], Session::get('locale'))
                         : 'Edit Ingredient' }}');
            $('#pizzaId').val(id);
            $('#pizzaName').val(name);
            $('#pizzaPrice').val(price);
        });

        $('#pizzaForm').on('submit', function(event){
            event.preventDefault();
            var pizzaId = $('#pizzaId').val();

            var pizzaData = {
                _token: $('input[name="_token"]').val(),
                name: $('#pizzaName').val(),
                price: $('#pizzaPrice').val(),
            };

            if(!pizzaId)
            {
                //Create Ingredient
                $.ajax({
                    url: '/api/pizzas/ingredients',
                    method: 'POST',
                    data: JSON.stringify(pizzaData),
                    contentType: 'application/json',
                    success: function(response) {
                        console.log('Ingredient Added:', response);
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
                //Update Ingredient
                $.ajax({
                    url: '/api/pizzas/ingredients/'+pizzaId,
                    method: 'PUT',
                    data: JSON.stringify(pizzaData),
                    contentType: 'application/json',
                    success: function(response) {
                        console.log('Ingredient updated:', response);
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
