@extends('template.Layout')
@section('titre')
    Camions
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
<div class="filter-container mb-4">
    <form id="filter-form" class="form-inline">
        <div class="form-group mr-2">
            <label for="search" class="mr-2">Recherche :</label>
            <input type="text" name="search" id="search" class="form-control" placeholder="Rechercher un camion">
        </div>
        <button type="submit" class="btn btn-primary">Filtrer</button>
        <button type="button" id="reset-button" class="btn btn-secondary ml-2">Réinitialiser</button>
    </form>
</div>

<div id="table-container">
    <table class="table">
        <!-- Contenu de la table généré ici -->
        @foreach ($camions as $camion)
            <tr>
                <td>{{ $camion->nom }}</td>
                <td>{{ $camion->type }}</td>
                <!-- Autres colonnes -->
            </tr>
        @endforeach
    </table>
</div>

@endsection

@section('script')

<script src="assets/js/plugins/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
        // Filtrage avec AJAX
        $('#filter-form').on('submit', function(e) {
            e.preventDefault(); // Empêche le rechargement de la page

            let search = $('#search').val();
            $.ajax({
                url: "/magasin-camion", // URL de l'action
                method: "GET",
                data: { search: search },
                success: function(response) {
                    $('#table-container').html(response); // Remplace le contenu de la table
                },
                error: function(xhr) {
                    console.error("Erreur :", xhr.responseText);
                }
            });
        });

        // Réinitialiser les filtres
        $('#reset-button').on('click', function() {
            $('#search').val(''); // Vide le champ de recherche
            $('#filter-form').submit(); // Recharge la table sans filtre
        });
    });
</script>

@endsection
