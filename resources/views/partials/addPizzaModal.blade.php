<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-dark text-light">
            <h5 class="modal-title" id="addPizzaModalLabel">Add New Pizza</h5>
            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('pizzas.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="pizzaName" class="form-label">Pizza Name</label>
                    <input type="text" class="form-control" id="pizzaName" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="ingredients" class="form-label">Select Ingredients</label>
                    <div class="form-group">
                        @foreach ($ingredients as $ingredient)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $ingredient->id }}" id="ingredient{{ $ingredient->id }}" name="ingredients[]" @if($pizza->ingredients->contains($ingredient)) checked @endif>
                                <label class="form-check-label" for="ingredient{{ $ingredient->id }}">
                                    {{ $ingredient->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus mr-2"></i>Add Pizza</button>
            </form>
        </div>
    </div>
</div>
