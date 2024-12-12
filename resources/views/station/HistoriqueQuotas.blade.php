@extends('template.Layout')
@section('titre')
    Liste des quotats
@endsection
@section('page')
<style>
    .error-message {
        color: red;
        display: block !important;
        font-size: 14px;
        padding: 5px;
        margin-top: 10px;
    }

    .filter-container {
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .filter-container .filter-label {
        font-weight: bold;
        margin-right: 10px;
    }

    .table-container {
        margin-top: 20px;
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #ddd;
        padding: 20px;
        border-radius: 4px 4px 0 0;
    }

    .card-body {
        padding: 20px;
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Informations de la station</h4>
                <input type="hidden" name="id_station" value="{{ $station->id_station }}">
                <p><strong>Nom de la station :</strong> {{ $station->station }}</p>
                <p><strong>NIF/STAT :</strong> {{ $station->nif_stat }}</p>
            </div>

            <div class="card-body">
                <h5 class="c-black-900"><b>Liste des quotas par campagne</b></h5>

                <!-- Section de filtre -->
                <div class="filter-container">
                    <div>
                        <label for="filterCampagne" class="filter-label">Filtrer par campagne :</label>
                        <select id="filterCampagne" class="form-control" style="width: 250px;">
                            <option value="">Toutes les campagnes</option>
                            @foreach ($campagnes as $campagne)
                                <option value="{{ $campagne->id_compagne }}">
                                    Année : {{ $campagne->annee }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Table des quotas -->
                <div class="table-container">
                    <div id="table-container" class="table-responsive">
                        <table id="produitTable" class="table table-hover table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th>Année</th>
                                    <th>Navire</th>
                                    <th>Station</th>
                                    <th>Numéro Station</th>
                                    <th>Quotas</th>
                                </tr>
                            </thead>
                            <tbody id="table-body"></tbody>
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

    function appendquotas(quotas) {
        var row = '<tr>' +
                    '<td>' + quotas.annee + '</td>' +
                    '<td>' + quotas.navire + '</td>' +
                    '<td>' + quotas.numero_station + '</td>' +
                    '<td>' + quotas.station + '</td>' +
                    '<td>' + quotas.quotas + '</td>' +
                '</tr>';
        $('#table-body').append(row);
    }

    function appendPagination(data, campagne, idStation) {
        let pagination = '';

        // Bouton "Précédent"
        if (data.prev_page_url) {
            pagination += '<button class="btn btn-primary mx-1" onclick="loadquotas('+idStation+',' + (data.current_page - 1) + ',' + campagne +')">Précédent</button>';
        } else {
            pagination += '<button class="btn btn-secondary mx-1" disabled>Précédent</button>';
        }

        // Numéros de pages
        for (let i = 1; i <= data.last_page; i++) {
            pagination += '<button class="btn ' + (i === data.current_page ? 'btn-dark' : 'btn-light') + ' mx-1" onclick="loadquotas(' +idStation+',' + i + ',' + campagne +')">' + i + '</button>';
        }

        // Bouton "Suivant"
        if (data.next_page_url) {
            pagination += '<button class="btn btn-primary mx-1" onclick="loadquotas('+idStation+',' + (data.current_page + 1) + ',' + campagne +')">Suivant</button>';
        } else {
            pagination += '<button class="btn btn-secondary mx-1" disabled>Suivant</button>';
        }

        $('#pagination').html(pagination);
    }

    function loadquotas(idStation, page = 1, idCampagne = null) {
        var url = "{{ url('/station/quotas') }}" + "?page=" + page+"&id_station="+idStation;

        if (idCampagne) {
            url += "&id_campagne=" + idCampagne;
        }

        $.ajax({
            url: url,
            type: 'GET',
            data: {
                id_station: idStation
            },
            success: function(data) {
                console.log(data);
                $('#table-body').empty();
                data.data.forEach(function(quotas) {
                    appendquotas(quotas);
                });
                appendPagination(data, idCampagne, idStation);
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors du chargement des quotas : ", error);
            }
        });
    }


    $(document).ready(function() {
        var idStation = $('input[name="id_station"]').val();
        loadquotas(idStation, 1, null);
        $('#filterCampagne').change(function() {
            var selectedCampagneId = $(this).val();
            loadquotas(idStation, 1, selectedCampagneId);
        });
    });

</script>
@endsection
