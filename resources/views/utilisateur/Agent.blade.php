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
                        <hr><form id="ajout_agentForm" action="{{ url('ajout-agent') }}" method="POST">
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
                                        @foreach($sexes as $sexe)
                                            <option value="{{ $sexe->id_sexe }}">{{ $sexe->sexe }}</option>
                                        @endforeach
                                    </select>
                                    <!-- Optional error message for 'sexe' -->
                                    <div class="mb-3">
                                        <div id="error-sexe" class="error-message text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="situation">Situation familiale</label>
                                    <select id="situation" name="situation" class="form-control" required>
                                        @foreach($situations as $situation)
                                            <option value="{{ $situation->id_situation_familial }}">{{ $situation->situation_familial }}</option>
                                        @endforeach
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
                                            <th>Date de naissance</th>
                                            <th>CIN</th>
                                            <th>Sexe</th>
                                            <th>Situation patrimonial</th>
                                            <th>Embauvher le</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body">
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

    loadAgent();
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
                        $('#error-' + key).text(messages[0]); // Ensure these elements exist
                    });
                }
            }
        });
    });

    $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id_agent');

            if (confirm('Êtes-vous sûr de vouloir supprimer cette agent ?')) {
                $.ajax({
                    url: '/supp-agent/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            alert(response.message);
                            loadAgent(); // Recharge les données après suppression
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Erreur lors de la suppression : ", error);
                    }
                });
            }
        });

    function loadAgent() {
        $.ajax({
            url: '/get-agent', // Assuming you're including this in a Blade file
            type: 'GET',
            success: function(data) {
                $('#table-body').empty();
                data.forEach(function(agent) {
                    appendAgent(agent);
                });
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors du chargement des réservations : ", error);
            }
        });
    }
    const sexes = @json($sexes); // Convert PHP array to JavaScript
    const situations = @json($situations);

    const sexeMap = {};
    sexes.forEach(sexe => {
        sexeMap[sexe.id_sexe] = sexe.sexe;
    });

    const situationMap = {};
    situations.forEach(situation => {
        situationMap[situation.id_situation_familial] = situation.situation_familial;
    });

    function appendAgent(agent) {
        var row = '<tr>' +
                  '<td>' + agent.nom + ' ' + agent.prenom + '</td>' + // Added space
                  '<td>' + agent.date_naissance + '</td>' +
                  '<td>' + agent.cin + '</td>' +
                  '<td>' + sexeMap[agent.sexe_id]+ '</td>' +
                  '<td>' + situationMap[agent.situation_familial_id] + '</td>' +
                  '<td>' + agent.created_at + '</td>' +
                  '<td>' +
                    '<button class="btn btn-danger btn-sm delete-btn" data-id_agent="' + agent.id_utilisateur + '">Supprimer</button>' +
                  '</td>' +
                  '</tr>';
        $('#table-body').append(row);
    }
});

</script>
@endsection
