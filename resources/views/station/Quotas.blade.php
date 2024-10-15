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
                        <h5 class="mt-5">Insertion de nouvelle Station</h5>
                        <hr><form id="ajout_stationForm" action="{{ url('ajout-station') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="navire">Navire</label>
                                    <select id="navire" name="navire_id" class="form-control" required>
                                        @foreach($navires as $navire)
                                            <option value="{{ $navire->id_navire }}">{{ $navire->navire }}</option>
                                        @endforeach
                                    </select>
                                    <div id="error-navire" class="error-message">Veuillez sélectionner une navire.</div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="annee">Annee</label>
                                    <input type="text" class="form-control" name="annee" id="annee" maxlength="13">
                                    <div class="mb-3">
                                        <div id="error-annee" class="error-message text-danger"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                        @foreach($stations as $station)
                                            <label for="{{ $station->id_station }}">{{ $station->station }}</label>
                                            <input type="text" class="form-control" name="{{ $station->id_station }}" id="{{ $station->id_station }}" maxlength="13">
                                            <div class="mb-3">
                                                <div id="error-{{ $station->id_station }}" class="error-message text-danger"></div>
                                            </div>
                                        @endforeach
                                    <div id="error-navire" class="error-message"></div>
                                </div>
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
        </div>
        <!--  Liste   --->

        <!-- [ modal ] start -->
		<div id="modifierModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modificationstation" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Modification</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form id="modifier_stationForm" action="" method="POST">
                            @csrf
                            <input type="hidden" id="id_station-modal" name="id_station">
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input type="text" class="form-control" id="nom-modal" name="nom">
                            </div>
                            <div  class="form-group">
                                <div id="error-modal-nom" class="error-message text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label for="nif_stat">NIF</label>
                                <input type="text" class="form-control" id="nif_stat-modal" name="nif_stat" maxlength="13">
                            </div>
                            <div  class="form-group">
                                <div id="error-modal-nif_stat" class="error-message text-danger"></div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn  btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn  btn-primary" id="saveChangesBtn">Modifier</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ modal ] end -->

@endsection
@section('script')


@endsection
