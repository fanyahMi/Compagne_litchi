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
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="navire">Navire</label>
                            <select id="navire" name="navire_id" class="form-control" required>
                                <option value="">Sélectionner</option>
                                @foreach($navires as $navire)
                                    <option value="{{ $navire->id_navire }}">{{ $navire->navire }}</option>
                                @endforeach
                            </select>
                            <div id="error-navire" class="error-message">Veuillez sélectionner un navire.</div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="station">Station</label>
                            <select id="station" name="station_id" class="form-control" required>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id_station }}">{{ $station->station }}</option>
                                @endforeach
                            </select>
                            <div id="error-station" class="error-message">Veuillez sélectionner une station.</div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="quantite">Quantité de palette</label>
                            <input type="number" class="form-control" name="quantite_palette" id="quantite" min="1" required>
                            <div id="error-quantite" class="error-message">Veuillez entrer une quantité valide.</div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="bl">Bon de livraison</label>
                            <input type="text" class="form-control" name="bon_livraison" id="bl" required>
                            <div id="error-bl" class="error-message">Veuillez entrer un bon de livraison valide.</div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="fichier">Fichier</label>
                            <input type="file" class="form-control" name="fichier" id="fichier" accept="application/pdf">
                            <div id="error-fichier" class="error-message">Veuillez sélectionner un fichier.</div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="nom">Nom du chauffeur</label>
                            <input type="text" class="form-control" name="chauffeur" id="nom" required>
                            <div id="error-nom" class="error-message">Veuillez entrer le nom du chauffeur.</div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="matricule_camion">Numero camion</label>
                            <input type="text" class="form-control" name="numero_camion" id="matricule_camion" maxlength="12" required>
                            <div id="error-matricule_camion" class="error-message">Veuillez entrer une matricule valide.</div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Insérer</button>
                </form>
            </div>

            <!-- [Liste des réservations] -->
            <div class="card-body">
                <h5 class="c-black-900"><b>Liste des réservations</b></h5>
                <div class="mT-30">
                    <div id="table-container">
                        <table id="" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Numero de camion</th>
                                    <th>Bon de livraison</th>
                                    <th>Quantité de palette</th>
                                    <th>Station</th>
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


