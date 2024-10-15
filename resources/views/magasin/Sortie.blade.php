@extends('template.Layout')
@section('titre')
    Sortie de Magasin
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
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Sortie de Magasin</h4>
            </div>
            <div class="card-body">
                <form id="sortie_magasin_form" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="entree_magasin_id">Camion</label>
                            <select id="entree_magasin_id" name="entree_magasin_id" class="form-control" required>
                                <option value="">Sélectionner un camion</option>
                                @foreach($camions as $camion)
                                    <option value="{{ $camion->id_entree_magasin }}">{{ $camion->numero_camion }}</option>
                                @endforeach
                            </select>
                            <div id="error-entree_magasin_id" class="error-message">Veuillez sélectionner un camion.</div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="quantite_sortie">Quantité de Sortie</label>
                            <input type="number" class="form-control" name="quantite_sortie" id="quantite_sortie" min="1" required>
                            <div id="error-quantite_sortie" class="error-message">Veuillez entrer une quantité valide.</div>
                        </div>
                    </div>

                    <b id="quantite-affiche">Quantité Entrant : <span id="quantite-valeur"></span></b><br>

                    <button type="submit" class="btn btn-primary">Enregistrer la Sortie</button>
                </form>
            </div>
            <div class="card-body">
                <div class="mT-30">
                    <div id="table-container">
                        <table id="" class="table table-hover table-bordered ">
                            <thead>
                                <tr>
                                    <th>Numero de camion</th>
                                    <th>Quantité sortant</th>
                                    <th>Date</th>
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
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    loadSortie();
    $('#entree_magasin_id').change(function() {
        var idEntreMagasin = $(this).val();
        if (idEntreMagasin) {
            $.ajax({
                url: "/quantite-entree/" + idEntreMagasin,
                method: 'GET',
                success: function(data) {
                    $('#quantite-valeur').text(data ? data.quantite_palette : 'Aucune quantité disponible');
                },
                error: function(xhr) {
                    $('#quantite-valeur').text('Erreur de récupération de la quantité');
                }
            });
        } else {
            $('#quantite-valeur').text('');
        }
    });

    $('#sortie_magasin_form').submit(function(e) {
        e.preventDefault();
        $('.error-message').hide();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('sortie.store') }}",
            method: 'POST',
            data: formData,
            success: function(response) {
                $('#sortie_magasin_form')[0].reset();
                $('#quantite-valeur').text('');
                loadSortie();
            },
            error: function(xhr) {
                console.log(xhr);
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, messages) {
                        $('#error-' + key).text(messages[0]).show();
                    });
                } else {
                    alert('Erreur : ' + xhr.responseJSON.message);
                }
            }
        });
    });

    function loadSortie() {
        $.ajax({
            url: '/get-sortie',
            type: 'GET',
            success: function(data) {
                $('#table-body').empty();
                data.forEach(function(sortie) {
                    appendSortie(sortie);
                });
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors du chargement des sortant du magasin : ", error);
            }
        });
    }

    function appendSortie(sortie) {
        var row = '<tr>' +
                    '<td>' + sortie.matricule_sortant + '</td>' +
                    '<td>' + sortie.quantite_sortie + '</td>' +
                    '<td>' + sortie.date_sortie + '</td>' +
                   '</tr>';
        $('#table-body').append(row);
    }
});
</script>
@endsection
