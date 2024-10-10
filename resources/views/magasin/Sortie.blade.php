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
                Sortie de Magasin
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

                    <h3 id="quantite-affiche">Quantité Entrant : <span id="quantite-valeur"></span></h3>

                    <button type="submit" class="btn btn-primary">Enregistrer la Sortie</button>
                </form>
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
                location.reload();
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
});
</script>
@endsection
