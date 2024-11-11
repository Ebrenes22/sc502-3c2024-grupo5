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

    function generarRecomendaciones(rutina) {
        const recomendaciones = [];

        // Recomendación basada en el sueño
        if (rutina.sueno < 7) {
            recomendaciones.push("Intenta dormir al menos 7 horas para mejorar tu descanso.");
        }

        // Recomendación basada en la variedad de alimentos
        const comidas = ["desayuno", "almuerzo", "cena"];
        comidas.forEach(comida => {
            const alimentos = rutina.alimentacion[0][comida];
            if (alimentos.length < 3) {
                const sugerencia = comidaRecomendacion[Math.floor(Math.random() * comidaRecomendacion.length)];
                recomendaciones.push(`Para una dieta más balanceada en el ${comida}, considera agregar opciones como: ${sugerencia.join(", ")}.`);
            }
        });

        const totalDuracion = rutina.ejercicios[0].detalles.reduce((total, ejercicio) => total + parseInt(ejercicio.duracion), 0);
        const tiposEjercicio = new Set(rutina.ejercicios[0].detalles.map(ejercicio => ejercicio.tipo));
        
        if (totalDuracion < 30) {
            recomendaciones.push("Considera aumentar el tiempo total de ejercicio a al menos 30 minutos.");
        }
        if (tiposEjercicio.size < 2) {
            recomendaciones.push("Añade variedad a tu rutina de ejercicios para trabajar diferentes grupos musculares.");
        }

        return recomendaciones;
    }

    function loadRutinas() {
        const routineList = document.getElementById('routine-list');
        routineList.innerHTML = '';
        rutinas.forEach(function (rutina) {
            const recomendaciones = generarRecomendaciones(rutina);

            const rutinaCard = document.createElement('div');
            rutinaCard.className = 'col-md-4 mb-3';
            rutinaCard.innerHTML = `
            <div class="card border-info">
                <img src="assets/images/fondotarjetarecomendacion.jpg" class="card-img-top" >
                <div class="card-body">
                    <h5 class="card-header">Rutina del ${rutina.date}</h5>
                    <p class="card-text"><strong>Hora de levantarse:</strong> ${rutina.horaLevantarse}</p>
                    <p class="card-text"><strong>Sueño:</strong> ${rutina.sueno} horas</p>
                    <p class="card-text"><strong>Ritmo Cardíaco:</strong> ${rutina.ritmoCardiaco} bpm</p>
                    <p class="card-text"><strong>Peso:</strong> ${rutina.peso} kg</p>
                    <p class="card-text"><strong>Calorías Quemadas:</strong> ${rutina.caloriasQuemadas} kcal</p>
                    <p class="card-text"><strong>Estrés:</strong> ${rutina.estres}%</p>
                    <p class="card-text"><strong>Hidratación:</strong> ${rutina.hidratacion} vasos</p>
                    
                    <h6>Alimentación</h6>
                    <ul>
                        <li><strong>Desayuno:</strong> ${rutina.alimentacion[0].desayuno.join(', ')}</li>
                        <li><strong>Almuerzo:</strong> ${rutina.alimentacion[0].almuerzo.join(', ')}</li>
                        <li><strong>Cena:</strong> ${rutina.alimentacion[0].cena.join(', ')}</li>
                    </ul>
                    
                    <h6>Ejercicios</h6>
                    <ul>
                        ${rutina.ejercicios[0].detalles.map(ejercicio => `
                            <li><strong>${ejercicio.tipo}</strong> - Duración: ${ejercicio.duracion} mins, Repeticiones: ${ejercicio.repeticiones}</li>
                        `).join('')}
                    </ul>

                    <div class="card-footer">
                    ${recomendaciones.length > 0 ? `
                        <h6>Recomendaciones</h6>
                        <ul>
                            ${recomendaciones.map(rec => `<li>${rec}</li>`).join('')}
                        </ul>
                    ` : ''}
                    </div>
                    

                </div>
            </div>
            `;
            routineList.appendChild(rutinaCard);
        });
    }
    function renderGraficaSueno() {
        const fechas = rutinas.map(rutina => rutina.date);
        const horasSueno = rutinas.map(rutina => rutina.sueno);

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

    function renderGraficaAgua() {
        const fechas = rutinas.map(rutina => rutina.date);
        const vasosAgua = rutinas.map(rutina => rutina.hidratacion);

        const ctx = document.getElementById('graficaAgua').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: fechas,
                datasets: [{
                    label: 'Vasos de Agua',
                    data: vasosAgua,
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
                            text: 'Vasos'
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

    function renderGraficaCardio() {
        const fechas = rutinas.map(rutina => rutina.date);
        const ritmo = rutinas.map(rutina => rutina.ritmoCardiaco);

        const ctx = document.getElementById('graficaCardio').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: fechas,
                datasets: [{
                    label: 'Ritmo Cardíaco Promedio',
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
                            text: 'Ritmo Cardíaco'
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

    function renderGraficaCalorias() {
        const fechas = rutinas.map(rutina => rutina.date);
        const calorias = rutinas.map(rutina => rutina.caloriasQuemadas);

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
                            text: 'Vasos'
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



    loadRutinas();
    renderGraficaSueno();
    renderGraficaAgua();
    renderGraficaCalorias();
    renderGraficaCardio();
});