<div id="modifierModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModificationEntree" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="modifier"  method="POST">
                    @csrf
                    <input type="hidden" id="id_entree-modal" name="id_entree">
                    <input type="hidden" id="encien-fichier" name="encien">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="station-modal">Station</label>
                            <select id="station-modal" name="station_id" class="form-control" required>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id_station }}">{{ $station->station }}</option>
                                @endforeach
                            </select>
                            <div id="error-modal-station" class="error-message text-danger"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="navire">Navire</label>
                            <select id="navire-modal" name="navire_id" class="form-control" required>
                                <option value="">Sélectionner</option>
                                @foreach($navires as $navire)
                                    <option value="{{ $navire->id_navire }}">{{ $navire->navire }}</option>
                                @endforeach
                            </select>
                            <div id="error-modal-navire" class="error-message">Veuillez sélectionner un navire.</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="quantite-modal">Quantité de palette</label>
                        <input type="number" class="form-control" name="quantite_palette" id="quantite-modal" min="1" required>
                        <div id="error-modal-quantite" class="error-message">Veuillez entrer une quantité valide.</div>
                    </div>
                    <div class="form-group">
                        <label for="bl-modal">Bon de livraison</label>
                        <input type="text" class="form-control" name="bon_livraison" id="bl-modal" required>
                        <div id="error-modal-bl" class="error-message">Veuillez entrer un bon de livraison valide.</div>
                    </div>
                    <div class="form-group ">
                        <label for="fichier-modal">Fichier</label>
                        <input type="text" class="form-control" id="current-file" readonly>
                        <input type="file" class="form-modal-control" name="fichier" id="fichier-modal" accept="application/pdf" >
                        <div id="error-modal-fichier" class="error-message"></div>
                    </div>
                    <div class="form-group ">
                        <label for="nom-modal">Nom du chauffeur</label>
                        <input type="text" class="form-control" name="chauffeur" id="nom-modal" required>
                        <div id="error-modal-nom" class="error-message"></div>
                    </div>
                    <div class="form-group ">
                        <label for="matricule-modal_camion">Numero camion</label>
                        <input type="text" class="form-control" name="numero_camion" id="matricule-modal_camion" maxlength="12" required>
                        <div id="error-matricule-modal_camion" class="error-message">Veuillez entrer une matricule valide.</div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Insérer</button>
            </div>
        </form>
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

        if (file) {
            var reader = new FileReader();
            reader.onloadend = function() {
                formData.append('fichier_base64', reader.result);
                submitForm(formData);
            };
            reader.readAsDataURL(file);
        } else {
            submitForm(formData); // Envoyer sans fichier
        }
    });

    $('#modifier').submit(function(e) {
        e.preventDefault();
        $('p.error-message').text('');
        var fileInput = document.getElementById('fichier-modal');
        var file = fileInput.files[0];
        var formData = new FormData($('#modifier')[0]);

        if (file) {
            var reader = new FileReader();
            reader.onloadend = function() {
                formData.append('fichier_base64', reader.result);
                submitUpdate(formData);
            };
           reader.readAsDataURL(file);
        } else {
            submitUpdate(formData);

        }
        location.reload();

    });

    function submitForm(formData) {
        $.ajax({
            url: "{{ route('entre.store') }}",
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
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, messages) {
                        $('#error-' + key).text(messages[0]).show();
                    });
                }
            }
        });
    }

    function submitUpdate(formData) {
        $.ajax({
            url: "{{ route('entre.modifier') }}",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert('Vous avez effectué un entré');
                $('#modifier')[0].reset();
                loadEntree();
            },
            error: function(xhr) {
                console.log(xhr);
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, messages) {
                        $('#error-modal-' + key).text(messages[0]).show();
                    });
                }
            }
        });
    }

    function loadEntree() {
        $.ajax({
            url: '/get-entree',
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

    const stations = @json($stations);
    const station = {};

    stations.forEach(s => {
        station[s.id_station] = s.station;
    });

    function appendEntree(entree) {
        var row = '<tr>' +
                    '<td>' + entree.numero_camion + '</td>' +
                    '<td>' + entree.bon_livraison + ' (' + entree.path_bon_livraison + ')</td>' +
                    '<td>' + entree.quantite_palette + '</td>' +
                    '<td>' + (station[entree.station_id] || 'Station inconnue') + '</td>' + // Vérifie si la station existe
                    '<td>' +
                        '<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifierModal" data-id_entree="' + entree.id_entree_magasin + '">Modifier</button>' +
                    '</td>' +
                    '</tr>';
        $('#table-body').append(row);
    }

    $(document).on('click', '.btn[data-toggle="modal"][data-target="#modifierModal"]', function() {
        var id = $(this).data('id_entree');
        $.ajax({
            url: '/get-entree/' + id,
            type: 'GET',
            success: function(entree_magasin) {
                $('#id_entree-modal').val(entree_magasin.id_entree_magasin);
                if(entree_magasin.path_bon_livraison){
                    $('#encien-fichier').val(entree_magasin.path_bon_livraison);
                }else{
                    $('#encien-fichier').val("Aucun");
                }

                $('#station-modal').val(entree_magasin.station_id).trigger('change');
                $('#navire-modal').val(entree_magasin.navire_id).trigger('change');
                $('#quantite-modal').val(entree_magasin.quantite_palette);
                $('#bl-modal').val(entree_magasin.bon_livraison);
                $('#nom-modal').val(entree_magasin.chauffeur);
                $('#matricule-modal_camion').val(entree_magasin.numero_camion);
                if (entree_magasin.path_bon_livraison) {
                    $('#current-file').val(entree_magasin.path_bon_livraison);
                } else {
                    $('#current-file').val('Aucun fichier sélectionné.');
            }

            },
            error: function(xhr, status, error) {
                console.error("Erreur lors de la récupération de l'entree en magasin : ", error);
            }
        });
    });

    /*('#modifier_entreForm').submit(function(e) {
        e.preventDefault();

        console.log('fhdghjq');
        $('p.error-message').text('');
        var fileInput = document.getElementById('fichier-modal');
        var file = fileInput.files[0];
        var formData = new FormData($('#modifier_entreForm')[0]);

        if (file) {
            var reader = new FileReader();
            reader.onloadend = function() {
                formData.append('fichier_base64', reader.result);
                console.log(reader.result);
               // submitUpdate(formData);
            };
            reader.readAsDataURL(file);
        } else {
           // submitUpdate(formData); // Envoyer sans fichier
        }
    });*/




});
</script>
@endsection
