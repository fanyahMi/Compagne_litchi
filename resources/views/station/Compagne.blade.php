@extends('template.Layout')
@section('titre')
    Compagne
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
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Ajouter l'anné de compagne</h4>
            </div>
            <div class="card-body">
                <form id="sortie_magasin_form" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="debut">Debut</label>
                            <input type="date" class="form-control" name="debut" id="debut" min="1" required>
                            <div id="error-debut" class="error-message">Veuillez entrer une date.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fin">Fin</label>
                            <input type="date" class="form-control" name="fin" id="fin" min="1" required>
                            <div id="error-fin" class="error-message">Veuillez entrer une date.</div>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary">Enregistrer la Sortie</button>
                </form>
            </div>
            <div class="card-body">
                <div class="mT-30">
                    <div id="table-container table-responsive">
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
