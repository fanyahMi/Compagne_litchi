@extends('template.Layout')
@section('titre')
    Mouvement des navires
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
                Insertion des mouvement des navires
            </div>
            <div class="card-body">
                <form id="ajout_mouvementForm" action="ajout-mouvement" method="POST">
                    @csrf
                    <!-- Champ pour sélectionner une anne de compagne -->

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="compagne_id">Compagne</label>
                            <select id="compagne_id" name="compagne_id" class="form-control" required>
                                @foreach($compagnes as $compagne)
                                    <option value="{{ $compagne->id_compagne }}">{{ $compagne->annee }}</option>
                                @endforeach
                            </select>
                            <div id="error-compagne_id" class="error-message">Veuillez sélectionner une compagne.</div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="navire_id">Navire</label>
                            <select id="navire_id" name="navire_id" class="form-control" required>
                                @foreach($navires as $navire)
                                    <option value="{{ $navire->id_navire }}">{{ $navire->navire }}</option>
                                @endforeach
                            </select>
                            <div id="error-station_id" class="error-message"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="date_arrive">Date d'arrivé</label>
                            <input type="date" class="form-control" name="date_arrive" id="date_arrive" required>
                            <div id="error-date_arrive" class="error-message"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="depart">Date de depart</label>
                            <input type="date" class="form-control" name="depart" id="depart" >
                            <div id="error-depart" class="error-message"></div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Insérer</button>
                </form>

            </div>

            <!-- [Liste des réservations] -->
            <div class="card-body">
                <h5 class="c-black-900"></h5>
                <div class="mT-30">

                    <div id="table-container">
                        <table id="" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Compagne</th>
                                    <th>Navire</th>
                                    <th>Date d'arrivé</th>
                                    <th>Date de départ</th>
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

loadMouvement();

$('#ajout_mouvementForm').on('submit', function(event) {
    event.preventDefault();

    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            alert('Mouvement ajouté avec succès !');
            console.log(response);
            $('p.error-message').text(''); // Réinitialiser les messages d'erreur
            $('#ajout_mouvementForm')[0].reset(); // Réinitialiser le formulaire
            loadMouvement(); // Recharger les années ou autres données pertinentes
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


function loadMouvement() {
    $.ajax({
        url: '/get-mouvement',
        type: 'GET',
        success: function(data) {
            $('#table-body').empty();
            data.forEach(function(mouvement) {
               appendMouvement(mouvement);
            });
        },
        error: function(xhr, status, error) {
            console.error("Erreur lors du chargement des numéros de station : ", xhr);
        }
    });
}

function appendMouvement(mouvement) {
var button = mouvement.etat === 1
    ? '<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifierModal" data-id_mouvement="' + mouvement.id_numero_station + '">'+
    '<i class="fas fa-edit"></i></button>'
    : ''; // Hide the button if etat is not 0

var row = '<tr>' +
            '<td>' + mouvement.annee + '</td>' +
            '<td>' + mouvement.navire + '</td>' +
            '<td>' + mouvement.date_arrive + '</td>' +
            '<td>' + mouvement.date_depart + '</td>' +
            '<td>' + button + '</td>' +
          '</tr>';

    $('#table-body').append(row);
}


});
</script>
@endsection
