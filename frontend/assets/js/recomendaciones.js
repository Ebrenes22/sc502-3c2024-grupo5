import * as graficos from "https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js";

const comidaRecomendacion = [
    ["ensalada de espinacas", "pollo a la parrilla", "papa asada"],
    ["quinoa", "aguacate", "salmón"],
    ["frutas mixtas", "yogurt", "granola"],
    ["arroz integral", "frijoles negros", "ensalada de verduras"],
    ["omelette vegetariano", "pan integral", "jugo de naranja"]
];

const rutinas = [
    { 
        id: 1, 
        alimentacion: [
            {
                desayuno: ["huevos", "tocino", "aguacate"],
                almuerzo: ["arroz", "frijoles", "pollo", "ensalada"],
                cena: ["sopa azteca"]
            }
        ], 
        sueno: 8, 
        date: "2024-12-01", 
        horaLevantarse: "06:30",
        ritmoCardiaco: 95,
        peso: 85,
        caloriasQuemadas: 500,
        estres: 35,
        hidratacion: 8,
        ejercicios: [
            {
                id: 1,
                detalles: [
                    { tipo: "cardio", duracion: 40, repeticiones: 1 },
                    { tipo: "natacion", duracion: 20, repeticiones: 4 }
                ]
            }
        ]
    },
    { 
        id: 2, 
        alimentacion: [
            {
                desayuno: ["pan integral", "aguacate", "batido de frutas"],
                almuerzo: ["pasta", "verduras al grill", "pollo"],
                cena: ["ensalada césar", "pan integral"]
            }
        ], 
        sueno: 7, 
        date: "2024-12-02", 
        horaLevantarse: "07:00",
        ritmoCardiaco: 88,
        peso: 83,
        caloriasQuemadas: 600,
        estres: 40,
        hidratacion: 7,
        ejercicios: [
            {
                id: 2,
                detalles: [
                    { tipo: "pesas", duracion: 45, repeticiones: 3 },
                    { tipo: "caminata", duracion: 30, repeticiones: 1 }
                ]
            }
        ]
    },
    { 
        id: 3, 
        alimentacion: [
            {
                desayuno: ["yogurt", "granola", "frutas"],
                almuerzo: ["arroz integral", "salmón", "brócoli", "ensalada"],
                cena: ["tacos de pollo", "aguacate"]
            }
        ], 
        sueno: 6, 
        date: "2024-12-03", 
        horaLevantarse: "05:45",
        ritmoCardiaco: 92,
        peso: 82,
        caloriasQuemadas: 700,
        estres: 30,
        hidratacion: 9,
        ejercicios: [
            {
                id: 3,
                detalles: [
                    { tipo: "yoga", duracion: 60, repeticiones: 1 },
                    { tipo: "ciclismo", duracion: 50, repeticiones: 1 }
                ]
            }
        ]
    }
];

