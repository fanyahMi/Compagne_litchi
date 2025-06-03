@extends('template.Layout')
@section('titre')
    Numéro des stations
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
    #confirmation-message {
        font-size: 1rem;
        padding: 10px;
        display: flex;
        align-items: center;
    }
    #confirmation-message i {
        margin-right: 8px;
    }
    /* Appliquer une police normale à tous les éléments concernés */
    .card, .card-header, .card-body, label, input, select, button, table, th, td, b, span {
        font-weight: normal !important;
    }
    /* Masquer la carte des filtres par défaut */
    #filter-card {
        display: none;
    }
    /* Espacement pour les icônes dans les boutons */
    .btn i {
        margin-right: 5px;
    }
    .table-sm {
        font-size: 0.875rem; /* Taille de police réduite */
    }
    .table-sm th, .table-sm td {
        padding: 0.3rem; /* Espacement réduit */
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <!-- Bouton pour montrer/fermer les filtres, aligné à gauche -->
        <div class="mb-4 text-left">
            <button type="button" class="btn btn-secondary" id="show-filter-btn"><i class="fas fa-filter"></i> Afficher les filtres</button>
        </div>

        <!-- Card for Filters -->
        <div class="card mb-4" id="filter-card">
            <div class="card-header">
                <h5>Filtres</h5>
            </div>
            <div class="card-body">
                <div class="mT-30">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="filter-compagne">Campagne</label>
                            <select id="filter-compagne" class="form-control">
                                <option value="">Sélectionner l'année</option>
                                @foreach($compagnes as $compagne)
                                    <option value="{{ $compagne->id_compagne }}">{{ $compagne->annee }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filter-station">Station</label>
                            <select id="filter-station" class="form-control">
                                <option value="">Sélectionner</option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id_station }}">{{ $station->station }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filter-numero">Numéro Station</label>
                            <input type="number" class="form-control" id="filter-numero">
                        </div>
                        <div class="form-group col-md-3" style="align-content: flex-end">
                            <button type="button" class="btn btn-secondary" id="filter-btn"><i class="fas fa-search"></i> Filtrer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card for Form -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Insertion des numéros de station</h5>
            </div>
            <div class="card-body">
                <div id="confirmation-message" class="alert alert-success mt-3" role="alert" style="display: none;">
                    <i class="fas fa-check-circle mr-2"></i> Numéro de station enregistré
                </div>
                <form id="ajout_numero_station" action="ajout-numero" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="compagne_id">Campagne</label>
                            <select id="compagne_id" name="compagne_id" class="form-control" required>
                                <option value="">Sélectionner</option>
                                @foreach($compagnes as $compagne)
                                    <option value="{{ $compagne->id_compagne }}">{{ $compagne->annee }}</option>
                                @endforeach
                            </select>
                            <div id="error-compagne_id" class="error-message">Veuillez sélectionner une compagne.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="station_id">Station</label>
                            <select id="station_id" name="station_id" class="form-control" required>
                                <option value="">Sélectionner</option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id_station }}">{{ $station->station }}</option>
                                @endforeach
                            </select>
                            <div id="error-station_id" class="error-message">Veuillez sélectionner une station.</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="numero_station">Numéro Station</label>
                            <input type="number" class="form-control" name="numero_station" id="numero_station" min="1" required>
                            <div id="error-numero_station" class="error-message">Veuillez entrer un numéro de station valide.</div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Enregistrer</button>
                </form>
            </div>
        </div>

        <!-- Card for Table -->
        <div class="card">
            <div class="card-header">
                <h5>Liste des numéros de station</h5>
            </div>
            <div class="card-body">
                <div class="mT-30">
                    <div id="table-responsive" style="overflow-x: auto;">
                        <table class="table table-hover table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Compagne</th>
                                    <th>Station</th>
                                    <th>Numéro</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                            </tbody>
                        </table>
                    </div>
                    <div id="pagination" class="mt-3 text-center"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modifierModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModificationNumeroStation" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modification du numéro de station</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="modifier_numero-stationForm" method="POST">
                    @csrf
                    <input type="hidden" id="id_numero_station-modal" name="id_numero_station">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="compagne_id-modal">Campagne</label>
                            <select id="compagne_id-modal" name="compagne_id" class="form-control" required>
                                <option value="">Sélectionner</option>
                                @foreach($compagnes as $compagne)
                                    <option value="{{ $compagne->id_compagne }}">{{ $compagne->annee }}</option>
                                @endforeach
                            </select>
                            <div id="error-modal-compagne_id" class="error-message">Veuillez sélectionner une compagne.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="station_id-modal">Station</label>
                            <select id="station_id-modal" name="station_id" class="form-control" required>
                                <option value="">Sélectionner</option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id_station }}">{{ $station->station }}</option>
                                @endforeach
                            </select>
                            <div id="error-modal-station_id" class="error-message">Veuillez sélectionner une station.</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="numero_station-modal">Numéro Station</label>
                            <input type="number" class="form-control" id="numero_station-modal" name="numero_station" min="1" required>
                            <div id="error-modal-numero_station" class="error-message">Veuillez entrer un numéro de station valide.</div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Fermer</button>
                <button type="button" class="btn btn-primary" id="saveChangesBtn"><i class="fas fa-save"></i> Enregistrer</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<!-- Inclure Font Awesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function appendNumero(numero_stations) {
    const button = numero_stations.etat === 0
        ? `<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifierModal" data-id_numero_stations="${numero_stations.id_numero_station}"><i class="fas fa-edit"></i> Modifier</button>`
        : '';
    const row = `
        <tr>
            <td>${numero_stations.annee}</td>
            <td>${numero_stations.station}</td>
            <td>${numero_stations.numero_station}</td>
            <td>${button}</td>
        </tr>`;
    $('#table-body').append(row);
}

