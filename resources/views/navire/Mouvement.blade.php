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
                            <label for="date_depart">Date de depart</label>
                            <input type="date" class="form-control" name="date_depart" id="date_depart" >
                            <div id="error-date_depart" class="error-message"></div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Insérer</button>
                </form>

            </div>

            <!---filtre--->
            <div class="card-body">
                <div class="mT-30">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="filter-navire">Navire</label>
                            <input type="text" class="form-control" id="filter-navire">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="filter-compagne">compagne</label>
                            <select id="filter-compagne" class="form-control">
                                <option value="">Sélectionner compagne</option>
                                @foreach($compagnes as $compagne)
                                    <option value="{{ $compagne->id_compagne }}">{{ $compagne->annee }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="filter-date_arriver">Date d'arrivée</label>
                            <input type="date" class="form-control" id="filter-date_arriver">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="filter-date_depart">Date de depart</label>
                            <input type="date" class="form-control" id="filter-date_depart">
                        </div>
                        <div class="form-group col-md-2" style="align-content: flex-end">
                            <button type="button" class="btn btn-secondary" id="filter-btn">Filtrer</button>
                        </div>
                    </div>
                </div>
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
                    <div id="pagination" class="mt-3 text-center"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- [ modal ] start -->
<div id="modifierModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModificationAgent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="modifier_mouvementForm" action="" method="POST">
                    @csrf
                    <input type="hidden" id="id_mouvement_navire-modal" name="id_mouvement_navire">

                    <div class="form-group">
                        <label for="compagne_id">Compagne</label>
                        <input type="hidden"  id="compagne_id-modal-hidden" name="compagne_id-modal">
                        <select id="compagne_id-modal" name="compagne_id" class="form-control" disabled>
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
                        <label for="navire_id">Navire</label>
                        <input type="hidden" id="navire_id-modal-hidden" name="navire_id-modal" >
                        <select id="navire_id-modal" name="navire_id" class="form-control" disabled>
                            <option value="">Sélectionner</option>
                            @foreach($navires as $navire)
                                <option value="{{ $navire->id_navire }}">{{ $navire->navire }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div  class="form-group">
                        <div id="error-modal-navire_id" class="error-message text-danger"></div>
                    </div>

                    <div class="form-group">
                        <label for="date_arrive">Date d'arrivée</label>
                        <input type="date" class="form-control" id="date_arrive-modal" name="date_arrive-modal">
                    </div>
                    <div  class="form-group">
                        <div id="error-modal-date_arrive-modal" class="error-message text-danger"></div>
                    </div>

                    <div class="form-group">
                        <label for="date_depart">Date de départ</label>
                        <input type="date" class="form-control" id="date_depart-modal" name="date_depart-modal">
                    </div>
                    <div  class="form-group">
                        <div id="error-modal-date_depart-modal" class="error-message text-danger"></div>
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
<!-- [ modal ] end -->

@endsection
@section('script')
<script src="assets/js/plugins/jquery-ui.min.js"></script>
<script>

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function appendMouvement(mouvement) {
    var button = mouvement.etat === 1
        ? '<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifierModal" data-id_mouvement="' + mouvement.id_mouvement_navire + '">'+
        '<i class="fas fa-edit"></i></button>'
        : '';

    var row = '<tr>' +
                '<td>' + mouvement.annee + '</td>' +
                '<td>' + mouvement.navire + '</td>' +
                '<td>' + mouvement.date_arriver + '</td>' +
                '<td>' + mouvement.date_depart + '</td>' +
                '<td>' + button + '</td>' +
            '</tr>';

    $('#table-body').append(row);
}

function appendPagination(data) {
    let pagination = '';

    // Bouton "Précédent"
    if (data.prev_page_url) {
        pagination += '<button class="btn btn-primary mx-1" onclick="loadMouvement(' + (data.current_page - 1) + ')">Précédent</button>';
    } else {
        pagination += '<button class="btn btn-secondary mx-1" disabled>Précédent</button>';
    }

    // Numéros de pages
    for (let i = 1; i <= data.last_page; i++) {
        pagination += '<button class="btn ' + (i === data.current_page ? 'btn-dark' : 'btn-light') + ' mx-1" onclick="loadMouvement(' + i + ')">' + i + '</button>';
    }

    // Bouton "Suivant"
    if (data.next_page_url) {
        pagination += '<button class="btn btn-primary mx-1" onclick="loadMouvement(' + (data.current_page + 1) + ')">Suivant</button>';
    } else {
        pagination += '<button class="btn btn-secondary mx-1" disabled>Suivant</button>';
    }

    $('#pagination').html(pagination);
}

function loadMouvement(page = 1) {
    const navire = $('#filter-navire').val();
    const compagne = $('#filter-compagne').val();
    const date_arriver = $('#filter-date_arriver').val();
    const date_depart = $('#filter-date_depart').val();

    $.ajax({
        url: '/get-mouvement?page=' + page,
        type: 'GET',
        data: {
            navire: navire,
            compagne: compagne,
            date_arriver: date_arriver,
            date_depart: date_depart,
        },
        success: function(data) {
            $('#table-body').empty();
            $('#pagination').empty();

            data.data.forEach(function(mouvement) {
                appendMouvement(mouvement);
            });

            appendPagination(data);
        },
        error: function(xhr, status, error) {
            console.error("Erreur lors du chargement des réservations : ", error);
        }
    });
}


$(document).ready(function() {
    $('#filter-btn').on('click', function() {
        loadMouvement(1)
    });

    loadMouvement(1)

$('#ajout_mouvementForm').on('submit', function(event) {
    event.preventDefault();

    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            alert('Mouvement ajouté avec succès !');
            $('p.error-message').text('');
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

$(document).on('click', '.btn[data-toggle="modal"][data-target="#modifierModal"]', function() {
    var id = $(this).data('id_mouvement');
    $.ajax({
        url: '/get-mouvement/' + id,
        type: 'GET',
        success: function(mouvementData) {
            $('#id_mouvement_navire-modal').val(mouvementData.id_mouvement_navire);
            $('#compagne_id-modal').val(mouvementData.compagne_id).trigger('change');
            $('#navire_id-modal').val(mouvementData.navire_id).trigger('change');
            $('#compagne_id-modal-hidden').val(mouvementData.compagne_id);
            $('#navire_id-modal-hidden').val(mouvementData.navire_id);
            $('#date_arrive-modal').val(mouvementData.date_arriver);
            $('#date_depart-modal').val(mouvementData.date_depart);
        },
        error: function(xhr, status, error) {
            console.error("Erreur lors de la récupération du mouvement : ", error);
        }
    });
});

$('#saveChangesBtn').on('click', function(e) {
    e.preventDefault();
    var formData = $('#modifier_mouvementForm').serialize();
    $.ajax({
        url: '/update-mouvement',
        method: 'PUT',
        data: formData,
        contentType: 'application/x-www-form-urlencoded',
        success: function(response) {
            alert('Modifications enregistrées avec succès !');
            $('#modifierModal').modal('hide');
            loadMouvement();
        },
        error: function(xhr) {
            var errors = xhr.responseJSON.errors;
            $.each(errors, function(key, messages) {
                console.log('#error-modal-'+key + "  "+ messages);
                $('#error-modal-' + key).text(messages);
                $('#error-modal-' + key).css('display', 'block');
            });
        }
    });
});


});
</script>
@endsection