document.addEventListener('DOMContentLoaded', function () {
    let progresos = [];
    let recomendaciones = [];
    let idprogreso = 0;
    let recomendacionesGuardar = [];
    const API_URL2 = '/backend/progress.php'; // Endpoint para cargar progreso
    const API_URL = '/backend/recommendations.php'; // Endpoint para guardar recomendaciones

    async function loadProgress() {
        try {
            const response = await fetch(API_URL2, {
                method: 'GET',
                credentials: 'include',
            });

            if (!response.ok) {
                if (response.status === 401) {
                    window.location.href = 'index.php';
                }
                throw new Error('Error al obtener progreso');
            }

            progresos = await response.json();
            renderProgressWithRecommendations(progresos);
        } catch (err) {
            console.error(err);
        }
    }

    function generarRecomendaciones(progreso) {
        const recomendaciones = [];

        if (progreso.hours_sleep < 7) {
            recomendaciones.push("Intenta dormir al menos 7 horas para mejorar tu descanso.");
        }

        const alimentosTotales = progreso.meats.length;
        if (alimentosTotales < 3) {
            recomendaciones.push("Intenta incluir más alimentos variados en tu dieta para balancearla.");
        }

        if (progreso.distance_km < 5) {
            recomendaciones.push("Considera aumentar tu distancia total diaria a al menos 5 km.");
        }

        if (progreso.exercises_completed < 2) {
            recomendaciones.push("Incluye variedad en tu rutina de ejercicios para trabajar diferentes grupos musculares.");
        }

        return recomendaciones;
    }

    function renderProgressWithRecommendations(progresos) {
        const progressList = document.getElementById('progress-list');
        progressList.innerHTML = '';

        progresos.forEach(progreso => {
            const recomendaciones = generarRecomendaciones(progreso);

            const card = document.createElement('div');
            card.className = 'col-md-4 mb-3';
            card.innerHTML = `
                <div class="card border-info">
                    <div class="card-body">
                        <h5 class="card-title">Progreso del ${progreso.recorded_at}</h5>
                        <p class="card-text"><strong>Sueño:</strong> ${progreso.hours_sleep} horas</p>
                        <p class="card-text"><strong>Distancia Recorrida:</strong> ${progreso.distance_km} km</p>
                        <p class="card-text"><strong>Peso:</strong> ${progreso.weight} kg</p>
                        <p class="card-text"><strong>Calorías Quemadas:</strong> ${progreso.calories_burned} kcal</p>
                        
                        <h6>Recomendaciones</h6>
                        <ul id="recommendation-${progreso.progress_id}">
                            ${recomendaciones.map(rec => `<li>${rec}</li>`).join('')}
                        </ul>
                        
                        <button class="btn btn-primary save-recommendation" data-id="${progreso.progress_id}">
                            Guardar Recomendación
                        </button>
                    </div>
                </div>
            `;
            progressList.appendChild(card);
        });

        // Agregar evento a los botones de guardar recomendación
        const saveButtons = document.querySelectorAll('.save-recommendation');
        saveButtons.forEach(button => {
        button.addEventListener('click', function () {
            idprogreso = button.dataset.id;
            recomendacionesGuardar = Array.from(document.querySelectorAll(`#recommendation-${idprogreso} li`)).map(li => li.textContent);

            //const recommendations = Array.from(recommendationsList.querySelectorAll('li')).map(li => li.textContent


            const modal = new bootstrap.Modal(document.getElementById('recommendationsModal'));
            modal.show();
        });

        });
        
        
    }

    document.getElementById('recommendations-form').addEventListener('submit', async function (e) {
        e.preventDefault();
    
        // Obtener los valores de los campos
        const type = document.getElementById("type").value;
        const minWeight = document.getElementById("min-weight").value;
        const maxWeight = document.getElementById("max-weight").value;
    
        // Crear el objeto para enviar
        const recommendationData = {
            type: type.trim(),
            progress_id: parseInt(idprogreso, 10),
            description: recomendacionesGuardar.join(', '),
            min_weight: parseFloat(minWeight),
            max_weight: parseFloat(maxWeight)
        };
    
        console.log("Enviando datos:", recommendationData);
    
        try {
            // Crear nueva recomendación
            const response = await fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(recommendationData),
                credentials: "include"
            });
    
            if (!response.ok) {
                const errorData = await response.json();
                console.error("Error al crear la recomendación:", errorData);
                return;
            }
    
            // Cerrar el modal
            //var modal = bootstrap.Modal.getInstance(document.getElementById('recommendationsModal'));
           // modal.hide();
    
            // Recargar la lista de recomendaciones
            loadRecommendations();
        } catch (error) {
            console.error("Ocurrió un error al guardar la recomendación:", error);
        }
    });
    

    async function loadRecommendations() {
        try {
            const response = await fetch(API_URL, {
                method: 'GET',
                credentials: 'include',
            });

            if (!response.ok) {
                if (response.status === 401) {
                    window.location.href = 'index.php';
                }
                throw new Error('Error al obtener progreso');
            }

            recomendaciones = await response.json();
            renderRecommendations(recomendaciones);
        } catch (err) {
            console.error(err);
        }
    }
    
    function renderRecommendations(recommendations) {
        const recommendationList = document.getElementById('recommendation-list');
        recommendationList.innerHTML = '';
    
        recommendations.forEach(recommendation => {
            const card = document.createElement('div');
            card.className = 'col-md-4 mb-3';
            card.innerHTML = `
                <div class="card border-info">
                    <div class="card-body">
                        <h5 class="card-title">${recommendation.type}</h5>
                        <p class="card-text"><strong>Descripción:</strong> ${recommendation.description}</p>
                        <p class="card-text"><strong>Peso Mínimo:</strong> ${recommendation.min_weight} kg</p>
                        <p class="card-text"><strong>Peso Máximo:</strong> ${recommendation.max_weight} kg</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                    <button class="btn btn-danger btn-sm delete-recommendation" data-id="${recommendation.recommendations_id}">Delete</button>
                </div>
                </div>
            `;
            recommendationList.appendChild(card);
        });

        document.querySelectorAll('.delete-recommendation').forEach(function (button) {
            button.addEventListener('click', handleDeleteRecommendation);
        });
    }

    async function handleDeleteRecommendation(event) {
        const id = parseInt(event.target.dataset.id);
        const response = await fetch(`${API_URL}?recommendations_id=${id}`,{
            method: 'DELETE',
            credentials: 'include'
        });
        if (!response.ok) {
            loadRecommendations();
        } else {
            console.error("Error eliminando el progreso");
        }
    }
    


    // Inicializar carga de progreso
    loadProgress();
    loadRecommendations();
});

