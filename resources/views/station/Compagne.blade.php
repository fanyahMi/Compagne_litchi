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
                <form id="create_compagne_form" action="ajout-compagne" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="annee">Annee de compagne</label>
                            <input type="number" class="form-control" name="annee" id="annee" min="1800" required>
                            <div id="error-annee" class="error-message"></div>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="debut">Debut</label>
                            <input type="month" class="form-control" name="debut" id="debut" min="1" required>
                            <div id="error-debut" class="error-message"></div>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="fin">Fin</label>
                            <input type="month" class="form-control" name="fin" id="fin" min="1" required>
                            <div id="error-fin" class="error-message"></div>
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

    //loadAnnee();
    $('#create_compagne_form').on('submit', function(event) {
        event.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert('Agent ajouté avec succès !');
                console.log(response);
                $('p.error-message').text(''); // Réinitialiser les messages d'erreur
                $('#create_compagne_form')[0].reset(); // Réinitialiser le formulaire
                //loadAnnee(); // Recharger les années ou autres données pertinentes
            },
            error: function(xhr) {
                $('p.error-message').text(''); // Réinitialiser les messages d'erreur
                $('#error-message').text(''); // Réinitialiser le message global d'erreur

                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;

                    // Pour chaque champ ayant une erreur, afficher tous les messages d'erreur
                    $.each(errors, function(key, messages) {
                        var errorMessages = '';
                        $.each(messages, function(index, message) {
                            errorMessages += message + '<br>'; // Concatenation des messages d'erreur
                        });
                        $('#error-' + key).html(errorMessages); // Afficher toutes les erreurs pour le champ
                    });
                }
            }
        });
    });

    function loadAnnee() {
        $.ajax({
            url: '/get-compagne',
            type: 'GET',
            success: function(data) {
                $('#table-body').empty();
                data.forEach(function(compagne) {
                    appendAnneCompagne(compagne);
                });
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors du chargement des années de compagnes : ", error);
            }
        });
    }

    function appendAnneCompagne(compagne) {
        var row = '<tr>' +
                    '<td>' + compagne.annee  + '</td>' +
                    '<td>' + compagne.debut + '</td>' + // Added space
                    '<td>' + compagne.fin + '</td>' +
                    '<td>' + compagne.etat + '</td>' +
                  '</tr>';
        $('#table-body').append(row);
    }
</script>
@endsection
