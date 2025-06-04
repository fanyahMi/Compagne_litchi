@extends('template.Layout')

@section('titre')
   Accueil - Exportateur de Litchis
@endsection

@section('page')
<style>
    body {
        background-color: #f7f9fc;
        font-family: 'Arial', sans-serif;
    }
    .header {
        background-color: #003087;
        color: #fff;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .header img {
        height: 60px;
    }
    .card {
        border: none;
        border-radius: 12px;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
    }
    .table-custom th, .table-custom td {
        border: 1px solid #e0e6ed;
        text-align: center;
        padding: 12px;
    }
    .rank {
        width: 60px;
        font-weight: bold;
        font-size: 20px;
        color: #003087;
    }
    .large-number {
        font-size: 24px;
        font-weight: bold;
        color: #1a2526;
    }
    .info-section {
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 400px;
    }
    .info-top {
        display: flex;
        align-items: flex-start;
    }
    .info-text {
        margin-right: 40px;
    }
    .info-text p {
        margin-bottom: 10px;
        color: #1a2526;
        font-size: 15px;
    }
    .progress-container {
        display: flex;
        align-items: center;
    }
    .progress-wrapper, .shift-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-left: 20px;
    }
    .progress-vertical {
        width: 50px;
        height: 250px;
        transform: rotate(180deg);
        position: relative;
        background: #e0e6ed;
        border-radius: 8px;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .progress-bar-vertical {
        transform: rotate(180deg);
        width: 100%;
        border-radius: 8px;
        background-color: #28a745;
    }
    .progress-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #fff;
        font-weight: bold;
        font-size: 16px;
    }
    .shift-box {
        width: 50px;
        height: 250px;
        background-color: #0056d2;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 24px;
        font-weight: bold;
        border-radius: 8px;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .forecast-section {
        display: flex;
        justify-content: flex-end;
        margin-top: auto;
        gap: 15px;
    }
    .forecast-card {
        background-color: #fff;
        border-left: 4px solid #003087;
        border-radius: 8px;
        padding: 12px 15px;
        width: 150px;
        text-align: center;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease;
    }
    .forecast-card:hover {
        transform: scale(1.05);
    }
    .forecast-card.reste {
        border-left-color: #dc3545;
    }
    .forecast-card i {
        font-size: 18px;
        margin-right: 5px;
        color: #1a2526;
    }
    .forecast-card p {
        margin: 0;
        font-size: 14px;
        color: #1a2526;
    }
    .forecast-value {
        font-size: 20px;
        font-weight: bold;
        color: #1a2526;
    }
    .card-title {
        color: #003087;
        font-weight: bold;
    }
</style>

<div class="container text-center mt-5">

    <div class="header d-flex justify-content-between align-items-center">
        <img src="/assets/images/SMMC-Logo.png" alt="SMMC Logo" class="me-3">
        <div class="text-end">
            <p class="mb-0"><i class="fas fa-info-circle"></i> INFORMATION TECHNIQUE</p>
            <p class="mb-0"><i class="fas fa-calendar-alt"></i> Date: 2025-06-03 22:18</p>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="card info-section mb-4">
                <div class="card-body">
                    <h5 class="card-title text-center mb-3"><i class="fas fa-boxes"></i> Calages du Navire</h5>
                    <table class="table table-custom">
                        <tbody>
                            <tr>
                                <td class="rank">1</td>
                                <td class="large-number">0040</td>

                            </tr>
                            <tr>
                                <td class="rank">2</td>
                                <td class="large-number">0020</td>

                            </tr>
                            <tr>
                                <td class="rank">3</td>
                                <td class="large-number">0199</td>

                            </tr>
                            <tr>
                                <td class="rank">4</td>
                                <td class="large-number">00</td>

                            </tr>
                            <tr>
                                <td class="rank">5</td>
                                <td class="large-number">00</td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mb-1">
                <div class="card-body">
                    <h5 class="card-title mb-2"></i> Total</h5>
                    <p class="forecast-value">0259</p>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card mb-1">
                <div class="card-body">
                    <h5 class="card-title mb-2">&#8721; </i> Entree magasin</h5>
                    <p class="forecast-value">256</p>
                </div>
            </div>
            <div class="card mb-1">
                <div class="card-body">
                    <h5 class="card-title mb-2">&#8721; </i> Sortie magasin</h5>
                    <p class="forecast-value">256</p>
                </div>
            </div>
            <div class="card mb-1">
                <div class="card-body">
                    <h5 class="card-title mb-2">&#8721; </i> Entree shift</h5>
                    <p class="forecast-value">256</p>
                </div>
            </div>
            <div class="card mb-1">
                <div class="card-body">
                    <h5 class="card-title mb-2">&#8721; </i> Sortie shift</h5>
                    <p class="forecast-value">256</p>
                </div>
            </div>
            <div class="card mb-1">
                <div class="card-body">
                    <h5 class="card-title mb-2">&#8721; </i> Embarquer shift</h5>
                    <p class="forecast-value">256</p>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-body ">
                    <div class="info-top">
                        <div class="col-8">
                            <div class="info-text">
                                <h5 class="card-title mb-3"><i class="fas fa-ship"></i> Informations Navire</h5>
                                <p><i class="fas fa-ship"></i> NAVIRE: Atlantic klipper</p>
                                <p><i class="fas fa-map-marker-alt"></i> DESTINATION: Europe</p>
                                <p><i class="fas fa-clock"></i> ETAT: 2025-05-03 22:18</p>
                            </div>
                            <br>
                            <div class="forecast-section">
                                <div class="forecast-card">
                                    <p><i class="fas fa-eye"></i> Prévision</p>
                                    <p class="forecast-value">7311</p>
                                </div>
                                <div class="forecast-card reste">
                                    <p><i class="fas fa-hourglass-half"></i> Reste</p>
                                    <p class="forecast-value">7052</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="progress-container">
                                <div class="progress-wrapper">
                                    <p>%</p>
                                    <div class="progress progress-vertical">
                                        <div class="progress-bar progress-bar-striped bg-success progress-bar-vertical" role="progressbar" style="height: 3.5%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                            <span class="progress-text">3,5</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="shift-container">
                                    <p>Shift</p>
                                    <div class="shift-box">3</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
Stat
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script>
    console.log('Page d\'accueil pour l\'exportateur de litchis chargée.');
</script>
@endsection
