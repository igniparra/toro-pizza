<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Pizzas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Add Pizza Button -->
            <div class="mb-4">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPizzaModal">
                    <i class="fa-solid fa-plus mr-2"></i>Add Pizza
                </button>
            </div>

            <!-- Pizzas List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Ingredients</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pizzas as $pizza)
                                <tr>
                                    <th scope="row">{{ $pizza->id }}</th>
                                    <td>{{ $pizza->name }}</td>
                                    <td>{{ implode(', ', $pizza->ingredients->pluck('name')->toArray()) }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editPizzaModal-{{ $pizza->id }}"><i class="fa-solid fa-pen-to-square mr-2"></i>Edit</button>
                                        <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $pizza->id }})"><i class="fa-solid fa-trash-can mr-2"></i>Delete</button>
                                    </td>
                                </tr>
                                <!-- Edit Pizza Modal -->
                                <div class="modal fade" id="editPizzaModal-{{ $pizza->id }}">
                                    @include('partials.editPizzaModal', ['pizza' => $pizza])
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Pizza Modal -->
    <div class="modal fade" id="addPizzaModal" tabindex="-1" aria-labelledby="addPizzaModalLabel" aria-hidden="true">
        <!-- Modal Content -->
        @include('partials.addPizzaModal')
    </div>

    <!-- Include scripts -->
    @vite(['resources/js/app.js', 'resources/js/pizza.js'])
</x-app-layout>

<script>
function confirmDelete(pizzaId) {
    if(confirm('Are you sure you want to delete this pizza?')) {
        document.getElementById('delete-pizza-form-' + pizzaId).submit();
    }
}
</script>
