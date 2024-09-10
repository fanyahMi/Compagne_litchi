<style>
    .error-message {
        color: red;
        margin-top: 5px;
    }

    /* Styles pour le modal */
    .modal2 {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
    }

    .modal2-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        padding: 20px;
        max-width: 600px; /* Ajustement de la largeur maximale */
        width: 80%;
        text-align: center;
    }

    .modal2-title {
        font-size: 24px; /* Augmentation de la taille du titre */
        font-weight: bold;
        margin-bottom: 15px;
    }

    .modal2-body {
        max-height: 300px; /* Hauteur maximale pour le défilement */
        overflow-y: auto; /* Activation du défilement vertical */
        margin-bottom: 15px;
    }

    .modal2-footer {
        text-align: center;
    }

    .modal2-button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .modal2-button:hover {
        background-color: #0056b3;
    }

    /* Style pour la table */
    .error-table {
        width: 100%;
        border-collapse: collapse;
    }

    .error-table th,
    .error-table td {
        border: 1px solid #ccc;
        padding: 8px;
    }

    .error-table thead th {
        background-color: #f2f2f2;
    }
</style>



<!-- Modal -->
<div id="errorModal" class="modal2">
    <div class="modal2-content">
        <h2 class="modal2-title">Erreur sur l'importation</h2>
        <div class="modal2-body">
            <div class="table-responsive"> <!-- Ajout d'une classe pour permettre le défilement -->
                <table class="error-table table table-striped">
                    <thead>
                        <tr>
                            <th style="position: sticky; top: 0; background-color: #fff;">Ligne</th>
                            <th style="position: sticky; top: 0; background-color: #fff;">Erreur</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(Session::has('errorsImp'))
                            @foreach (Session::get('errorsImp') as $error)
                                @foreach ($error['errors'] as $errorMessage)
                                    <tr>
                                        <td>{{ $error['line'] }}</td>
                                        <td>{{ $errorMessage }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal2-footer">
            <button id="closeModalBtn" class="modal2-button">Fermer</button>
        </div>
    </div>
</div>


<!-- Modal de progression -->
<div id="progressModal" class="modal2">
    <div class="modal2-content">
        <h2 class="modal2-title">Importation en cours</h2>
        <div class="modal2-body">
            <progress id="importProgress" value="0" max="100"></progress>
            <p id="progressMessage">Veuillez patienter pendant l'importation...</p>
        </div>
    </div>
</div>



<div class="masonry-item col-md-12">
    <div class="bgc-white p-20 bd">
        <h6 class="c-grey-900">Import</h6>
        <div class="mT-30">
            <form id="FormImporter" enctype="multipart/form-data">

                <!-- CSRF Token -->
                @csrf

                <!-- CSV File Field -->
                <div class="row mT-15">
                    <div class="mb-12 col-md-12">
                        <label class="form-label" for="csv_file">Fichier CSV</label>
                        <input type="file" name="csv_fileImp" class="form-control" id="csv_fileImp" accept="text/csv">
                        <span id="csv_fileImp_error" class="error-message"></span>
                    </div>
                </div>

                <!-- Excel File Field -->
                <div class="row mT-15">
                    <div class="mb-12 col-md-12">
                        <label class="form-label" for="excel_file">Fichier Excel</label>
                        <input type="file" name="excel_fileImp" class="form-control" id="excel_fileImp" accept=".xlsx, .xls">
                        <span id="excel_fileImp_error" class="error-message"></span>
                    </div>
                </div>

                <!-- Bouton de soumission -->
                <br>
                <button type="button" class="btn btn-primary btn-color" onclick="submitForm()">Importer</button>
            </form>
        </div>
    </div>
</div>

<script>
    function submitForm() {
        $('#csv_fileImp_error').text("");
        $('#excel_fileImp_error').text("");
        var formData = new FormData($('#FormImporter')[0]);
        $('#progressModal').show();
        var steps = 10;
        var currentStep = 0;

        function performStep() {
            currentStep++;
            var percentComplete = (currentStep / steps) * 100;
            $('#importProgress').attr('value', percentComplete);
            $('#progressMessage').text('Importation en cours... ' + Math.round(percentComplete) + '%');
            if (currentStep < steps) {
                setTimeout(performStep, 1500);
            } else {
                $('#progressModal').hide();
            }
        }

        performStep();

        $.ajax({
            url: "{{ url('importerFinal') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
            },
            error: function(xhr, status, error) {
                if(xhr.responseJSON) {
                    $('#progressModal').hide();
                    var errors = xhr.responseJSON;
                    console.log(errors);
                    if(errors.errors.csv_fileImp != null) {
                        $('#csv_fileImp_error').text(errors.errors.csv_fileImp[0]);
                    }
                    if(errors.errors.excel_fileImp){
                        $('#excel_fileImp_error').text(errors.errors.excel_fileImp[0]);
                    }
                    else if(errors.errors) {
                        displayErrors(errors.errors);
                    }
                }
            }
        });
    }

    function displayErrors(errors) {
        var errorTableBody = $('#errorModal .error-table tbody');
        errorTableBody.empty();
        $.each(errors, function(index, error) {
            $.each(error.errors, function(_, errorMessage) {
                var errorRow = $('<tr>');
                errorRow.append($('<td>').text(error.line));
                errorRow.append($('<td>').text(errorMessage));
                errorTableBody.append(errorRow);
            });
        });
        $('#errorModal').show();
    }

    $(document).ready(function() {
        $('#closeModalBtn').click(function() {
            $('#errorModal').hide();
        });
    });


</script>



