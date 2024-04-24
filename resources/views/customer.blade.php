<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Make your pizza') }}
        </h2>
        <script>
            window.pizzas = @json($pizzas);
        </script>
        @vite(['resources/js/app.js', 'resources/js/pizza.js'])
    </x-slot>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <!-- Pizzas Column -->
                <div class="col-md-6">
                    <h3>Select a Pizza</h3>
                    <div class="list-group">
                        @foreach ($pizzas as $pizza)
                            <a href="#" class="list-group-item list-group-item-action pizza-item" data-id="{{ $pizza->id }}">
                                {{ $pizza->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <!-- Ingredients Column -->
                <div class="col-md-6">
                    <h3>Ingredients</h3>
                    <div id="ingredients-list" class="d-none">
                        @foreach ($ingredients as $ingredient)
                            <div class="form-check">
                                <input class="form-check-input ingredient-checkbox" type="checkbox" value="{{ $ingredient->id }}" id="ingredient-{{ $ingredient->id }}" data-cost="{{ $ingredient->cost }}">
                                <label class="form-check-label" for="ingredient-{{ $ingredient->id }}">
                                    {{ $ingredient->name }} (${{ number_format($ingredient->cost, 2) }})
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="total-price mt-3">
                        Total Price: $<span id="total-price">0.00</span>
                    </div>
                    <div class="text-center mt-4 hidden" id='buy-now-btn'>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#orderSummaryModal">
                            <i class="fa-solid fa-cart-shopping mr-2"></i> Order Now
                        </button>
                    </div>
                </div>
            </div> 
        </div>
    </div>

    <!-- Order Summary Modal -->
    <div class="modal fade" id="orderSummaryModal" tabindex="-1" aria-labelledby="orderSummaryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-light">
                    <h5 class="modal-title" id="orderSummaryModalLabel">Order Summary</h5>
                    <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Placeholder for the selected pizza name -->
                    <h4 class="fw-bold mb-3" id="selected-pizza-name"><span></span></h4>
                    <!-- Placeholder for the selected ingredients -->
                    <p class="fw-bold">Ingredients:</p>
                    <ul id="selected-ingredients-list">
                        <!-- JavaScript will insert list items here -->
                    </ul>
                </div>
                <div class="modal-footer">
                    <span class="me-auto">Final Price: $<span id="total-price-modal">0.00</span></span>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Complete Order</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
