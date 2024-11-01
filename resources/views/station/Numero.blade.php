@extends('template.Layout')
@section('titre')
    Numero des stations
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
                            <label for="compagne_id">compagne</label>
                            <select id="compagne_id" name="compagne_id" class="form-control" required>
                                @foreach($compagnes as $compagne)
                                    <option value="{{ $compagne->id_compagne }}">{{ $compagne->annee }}</option>
                                @endforeach
                            </select>
                            <div id="error-compagne_id" class="error-message">Veuillez sélectionner une compagne.</div>
                        </div>
                    </div>


                    <!-- Champ pour entrer le numéro de station -->
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="station_id">Station</label>
                            <select id="station_id" name="station_id" class="form-control" required>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id_station }}">{{ $station->station }}</option>
                                @endforeach
                            </select>
                            <div id="error-station_id" class="error-message"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="numero_station">Numero Station</label>
                            <input type="number" class="form-control" name="numero_station" id="numero_station" required>
                            <div id="error-numero_station" class="error-message"></div>
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

<div id="modifierModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModificationAgent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="modifier_numero-stationForm" action="" method="POST">
                    @csrf
                    <input type="hidden" id="id_numero_station-modal" name="id_numero_station">
                    <div class="form-group">
                        <label for="compagne_id">Compagne</label>
                        <select id="compagne_id-modal" name="compagne_id" class="form-control">
                            <option value="">Sélectionner</option>
                            @foreach($compagnes as $compagne)
                                <option value="{{ $compagne->id_compagne }}">{{ $compagne->annee }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div  class="form-group">
                        <div id="error-modal-compagne_id" class="error-message text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label for="station_id">Station</label>
                        <select id="station_id-modal" name="station_id" class="form-control">
                            <option value="">Sélectionner</option>
                            @foreach($stations as $station)
                                <option value="{{ $station->id_station }}">{{ $station->station }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div  class="form-group">
                        <div id="error-modal-station_id" class="error-message text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label for="numero_station">Numero</label>
                        <input type="text" class="form-control" id="numero_station-modal" name="numero_station">
                    </div>
                    <div  class="form-group">
                        <div id="error-modal-numero_station" class="error-message text-danger"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn  btn-primary" id="saveChangesBtn">Modifier</button>
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
        ? '<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifierModal" data-id_numero_stations="' + numero_stations.id_numero_station + '">'+
        '<i class="fas fa-edit"></i></button>'
        : ''; // Hide the button if etat is not 0

    var row = '<tr>' +
                '<td>' + numero_stations.annee + '</td>' +
                '<td>' + numero_stations.station + '</td>' +
                '<td>' + numero_stations.numero_station + '</td>' +
                '<td>' + button + '</td>' +
              '</tr>';

        $('#table-body').append(row);
    }


    $(document).on('click', '.btn[data-toggle="modal"][data-target="#modifierModal"]', function() {
        var id = $(this).data('id_numero_stations');
        $.ajax({
            url: '/get-numero-station/' + id,
            type: 'GET',
            success: function(numero_stationData) {
                $('#id_numero_station-modal').val(numero_stationData.id_numero_station);
                $('#compagne_id-modal').val(numero_stationData.id_compagne);
                $('#station_id-modal').val(numero_stationData.id_station).trigger('change');
                $('#numero_station-modal').val(numero_stationData.numero_station);
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors de la récupération de l'agent : ", xhr);
            }
        });
    });

    $('#saveChangesBtn').on('click', function(e) {
        e.preventDefault();
        var formData = $('#modifier_numero-stationForm').serialize();
        $.ajax({
            url: '/update-numero-station',
            method: 'PUT',
            data: formData,
            success: function(response) {
                alert('Modifications enregistrées avec succès !');
                $('#modifierModal').modal('hide');
                loadNumero_station();
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, messages) {
                    $('#error-modal-' + key).text(messages[0]);
                });
            }
        });
    });

});
</script>
@endsection
