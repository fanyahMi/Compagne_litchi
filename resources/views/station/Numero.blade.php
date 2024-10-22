@extends('template.Layout')
@section('titre')
    Entre magasin
@endsection
@section('page')

<style>
    .error-message {
        color: red;
        font-size: 14px;
        padding: 5px;
        margin-top: 5px;
        display: none;
    }
    .card-header {
        padding: 15px;
        font-size: 18px;
        font-weight: bold;
    }
    .card-body {
        padding: 20px;
    }
    .form-group label {
        font-weight: bold;
    }
    .table th {
        background-color: #007bff;
        color: white;
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                Insertion des numero de station
            </div>
            <div class="card-body">
                <form id="ajout_numero_station" action="ajout-numero" method="POST">
                    @csrf
                    <!-- Champ pour sélectionner une anne de compagne -->

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="compagne">compagne</label>
                            <select id="compagne" name="compagne_id" class="form-control" required>
                                @foreach($compagnes as $compagne)
                                    <option value="{{ $compagne->id_compagne }}">{{ $compagne->annee }}</option>
                                @endforeach
                            </select>
                            <div id="error-compagne" class="error-message">Veuillez sélectionner une compagne.</div>
                        </div>
                    </div>


                    <!-- Champ pour entrer le numéro de station -->
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="station">Station</label>
                            <select id="station" name="station_id" class="form-control" required>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id_station }}">{{ $station->station }}</option>
                                @endforeach
                            </select>
                            <div id="error-station" class="error-message">Veuillez sélectionner une station.</div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="numero_station">Numero Station</label>
                            <input type="number" class="form-control" name="numero_station" id="numero_station" required>
                            <div id="error-numero_station" class="error-message">Veuillez entrer un numéro de station.</div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Insérer</button>
                </form>

            </div>

            <!-- [Liste des réservations] -->
            <div class="card-body">
                <h5 class="c-black-900"><b>Liste numereo station</b></h5>
                <div class="mT-30">

                    <div id="table-container">
                        <table id="" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Compagne</th>
                                    <th>Station</th>
                                    <th>Numero</th>
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
<script src="assets/js/plugins/jquery-ui.min.js"></script>
<script>
$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadNumero_station();

    $('#ajout_numero_station').on('submit', function(event) {
        event.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert('Numéro de station ajouté avec succès !');
                console.log(response);
                $('p.error-message').text(''); // Réinitialiser les messages d'erreur
                $('#ajout_numero_station')[0].reset(); // Réinitialiser le formulaire
                loadNumero_station(); // Recharger les années ou autres données pertinentes
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


    function loadNumero_station() {
        $.ajax({
            url: '/get-numero-station',
            type: 'GET',
            success: function(data) {
                $('#table-body').empty();
                data.forEach(function(numero_stations) {
                   appendNumero(numero_stations);
                });
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors du chargement des numéros de station : ", xhr);
            }
        });
    }



    function appendNumero(numero_stations) {
    // Check if the etat is 0 (modifiable) or not
    var button = numero_stations.etat === 1
        ? '<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifierModal" data-id_numero_stations="' + numero_stations.id_numero_stations_magasin + '">Modifier</button>'
        : ''; // Hide the button if etat is not 0

    var row = '<tr>' +
                '<td>' + numero_stations.annee + '</td>' +
                '<td>' + numero_stations.station + '</td>' +
                '<td>' + numero_stations.numero_station + '</td>' +
                '<td>' + button + '</td>' +
              '</tr>';

    $('#table-body').append(row);
}






});
</script>
@endsection
