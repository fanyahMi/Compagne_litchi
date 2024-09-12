@extends('template.Layout')
@section('titre')
    Liste des agents
@endsection
@section('page')
<style>

    #error-message {
    color: red;
    display: block !important; /* Assurez-vous que le message est affiché */
    font-size: 14px; /* Ajustez la taille de la police si nécessaire */
    padding: 5px;
    margin-top: 10px;
}

</style>
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ form-element ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mt-5">Insertion de nouvel agent</h5>
                        <hr><form id="ajout_agentForm" action="{{ url('ajout_agent') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom">
                                    @error('nom')
                                        <p class="error-message" style="color: red;">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="prenom">Prénom</label>
                                    <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prénom">
                                    <!-- Optional error message for 'prenom' -->
                                    @error('prenom')
                                        <p class="error-message" style="color: red;">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="dateNaissance">Date de naissance</label>
                                    <input type="date" class="form-control" name="dateNaissance" id="dateNaissance">
                                    @error('dateNaissance')
                                        <p class="error-message" style="color: red;">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="cin">CIN</label>
                                    <input type="text" class="form-control" name="cin" id="cin" maxlength="12">
                                    @error('cin')
                                        <p class="error-message" style="color: red;">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="sexe">Sexe</label>
                                    <select id="sexe" name="sexe" class="form-control" required>
                                        <option value="">Sélectionner</option>
                                        <option value="M">Masculin</option>
                                        <option value="F">Féminin</option>
                                    </select>
                                    <!-- Optional error message for 'sexe' -->
                                    @error('sexe')
                                        <p class="error-message" style="color: red;">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="situation">Situation familiale</label>
                                    <select id="situation" name="situation" class="form-control" required>
                                        <option value="">Sélectionner</option>
                                        <option value="Célibataire">Célibataire</option>
                                        <option value="Marié">Marié</option>
                                    </select>
                                    <!-- Optional error message for 'situation' -->
                                    @error('situation')
                                        <p class="error-message" style="color: red;">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Insérer</button>
                        </form>
                        <div id="error-message" class="error-message"></div>
                    </div>
                    <div class="card-body">
                        <h5 class="c-black-900"><b>Liste des réservations</b></h5>
                        <div class="mT-30">
                            <div id="table-container">
                                <table id="produitTable" class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nom et prénom</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body">
                                        <tr>
                                            <td>fft</td>
                                            <td>hdgyg</td>
                                            <td>jhgdgu</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ form-element ] end -->
        </div>
        <!--  Liste   --->

@endsection
@section('script')

<script src="assets/js/plugins/jquery-ui.min.js"></script>
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#ajout_agentForm').on('submit', function(event) {
        event.preventDefault(); // Prevent page reload

        $.ajax({
            url: $(this).attr('action'), // Get form's action URL
            method: 'POST', // Request method
            data: $(this).serialize(), // Serialize form data
            success: function(response) {
                alert('Agent ajouté avec succès !');
                console.log(response);
                $('p.error-message').text(''); // Clear previous error messages
                $('#ajout_agentForm')[0].reset(); // Optionally reset the form
            },
            error: function(xhr) {
                // Clear all previous error messages
                $('p.error-message').text(''); // Clear all previous error messages
                try {
                    var responseJSON = $.parseJSON(xhr.responseText);
                    if (responseJSON.errors) {
                        // Display errors below respective fields
                        $.each(responseJSON.errors, function(key, messages) {
                            $('#' + key).siblings('.error-message').text(messages.join(', '));
                        });
                    } else {
                        $('#errorMessage').text('Erreur inconnue: ' + xhr.responseText);
                    }
                } catch (e) {
                    $('#errorMessage').text('Erreur inconnue: ' + xhr.responseText);
                }
            }
        });
    });
});
</script>
@endsection
