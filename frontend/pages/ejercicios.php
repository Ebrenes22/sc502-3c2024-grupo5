<?php
$page = 'ejercicios.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <title>Ejercicios</title>
</head>

<body>
    <div class="container">
        <h1>Ejercicios</h1>
        <div class="card mb-3" style="max-width: none;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="assets\images\personal_trainer.jpg" class="img-fluid rounded-start">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Ingrese su rutina</h5>
                        <div class="mb-3">
                            <label class="form-label">Ejercicio</label>
                            <select class="form-select" aria-label="Default select example" id="inputEjercicio">
                                <!-- Se insertan ejercicios desde la base de datos -->
                                <!-- <option selected>Seleccione una opcion...</option>
                                <option value="1">Lagartijas</option>
                                <option value="2">Plancha</option>
                                <option value="3">Sentadilla</option> -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="inputRepeticiones" class="form-label">Repeticiones</label>
                            <input type="number" class="form-control" id="inputRepeticiones">
                        </div>
                        <div class="mb-3">
                            <label for="inputFecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="inputFecha">
                        </div>
                        <button type="button" class="btn btn-primary create-exercise-log"><i class="bi bi-plus-circle"></i> Registrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <h1>Registro de Ejercicios</h1>
        <div class="accordion" id="accordionRegistroEjercicio">
            <!--Aqui se insertan los exercise_log -->
            <!-- <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Rutina 27 de agosto 2024
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
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
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Sentadilla</td>
                                    <td>20</td>
                                    <td>100</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Plancha</td>
                                    <td>10</td>
                                    <td>150</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Lagartija</td>
                                    <td>50</td>
                                    <td>200</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <th scope="row"></th>
                                <td></td>
                                <td></td>
                                <td>Total: 450</td>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Rutina 26 de agosto 2024
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
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
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Sentadilla</td>
                                    <td>20</td>
                                    <td>100</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Plancha</td>
                                    <td>10</td>
                                    <td>150</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Lagartija</td>
                                    <td>50</td>
                                    <td>200</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Rutina 25 de agosto 2024
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
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
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Sentadilla</td>
                                    <td>20</td>
                                    <td>100</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Plancha</td>
                                    <td>10</td>
                                    <td>150</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Lagartija</td>
                                    <td>50</td>
                                    <td>200</td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div> -->
        </div>
    </div>

    <div class="modal fade" id="exerciseLogModal" tabindex="-1" aria-labelledby="exerciseLogModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exerciseLogModalLabel">Editar ejercicio de rutina</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                    <form id="exerciseLog-form">
                        <input type="hidden" id="exercise-log-id">
                        <select class="form-select" aria-label="Default select example" id="inputEjercicioForm">
                            <!-- Se insertan ejercicios desde la base de datos -->
                            <option selected>Seleccione una opcion...</option>
                            <option value="1">Lagartijas</option>
                            <option value="2">Plancha</option>
                            <option value="3">Sentadilla</option>
                        </select>
                </div>
                <div class="mb-3">
                    <label for="inputRepeticiones" class="form-label">Repeticiones</label>
                    <input type="number" class="form-control" id="inputRepeticionesForm">
                </div>
                <div class="mb-3">
                    <label for="inputFecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control" id="inputFechaForm">
                </div>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>

                </form>
            </div>
        </div>
    </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="assets/js/ejercicios.js"></script>
</body>

</html>