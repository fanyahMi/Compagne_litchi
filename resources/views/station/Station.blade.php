@extends('template.Layout')
@section('titre')
    Liste des stations
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
    /* Appliquer une police normale */
    .card, .card-header, .card-body, label, input, select, button, table, th, td, b {
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
    /* Style pour les conteneurs de messages */
    #success-message, #error-message {
        font-size: 14px;
        padding: 10px;
        margin-top: 10px;
        display: none;
        border-radius: 4px;
    }
    #success-message {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
        display: flex;
        align-items: center;
    }
    #error-message {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
        display: flex;
        align-items: center;
    }
    #success-message i, #error-message i {
        margin-right: 8px;
    }
    /* Style pour le tableau responsive */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 1rem;
    }
    .table-sm th, .table-sm td {
        padding: 0.3rem;
        font-size: 0.875rem;
    }
    @media (max-width: 768px) {
        .table-sm th, .table-sm td {
            padding: 0.2rem;
            font-size: 0.75rem;
        }
    }
</style>

<!-- [ Main Content ] start -->
<div class="row">
    <div class="col-sm-12">
        <!-- Conteneurs pour les messages -->
        
        <div id="error-message" class="error-message" style="display: none;"></div>

        <!-- Bouton pour montrer/fermer les filtres -->
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
                        <div class="form-group col-md-4">
                            <label for="filter-name">Nom</label>
                            <input type="text" class="form-control" id="filter-name" placeholder="Filtrer par nom">
                        </div>
                        <div class="form-group col-md-2" style="align-content: flex-end">
                            <button type="button" class="btn btn-secondary" id="filter-btn"><i class="fas fa-search"></i> Filtrer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card for Insertion -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Insertion de nouvelle Station</h5>
            </div>
            <div class="card-body">
                <div id="success-message" style="display: none;">
                    <i class="fas fa-check-circle mr-2"></i> Confirmation enregistrée
                </div>
                <form id="ajout_stationForm" action="{{ url('ajout-station') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="nom">Nom</label>
                            <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom">
                            <div class="mb-3">
                                <div id="error-nom" class="error-message text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nif_stat">NIF</label>
                            <input type="text" class="form-control" name="nif_stat" id="nif_stat" maxlength="13">
                            <div class="mb-3">
                                <div id="error-nif_stat" class="error-message text-danger"></div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Insérer</button>
                </form>
            </div>
        </div>

        <!-- Card for List -->
        <div class="card">
            <div class="card-header">
                <h5>Liste des stations</h5>
            </div>
            <div class="card-body">
                <div class="mT-30">
                    <div id="table-container" class="table-responsive">
                        <table id="produitTable" class="table table-hover table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Station</th>
                                    <th>NIF/STAT</th>
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
<!-- Liste --->

<!-- [ modal ] start -->
<div id="modifierModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modificationstation" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="modifier_stationForm" action="" method="POST">
                    @csrf
                    <input type="hidden" id="id_station-modal" name="id_station">
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" id="nom-modal" name="nom">
                        <div id="error-modal-nom" class="error-message text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label for="nif_stat">NIF</label>
                        <input type="text" class="form-control" id="nif_stat-modal" name="nif_stat" maxlength="13">
                        <div id="error-modal-nif_stat" class="error-message text-danger"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                <button type="button" class="btn btn-primary" id="saveChangesBtn"><i class="fas fa-save"></i> Modifier</button>
            </div>
        </div>
    </div>
</div>
<!-- [ modal ] end -->

@endsection
@section('script')

<!-- Inclure Font Awesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="assets/js/plugins/jquery-ui.min.js"></script>
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function appendStation(station) {
    var row = '<tr>' +
              '<td><a href="{{ url("station/historique-quotas") }}?id_station=' + station.id_station + '">' + station.station + '</a></td>' +
              '<td>' + station.nif_stat + '</td>' +
              '<td class="col-md-2">' +
                '<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifierModal" data-id_station="' + station.id_station + '"><i class="fas fa-edit"></i> Modifier</button>' +
              '</td>' +
              '</tr>';
    $('#table-body').append(row);
}