function appendPagination(data) {
    let pagination = '';

    if (data.prev_page_url) {
        pagination += '<button class="btn btn-primary mx-1" onclick="loadNumero_station(' + (data.current_page - 1) + ')">Précédent</button>';
    } else {
        pagination += '<button class="btn btn-secondary mx-1" disabled>Précédent</button>';
    }

    for (let i = 1; i <= data.last_page; i++) {
        pagination += '<button class="btn ' + (i === data.current_page ? 'btn-dark' : 'btn-light') + ' mx-1" onclick="loadNumero_station(' + i + ')">' + i + '</button>';
    }

    if (data.next_page_url) {
        pagination += '<button class="btn btn-primary mx-1" onclick="loadNumero_station(' + (data.current_page + 1) + ')">Suivant</button>';
    } else {
        pagination += '<button class="btn btn-secondary mx-1" disabled>Suivant</button>';
    }

    $('#pagination').html(pagination);
}

function loadNumero_station(page = 1) {
    const compagne = $('#filter-compagne').val();
    const station = $('#filter-station').val();
    const numero = $('#filter-numero').val();
    $.ajax({
        url: '/get-numero-station?page=' + page,
        type: 'GET',
        data: {
            compagne: compagne,
            station: station,
            numero_station: numero
        },
        success: function(data) {
            $('#table-body').empty();
            data.data.forEach(function(numero_stations) {
                appendNumero(numero_stations);
            });
            appendPagination(data);
        },
        error: function(xhr, status, error) {
            console.error("Erreur lors du chargement des numéros de station : ", error);
        }
    });
}

$(document).ready(function() {
    // Gestion du bouton "Afficher/Masquer les filtres"
    $('#show-filter-btn').on('click', function() {
        if ($('#filter-card').is(':visible')) {
            $('#filter-card').slideUp();
            $(this).html('<i class="fas fa-filter"></i> Afficher les filtres').removeClass('btn-danger').addClass('btn-secondary');
        } else {
            $('#filter-card').slideDown();
            $(this).html('<i class="fas fa-times"></i> Fermer les filtres').removeClass('btn-secondary').addClass('btn-danger');
        }
    });

    $('#filter-btn').on('click', function() {
        loadNumero_station(1);
    });

    loadNumero_station(1);

    $('#ajout_numero_station').on('submit', function(event) {
        event.preventDefault();
        $('.error-message').hide();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#ajout_numero_station')[0].reset();
                loadNumero_station();
                $('#confirmation-message').fadeIn().delay(3000).fadeOut();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, messages) {
                        $('#error-' + key).text(messages[0]).show();
                    });
                } else {
                    $('#confirmation-message')
                        .removeClass('alert-success')
                        .addClass('alert-danger')
                        .html('<i class="fas fa-exclamation-circle mr-2"></i> Erreur : ' + xhr.responseJSON.message)
                        .fadeIn().delay(3000).fadeOut();
                }
            }
        });
    });

    $(document).on('click', '.btn[data-toggle="modal"][data-target="#modifierModal"]', function() {
        var id = $(this).data('id_numero_stations');
        $.ajax({
            url: '/get-numero-station/' + id,
            type: 'GET',
            success: function(numero_stationData) {
                $('#id_numero_station-modal').val(numero_stationData.id_numero_station);
                $('#compagne_id-modal').val(numero_stationData.id_compagne).trigger('change');
                $('#station_id-modal').val(numero_stationData.id_station).trigger('change');
                $('#numero_station-modal').val(numero_stationData.numero_station);
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors de la récupération du numéro de station : ", error);
            }
        });
    });

    $('#saveChangesBtn').on('click', function(e) {
        e.preventDefault();
        $('.error-message').hide();
        var formData = $('#modifier_numero-stationForm').serialize();
        $.ajax({
            url: '/update-numero-station',
            method: 'PUT',
            data: formData,
            success: function(response) {
                $('#modifier_numero-stationForm')[0].reset();
                $('#modifierModal').modal('hide');
                loadNumero_station();
                $('#confirmation-message').fadeIn().delay(3000).fadeOut();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, messages) {
                        $('#error-modal-' + key).text(messages[0]).show();
                    });
                } else {
                    $('#confirmation-message')
                        .removeClass('alert-success')
                        .addClass('alert-danger')
                        .html('<i class="fas fa-exclamation-circle mr-2"></i> Erreur : ' + xhr.responseJSON.message)
                        .fadeIn().delay(3000).fadeOut();
                }
            }
        });
    });
});
</script>
@endsection