<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Ingredients') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Add Ingredient Form -->
            <div class="mb-4">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addIngredientModal">
                    <i class="fa-solid fa-plus mr-2"></i> Add Ingredient
                </button>
            </div>

            <!-- Ingredients List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Cost</th>
                                <th scope="col">Actions</th>
                                <th scope="col">Order</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ingredients as $ingredient)
                                <tr>
                                    <th scope="row">{{ $ingredient->order }}</th>
                                    <td>{{ $ingredient->name }}</td>
                                    <td>${{ number_format($ingredient->cost, 2) }}</td>
                                    <td >
                                        <button class="btn btn-primary btn-sm mx-2" data-bs-toggle="modal" data-bs-target="#editIngredientModal-{{ $ingredient->id }}"><i class="fa-solid fa-pen-to-square mr-2"></i>Edit</button>
                                        <button class="btn btn-danger btn-sm mx-2" onclick="confirmDelete({{ $ingredient->id }})"><i class="fa-solid fa-trash-can mr-2"></i>Delete</button>
                                    </td>
                                    <td class='d-flex'>
                                        @if ($loop->first)
                                            <button class="btn btn-secondary btn-sm disabled mx-2"><i class="fa-solid fa-arrow-up mr-2"></i>Up</button>
                                        @else
                                            <form action="{{ route('ingredients.moveUp', $ingredient->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm mx-2"><i class="fa-solid fa-arrow-up mr-2"></i>Up</button>
                                            </form>
                                        @endif

                                        @if ($loop->last)
                                            <button class="btn btn-secondary btn-sm disabled mx-2"><i class="fa-solid fa-arrow-down mr-2"></i>Down</button>
                                        @else
                                            <form action="{{ route('ingredients.moveDown', $ingredient->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm mx-2"><i class="fa-solid fa-arrow-down mr-2"></i>Down</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                <!-- Edit Ingredient Modal -->
                                <div class="modal fade" id="editIngredientModal-{{ $ingredient->id }}">
                                    @include('partials.editIngredientModal', ['ingredient' => $ingredient])
                                </div>
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Ingredient Modal -->
    <div class="modal fade" id="addIngredientModal" tabindex="-1" aria-labelledby="addIngredientModalLabel" aria-hidden="true">
        <!-- Modal Content -->
        @include('partials.addIngredientModal')
    </div>

    <!-- Include pizza.js -->
    @vite(['resources/js/app.js', 'resources/js/pizza.js'])
</x-app-layout>

<script>
function confirmDelete(ingredientId) {
    if(confirm('Are you sure you want to delete this ingredient?')) {
        document.getElementById('delete-ingredient-form-' + ingredientId).submit();
    }
}
</script>
