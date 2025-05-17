@extends('template.Layout')
@section('titre')
    Liste des quotats
@endsection
@section('page')
<style>
    .error-message {
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
                <h5 class="mt-5">Insertion des quotas </h5>
                <hr>
                <form id="ajout_quotasForm" action="{{ url('ajout-quotas') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="navire">Navire</label>
                            <select id="navire" name="navire_id" class="form-control" required>
                                @foreach($navires as $navire)
                                    <option value="{{ $navire->id_navire }}">{{ $navire->navire }}</option>
                                @endforeach
                            </select>
                            <div id="error-navire" class="error-message"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="station">Station</label>
                            <select id="station" name="numero_station_id" class="form-control" required>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id_numero_station }}">{{ $station->numero_station }}( {{ $station->station }} -  {{ $station->annee }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="quotas">Quotas</label>
                            <input type="text" class="form-control" name="quotas" id="quotas" maxlength="13">
                            <div class="mb-3">
                                <div id="error-quotas" class="error-message text-danger"></div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Insérer</button>
                </form>
                <div  class="error-message"></div>
            </div>

            <div class="card-body">
                <div class="mT-30">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="filter-navire">Navire</label>
                            <select id="filter-navire" class="form-control">
                                <option value="">Sélectionner </option>
                                @foreach($navires as $navire)
                                    <option value="{{ $navire->id_navire }}">{{ $navire->navire }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filtre-station">Station</label>
                            <select id="filtre-station" class="form-control">
                                <option value="">Sélectionner</option>
                                @foreach( $normal_stations as $station)
                                    <option value="{{ $station->id_station }}">{{ $station->station }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filter-annee">Annee</label>
                            <select id="filter-annee" class="form-control">
                                <option value="">Sélectionner</option>
                                @foreach($compagnes as $campagne)
                                    <option value="{{ $campagne->id_compagne }}">{{ $campagne->annee }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2" style="align-content: flex-end">
                            <button type="button" class="btn btn-secondary" id="filter-btn">Filtrer</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <h5 class="c-black-900"><b>Liste des stations</b></h5>
                <div class="mT-30">
                    <div class="table-responsive">
                        <table id="produitTable" class="table table-hover table-bordered ">
                            <thead>
                                <tr>
                                    <th>Année</th>
                                    <th>Navire</th>
                                    <th>Station</th>
                                    <th>Quotas</th>
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
    <!-- [ form-element ] end -->
</div>

<!-- Modal Modification -->
<div id="modifierModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModificationAgent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="modifier_QuotasForm" action="/update-quotas" >
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
                                <option value="{{ $station->id_numero_station }}">{{ $station->numero_station }} ({{ $station->station }} -  {{ $station->annee }})</option>
                            @endforeach
                        </select>
                        <div id="error-modal-numero_station" class="error-message text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label for="quotas-modal">Quotas</label>
                        <input type="number" class="form-control" id="quotas-modal" name="quotas">
                        <div id="error-modal-quotas" class="error-message text-danger"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" id="saveChangesBtn">Modifier</button>
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

    function appendquotas(quotas) {
        var row = '<tr>' +
                    '<td>' + quotas.annee + '</td>' +
                    '<td>' + quotas.navire + '</td>' +
                    '<td>' + quotas.station + ' - '+ quotas.numero_station  +'</td>' +
                    '<td>' + quotas.quotas + '</td>' +
                    '<td class="col-md-2">' +
                        '<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifierModal" data-id_quotas="' + quotas.id_quotas + '"><i class="fas fa-edit"></i></button>' +
                    '</td>' +
                '</tr>';
        $('#table-body').append(row);
    }

    function appendPagination(data) {
        let pagination = '';

        // Bouton "Précédent"
        if (data.prev_page_url) {
            pagination += '<button class="btn btn-primary mx-1" onclick="loadquotas(' + (data.current_page - 1) + ')">Précédent</button>';
        } else {
            pagination += '<button class="btn btn-secondary mx-1" disabled>Précédent</button>';
        }

        // Numéros de pages
        for (let i = 1; i <= data.last_page; i++) {
            pagination += '<button class="btn ' + (i === data.current_page ? 'btn-dark' : 'btn-light') + ' mx-1" onclick="loadquotas(' + i + ')">' + i + '</button>';
        }

        // Bouton "Suivant"
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
            url: '/get-quotas?page='+page,
            type: 'GET',
            data: {
                    navire:navire,
                    campagne:campagne,
                    station: station
                },
            success: function(data) {
                $('#table-body').empty();
                data.data.forEach(function(quotas) {
                    appendquotas(quotas);
                });
                appendPagination(data);
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors du chargement des quotas : ", error);
            }
        });
    }

   $(document).ready(function() {

    $('#filter-btn').on('click', function() {
        loadquotas(1);

    });

    $('#filter-annee').on('change', function () {
        const selectedYear = $(this).val();
        const $table = $('table');

        // Supprimer la ligne de somme existante
        $table.find('.somme-quotas').remove();

        if (selectedYear) {
            // Calculer la somme des quotas
            let totalQuotas = 0;
            $table.find('tbody tr').each(function () {
                const quota = parseFloat($(this).find('td:nth-child(4)').text()) || 0; // 4ème colonne pour quotas
                totalQuotas += quota;
            });

            // Ajouter la ligne de somme
            const totalRow = `
                <tr class="somme-quotas">
                    <td colspan="3" class="text-right"><strong>Total Quotas :</strong></td>
                    <td><strong>${totalQuotas}</strong></td>
                </tr>
            `;
            $table.find('tbody').append(totalRow);
        }
    });

    loadquotas(1);

        $('#ajout_quotasForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    alert('Quota ajouté avec succès !');
                    $('.error-message').text('');
                    $('#ajout_quotasForm')[0].reset();
                    loadquotas(1);  // Reload the quotas table
                },
                error: function(xhr) {
                    $('.error-message').text('');
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, messages) {
                            $('#error-' + key).text(messages[0]);
                        });
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
                $('#quotas-modal').val(quotasData.quotas);
            },
            error: function(xhr, status, error) {
               console.log(xhr.responseText);
            }
        });
    });


    $('#saveChangesBtn').on('click', function() {
        var form = $('#modifier_QuotasForm');
        $.ajax({
            url: form.attr('action'),
            method: 'PUT',
            data: form.serialize(),
            success: function(response) {
                if(response.status){
                    loadquotas();
                    $('#modifierModal').modal('hide');
                }else{
                    $('.error-message').text('');
                }

            },
            error: function(xhr) {
                $('.error-message').text('');
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, messages) {
                        $('#error-modal-' + key).text(messages[0]);
                    });
                }
            }
        });
    });

    $('#modifierModal').on('hidden.bs.modal', function () {
        $('.error-message').text('');
    });
});

</script>
@endsection
