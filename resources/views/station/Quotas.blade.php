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
                <a href="{{ url('export-model-navire-station') }}">Exporter modèle</a>
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
                            <label for="numero_station">Station</label>
                            <select id="numero_station" name="numero_station_id" class="form-control" required>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id_numero_station }}">{{ $station->numero_station }}( {{ $station->station }} -  {{ $station->annee }})</option>
                                @endforeach
                            </select>
                            <div id="error-numero_station" class="error-message"></div>
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
                <h5 class="c-black-900"><b>Liste des stations</b></h5>
                <div class="mT-30">
                    <div id="table-container" class="table-responsive">
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
   $(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadquotas();

    // Form submission for adding quotas
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
                loadquotas();  // Reload the quotas table
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

    // Function to load quotas
    function loadquotas() {
        $.ajax({
            url: '/get-quotas',
            type: 'GET',
            success: function(data) {
                $('#table-body').empty();
                data.forEach(function(quotas) {
                    appendquotas(quotas);
                });
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors du chargement des quotas : ", error);
            }
        });
    }

    // Append quotas to the table
    function appendquotas(quotas) {
        var row = '<tr>' +
                    '<td>' + quotas.annee + '</td>' +
                    '<td>' + quotas.navire + '</td>' +
                    '<td>' + quotas.station + '</td>' +
                    '<td>' + quotas.quotas + '</td>' +
                    '<td class="col-md-2">' +
                        '<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifierModal" data-id_quotas="' + quotas.id_quotas + '"><i class="fas fa-edit"></i></button>' +
                    '</td>' +
                '</tr>';
        $('#table-body').append(row);
    }

    // Edit button to open modal and load data
    $(document).on('click', '.btn[data-toggle="modal"][data-target="#modifierModal"]', function() {
        var id = $(this).data('id_quotas');
        $.ajax({
            url: '/get-quotas/' + id,
            type: 'GET',
            success: function(quotasData) {
                console.log(quotasData);
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

    // Save changes after modifying quotas
    $('#saveChangesBtn').on('click', function() {
        var form = $('#modifier_QuotasForm');
        $.ajax({
            url: form.attr('action'),
            method: 'PUT',
            data: form.serialize(),
            success: function(response) {
                console.log(response.status);
                if(response.status){
                    alert('Quota modifié avec succès !');
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

    // Clear error messages when closing the modal
    $('#modifierModal').on('hidden.bs.modal', function () {
        $('.error-message').text('');
    });
});

</script>
@endsection
