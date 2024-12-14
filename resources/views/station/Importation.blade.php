@extends('template.Layout')
@section('titre')
    Liste des quotats
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
            <div class="card-header">
                <h5>Importation de numéro de chaque station et ses quotas </h5>
            </div>
            <div class="card-body">
                <a href="{{ url('export-model-navire-station') }}">Exporter modèle</a>
                <hr>
                <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <select class="form-control" name="compagne_id" id="">
                                @foreach ($compagnes as $compagne)
                                    <option value="{{ $compagne->id_compagne }}">{{ $compagne->annee }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="file" class="form-control" name="file" accept=".xlsx" required>
                        </div>
                        <div class="form-group col-md-3">
                            <button type="submit" class="btn btn-primary">Importer</button>
                        </div>
                    </div>
                </form>

                <!-- Affichage des erreurs -->
                @if($errors->any())
                    <div id="error-message" class="error-message">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- [ form-element ] end -->
</div>
@endsection
