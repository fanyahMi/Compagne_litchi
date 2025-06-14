@extends('template.Layout')
@section('titre')
    Tableau de Bord - Statistiques Quotas
@endsection
@section('page')
<style>
    /* Style général pour les messages d'erreur */
    .error-message {
        color: red;
        font-size: 14px;
        padding: 5px;
        margin-top: 5px;
        display: none;
    }

    /* Design de la carte */
    .card-custom {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        overflow: hidden;
    }

    .card-custom:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .card-header-custom {
        background: linear-gradient(135deg, #1abc9c, #16a085);
        color: white;
        font-size: 16px;
        font-weight: bold;
        padding: 15px;
        text-align: center;
    }

    .card-body-custom {
        padding: 20px;
        text-align: center;
        font-size: 14px;
        color: #333;
    }

    .stat-value {
        font-size: 24px;
        font-weight: bold;
        color: #1abc9c;
        margin: 10px 0;
    }

    /* Conteneur principal */
    .container-dashboard {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    /* Conteneur pour les graphiques */
    .chart-container {
        width: 100%;
        max-width: 500px;
        margin: 20px auto;
    }

    /* Mise en évidence du titre */
    .dashboard-title {
        background: linear-gradient(135deg, #1abc9c, #16a085);
        color: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
        font-weight: bold;
        text-align: center;
    }

    /* Responsivité mobile */
    @media (max-width: 768px) {
        .container-dashboard {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        }
        .chart-container {
            width: 90%;
        }
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="dashboard-title">
                Tableau de Bord - Campagne en cours : {{ $currentCampagne->annee }}
            </div>
            <div class="card-body">
                <!-- Filtres pour campagne et navire -->
                <div class="form-row mb-4">
                    <div class="form-group col-md-3">
                        <label for="filter-compagne">Campagne</label>
                        <select id="filter-compagne" class="form-control">
                            @foreach($campagnes as $campagne)
                                <option value="{{ $campagne->id_compagne }}"
                                        {{ $campagne->etat == 1 ? 'selected' : '' }}>
                                    {{ $campagne->annee }} {{ $campagne->etat == 1 ? '(En cours)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="filter-navire">Navire</label>
                        <select id="filter-navire" class="form-control">
                            <option value="">Tous les navires</option>
                            @foreach($navires as $navire)
                                <option value="{{ $navire->id_navire }}">{{ $navire->navire }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label> </label>
                        <button type="button" class="btn btn-secondary form-control" id="filter-charts-btn">Appliquer</button>
                    </div>
                </div>

                <!-- Statistiques clés -->
                <div class="container-dashboard" id="stats-container">
                    <div class="card card-custom">
                        <div class="card-header-custom">Total Palettes</div>
                        <div class="card-body-custom">
                            <div class="stat-value" id="stat-total-pallets">0</div>
                            <p>Palettes embarquées</p>
                        </div>
                    </div>
                    <div class="card card-custom">
                        <div class="card-header-custom">Pourcentage Quota</div>
                        <div class="card-body-custom">
                            <div class="stat-value" id="stat-pourcentage">0%</div>
                            <p>Moyenne d'utilisation</p>
                        </div>
                    </div>
                    <div class="card card-custom">
                        <div class="card-header-custom">Stations Actives</div>
                        <div class="card-body-custom">
                            <div class="stat-value" id="stat-stations">0</div>
                            <p>Stations</p>
                        </div>
                    </div>
                </div>

                <!-- Graphiques -->
                <div class="container-dashboard">
                    <!-- Graphique 1 : Total Pallets vs Quotas -->
                    <div class="card card-custom">
                        <div class="card-header-custom">Quotas par Navire</div>
                        <div class="card-body-custom">
                            <div class="chart-container">
                                <canvas id="quotasChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Graphique 2 : Répartition par Station (Doughnut) -->
                    <div class="card card-custom">
                        <div class="card-header-custom">Palettes par Station</div>
                        <div class="card-body-custom">
                            <div class="chart-container" style="width: 50%">
                                <canvas id="stationsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('assets/js/plugins/jquery-ui.min.js') }}"></script>
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Variables globales pour les graphiques
let quotasChart = null;
let stationsChart = null;

function initializeCharts(navires, totalPallets, quotas, pourcentages, stationsLabels, stationsData, selectedNavire) {
    // Détruire les graphiques existants s'ils existent
    if (quotasChart) quotasChart.destroy();
    if (stationsChart) stationsChart.destroy();

    // Graphique 1 : Bar Chart (Total Pallets vs Quotas)
    const quotasCtx = document.getElementById('quotasChart').getContext('2d');
    quotasChart = new Chart(quotasCtx, {
        type: 'bar',
        data: {
            labels: navires,
            datasets: [
                {
                    label: 'Total Palettes',
                    data: totalPallets,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Quota',
                    data: quotas,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Nombre de palettes' }
                },
                x: {
                    title: { display: true, text: 'Navire' }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const index = context.dataIndex;
                            const datasetLabel = context.dataset.label;
                            const value = context.raw;
                            const pourcentage = pourcentages[index];
                            return `${datasetLabel}: ${value} (${pourcentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Graphique 2 : Doughnut Chart (Répartition par station)
    const stationsCtx = document.getElementById('stationsChart').getContext('2d');
    // Calculer les données pour le Doughnut Chart
    const stationTotals = stationsLabels.map(station => {
        let total = 0;
        if (selectedNavire && stationsData[selectedNavire]) {
            total = stationsData[selectedNavire][station] || 0;
        } else {
            navires.forEach(navire => {
                total += stationsData[navire]?.[station] || 0;
            });
        }
        return total;
    });

    stationsChart = new Chart(stationsCtx, {
        type: 'doughnut',
        data: {
            labels: stationsLabels,
            datasets: [{
                label: 'Palettes par Station',
                data: stationTotals,
                backgroundColor: stationsLabels.map((_, index) =>
                    `rgba(${100 + index * 50}, ${150 - index * 30}, ${200 - index * 20}, 0.5)`
                ),
                borderColor: stationsLabels.map((_, index) =>
                    `rgba(${100 + index * 50}, ${150 - index * 30}, ${200 - index * 20}, 1)`
                ),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: {
                    display: true,
                    text: selectedNavire ? `Palettes par Station pour ${navires.find(n => stationsData[n] && Object.keys(stationsData[n]).length > 0)}` : 'Palettes par Station (Global)'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw;
                            return `${label}: ${value} palettes`;
                        }
                    }
                }
            }
        }
    });
}

function updateStats(totalPallets, pourcentage, stationsCount) {
    $('#stat-total-pallets').text(totalPallets || 0);
    $('#stat-pourcentage').text(`${pourcentage || 0}%`);
    $('#stat-stations').text(stationsCount || 0);
}

function loadDashboardData(compagneId, navireId = '') {
    $.ajax({
        url: '/dashboard/quotas',
        type: 'GET',
        data: {
            id_compagne: compagneId,
            id_navire: navireId
        },
        success: function(data) {
            console.log(data);
            // Mettre à jour les statistiques
            updateStats(data.total_pallets, data.avg_pourcentage, data.stations_count);

            // Initialiser les graphiques
            initializeCharts(
                data.navires,
                data.total_pallets_data,
                data.quotas,
                data.pourcentages,
                data.stations_labels,
                data.stations_data,
                data.navires.find(navire => navire.id_navire === navireId) || ''
            );
        },
        error: function(xhr, status, error) {
            console.error('Erreur lors du chargement des données du dashboard : ', xhr.status, xhr.responseText);
            updateStats(0, 0, 0);
            initializeCharts([], [], [], [], [], {}, '');
        }
    });
}

$(document).ready(function() {
    // Charger les données initiales du dashboard
    const initialCompagne = $('#filter-compagne').val();
    loadDashboardData(initialCompagne);

    // Événement pour le filtre des graphiques
    $('#filter-charts-btn').on('click', function() {
        const compagne = $('#filter-compagne').val();
        const navire = $('#filter-navire').val();
        loadDashboardData(compagne, navire);
    });
});
</script>
@endsection
