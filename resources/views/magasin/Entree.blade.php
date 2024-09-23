@extends('template.Layout')
@section('titre')
    Entre magasin
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

<div class="row">
    <!-- [ form-element ] start -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="mt-5">Insertion de nouvel agent</h5>
                <hr><form id="ajout_magasin" action="{{ url('insert-entree-magasin') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="navire">Navire</label>
                            <select id="navire" name="navire" class="form-control" required>
                                <option value="">Sélectionner</option>
                                @foreach($navires as $navire)
                                    <option value="{{ $navire->id_navire }}">{{ $navire->navire }}</option>
                                @endforeach
                            </select>
                            <!-- Optional error message for 'navire' -->
                            <div class="mb-3">
                                <div id="error-navire" class="error-message text-danger"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="station">Station</label>
                            <select id="station" name="station" class="form-control" required>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id_station }}">{{ $station->station }}</option>
                                @endforeach
                            </select>
                            <!-- Optional error message for 'station' -->
                            <div class="mb-3">
                                <div id="error-station" class="error-message text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="quantite">Quantite de palette</label>
                            <input type="number" class="form-control" name="quantite" id="quantite" min="1">
                            <div class="mb-3">
                                <div id="error-quantite" class="error-message text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="bl">Bon de livraison</label>
                            <input type="file" class="form-control " name="bl" id="bl">
                            <div class="mb-3">
                                <div id="error-bl" class="error-message text-danger"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="nom">Nom du chauffeur</label>
                            <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom">
                            <div class="mb-3">
                                <div id="error-nom" class="error-message text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="matricule_camion">Matricule camion</label>
                            <input type="text" class="form-control" name="matricule_camion" id="matricule_camion" maxlength="12">
                            <div class="mb-3">
                                <div id="error-matricule_camion" class="error-message text-danger"></div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Insérer</button>
                </form>
                <div id="error-message" class="error-message"></div>
            </div>
            <div class="card-body">
                <h5 class="c-black-900"><b>Liste des réservations</b></h5>
                <div class="mT-30">
                    <div id="table-container">
                        <table id="produitTable" class="table table-hover table-bordered ">
                            <thead>
                                <tr>
                                    <th>Matricule</th>
                                    <th>Nom et prénom</th>
                                    <th>Date de naissance</th>
                                    <th>matricule-camion</th>
                                    <th>navire</th>
                                    <th>station </th>
                                    <th>Embaucher le</th>
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

@endsection
@section('script')

@endsection