function appendPagination(data) {
    let pagination = '';
    if (data.prev_page_url) {
        pagination += '<button class="btn btn-primary mx-1" onclick="loadstation(' + (data.current_page - 1) + ')">Précédent</button>';
    } else {
        pagination += '<button class="btn btn-secondary mx-1" disabled>Précédent</button>';
    }
    for (let i = 1; i <= data.last_page; i++) {
        pagination += '<button class="btn ' + (i === data.current_page ? 'btn-dark' : 'btn-light') + ' mx-1" onclick="loadstation(' + i + ')">' + i + '</button>';
    }
    if (data.next_page_url) {
        pagination += '<button class="btn btn-primary mx-1" onclick="loadstation(' + (data.current_page + 1) + ')">Suivant</button>';
    } else {
        pagination += '<button class="btn btn-secondary mx-1" disabled>Suivant</button>';
    }
    $('#pagination').html(pagination);
}

function loadstation(page = 1) {
    const name = $('#filter-name').val();
    $.ajax({
        url: '/get-station?page=' + page,
        type: 'GET',
        data: {
            name: name,
        },
        success: function(data) {
            $('#table-body').empty();
            $('#pagination').empty();
            data.data.forEach(function(station) {
                appendStation(station);
            });
            appendPagination(data);
        },
        error: function(xhr, status, error) {
            console.error("Erreur lors du chargement des stations : ", error);
            $('#error-message')
                .html('<i class="fas fa-exclamation-circle mr-2"></i> Erreur lors du chargement des stations')
                .fadeIn().delay(3000).fadeOut();
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
        loadstation(1);
    });

    loadstation(1);

    $('#ajout_stationForm').on('submit', function(event) {
        event.preventDefault();
        $('.error-message').hide();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#ajout_stationForm')[0].reset();
                loadstation();
                $('#success-message').fadeIn().delay(3000).fadeOut();
            },
            error: function(xhr) {
                $('.error-message').hide();
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, messages) {
                        $('#error-' + key).text(messages[0]).show();
                    });
                } else {
                    $('#error-message')
                        .html('<i class="fas fa-exclamation-circle mr-2"></i> Erreur : ' + xhr.responseJSON.message)
                        .fadeIn().delay(3000).fadeOut();
                }
            }
        });
    });

    $(document).on('click', '.btn[data-toggle="modal"][data-target="#modifierModal"]', function() {
        var id = $(this).data('id_station');
        $.ajax({
            url: '/get-station/' + id,
            type: 'GET',
            success: function(stationData) {
                $('#id_station-modal').val(stationData.id_station);
                $('#nom-modal').val(stationData.station);
                $('#nif_stat-modal').val(stationData.nif_stat);
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors de la récupération de la station : ", error);
                $('#error-message')
                    .html('<i class="fas fa-exclamation-circle mr-2"></i> Erreur lors de la récupération de la station')
                    .fadeIn().delay(3000).fadeOut();
            }
        });
    });

    $('#saveChangesBtn').on('click', function(e) {
        e.preventDefault();
        $('.error-message').hide();
        var formData = $('#modifier_stationForm').serialize();
        $.ajax({
            url: '/update-station',
            method: 'PUT',
            data: formData,
            success: function(response) {
                $('#modifierModal').modal('hide');
                loadstation();
                $('#success-message').fadeIn().delay(3000).fadeOut();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, messages) {
                        $('#error-modal-' + key).text(messages[0]).show();
                    });
                } else {
                    $('#error-message')
                        .html('<i class="fas fa-exclamation-circle mr-2"></i> Erreur : ' + xhr.responseJSON.message)
                        .fadeIn().delay(3000).fadeOut();
                }
            }
        });
    });
});
</script>
@endsection