@extends('template.Layout')
@section('titre')
    Liste des quotat
@endsection
@section('page')
<style>

    #error-message {
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
                        <a href="{{ url('export-model-navire-station') }}">Exporté model</a>
                        <hr><form id="ajout_quotasForm" action="{{ url('ajout-quotas') }}" method="POST">
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
                                    <div id="error-station" class="error-message"></div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Insérer</button>
                        </form>
                        <div id="error-message" class="error-message"></div>
                    </div>
                    <div class="card-body">
                        <h5 class="c-black-900"><b>Liste des stations</b></h5>
                        <div class="mT-30">
                            <div id="table-container table-responsive">
                                <table id="produitTable" class="table table-hover table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>Annee</th>
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
        <div id="modifierModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModificationAgent" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Modification</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form id="modifier_QuotasForm" action="" method="POST">
                            @csrf
                            <input type="hidden" id="id_quotas-modal" name="id_quotas">
                            <div class="form-group">
                                <label for="navire">Navire</label>
                                <select id="navire-modal" name="navire_id" class="form-control">
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
                                <label for="numero_station">Station</label>
                                <select id="numero_station-modal" name="numero_station" class="form-control">
                                    <option value="">Sélectionner</option>
                                    @foreach($stations as $station)
                                        <option value="{{ $station->id_numero_station }}">{{ $station->numero_station }}( {{ $station->station }} -  {{ $station->annee }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div  class="form-group">
                                <div id="error-modal-numero_station" class="error-message text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label for="quotas">Quotas</label>
                                <input type="text" class="form-control" id="quotas-modal" name="quotas">
                            </div>
                            <div  class="form-group">
                                <div id="error-modal-quotas" class="error-message text-danger"></div>
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
        $('#ajout_quotasForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    alert('Quotas ajouté avec succès !');
                    console.log(response);
                    $('p.error-message').text('');
                    $('#ajout_quotasForm')[0].reset();
                    loadquotas();
                },
                error: function(xhr) {
                    console.log(xhr);
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
                    console.error("Erreur lors du chargement des quotass : ", error);
                }
            });
        }

        function appendquotas(quotas) {
            var row = '<tr>' +
                    '<td>' + quotas.annee + '</td>' +
                    '<td>' + quotas.navire + '</td>' +
                    '<td>' + quotas.station + '</td>' +
                    '<td>' + quotas.quotas + '</td>' +
                    '<td class="col-md-2">' +
                        '<button  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifierModal" data-id_quotas="' + quotas.id_quotas + '"><i class="fas fa-edit"></i></button>' +
                    '</td>' +
                    '</tr>';
            $('#table-body').append(row);
        }

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
                    console.error("Erreur lors de la récupération du quotas : ", error);
                }
            });
        });

        $('#saveChangesBtn').on('click', function(e) {
            e.preventDefault();
            var formData = $('#modifier_QuotasForm').serialize();
            $.ajax({
                url: '/update-quotas',
                method: 'PUT',
                data: formData,
                success: function(response) {
                    alert('Modifications enregistrées avec succès !');
                    $('#modifierModal').modal('hide');
                    loadquotas();
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, messages) {
                        $('#error-modal-' + key).text(messages[0]);
                    });
                }
            });
        });



    });

</script>
@endsection
