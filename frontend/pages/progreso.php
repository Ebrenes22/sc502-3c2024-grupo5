<?php
    $page = 'progreso.php';
    ?>
    
    <div class="container my-4">
        <h1 class="text-center mb-4" >Sigue tu progreso</h1>
        <div class="d-flex justify-content-center mb-4" >
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#progressModal">Añadir nueva entrada de progreso</button>
        </div>
        <div id="progress-list" class="row">

        </div>
    </div>

    <div class="modal fade" id="progressModal" tabindex="-1" aria-labelledby="progressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="progressModalLabel">Add Progress</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="progress-form">
                    <input type="hidden" id="progress-id">
                    
                    <div class="mb-3">
                        <label for="exercise-log-id" class="form-label">Exercise Log ID</label>
                        <input type="number" class="form-control" id="exercise-log-id" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="weight" class="form-label">Weight (kg)</label>
                        <input type="number" step="0.1" class="form-control" id="weight" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="calories-consumed" class="form-label">Calories Consumed</label>
                        <input type="number" class="form-control" id="calories-consumed" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="calories-burned" class="form-label">Calories Burned</label>
                        <input type="number" class="form-control" id="calories-burned" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="exercises-completed" class="form-label">Exercises Completed</label>
                        <input type="number" class="form-control" id="exercises-completed" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="hours-sleep" class="form-label">Hours of Sleep</label>
                        <input type="number" step="0.1" class="form-control" id="hours-sleep" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="distance-km" class="form-label">Distance (km)</label>
                        <input type="number" step="0.1" class="form-control" id="distance-km" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="recorded-at" class="form-label">Recorded At</label>
                        <input type="datetime-local" class="form-control" id="recorded-at" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="meats" class="form-label">Meals (JSON Format)</label>
                        <textarea class="form-control" id="meats" rows="3" placeholder='{"breakfast": "Oatmeal", "lunch": "Grilled chicken", "dinner": "Salmon"}'></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Save Progress</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <div style="width: 100%; max-width: 600px; margin: auto;">
        <canvas id="graficaSueno"></canvas>
    </div>

    <div style="width: 100%; max-width: 600px; margin: auto;">
        <canvas id="graficaAgua"></canvas>
    </div>

    <div style="width: 100%; max-width: 600px; margin: auto;">
        <canvas id="graficaCardio"></canvas>
    </div>

    <div style="width: 100%; max-width: 600px; margin: auto;">
        <canvas id="graficaCalorias"></canvas>
    </div>


    </div>
    <script type="module" src="assets/js/progress.js"></script>
