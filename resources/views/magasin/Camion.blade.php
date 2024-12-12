@extends('template.Layout')
@section('titre')
    Sortie de Magasin
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
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Historique de mouvement Camion</h4>
            </div>
            <div class="card-body">
                <div class="mT-30">
                    <div class="form-row">
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
                        <div class="form-group col-md-3">
                            <label for="filter-type-shift">Type Shift</label>
                            <select id="filter-type-shift" class="form-control">
                                <option value="-1">Sélectionner</option>
                                <option value="1">Entrée</option>
                                <option value="2">Sortie</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filter-shift">Shift</label>
                            <select id="filter-shift" class="form-control">
                                <option value="">Sélectionner</option>
                                @foreach($shifts as $shift)
                                    <option value="{{ $shift->id_shift }}">{{ $shift->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filter-camion">Numero Camion</label>
                            <input type="text" class="form-control"  id="filter-camion" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filter-type-date">Type date</label>
                            <select id="filter-type-date" class="form-control">
                                <option value="-1">Sélectionner</option>
                                <option value="1">Entrée</option>
                                <option value="2">Sortie</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="debut">Date debut</label>
                            <input type="date" class="form-control"  id="debut" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="fin">Date fin</label>
                            <input type="date" class="form-control"  id="fin" required>
                        </div>
                        <div class="form-group col-md-2" style="align-content: flex-end">
                            <button type="button" class="btn btn-secondary" id="filter-btn">Filtrer</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="mT-30">
                    <div id="table-container table-responsive">
                        <table id="" class="table table-responsive table-hover table-bordered ">
                            <thead>
                                <tr>
                                    <th>Campagne</th>
                                    <th>Chaufeur</th>
                                    <th>Numero de camion</th>
                                    <th>Date Entrée</th>
                                    <th>Shift entrée</th>
                                    <th>Date Sortie</th>
                                    <th>Shift sortie</th>
                                    <th>Nº station</th>
                                    <th>Quantité Entrant</th>
                                    <th>Quantité sortant</th>
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

@endsection

@section('script')
<script>

$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function appendSortie(sortie) {
        var row = '<tr>' +
                    '<td>' + sortie.annee + '</td>' +
                    '<td>' + sortie.chauffeur + '</td>' +
                    '<td>' + sortie.numero_camion + '</td>' +
                    '<td>' + sortie.date_entrant + '</td>' +
                    '<td>' + sortie.description + '</td>' +
                    '<td>' + sortie.date_sortie + '</td>' +
                    '<td>' + sortie.description_sortie + '</td>' +
                    '<td>' + sortie.numero_station + '<small> ( ' + ( sortie.station || 'Station inconnue') + ' )</small></td>' +
                    '<td>' + sortie.quantite_palette + '</td>' +
                    '<td>' + sortie.quantite_sortie + '</td>' +

                   '</tr>';
        $('#table-body').append(row);
    }

    function appendPagination(data) {
        let pagination = '';

        // Bouton "Précédent"
        if (data.prev_page_url) {
            pagination += '<button class="btn btn-primary mx-1" onclick="loadSortie(' + (data.current_page - 1) + ')">Précédent</button>';
        } else {
            pagination += '<button class="btn btn-secondary mx-1" disabled>Précédent</button>';
        }

        // Numéros de pages
        for (let i = 1; i <= data.last_page; i++) {
            pagination += '<button class="btn ' + (i === data.current_page ? 'btn-dark' : 'btn-light') + ' mx-1" onclick="loadSortie(' + i + ')">' + i + '</button>';
        }

        // Bouton "Suivant"
        if (data.next_page_url) {
            pagination += '<button class="btn btn-primary mx-1" onclick="loadSortie(' + (data.current_page + 1) + ')">Suivant</button>';
        } else {
            pagination += '<button class="btn btn-secondary mx-1" disabled>Suivant</button>';
        }

        $('#pagination').html(pagination);
    }

    function loadSortie(page = 1) {
        const campagne = $('#filter-annee').val();
        const station = $('#filtre-station').val();
        const shift = $('#filter-shift').val();
        const typeShift = $('#type-shift').val();
        const camion = $('#filtre-camion').val();
        const typeDate = $('#type-date').val();
        const debut = $('#debut').val();
        const fin  = $('#fin').val();
        $.ajax({
            url: '/get-sortie?page='+page,
            type: 'GET',
            data: {
                    campagne:campagne,
                    station: station,
                    shift:shift,
                    camion:camion,
                    debut:debut,
                    fin:fin,
                    type_shift:typeShift,
                    type_date:typeDate,
                    mouvement:1
                },
            success: function(data) {
                $('#table-body').empty();
                data.data.forEach(function(sortie) {
                    appendSortie(sortie);
                });
                appendPagination(data);
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors du chargement des sortant du magasin : ", error);
            }
        });
    }
$(document).ready(function() {

    $('#filter-btn').on('click', function() {
        loadSortie(1);
    });
    loadSortie(1);

    $('#entree_magasin_id').change(function() {
        var idEntreMagasin = $(this).val();
        if (idEntreMagasin) {
            $.ajax({
                url: "/quantite-entree/" + idEntreMagasin,
                method: 'GET',
                success: function(data) {
                    $('#quantite-valeur').text(data ? data.quantite_palette : 'Aucune quantité disponible');
                },
                error: function(xhr) {
                    $('#quantite-valeur').text('Erreur de récupération de la quantité');
                }
            });
        } else {
            $('#quantite-valeur').text('');
        }
    });

    $('#sortie_magasin_form').submit(function(e) {
        e.preventDefault();
        $('.error-message').hide();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('sortie.store') }}",
            method: 'POST',
            data: formData,
            success: function(response) {
                $('#sortie_magasin_form')[0].reset();
                $('#quantite-valeur').text('');
                loadSortie();
            },
            error: function(xhr) {
                console.log(xhr);
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, messages) {
                        $('#error-' + key).text(messages[0]).show();
                    });
                } else {
                    alert('Erreur : ' + xhr.responseJSON.message);
                }
            }
        });
    });




});
</script>
@endsection
