document.addEventListener('DOMContentLoaded', function () {

    let exerciseLogs = [];
    let exercises = [];
    const API_URL_EJERCICIOS = '../backend/ejercicios_backend.php';

    async function loadExerciseLogs() {
        //va al servidor por los registros de ejercicio
        try {
            const response = await fetch(API_URL_EJERCICIOS, {
                method: 'GET',
                credentials: 'include'
            });
            if (response.ok) {
                exerciseLogs = await response.json();
                renderExerciseLogs(exerciseLogs);
            } else {
                if (response.status == 401) {
                    window.location.href = 'ejercicios.php';
                }
                console.error("Error al obtener exerciseLogs");
            }
        } catch (err) {
            console.error(err);
        }
    }

    async function loadExercises() {
        //traer ejercicios para insertar en el form select
        try {
            const response = await fetch(API_URL_EJERCICIOS, {
                method: 'GET',
                credentials: 'include'
            });
            if (response.ok) {
                exercises = await response.json();

                renderExercises(exercises);
            } else {
                if (response.status == 401) {
                    window.location.href = 'ejercicios.php';
                }
                console.error("Error al obtener exercises");
            }
        } catch (err) {
            console.error(err);
        }
    }

    function renderExercises(exercises) {
        exercises.innerHTML = '';

        exercises.forEach(function (exercise) {
            const select = exercise.querySelector('select');
            const option = document.createElement('option');
            option.innerHTML = `<option value="${exercise.description}">${exercise.name}</option>`;
            select.appendChild(option);

        });
    }


    function renderExerciseLogs(exerciseLogs) {
        //agrupar logs por fecha
        const logsGrupoFecha = exerciseLogs.reduce((acc, exerciseLog) => {
            if (!acc[exerciseLog.exercise_log_date]) {
                acc[exerciseLog.exercise_log_date] = [];
            }
            acc[exerciseLog.exercise_log_date].push(exerciseLog);
            return acc;
        }, {});

        //mostrar los logs de ejercicios desde el backend
        const exerciseLogsList = document.getElementById('accordionRegistroEjercicio');
        exerciseLogsList.innerHTML = '';
        Object.keys(logsGrupoFecha).forEach(function (date) {
            const exerciseLogsItem = document.createElement('div');
            exerciseLogsItem.className = 'accordion-item';
            const collapsarId = `collapse-${date.replace(/\s+/g, '-')}`;
            exerciseLogsItem.innerHTML = `
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#${collapsarId}" aria-expanded="true" aria-controls="${collapsarId}">
                        Rutina ${date}
                    </button>
                </h2>
                <div id="${collapsarId}" class="accordion-collapse collapse show" data-bs-parent="#accordionRegistroEjercicio">

                    <div class="accordion-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Ejercicio</th>
                                    <th scope="col">Repeticiones</th>
                                    <th scope="col">Calorias Quemadas</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                            <tfoot>
                                <th scope="row" colspan="3" class="text-end"></th>
                                <td id="totalCalories" class="text-end"></td>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            `;

            const tableBody = exerciseLogsItem.querySelector('tbody');
            let totalCalorias = 0;

            logsGrupoFecha[date].forEach(function (exerciseLog, index) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <th scope="row">${index + 1}</th>
                    <td>${exerciseLog.exercise_name}</td>
                    <td>${exerciseLog.repetitions}</td>
                    <td>${exerciseLog.calories_burned}</td>
                    <button type="button" class="btn btn-primary edit-exercise-log" data-id="${exerciseLog.exercise_log_id}"><i class="bi bi-pencil-fill"></i></button>
                    <button type="button" class="btn btn-primary delete-exercise-log" data-id="${exerciseLog.exercise_log_id}"><i class="bi bi-x-circle"></i></button>
                `;
                tableBody.appendChild(row);

                totalCalorias += Math.trunc(exerciseLog.calories_burned);
            });

            const footer = exerciseLogsItem.querySelector('tfoot td');
            footer.innerText = `Total: ${totalCalorias} Calorias`;

            exerciseLogsList.appendChild(exerciseLogsItem);

        });

        document.querySelectorAll('.delete-exercise-log').forEach(function (button) {
            button.addEventListener('click', handleDeleteExerciseLog);
        });

        document.querySelectorAll('.edit-exercise-log').forEach(function (button) {
            button.addEventListener('click', handleEditExerciseLog);
        });
    }

    //Crear exercise log
    document.querySelectorAll('.create-exercise-log').forEach(function (button) {
        button.addEventListener('click', async function (e) {
            e.preventDefault();

            const inputEjercicio = document.getElementById("inputEjercicio").value;
            const inputRepeticiones = document.getElementById("inputRepeticiones").value;
            const inputFecha = document.getElementById("inputFecha").value;

            const newExerciseLog = {
                exercise_id: inputEjercicio,
                repetitions: inputRepeticiones,
                exercise_log_date: inputFecha,
                calories_burned: 0 //Se calcula en el backend
            };
            //enviar la tarea al backend
            const response = await fetch(API_URL_EJERCICIOS, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(newExerciseLog),
                credentials: "include"
            });
            if (!response.ok) {
                console.error("Sucedio un error");
            }
            loadExerciseLogs()
        });
    });

    async function handleDeleteExerciseLog(event) {
        const exercise_log_id = parseInt(event.target.dataset.id);
        const response = await fetch(`${API_URL_EJERCICIOS}?id=${exercise_log_id}`, {
            method: 'DELETE',
            credentials: 'include'
        });
        if (response.ok) {
            loadExerciseLogs();
        } else {
            console.error("Error eliminando  log ejercicio");
        }
    }

    function handleEditExerciseLog(event) {
        try {
            const exerciseLogId = parseInt(event.target.dataset.id);
            alert(exerciseLogId);
            while(Number.isNaN(exerciseLogId)){
                exerciseLogId = parseInt(event.target.dataset.id);
            }
            const exerciseLog = exerciseLogs.find(e => e.exercise_log_id === exerciseLogId);
            console.log(exerciseLog);

            //cargar los datos en el formulario 
            setTimeout(() => {
                document.getElementById('exercise-log-id').value = exerciseLog.exercise_log_id;
                document.getElementById('inputEjercicioForm').value = exerciseLog.exercise_id;
                document.getElementById('inputRepeticionesForm').value = exerciseLog.repetitions;
                document.getElementById('inputFechaForm').value = exerciseLog.exercise_log_date;
            }, 100);

            //mostrar el modal
            const modal = new bootstrap.Modal(document.getElementById("exerciseLogModal"));
            modal.show();
        } catch (error) {
            alert("Error editando exerciseLog");
            console.error(error);
        }
    }

    document.getElementById('exerciseLogModal').addEventListener('show.bs.modal', function () {
        document.getElementById('exerciseLog-form').reset();

    });

    document.getElementById('exerciseLog-form').addEventListener('submit', async function (e) {
        e.preventDefault();

        const idEjercicioLog = document.getElementById("exercise-log-id").value;
        const nombreEjercicioLog = document.getElementById("inputEjercicioForm").value;
        const repeticiones = document.getElementById("inputRepeticionesForm").value;
        const fecha = document.getElementById("inputFechaForm").value;

        const response = await fetch(`${API_URL_EJERCICIOS}?id=${idEjercicioLog}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                exercise_log_id: idEjercicioLog, exercise_id: nombreEjercicioLog,
                repetitions: repeticiones, exercise_log_date: fecha, calories_burned: 0
            }),
            credentials: "include"
        });
        if (!response.ok) {
            console.error("Sucedio un error");
        }

        const modal = new bootstrap.Modal(document.getElementById('exerciseLogModal'));
        modal.hide();
        loadExerciseLogs();

    });







    loadExercises()
    loadExerciseLogs()
});

