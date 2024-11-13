<?php
$page = 'alimentos.php';
?>

<link rel="stylesheet" href="/frontend/assets/css/cards-style-food.css">

<div class="container">
    <h1>Alimentos</h1>
    <div class="container my-4 mb-4">
        <div class="d-flex flex-wrap justify-content-center">
            <div class="card food-card m-2 shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title">Desayunos</h5>
                    <img src="/frontend/assets/images/desayuno.jpeg" alt="Desayuno" class="img-card">
                    <a href="#" class="btn btn-primary mt-3">Ver Desayunos</a>
                </div>
            </div>
            <div class="card food-card m-2 shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title">Almuerzos</h5>
                    <img src="/frontend/assets/images/almuerzo.jpg" alt="Almuerzo" class="img-card">
                    <a href="#" class="btn btn-primary mt-3">Ver Almuerzos</a>
                </div>
            </div>
            <div class="card food-card m-2 shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title">Cenas</h5>
                    <img src="/frontend/assets/images/cena.jpg" alt="Cena" class="img-card">
                    <a href="#" class="btn btn-primary mt-3">Ver Cenas</a>
                </div>
            </div>
            <div class="card food-card m-2 shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title">Snacks</h5>
                    <img src="/frontend/assets/images/snack.jpg" alt="Snack" class="img-card">
                    <a href="#" class="btn btn-primary mt-3">Ver Snacks</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-4 mt-5">
        <h1 class="text-center">Registro de Alimentos</h1>
            <div class="form-group">
                <label for="food_name">Alimento</label>
                <input type="text" class="form-control" id="food_name" name="food_name" required>
            </div>
            <div class="form-group">
                <label for="calories">Calorías</label>
                <input type="number" class="form-control" id="calories" name="calories" required>
            </div>
            <div class="form-group">
                <label for="date">Fecha</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>

</div>