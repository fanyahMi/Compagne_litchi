@extends('template.Layout')
@section('titre')
    Liste des stations
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
                        <h5 class="mt-5">Insertion de nouvelle Station</h5>
                        <hr><form id="ajout_stationForm" action="{{ url('ajout-station') }}" method="POST">
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
                            <button type="submit" class="btn btn-primary">Insérer</button>
                        </form>
                        <div id="error-message" class="error-message"></div>
                    </div>
                    <div class="card-body">
                        <h5 class="c-black-900"><b>Liste des stations</b></h5>
                        <div class="mT-30">
                            <div id="table-responsive">
                                <table id="produitTable" class="table table-hover table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>Station</th>
                                            <th>NIF</th>
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
        <!--  Liste   --->

        <!-- [ modal ] start -->
		<div id="modifierModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modificationstation" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Modification</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form id="modifier_stationForm" action="" method="POST">
                            @csrf
                            <input type="hidden" id="id_station-modal" name="id_station">
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input type="text" class="form-control" id="nom-modal" name="nom">
                            </div>
                            <div  class="form-group">
                                <div id="error-modal-nom" class="error-message text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label for="nif_stat">NIF</label>
                                <input type="text" class="form-control" id="nif_stat-modal" name="nif_stat" maxlength="13">
                            </div>
                            <div  class="form-group">
                                <div id="error-modal-nif_stat" class="error-message text-danger"></div>
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
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadstation();
    $('#ajout_stationForm').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert('Station ajouté avec succès !');
                console.log(response);
                $('p.error-message').text('');
                $('#ajout_stationForm')[0].reset();
                loadstation();
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

    function loadstation() {
        $.ajax({
            url: '/get-station',
            type: 'GET',
            success: function(data) {
                $('#table-body').empty();
                data.forEach(function(station) {
                    appendStation(station);
                });
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors du chargement des stations : ", error);
            }
        });
    }



    function appendStation(station) {
        var row = '<tr>' +
                  '<td>' + station.station + '</td>' +
                  '<td>' + station.nif_stat + '</td>' +
                  '<td class="col-md-2">' +
                    '<button  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifierModal" data-id_station="' + station.id_station + '"><i class="fas fa-edit"></i></button>' +
                  '</td>' +
                  '</tr>';
        $('#table-body').append(row);
    }

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
                console.error("Erreur lors de la récupération de l'station : ", error);
            }
        });
    });

    $('#saveChangesBtn').on('click', function(e) {
        e.preventDefault();
        var formData = $('#modifier_stationForm').serialize();
        $.ajax({
            url: '/update-station',
            method: 'PUT',
            data: formData,
            success: function(response) {
                alert('Modifications enregistrées avec succès !');
                $('#modifierModal').modal('hide');
                loadstation();
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, messages) {
                    $('#error-modal-' + key).text(messages[0]);
                });
            }
        });
    });


    $('#exampleModal').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var recipient = button.data('whatever')
		var modal = $(this)
		modal.find('.modal-title').text('New message to ' + recipient)
		modal.find('.modal-body input').val(recipient)
	})

});

</script>
@endsection
