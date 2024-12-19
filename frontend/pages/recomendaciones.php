<?php
    $page = 'recomendaciones.php';
    ?>
    

    <div class="container">
    <h1>Recomendaciones</h1>


    <div id="progress-list" class="row"></div>

    <div class="modal fade" id="recommendationsModal" tabindex="-1" aria-labelledby="recommendationsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="recommendationsModalLabel">Add Recommendation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="recommendations-form">
                    <input type="hidden" id="recommendations-id">

                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <input type="text" class="form-control" id="type" placeholder="e.g., Diet, Exercise" required>
                    </div>

                    <div class="mb-3">
                        <label for="min-weight" class="form-label">Min Weight (kg)</label>
                        <input type="number" step="0.1" class="form-control" id="min-weight" required>
                    </div>

                    <div class="mb-3">
                        <label for="max-weight" class="form-label">Max Weight (kg)</label>
                        <input type="number" step="0.1" class="form-control" id="max-weight" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Salvar Recomendación</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="recommendation-list" class="row"></div>




    </div>
    <script type="module" src="assets/js/recomendaciones.js"></script>
