import * as graficos from "https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js";
document.addEventListener('DOMContentLoaded', function () {

    let isEditMode = false;
    let editingId;
    let progress = [];
    const BASE_URL = '/htdocs/';
    const API_URL = `/backend/progress.php`;


async function loadProgress() {
    try {
        // Cargar progreso
        const response = await fetch(API_URL, {
            method: 'GET',
            credentials: 'include',
        });

        if (!response.ok) {
            if (response.status == 401) {
                window.location.href = 'index.php';
            }
            throw new Error('Error al obtener progreso');
        }

        progress = await response.json();

        // Renderizar todos los dias de progreso
        renderProgress(progress);
        renderGraficaSueno(progress);
        renderGraficaCalorias(progress);
        renderGraficaCardio(progress);
        renderGraficaPeso(progress);
    } catch (err) {
        console.error(err);
    }
}

function renderGraficaSueno(rutinas) {
    const fechas = rutinas.map(rutina => rutina.recorded_at);
    const horasSueno = rutinas.map(rutina => rutina.hours_sleep);

    const ctx = document.getElementById('graficaSueno').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: fechas,
            datasets: [{
                label: 'Horas de Sueño',
                data: horasSueno,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 2,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Horas'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Fecha'
                    }
                }
            }
        }
    });
}

function renderGraficaCardio(rutinas) {
    const fechas = rutinas.map(rutina => rutina.recorded_at);
    const ritmo = rutinas.map(rutina => rutina.distance_km);

    const ctx = document.getElementById('graficaCardio').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: fechas,
            datasets: [{
                label: 'Distancia recorrida',
                data: ritmo,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 2,
                fill: false,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Km diarios'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Fecha'
                    }
                }
            }
        }
    });
}

function renderGraficaCalorias(rutinas) {
    const fechas = rutinas.map(rutina => rutina.recorded_at);
    const calorias = rutinas.map(rutina => rutina.calories_burned);

    const ctx = document.getElementById('graficaCalorias').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: fechas,
            datasets: [{
                label: 'Calorías Quemadas',
                data: calorias,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 2,
                fill: false,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Calorías Quemadas'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Fecha'
                    }
                }
            }
        }
    });
}
function renderGraficaPeso(rutinas) {
    const fechas = rutinas.map(rutina => rutina.recorded_at);
    const calorias = rutinas.map(rutina => rutina.weight);

    const ctx = document.getElementById('graficaAgua').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: fechas,
            datasets: [{
                label: 'Progresión de Peso',
                data: calorias,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 2,
                fill: false,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Peso'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Fecha'
                    }
                }
            }
        }
    });
}
  
