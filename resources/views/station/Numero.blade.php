@extends('template.Layout')
@section('titre')
    Entre magasin
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
                Insertion de nouvel agent
            </div>
            <div class="card-body">
                <form id="ajout_magasin" method="POST">
                    @csrf
                    <!-- Champ pour sélectionner une station -->
                    <div class="form-group col-md-4">
                        <label for="station">Station</label>
                        <select id="station" name="station_id" class="form-control" required>
                            @foreach($stations as $station)
                                <option value="{{ $station->id_station }}">{{ $station->station }}</option>
                            @endforeach
                        </select>
                        <div id="error-station" class="error-message">Veuillez sélectionner une station.</div>
                    </div>

                    <!-- Champ pour afficher la compagne, en mode readonly -->
                    <div class="form-group col-md-4">
                        <label for="compagne">Compagne (Année)</label>
                        <input type="text" class="form-control" value="{{ $compagne->annee }}" readonly>
                        <input type="hidden" name="compagne_id" value="{{ $compagne->id_compagne }}">
                    </div>

                    <!-- Champ pour entrer le numéro de station -->
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="numero_station">Numero Station</label>
                            <input type="number" class="form-control" name="numero_station" id="numero_station" required>
                            <div id="error-numero_station" class="error-message">Veuillez entrer un numéro de station.</div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Insérer</button>
                </form>

            </div>

            <!-- [Liste des réservations] -->
            <div class="card-body">
                <h5 class="c-black-900"><b>Liste numereo station</b></h5>
                <div class="mT-30">

                    <div id="table-container">
                        <table id="" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Compagne</th>
                                    <th>Station</th>
                                    <th>Numero</th>
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
</div>


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

    loadEntree();

    $('#ajout_magasin').submit(function(e) {
        e.preventDefault();

        $('p.error-message').text('');
        var fileInput = document.getElementById('fichier');
        var file = fileInput.files[0];
        var formData = new FormData($('#ajout_magasin')[0]);
        submitForm(formData);
    });



    function submitForm(formData) {
        $.ajax({
            url: "{{ route('numero.store') }}",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert('Vous avez effectué un entré');
                $('#ajout_magasin')[0].reset();
                loadEntree();
            },
            error: function(xhr) {
                console.log(xhr);
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, messages) {
                        $('#error-' + key).text(messages[0]).show();
                    });
                }
            }
        });
    }


    function loadEntree() {
        $.ajax({
            url: '/get-numero-station/',
            type: 'GET',
            success: function(data) {
                $('#table-body').empty();
                data.forEach(function(entree) {
                   appendEntree(entree);
                });
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors du chargement des entree en magasin : ", error);
            }
        });
    }



    function appendEntree(entree) {
       var row = '<tr>' +
                    '<td>' + entree.annee + '</td>' +
                    '<td>' + entree.station + '</td>' +
                    '<td>' + entree.numero_station + '</td>' + // Vérifie si la station existe
                    '<td>' +
                        '<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifierModal" data-id_entree="' + entree.id_entree_magasin + '">Modifier</button>' +
                    '</td>' +
                    '</tr>';
        $('#table-body').append(row);
    }





});
</script>
@endsection
