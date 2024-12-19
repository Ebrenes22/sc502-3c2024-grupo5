<?php
$page = 'alimentos.php';
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="/frontend/assets/css/cards-style-food.css">

<h1>Alimentos</h1>
<div class="container my-4 mb-4">
    <div class="d-flex flex-wrap justify-content-center">
        <div class="card food-card m-2 shadow-lg">
            <div class="card-body text-center">
                <h5 class="card-title">Desayunos</h5>
                <img src="/frontend/assets/images/desayuno.jpeg" alt="Desayuno" class="img-card">
                <a href="#" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#breakfastModal">Ver Desayunos</a>
            </div>
        </div>
        <div class="card food-card m-2 shadow-lg">
            <div class="card-body text-center">
                <h5 class="card-title">Almuerzos</h5>
                <img src="/frontend/assets/images/almuerzo.jpg" alt="Almuerzo" class="img-card">
                <a href="#" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#lunchModal">Ver Almuerzos</a>
            </div>
        </div>
        <div class="card food-card m-2 shadow-lg">
            <div class="card-body text-center">
                <h5 class="card-title">Cenas</h5>
                <img src="/frontend/assets/images/cena.jpg" alt="Cena" class="img-card">
                <a href="#" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#dinnerModal">Ver Cenas</a>
            </div>
        </div>
        <div class="card food-card m-2 shadow-lg">
            <div class="card-body text-center">
                <h5 class="card-title">Snacks</h5>
                <img src="/frontend/assets/images/snack.jpg" alt="Snack" class="img-card">
                <a href="#" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#snacksModal">Ver Snacks</a>
            </div>
        </div>
    </div>
</div>

<!--Formulario de Registro de Alimentos-->
<div class="container my-4 mt-5">
    <h1 class="text-center">Registro de Alimentos</h1>
    <form id="foodForm" method="POST" action="/backend/alimentos_backend.php">
        <div class="form-group">
            <label for="food_name">Alimento</label>
            <input type="text" class="form-control" id="food_name" name="food_name" required>
        </div>
        <div class="form-group">
            <label for="portion_size">Tamaño de la porción (gramos)</label>
            <input type="number" class="form-control" id="portion_size" name="portion_size" required>
        </div>
        <div class="form-group">
            <label for="total_calories">Calorías totales</label>
            <input type="number" class="form-control" id="total_calories" name="total_calories" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>



<!-- Modal para Desayunos -->
<div class="modal fade" id="breakfastModal" tabindex="-1" aria-labelledby="breakfastModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="breakfastModalLabel">Opciones de Desayunos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>Huevos revueltos con jamón</li>
                    <li>Avena con frutas</li>
                    <li>Yogur con granola</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Almuerzos -->
<div class="modal fade" id="lunchModal" tabindex="-1" aria-labelledby="lunchModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lunchModalLabel">Opciones de Almuerzos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>Arroz con pollo</li>
                    <li>Ensalada César con pollo</li>
                    <li>Carne asada con puré de papa</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Cenas -->
<div class="modal fade" id="dinnerModal" tabindex="-1" aria-labelledby="dinnerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dinnerModalLabel">Opciones de Cenas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>Pechuga de pollo con verduras</li>
                    <li>Filete de pescado con ensalada</li>
                    <li>Sopa de lentejas</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Snacks -->
<div class="modal fade" id="snacksModal" tabindex="-1" aria-labelledby="snacksModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="snacksModalLabel">Opciones de Snacks</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>Chips</li>
                    <li>Frutas</li>
                    <li>Yogurt</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
