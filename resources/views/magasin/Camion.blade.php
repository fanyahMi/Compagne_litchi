@extends('template.Layout')
@section('titre')
    Liste des Camions dans le Magasin
@endsection
@section('page')

<style>
    .card-header {
        background-color: #28a745;
        color: white;
        font-size: 18px;
        font-weight: bold;
    }

    .card-body {
        padding: 20px;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #218838;
    }

    .table th {
        background-color: #28a745;
        color: white;
    }

    .table tbody tr:hover {
        background-color: #f0f9f0;
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                Liste des Camions dans le Magasin
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Navire</th>
                            <th>Station</th>
                            <th>Numéro Camion</th>
                            <th>Chauffeur</th>
                            <th>Date Entrant</th>
                            <th>Date Sortant</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($camions as $camion)
                            <tr>
                                <td>{{ $camion->navire }}</td>
                                <td>{{ $camion->station }}</td>
                                <td>{{ $camion->numero_camion }}</td>
                                <td>{{ $camion->chauffeur }}</td>
                                <td>{{ $camion->date_entrant }}</td>
                                <td>{{ $camion->date_sortie }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

@endsection
