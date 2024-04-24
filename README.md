# Toro Pizza

This application allows customers to customize pre-made pizzas with various ingredients and provides an admin interface to create, read, update, and delete (CRUD) ingredients and pizzas.

## Features

- **Customer Interface**
  - View a list of pre-made pizzas.
  - Customize a pizza by adding or removing ingredients.
  - View the updated price instantly as ingredients are added or removed.

- **Admin Interface**
  - Manage the list of ingredients.
  - Create new pizzas and define their ingredients.
  - Update existing pizzas and ingredients.
  - Delete pizzas and ingredients from the list.

## Installation Instructions

To set up the application on your local environment, follow these steps:

### 1. Clone the Repository
- git clone https://github.com/igniparra/toro-pizza.git
- cd toro-pizza

### 2. Install Dependencies
- composer install
- npm install
- npm run build

### 3. Set Up the Database
Create a new database and update `.env` with the database information.

If using the provided MySQL backup, rename .env.example to .env

Run migrations and seed the database:
- php artisan migrate --seed

### 4. Serve the Application
- php artisan serve

This will start a development server at http://localhost:8000

## Usage

- Access the application through your web browser to view the customer interface.
- Demo login information is present in the login screen
