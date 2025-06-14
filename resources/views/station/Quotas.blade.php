@extends('template.Layout')
@section('titre')
    Liste des quotas
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
    /* Alignement à droite pour la colonne Quotas */
    .quotas-column {
        text-align: right;
    }
</style>

<!-- [ Main Content ] start -->
<div class="row">
    <div class="col-sm-12">
        
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
                        <div class="form-group col-md-3">
                            <label for="filter-navire">Navire</label>
                            <select id="filter-navire" class="form-control">
                                <option value="">Sélectionner</option>
                                @foreach($navires as $navire)
                                    <option value="{{ $navire->id_navire }}">{{ $navire->navire }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filtre-station">Station</label>
                            <select id="filtre-station" class="form-control">
                                <option value="">Sélectionner</option>
                                @foreach($normal_stations as $station)
                                    <option value="{{ $station->id_station }}">{{ $station->station }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filter-annee">Année</label>
                            <select id="filter-annee" class="form-control">
                                <option value="">Sélectionner</option>
                                @foreach($compagnes as $campagne)
                                    <option value="{{ $campagne->id_compagne }}">{{ $campagne->annee }}</option>
                                @endforeach
                            </select>
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
                <h5>Insertion des quotas</h5>
            </div>
            <div class="card-body">
                 <!-- Conteneurs pour les messages -->
        <div id="success-message" style="display: none;">
            <i class="fas fa-check-circle mr-2"></i> Confirmation enregistrée
        </div>
       
                <form id="ajout_quotasForm" action="{{ url('ajout-quotas') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="navire">Navire</label>
                            <select id="navire" name="navire_id" class="form-control" required>
                                <option value="">Sélectionner</option>
                                @foreach($navires as $navire)
                                    <option value="{{ $navire->id_navire }}">{{ $navire->navire }}</option>
                                @endforeach
                            </select>
                            <div id="error-navire" class="error-message text-danger"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="station">Station</label>
                            <select id="station" name="numero_station_id" class="form-control" required>
                                <option value="">Sélectionner</option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id_numero_station }}">{{ $station->numero_station }} ({{ $station->station }} - {{ $station->annee }})</option>
                                @endforeach
                            </select>
                            <div id="error-numero_station_id" class="error-message text-danger"></div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="quotas">Quotas</label>
                            <input type="text" class="form-control" name="quotas" id="quotas" maxlength="13">
                            <div id="error-quotas" class="error-message text-danger"></div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Insérer</button>
                </form>
            </div>
        </div>

        <!-- Card for List -->
        <div class="card">
            <div class="card-header">
                <h5>Liste des quotas</h5>
            </div>
            <div class="card-body">
                <div class="mT-30">
                    <div class="table-responsive">
                        <table id="produitTable" class="table table-hover table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Année</th>
                                    <th>Navire</th>
                                    <th>Station</th>
                                    <th class="quotas-column">Quotas</th>
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

<!-- Modal Modification -->
<div id="modifierModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModificationQuotas" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="modifier_QuotasForm" action="/update-quotas">
                    @csrf
                    <input type="hidden" id="id_quotas-modal" name="id_quotas">
                    <div class="form-group">
                        <label for="navire-modal">Navire</label>
                        <select id="navire-modal" name="navire_id" class="form-control">
                            <option value="">Sélectionner</option>
                            @foreach($navires as $navire)
                                <option value="{{ $navire->id_navire }}">{{ $navire->navire }}</option>
                            @endforeach
                        </select>
                        <div id="error-modal-navire_id" class="error-message text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label for="numero_station-modal">Station</label>
                        <select id="numero_station-modal" name="numero_station_id" class="form-control">
                            <option value="">Sélectionner</option>
                            @foreach($stations as $station)
                                <option value="{{ $station->id_numero_station }}">{{ $station->numero_station }} ({{ $station->station }} - {{ $station->annee }})</option>
                            @endforeach
                        </select>
                        <div id="error-modal-numero_station_id" class="error-message text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label for="quotas-modal">Quotas</label>
                        <input type="text" class="form-control" id="quotas-modal" name="quotas">
                        <div id="error-modal-quotas" class="error-message text-danger"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Fermer</button>
                <button type="button" class="btn btn-primary" id="saveChangesBtn"><i class="fas fa-save"></i> Modifier</button>
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

// Fonction pour formater un nombre avec séparateur de milliers
function formatNumber(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
}

// Fonction pour déformater un nombre (retirer les espaces)
function unformatNumber(str) {
    return str.replace(/\s/g, '');
}

function appendquotas(quotas) {
    var row = '<tr>' +
                '<td>' + quotas.annee + '</td>' +
                '<td>' + quotas.navire + '</td>' +
                '<td>' + quotas.station + ' - ' + quotas.numero_station + '</td>' +
                '<td class="quotas-column">' + formatNumber(quotas.quotas) + '</td>' +
                '<td class="col-md-2">' +
                    '<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifierModal" data-id_quotas="' + quotas.id_quotas + '"><i class="fas fa-edit"></i> Modifier</button>' +
                '</td>' +
              '</tr>';
    $('#table-body').append(row);
}

