<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-dark text-light">
            <h5 class="modal-title">Edit Ingredient: {{ $ingredient->name }}</h5>
            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="edit-ingredient-form-{{ $ingredient->id }}" action="{{ route('ingredients.update', $ingredient) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label for="ingredientName" class="form-label">Name</label>
                    <input type="text" class="form-control" id="ingredientName" name="name" value="{{ $ingredient->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="ingredientCost" class="form-label">Cost</label>
                    <input type="number" step="0.01" class="form-control" id="ingredientCost" name="cost" value="{{ $ingredient->cost }}" required>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fa-regular fa-floppy-disk mr-2"></i>Save Changes</button>
            </form>
            <!-- Form for Delete Action -->
            <form id="delete-ingredient-form-{{ $ingredient->id }}" action="{{ route('ingredients.destroy', $ingredient) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>
