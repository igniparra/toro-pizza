<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-dark text-light">
            <h5 class="modal-title" id="addIngredientModalLabel">New Ingredient</h5>
            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="add-ingredient-form" action="{{ route('ingredients.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="ingredientName" class="form-label">Name</label>
                    <input type="text" class="form-control" id="ingredientName" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="ingredientCost" class="form-label">Cost</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" class="form-control" id="ingredientCost" name="cost" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus mr-2"></i>Add Ingredient</button>
            </form>
        </div>
    </div>
</div>
