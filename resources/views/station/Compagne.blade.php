@extends('template.Layout')
@section('titre')
    Compagne
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
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Ajouter l'anné de compagne</h4>
            </div>
            <div class="card-body">
                <form id="create_compagne_form" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="annee">Annee de compagne</label>
                            <input type="number" class="form-control" name="annee" id="annee" min="1800" required>
                            <div id="error-annee" class="error-message">Veuillez entrer une date.</div>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="debut">Debut</label>
                            <input type="date" class="form-control" name="debut" id="debut" min="1" required>
                            <div id="error-debut" class="error-message">Veuillez entrer une date.</div>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="fin">Fin</label>
                            <input type="date" class="form-control" name="fin" id="fin" min="1" required>
                            <div id="error-fin" class="error-message">Veuillez entrer une date.</div>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
            <div class="card-body">
                <div class="mT-30">
                    <div id="table-container table-responsive">
                        <table id="" class="table table-hover table-bordered ">
                            <thead>
                                <tr>
                                    <th>Annee de compagne</th>
                                    <th>Date de debut</th>
                                    <th>Fin </th>
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
</div>
@endsection
@section('script')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadAgent();
    $('#create_compagne_form').on('submit', function(event) {
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
                loadAgent();
            },
            error: function(xhr) {
                $('p.error-message').text('');
                $('#error-message').text('');
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, messages) {
                        $('#error-' + key).text(messages[0]);
                    });
                }
            }
        });
    });

    function loadAgent() {
        $.ajax({
            url: '/get-agent',
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

    function appendAgent(agent) {
        var row = '<tr>' +
                '<td>' + agent.matricule  + '</td>' +
                  '<td>' + agent.nom + ' ' + agent.prenom + '</td>' + // Added space
                  '<td>' + agent.date_naissance + '</td>' +
                  '<td>' + agent.cin + '</td>' +
                  '<td>' + sexeMap[agent.sexe_id]+ '</td>' +
                  '<td>' + situationMap[agent.situation_familial_id] + '</td>' +
                  '<td>' + agent.created_at + '</td>' +
                  '<td>' + roleMap[agent.role_id] + '</td>' +
                  '<td>' +
                    '<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifierModal" data-id_agent="' + agent.id_utilisateur + '">' +
                    '<i class="fas fa-edit"></i></button>' +
                  '</td>' +
                  '<td>' +
                    '<button class="btn btn-danger btn-sm delete-btn" data-id_agent="' + agent.id_utilisateur + '">' +
                    '<i class="fas fa-trash-alt"></i></button>' +
                  '</td>' +
                  '</tr>';
        $('#table-body').append(row);
    }
</script>
@endsection
