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
                                    <div class="mb-3">
                                        <div id="error-nom" class="error-message text-danger"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="prenom">Prénom</label>
                                    <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prénom">
                                    <!-- Optional error message for 'prenom' -->
                                    <div class="mb-3">
                                        <div id="error-prenom" class="error-message text-danger"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="dateNaissance">Date de naissance</label>
                                    <input type="date" class="form-control" name="dateNaissance" id="dateNaissance">
                                    <div class="mb-3">
                                        <div id="error-dateNaissance" class="error-message text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="cin">CIN</label>
                                    <input type="text" class="form-control" name="cin" id="cin" maxlength="12">
                                    <div class="mb-3">
                                        <div id="error-cin" class="error-message text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="sexe">Sexe</label>
                                    <select id="sexe" name="sexe" class="form-control" required>
                                        <option value="">Sélectionner</option>
                                        <option value="M">Masculin</option>
                                        <option value="F">Féminin</option>
                                    </select>
                                    <!-- Optional error message for 'sexe' -->
                                    <div class="mb-3">
                                        <div id="error-sexe" class="error-message text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="situation">Situation familiale</label>
                                    <select id="situation" name="situation" class="form-control" required>
                                        <option value="">Sélectionner</option>
                                        <option value="Célibataire">Célibataire</option>
                                        <option value="Marié">Marié</option>
                                    </select>
                                    <!-- Optional error message for 'situation' -->
                                    <div class="mb-3">
                                        <div id="error-situation" class="error-message text-danger"></div>
                                    </div>
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
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert('Agent ajouté avec succès !');
                console.log(response);
                $('p.error-message').text('');
                $('#ajout_agentForm')[0].reset();
            },
            error: function(xhr) {
                $('p.error-message').text('');
                $('#error-message').text('');

                console.log(xhr);

                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                     $.each(errors, function(key, messages) {
                        console.log('#' + key, messages[0]);
                        $('#error-' + key).text(messages[0]);
                    });
                }
            }
        });
    });
});

</script>
@endsection
