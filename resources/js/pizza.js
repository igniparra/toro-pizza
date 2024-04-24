document.addEventListener('DOMContentLoaded', function () {
    const pizzaElements = document.querySelectorAll('.pizza-item');
    const ingredientCheckboxes = document.querySelectorAll('.ingredient-checkbox');
    const totalPriceElement = document.getElementById('total-price');
    const totalPriceModal = document.getElementById('total-price-modal');
    const ingredientsList = document.getElementById('ingredients-list');
    const selectedPizzaName = document.getElementById('selected-pizza-name');

    // Function to update the total price
    function updateTotalPrice() {
        let total = Array.from(ingredientCheckboxes)
            .filter(checkbox => checkbox.checked)
            .reduce((sum, checkbox) => sum + parseFloat(checkbox.dataset.cost), 0);

        total *= 1.5; // Add 50% to the total cost
        totalPriceElement.textContent = total.toFixed(2);
        totalPriceModal.textContent = total.toFixed(2);

        //Updating the list of elements in the order details modal
        const selectedIngredientsList = document.getElementById('selected-ingredients-list');
        selectedIngredientsList.innerHTML = ''; // Clear the list before adding new items

        ingredientCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                total += parseFloat(checkbox.dataset.cost);

                // Create and append the list item for the ingredient
                const li = document.createElement('li');
                li.textContent = checkbox.nextElementSibling.textContent; // Assumes the label text is right next to the checkbox
                selectedIngredientsList.appendChild(li);
            }
        });

    }

    // Function to handle pizza selection
    function handlePizzaSelection(pizzaId) {
        ingredientCheckboxes.forEach(checkbox => {
            checkbox.checked = false; // Reset all checkboxes
            checkbox.disabled=false;
        });
        ingredientsList.classList.remove('d-none'); // Show ingredients list

        const selectedPizza = window.pizzas.find(pizza => pizza.id == pizzaId);
        selectedPizzaName.textContent = selectedPizza.name; //Load the modal of order now with the name of the pizza

        // Check the ingredients that belong to the selected pizza
        const selectedPizzaIngredients = window.pizzas.find(pizza => pizza.id == pizzaId).ingredients;
        selectedPizzaIngredients.forEach(ingredient => {
            document.getElementById(`ingredient-${ingredient.id}`).checked = true;
            document.getElementById(`ingredient-${ingredient.id}`).disabled = true;
            document.getElementById(`buy-now-btn`).classList.remove('hidden');
            document.getElementById(`buy-now-btn`).classList.add('d-flex');
        });

        updateTotalPrice(); // Update total price based on the selected pizza ingredients
    }

    // Event listeners for pizza selection
    pizzaElements.forEach(pizzaElement => {
        pizzaElement.addEventListener('click', function (event) {
            event.preventDefault();
            handlePizzaSelection(this.dataset.id);
        });
    });

    // Event listeners for ingredient checkbox changes
    ingredientCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateTotalPrice);
    });
});
