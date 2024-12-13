@extends('template.Layout')
@section('titre')
    Historique
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
                Historique embarquement campagne {{ $campagne }}
                <input type="hidden" id="filter-compagne" name="filter-compagne" value="{{ $idCampagne }}" >
            </div>


            <!---filtre--->
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
                        <div class="form-group col-md-2" style="align-content: flex-end">
                            <button type="button" class="btn btn-secondary" id="filter-btn">Rechercher</button>
                        </div>
                                        </div>

                </div>
            </div>

            <!-- [Liste des réservations] -->
            <div class="card-body">
                <h5 class="c-black-900"></h5>
                <div class="mT-30">

                    <div id="table-container table-responsive">
                        <table id="" class="table table-hover table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th>Navire</th>
                                    <th>Capacité max</th>
                                    <th>Quantité embarqué</th>
                                    <th>Option</th>
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
<script src="assets/js/plugins/jquery-ui.min.js"></script>
<script>

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


function appendMouvement(mouvement) {
    const compagne = $('#filter-compagne').val();
    var baseUrl = "{{ url('/historique-navire/cale') }}";
    var button = mouvement.quantite_embarque != 0 ?
        '<a class="btn btn-primary btn-sm" href="' + baseUrl + '/' + compagne + '/' + mouvement.id_navire + '">' +
        '<i class="fas fa-eye"></i> Détail' +
        '</a>' : '';
    var baseUrl2 = "{{ url('/export-situation') }}";
    var button2 = mouvement.quantite_embarque != 0 ?
        '<a class="btn btn-primary btn-sm" href="' + baseUrl2 + '/' + compagne + '/' + mouvement.id_navire + '">' +
        '<i class="fas fa-eye"></i> Rapport' +
        '</a>' : '';
    var row = '<tr>' +
                '<td>' + mouvement.navire + '</td>' +
                '<td style="text-align: right;">' + mouvement.quantite_max + '</td>' +
                '<td style="text-align: right;">' + mouvement.quantite_embarque + '</td>' +
                '<td>' + button +'   '+ button2+'</td>' +
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

    $.ajax({
        url: '/historique-navire?page=' + page,
        type: 'GET',
        data: {
            id_navire: navire,
            id_campagne: compagne,
        },
        success: function(data) {
            console.log(data);
            $('#table-body').empty();
            $('#pagination').empty();

            data.data.forEach(function(mouvement) {
                appendMouvement(mouvement);
            });

            appendPagination(data);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseJson);
            //console.error("Erreur lors du chargement des réservations : ", error);
        }
    });
}


$(document).ready(function() {
    $('#filter-btn').on('click', function() {
        loadMouvement(1)
    });

    loadMouvement(1)


});
</script>
@endsection
