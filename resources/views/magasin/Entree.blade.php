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

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .table th {
        background-color: #007bff;
        color: white;
    }
</style>

<div class="row">
    <!-- [ Form and Table ] start -->
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
                            <input type="file" class="form-control" name="fichier" id="fichier" accept="application/pdf" required>
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
        </div>
    </div>
    <!-- [ Form and Table ] end -->
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

    $('#ajout_magasin').submit(function(e) {
        e.preventDefault();

        $('p.error-message').text('');

        var fileInput = document.getElementById('fichier');
        var file = fileInput.files[0];

        if (file) {
            var reader = new FileReader();
            reader.onloadend = function() {
                var formData = new FormData($('#ajout_magasin')[0]);
                formData.append('fichier_base64', reader.result);
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, messages) {
                                $('#error-' + key).text(messages[0]);
                            });
                        } else {
                            alert('Erreur : ' + xhr.responseJSON.error);
                        }
                    }
                });
            };
            reader.readAsDataURL(file);
        } else {
            alert('Veuillez sélectionner un fichier.');
        }
    });
});
</script>
@endsection
