@extends('template.Layout')
@section('titre')
    Historique
@endsection
@section('page')
<style>
    /* Style général pour les messages d'erreur */
    .error-message {
        color: red;
        font-size: 14px;
        padding: 5px;
        margin-top: 5px;
        display: none;
    }

    /* Design de la carte */
    .card-custom {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        overflow: hidden;
    }

    .card-custom:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
    }

    .card-header-custom {
        background: linear-gradient(135deg,#1abc9c, #1abc9c);
        color: white;
        font-size: 16px;
        font-weight: bold;
        padding: 15px;
        text-align: center;
    }

    .card-body-custom {
        padding: 15px;
        text-align: center;
        font-size: 14px;
        color: #333;
    }

    /* Conteneur principal */
    .container-dashboard {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    /* Responsivité mobile */
    @media (max-width: 768px) {
        .container-dashboard {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        }
    }
</style>


<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Historique embarquement campagne {{ $campagne }} - {{ $navire }}</h5>
                <input type="hidden" id="filter-compagne" name="filter-compagne" value="{{ $idCampagne }}">
                <input type="hidden" id="filter-navire" name="filter-navire" value="{{ $idNavire }}">
            </div>

            <!-- Contenu dynamique -->
            <div class="card-body">
                <div class="container mt-4">
                    <div class="container-dashboard">
                        @foreach($cales as $cale)
                            <div class="card card-custom">
                                <div class="card-header-custom">
                                    Numéro de Cale : {{ $cale->numero_cale }}
                                </div>
                                <div class="card-body-custom">
                                    Quantité : {{ $cale->total_pallets }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Liste des mouvements</h5>
                <input type="hidden" id="filter-compagne" name="filter-compagne" value="{{ $idCampagne }}" >
                <input type="hidden" id="filter-navire" name="filter-navire" value="{{ $idNavire }}" >
            </div>

            <!---filtre--->
            <div class="card-body">
                <div class="mT-30">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="filter-cale">Cales</label>
                            <select id="filter-cale" class="form-control">
                                <option value="">Sélectionner</option>
                                @foreach($cales as $cale)
                                    <option value="{{ $cale->numero_cale }}">{{ $cale->numero_cale }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="filtre-station">Station</label>
                            <select id="filter-station" class="form-control">
                                <option value="">Sélectionner</option>
                                @foreach( $normal_stations as $station)
                                    <option value="{{ $station->id_station }}">{{ $station->station }}</option>
                                @endforeach
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
                            <label for="agent">Agent</label>
                            <input type="text" class="form-control"  id="agent">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="debut">Date debut</label>
                            <input type="date" class="form-control"  id="debut">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="fin">Date fin</label>
                            <input type="date" class="form-control"  id="fin">
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

                    <div id="table-container table-responsive ">
                        <table id="" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Numero Cale</th>
                                    <th>Station</th>
                                    <th>Shift</th>
                                    <th>Agent</th>
                                    <th>Date et heure embarquement</th>
                                    <th>Quantité</th>
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


function appendMouvement(mouvement) {

    var row = '<tr>' +
                '<td>' + mouvement.numero_cal + '</td>' +
                '<td>' + mouvement.numero_station + '  ' + mouvement.station + '</td>' +
                '<td>' + mouvement.description + '</td>' +
                '<td>' + mouvement.matricule  + '-' +mouvement.prenom+'</td>' +
                '<td>' + mouvement.embarquement + '</td>' +
                '<td style="text-align: right;">' + mouvement.nombre_pallets + '</td>' +
            '</tr>';
    $('#table-body').append(row);
}


function appendPagination(data) {
    let pagination = '';

    const currentPage = data.current_page;
    const lastPage = data.last_page;

    // Bouton "Précédent"
    pagination += data.prev_page_url
        ? `<button class="btn btn-primary mx-1" onclick="loadMouvement(${currentPage - 1})">Précédent</button>`
        : `<button class="btn btn-secondary mx-1" disabled>Précédent</button>`;

    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(lastPage, currentPage + 2);

    // Corriger si au début ou à la fin
    if (currentPage <= 3) {
        endPage = Math.min(5, lastPage);
    } else if (currentPage >= lastPage - 2) {
        startPage = Math.max(1, lastPage - 4);
    }

    // "..." avant
    if (startPage > 1) {
        pagination += `<button class="btn btn-light mx-1" disabled>...</button>`;
    }

    // Numéros de pages
    for (let i = startPage; i <= endPage; i++) {
        pagination += `<button class="btn ${i === currentPage ? 'btn-dark' : 'btn-light'} mx-1" onclick="loadMouvement(${i})">${i}</button>`;
    }

    // "..." après
    if (endPage < lastPage) {
        pagination += `<button class="btn btn-light mx-1" disabled>...</button>`;
    }

    // Bouton "Suivant"
    pagination += data.next_page_url
        ? `<button class="btn btn-primary mx-1" onclick="loadMouvement(${currentPage + 1})">Suivant</button>`
        : `<button class="btn btn-secondary mx-1" disabled>Suivant</button>`;

    $('#pagination').html(pagination);
}

function loadMouvement(page = 1) {
    const navire = $('#filter-navire').val();
    const compagne = $('#filter-compagne').val();
    const cale = $('#filter-cale').val();
    const station = $('#filter-station').val();
    const shift = $('#filter-shift').val();
    const agent = $('#agent').val();
    const debut = $('#debut').val();
    const fin = $('#fin').val();

    $.ajax({
        url: '/historique/navires/cales?page=' + page,
        type: 'GET',
        data: {
            id_navire: navire,
            id_campagne: compagne,
            cale:cale,
            id_shift:shift,
            id_station: station,
            agent:agent,
            date_debut:debut,
            date_fin:fin
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
