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
                        <hr><form id="ajout_stationForm" action="{{ url('ajout-station') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                @foreach ($compagnes as $compagne)
                                    <div class="radio col-md-3">
                                    <label>
                                        <input type="radio" name="optionsRadios" id="optionsRadios3" value="{{ $compagne->id_compagne }}" disabled> {{ $compagne->annee }}
                                    </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="navire">Navire</label>
                                    <select id="navire" name="navire_id" class="form-control" required>
                                        @foreach($navires as $navire)
                                            <option value="{{ $navire->id_navire }}">{{ $navire->navire }}</option>
                                        @endforeach
                                    </select>
                                    <div id="error-navire" class="error-message"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                @foreach($stations as $station)
                                <div class="form-group col-md-3">
                                            <label for="{{ $station->id_station }}">{{ $station->station }}</label>
                                            <input type="text" class="form-control" name="{{ $station->id_station }}" id="{{ $station->id_station }}" maxlength="13">
                                            <div class="mb-3">
                                                <div id="error-{{ $station->id_station }}" class="error-message text-danger"></div>
                                            </div>
                                    <div id="error-station" class="error-message"></div>
                                </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-primary">Insérer</button>
                        </form>
                        <div id="error-message" class="error-message"></div>
                    </div>
                    <div class="card-body">
                        <h5 class="c-black-900"><b>Liste des stations</b></h5>
                        <div class="mT-30">
                            <div id="table-container table-responsive">
                                <table id="produitTable" class="table table-hover table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>Annee</th>
                                            <th>Station</th>
                                            <th>Quotat</th>
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
            <!-- [ form-element ] end -->
        </div>        <!--  Liste   --->



@endsection
@section('script')


@endsection
