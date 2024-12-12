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
                        <a href="{{ url('export-model-navire-station') }}">Exporter modèle</a>
                        <hr>
                        <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <select class="form-control" name="compagne_id" id="">
                                        @foreach ($compagnes as $compagne)
                                                <option value="{{ $compagne->id_compagne }}">{{ $compagne->annee }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input type="file" class="form-control" name="file" accept=".xlsx" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Importer</button>
                        </form>
                        <div id="error-message" class="error-message"></div>
                    </div>
                </div>
            </div>
            <!-- [ form-element ] end -->
        </div>        <!--  Liste   --->
@endsection

