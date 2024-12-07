@extends('template.Layout')

@section('titre')
   Accueil - Exportateur de Litchis
@endsection

@section('page')
<div class="container text-center mt-5">
    <!-- Logo de l'entreprise -->
    <div class="mb-4">
        <img src="{{ url('assets/images/SMMC-Logo.png') }}" alt="Logo Exportateur de Litchis" class="img-fluid" style="max-width: 200px;">
    </div>

    <!-- Titre principal -->
    <h1 class="display-4">Bienvenue chez SMMC</h1>
    <p class="lead mt-3">
        Spécialiste de l'exportation de litchis de Madagascar, nous garantissons des produits frais et de qualité supérieure, cultivés avec soin pour satisfaire nos partenaires à travers le monde.
    </p>


    <p class="text-muted">
        &copy; {{ date('Y') }} SMMC. Tous droits réservés. Développé par Fanyah.
    </p>



</div>
@endsection

@section('script')
<script>
    console.log('Page d\'accueil pour l\'exportateur de litchis chargée.');
</script>
@endsection
