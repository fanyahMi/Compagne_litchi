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
                        <a href="{{ url('import-excel') }}">Exporté model</a>
                        <hr>
                        <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-row">
                                <select name="compagne_id" id="">
                                    @foreach ($compagnes as $compagne)
                                            <option value="{{ $compagne->id_compagne }}">{{ $compagne->annee }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="file" name="file" accept=".xlsx" required>
                            <button type="submit">Importer</button>
                        </form>
                        <div id="error-message" class="error-message"></div>
                    </div>
                </div>
            </div>
            <!-- [ form-element ] end -->
        </div>        <!--  Liste   --->



@endsection