function appendPagination(data) {
    let pagination = '';
    if (data.prev_page_url) {
        pagination += '<button class="btn btn-primary mx-1" onclick="loadquotas(' + (data.current_page - 1) + ')">Précédent</button>';
    } else {
        pagination += '<button class="btn btn-secondary mx-1" disabled>Précédent</button>';
    }
    for (let i = 1; i <= data.last_page; i++) {
        pagination += '<button class="btn ' + (i === data.current_page ? 'btn-dark' : 'btn-light') + ' mx-1" onclick="loadquotas(' + i + ')">' + i + '</button>';
    }
    if (data.next_page_url) {
        pagination += '<button class="btn btn-primary mx-1" onclick="loadquotas(' + (data.current_page + 1) + ')">Suivant</button>';
    } else {
        pagination += '<button class="btn btn-secondary mx-1" disabled>Suivant</button>';
    }
    $('#pagination').html(pagination);
}

function loadquotas(page = 1) {
    const navire = $('#filter-navire').val();
    const campagne = $('#filter-annee').val();
    const station = $('#filtre-station').val();
    $.ajax({
        url: '/get-quotas?page=' + page,
        type: 'GET',
        data: {
            navire: navire,
            campagne: campagne,
            station: station
        },
        success: function(data) {
            $('#table-body').empty();
            data.data.forEach(function(quotas) {
                appendquotas(quotas);
            });
            appendPagination(data);
            // Mettre à jour la somme des quotas si une année est sélectionnée
            updateTotalQuotas();
        },
        error: function(xhr, status, error) {
            console.error("Erreur lors du chargement des quotas : ", error);
            $('#error-message')
                .html('<i class="fas fa-exclamation-circle mr-2"></i> Erreur lors du chargement des quotas')
                .fadeIn().delay(3000).fadeOut();
        }
    });
}

// Fonction pour mettre à jour la somme des quotas
function updateTotalQuotas() {
    const selectedYear = $('#filter-annee').val();
    const $table = $('#produitTable');

    // Supprimer la ligne de somme existante
    $table.find('.somme-quotas').remove();

    if (selectedYear) {
        let totalQuotas = 0;
        $table.find('tbody tr:not(.somme-quotas)').each(function() {
            const quota = parseFloat(unformatNumber($(this).find('td:nth-child(4)').text())) || 0;
            totalQuotas += quota;
        });

        const totalRow = `
            <tr class="somme-quotas">
                <td colspan="3" class="text-right"><strong>Total Quotas :</strong></td>
                <td class="quotas-column"><strong>${formatNumber(totalQuotas)}</strong></td>
                <td></td>
            </tr>
        `;
        $table.find('tbody').append(totalRow);
    }
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

    // Formatage des champs quotas avec séparateur de milliers
    $('#quotas, #quotas-modal').on('input', function() {
        let value = unformatNumber($(this).val());
        if (value) {
            $(this).val(formatNumber(value));
        }
    });

    $('#filter-btn').on('click', function() {
        loadquotas(1);
    });

    $('#filter-annee').on('change', function() {
        loadquotas(1);
    });

    loadquotas(1);

    $('#ajout_quotasForm').on('submit', function(event) {
        event.preventDefault();
        $('.error-message').hide();
        // Déformater le champ quotas avant envoi
        let formData = $(this).serializeArray();
        formData = formData.map(item => {
            if (item.name === 'quotas') {
                item.value = unformatNumber(item.value);
            }
            return item;
        });
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            success: function(response) {
                $('#ajout_quotasForm')[0].reset();
                loadquotas(1);
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
        var id = $(this).data('id_quotas');
        $.ajax({
            url: '/get-quotas/' + id,
            type: 'GET',
            success: function(quotasData) {
                $('#id_quotas-modal').val(quotasData.id_quotas);
                $('#navire-modal').val(quotasData.navire_id).trigger('change');
                $('#numero_station-modal').val(quotasData.numero_station_id).trigger('change');
                $('#quotas-modal').val(formatNumber(quotasData.quotas));
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors de la récupération du quota : ", error);
                $('#error-message')
                    .html('<i class="fas fa-exclamation-circle mr-2"></i> Erreur lors de la récupération du quota')
                    .fadeIn().delay(3000).fadeOut();
            }
        });
    });

    $('#saveChangesBtn').on('click', function() {
        $('.error-message').hide();
        // Déformater le champ quotas avant envoi
        let formData = $('#modifier_QuotasForm').serializeArray();
        formData = formData.map(item => {
            if (item.name === 'quotas') {
                item.value = unformatNumber(item.value);
            }
            return item;
        });
        $.ajax({
            url: '/update-quotas',
            method: 'PUT',
            data: formData,
            success: function(response) {
                $('#modifierModal').modal('hide');
                loadquotas(1);
                $('#success-message').fadeIn().delay(3000).fadeOut();
            },
            error: function(xhr) {
                $('.error-message').hide();
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

    $('#modifierModal').on('hidden.bs.modal', function() {
        $('.error-message').text('').hide();
    });
});
</script>
@endsection