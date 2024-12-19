document.addEventListener('DOMContentLoaded', function () {
    let foodLogs = [];
    let foods = [];
    const API_URL_FOOD = '../backend/food_backend.php';

    async function loadFoodLogs() {
        // Obtener registros de alimentos desde el servidor
        try {
            const response = await fetch(API_URL_FOOD, {
                method: 'GET',
                credentials: 'include',
            });
            if (response.ok) {
                foodLogs = await response.json();
                renderFoodLogs(foodLogs);
            } else {
                console.error("Error al obtener los registros de alimentos");
            }
        } catch (err) {
            console.error(err);
        }
    }

    async function loadFoods() {
        // Obtener lista de alimentos para el formulario
        try {
            const response = await fetch(`${API_URL_FOOD}?list=foods`, {
                method: 'GET',
                credentials: 'include',
            });
            if (response.ok) {
                foods = await response.json();
                renderFoods(foods);
            } else {
                console.error("Error al obtener la lista de alimentos");
            }
        } catch (err) {
            console.error(err);
        }
    }

    function renderFoods(foods) {
        const foodSelect = document.getElementById('foodSelect');
        foodSelect.innerHTML = ''; // Limpiar opciones previas

        foods.forEach(food => {
            const option = document.createElement('option');
            option.value = food.food_id;
            option.textContent = food.name;
            foodSelect.appendChild(option);
        });
    }

    function renderFoodLogs(foodLogs) {
        const foodLogsContainer = document.getElementById('foodLogs');
        foodLogsContainer.innerHTML = ''; // Limpiar contenido previo

        foodLogs.forEach((log, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>${log.food_name}</td>
                <td>${log.portion_size}</td>
                <td>${log.total_calories}</td>
                <td>${log.log_date}</td>
                <td>
                    <button class="btn btn-primary edit-food-log" data-id="${log.food_log_id}">Editar</button>
                    <button class="btn btn-danger delete-food-log" data-id="${log.food_log_id}">Eliminar</button>
                </td>
            `;
            foodLogsContainer.appendChild(row);
        });

        document.querySelectorAll('.delete-food-log').forEach(button => {
            button.addEventListener('click', handleDeleteFoodLog);
        });

        document.querySelectorAll('.edit-food-log').forEach(button => {
            button.addEventListener('click', handleEditFoodLog);
        });
    }

    document.getElementById('createFoodLogForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const foodId = document.getElementById('foodSelect').value;
        const portionSize = document.getElementById('portionSize').value;
        const logDate = document.getElementById('logDate').value;

        const newFoodLog = {
            food_id: foodId,
            portion_size: portionSize,
            log_date: logDate,
        };

        const response = await fetch(API_URL_FOOD, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(newFoodLog),
            credentials: 'include',
        });

        if (!response.ok) {
            console.error("Error al crear el registro de alimentos");
            return;
        }

        loadFoodLogs();
    });

    async function handleDeleteFoodLog(event) {
        const foodLogId = event.target.dataset.id;

        const response = await fetch(`${API_URL_FOOD}?id=${foodLogId}`, {
            method: 'DELETE',
            credentials: 'include',
        });

        if (response.ok) {
            loadFoodLogs();
        } else {
            console.error("Error al eliminar el registro de alimentos");
        }
    }

    function handleEditFoodLog(event) {
        const foodLogId = event.target.dataset.id;
        const foodLog = foodLogs.find(log => log.food_log_id == foodLogId);

        if (!foodLog) {
            console.error("Registro de alimentos no encontrado");
            return;
        }

        document.getElementById('foodLogId').value = foodLog.food_log_id;
        document.getElementById('foodSelect').value = foodLog.food_id;
        document.getElementById('portionSize').value = foodLog.portion_size;
        document.getElementById('logDate').value = foodLog.log_date;

        const modal = new bootstrap.Modal(document.getElementById('foodLogModal'));
        modal.show();
    }

    document.getElementById('editFoodLogForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const foodLogId = document.getElementById('foodLogId').value;
        const foodId = document.getElementById('foodSelect').value;
        const portionSize = document.getElementById('portionSize').value;
        const logDate = document.getElementById('logDate').value;

        const updatedFoodLog = {
            food_log_id: foodLogId,
            food_id: foodId,
            portion_size: portionSize,
            log_date: logDate,
        };

        const response = await fetch(API_URL_FOOD, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(updatedFoodLog),
            credentials: 'include',
        });

        if (!response.ok) {
            console.error("Error al actualizar el registro de alimentos");
            return;
        }

        const modal = bootstrap.Modal.getInstance(document.getElementById('foodLogModal'));
        modal.hide();

        loadFoodLogs();
    });

    loadFoods();
    loadFoodLogs();
});