function renderProgress(progressEntries) {
    const progressList = document.getElementById('progress-list');
    progressList.innerHTML = ''; 
    
    progressEntries.forEach(progress => {

        let meatsList = '';
        try {
            const meats = JSON.parse(progress.meats || '[]'); 
            if (Array.isArray(meats) && meats.length > 0) {
                meatsList = '<ul class="list-group">';
                meats.forEach(meal => {
                    meatsList += `<li class="list-group-item">${meal}</li>`;
                });
                meatsList += '</ul>';
            } else {
                meatsList = '<p>No hay comidas registradas.</p>';
            }
        } catch (error) {
            meatsList = '<p>Error al procesar las comidas.</p>';
        }
    
        // Crear la tarjeta de progreso
        const progressCard = document.createElement('div');
        progressCard.className = 'col-md-4 mb-3';
        progressCard.innerHTML = `
            <div class="card">
                <div class="card-body">
                <img src="assets/images/fondotarjetarecomendacion.jpg" class="card-img-top" >
                    <h5 class="card-title">Fecha: ${progress.recorded_at}</h5>
                    <p class="card-text">Peso: ${progress.weight} kg</p>
                    <p class="card-text">Calorías Consumidas: ${progress.calories_consumed}</p>
                    <p class="card-text">Calorías Quemadas: ${progress.calories_burned}</p>
                    <p class="card-text">Ejercicios Completados: ${progress.exercises_completed}</p>
                    <p class="card-text">Horas de Sueño: ${progress.hours_sleep}</p>
                    <p class="card-text">Distancia: ${progress.distance_km} km</p>
                    <h6>Comidas del día:</h6>
                    ${meatsList}
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <button class="btn btn-secondary btn-sm edit-progress" data-id="${progress.progress_id}">Edit</button>
                    <button class="btn btn-danger btn-sm delete-progress" data-id="${progress.progress_id}">Delete</button>
                </div>
            </div>
        `;
    
        progressList.appendChild(progressCard);
    });


        document.querySelectorAll('.edit-progress').forEach(function (button) {
            button.addEventListener('click', handleEditProgress);
        });

        document.querySelectorAll('.delete-progress').forEach(function (button) {
            button.addEventListener('click', handleDeleteProgress);
        });
    }

    function handleEditProgress(event) {
        try {
            // Obtener el ID del progreso desde el botón que desencadena el evento
            const progressId = parseInt(event.target.dataset.id);
            
            // Buscar la entrada de progreso correspondiente en la lista de progreso (progressEntries)
            const progressU = progress.find(p => p.progress_id === progressId);
            if (!progressU) {
                alert("Progreso no encontrado");
                return;
            }
    
            // Cargar los datos del progreso en el formulario
            document.getElementById('exercise-log-id').value = progressU.exercise_log_id;
            document.getElementById('weight').value = progressU.weight;
            document.getElementById('calories-consumed').value = progressU.calories_consumed;
            document.getElementById('calories-burned').value = progressU.calories_burned;
            document.getElementById('exercises-completed').value = progressU.exercises_completed;
            document.getElementById('hours-sleep').value = progressU.hours_sleep;
            document.getElementById('distance-km').value = progressU.distance_km;
            document.getElementById('recorded-at').value = progressU.recorded_at;
    
            // Cargar el campo `meats` en el formulario
            const meatsField = document.getElementById('meats');
            const meats = JSON.parse(progressU.meats || '[]'); // Asegura que sea un array válido
            meatsField.value = meats.join(', '); // Mostrar como lista separada por comas
    
            // Configurar el modo de edición
            isEditMode = true;
            editingId = progressId;
    
            // Mostrar el modal
            const modal = new bootstrap.Modal(document.getElementById("progressModal"));
            modal.show();
        } catch (error) {
            alert("Error intentando editar el progreso");
            console.error(error);
        }
    }
    


    async function handleDeleteProgress(event) {
        const id = parseInt(event.target.dataset.id);
        const response = await fetch(`${API_URL}?progress_id=${id}`,{
            method: 'DELETE',
            credentials: 'include'
        });
        if (!response.ok) {
            loadProgress();
        } else {
            console.error("Error eliminando el progreso");
        }
    }
    
    document.querySelector('.btn-primary').addEventListener('click', function () {
        const modal = new bootstrap.Modal(document.getElementById('progressModal'));
        modal.show();
    });

    document.getElementById('progress-form').addEventListener('submit', async function (e) {
        e.preventDefault();
    
        // Obtener los valores de los campos
        const exerciseLogId = document.getElementById("exercise-log-id").value;
        const weight = document.getElementById("weight").value;
        const caloriesConsumed = document.getElementById("calories-consumed").value;
        const caloriesBurned = document.getElementById("calories-burned").value;
        const exercisesCompleted = document.getElementById("exercises-completed").value;
        const hoursSleep = document.getElementById("hours-sleep").value;
        const distanceKm = document.getElementById("distance-km").value;
        const recordedAt = document.getElementById("recorded-at").value;
        const meatsInput = document.getElementById("meats").value;
    
        // Procesar el campo meats (convertir string a array JSON)
        const meats = meatsInput.split(',').map(meal => meal.trim());
    
        // Crear el objeto para enviar
        const progressData = {
            exercise_log_id: exerciseLogId,
            weight: parseFloat(weight),
            calories_consumed: parseFloat(caloriesConsumed),
            calories_burned: parseFloat(caloriesBurned),
            exercises_completed: parseInt(exercisesCompleted, 10),
            hours_sleep: parseInt(hoursSleep, 10),
            distance_km: parseFloat(distanceKm),
            recorded_at: recordedAt,
            meats: JSON.stringify(meats)
        };

        if (!exerciseLogId || !weight || !caloriesConsumed || !caloriesBurned || !exercisesCompleted || !hoursSleep || !distanceKm || !recordedAt || !meatsInput) {
            console.error("Faltan datos");
            return; 
        }

        console.log(progressData);
    
        try {
            if (isEditMode) {
                // Modo edición: actualizar progreso existente
                const response = await fetch(`${API_URL}?progress_id=${editingId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(progressData),
                    credentials: "include"
                });
    
                if (!response.ok) {
                    console.error("Error al actualizar el progreso");
                    return;
                }
            } else {
                // Modo creación: crear nuevo progreso
                const response = await fetch(API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(progressData),
                    credentials: "include"
                });
    
                if (!response.ok) {
                    const errorData = await response.json();
                    console.error("Error al crear el progreso", errorData);
                    return;
                }
            }
    
            // Cerrar el modal
            var modal = new bootstrap.Modal(document.getElementById('progressModal'));
            modal.show();

    
            // Recargar la lista de progresos
            loadProgress();
        } catch (error) {
            console.error("Ocurrió un error al guardar el progreso:", error);
        }
    });
    

    document.getElementById('progressModal').addEventListener('show.bs.modal', function () {
        if (!isEditMode) {
            document.getElementById('progress-form').reset();
            // document.getElementById('task-title').value = "";
            // document.getElementById('task-desc').value = "";
            // document.getElementById('due-date').value = "";
        }
    });

    document.getElementById("progressModal").addEventListener('hidden.bs.modal', function () {
        editingId = null;
        isEditMode = false;
    })
    loadProgress();

});