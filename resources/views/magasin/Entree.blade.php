@extends('template.Layout')
@section('titre')
    Entrée en Magasin
@endsection
@section('page')

<style>
    .error-message {
        color: red;
        font-size: 14px;
        padding: 5px;
        margin-top: 5px;
        display: none;
    }
    #confirmation-message {
    font-size: 1rem;
    padding: 10px;
    display: flex;
    align-items: center;
}
#confirmation-message i {
    margin-right: 8px;
}
    /* Appliquer une police normale à tous les éléments concernés */
    .card, .card-header, .card-body, label, input, select, button, table, th, td, b, span {
        font-weight: normal !important;
    }
    /* Masquer la carte des filtres par défaut */
    #filter-card {
        display: none;
    }
    /* Espacement pour les icônes dans les boutons */
    .btn i {
        margin-right: 5px;
    }
    /* Style pour le lien cliquable dans la colonne Bon de livraison */
    .download-link {
        color: #007bff !important;
        cursor: pointer;
        text-decoration: none;
    }
    .download-link:hover {
        text-decoration: underline;
    }
    /* Espacement pour l'icône de téléchargement */
    .download-link i {
        margin-left: 5px;
    }
    .table-sm {
        font-size: 0.875rem; /* Taille de police réduite */
    }
    .table-sm th, .table-sm td {
        padding: 0.3rem; /* Espacement réduit */
    }
</style>

<div class="row">
    <div class="col-sm-12">

       
        <!-- Bouton pour montrer/fermer les filtres, aligné à gauche -->
        <div class="mb-4 text-left">
            <button type="button" class="btn btn-secondary" id="show-filter-btn"><i class="fas fa-filter"></i> Afficher les filtres</button>
        </div>

        <!-- Card for Filters -->
        <div class="card mb-4" id="filter-card">
            <div class="card-header">
                <h5>Filtres</h5>
            </div>
            <div class="card-body">
                <div class="mT-30">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="filter-navire">Navire</label>
                            <select id="filter-navire" class="form-control">
                                <option value="">Sélectionner</option>
                                @foreach($normal_navires as $navire)
                                    <option value="{{ $navire->id_navire }}">{{ $navire->navire }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filtre-station">Station</label>
                            <select id="filtre-station" class="form-control">
                                <option value="">Sélectionner</option>
                                @foreach($normal_stations as $station)
                                    <option value="{{ $station->id_station }}">{{ $station->station }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filter-annee">Année</label>
                            <select id="filter-annee" class="form-control">
                                <option value="">Sélectionner</option>
                                @foreach($compagnes as $campagne)
                                    <option value="{{ $campagne->id_compagne }}">{{ $campagne->annee }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filter-shift">Shift</label>
                            <select id="filter-shift" class="form-control">
                                <option value="">Sélectionner</option>
                                @foreach($shifts as $shift)
                                    <option value="{{ $shift->id_shift }}">{{ $shift->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filter-bon_livraison">Bon de livraison</label>
                            <input type="text" class="form-control" id="filter-bon_livraison">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filter-camion">Numéro Camion</label>
                            <input type="text" class="form-control" id="filter-camion">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="debut">Date début</label>
                            <input type="date" class="form-control" id="debut">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="fin">Date fin</label>
                            <input type="date" class="form-control" id="fin">
                        </div>
                        <div class="form-group col-md-3" style="align-content: flex-end">
                            <button type="button" class="btn btn-secondary" id="filter-btn"><i class="fas fa-search"></i> Filtrer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card for Form -->
        @if (!empty($stations))
        <div class="card mb-4">
            <div class="card-header">
                <h5>Entrée camion dans le magasin</h5>
            </div>
            <div class="card-body">
                <div id="confirmation-message" class="alert alert-success mt-3" role="alert" style="display: none;">
                    <i class="fas fa-check-circle mr-2"></i> Confirmation enregistrée
                </div>
                <form id="ajout_magasin" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="navire">Navire</label>
                            <select id="navire" name="navire_id" class="form-control" required>
                                <option value="">Sélectionner</option>
                                @foreach($navires as $navire)
                                    <option value="{{ $navire->id_navire }}">{{ $navire->navire }}</option>
                                @endforeach
                            </select>
                            <div id="error-navire" class="error-message">Veuillez sélectionner un navire.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="station">Station</label>
                            <select id="station" name="numero_station_id" class="form-control" required>
                                <option value="">Sélectionner</option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id_numero_station }}">{{ $station->station }} / {{ $station->numero_station }}</option>
                                @endforeach
                            </select>
                            <div id="error-station" class="error-message">Veuillez sélectionner une station.</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="quantite">Quantité de palette</label>
                            <input type="number" class="form-control" name="quantite_palette" id="quantite" min="1" required>
                            <div id="error-quantite" class="error-message">Veuillez entrer une quantité valide.</div>
                            <div id="reste-info" class="alert alert-info mt-3 d-flex align-items-center" role="alert" style="display: none;">
                                <i class="fas fa-box-open mr-2"></i>
                                <div>
                                    <strong>Reste de palettes à entrer :</strong> <span id="reste-valeur"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="bl">Bon de livraison</label>
                            <input type="text" class="form-control" name="bon_livraison" id="bl" required>
                            <div id="error-bon_livraison" class="error-message">Veuillez entrer un bon de livraison valide.</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fichier">Fichier (PDF)</label>
                            <input type="file" class="form-control" name="fichier" id="fichier" accept="application/pdf">
                            <div id="error-fichier" class="error-message">Veuillez sélectionner un fichier PDF.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nom">Nom du chauffeur</label>
                            <input type="text" class="form-control" name="chauffeur" id="nom" required>
                            <div id="error-nom" class="error-message">Veuillez entrer le nom du chauffeur.</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="matricule_camion">Numéro camion</label>
                            <input type="text" class="form-control" name="numero_camion" id="matricule_camion" maxlength="12" required>
                            <div id="error-matricule_camion" class="error-message">Veuillez entrer une matricule valide.</div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Enregistrer l'entrée</button>
                </form>
            </div>
        </div>
        @endif

        <!-- Card for Table -->
        <div class="card">
            <div class="card-header">
                <h5>Liste des entrées</h5>
            </div>
            <div class="card-body">
                <div class="mT-30">
                    <div id="table-responsive" style="overflow-x: auto;">
                        <table class="table table-hover table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Bon d'entrée</th>
                                    <th>Agent</th>
                                    <th>Campagne</th>
                                    <th>Navire</th>
                                    <th>Chauffeur</th>
                                    <th>Numéro de camion</th>
                                    <th>Bon de livraison</th>
                                    <th>Shift</th>
                                    <th>Quantité de palette</th>
                                    <th>Nº station</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                            </tbody>
                        </table>
                    </div>
                    <div id="pagination" class="mt-3 text-center"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@if (!empty($stations))
<div id="modifierModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModificationEntree" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modification de l'entrée</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="modifier" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id_entree-modal" name="id_entree">
                    <input type="hidden" id="encien-fichier" name="encien">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="navire-modal">Navire</label>
                            <select id="navire-modal" name="navire_id" class="form-control" required>
                                <option value="">Sélectionner</option>
                                @foreach($navires as $navire)
                                    <option value="{{ $navire->id_navire }}">{{ $navire->navire }}</option>
                                @endforeach
                            </select>
                            <div id="error-modal-navire" class="error-message">Veuillez sélectionner un navire.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="station-modal">Station</label>
                            <select id="station-modal" name="numero_station_id" class="form-control" required>
                                <option value="">Sélectionner</option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id_numero_station }}">{{ $station->station }} / {{ $station->numero_station }}</option>
                                @endforeach
                            </select>
                            <div id="error-modal-station" class="error-message">Veuillez sélectionner une station.</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="quantite-modal">Quantité de palette</label>
                            <input type="number" class="form-control" name="quantite_palette" id="quantite-modal" min="1" required>
                            <div id="error-modal-quantite" class="error-message">Veuillez entrer une quantité valide.</div>
                            <div id="reste-modal-info" class="alert alert-info mt-3 d-flex align-items-center" role="alert" style="display: none;">
                                <i class="fas fa-box-open mr-2"></i>
                                <div>
                                    <strong>Reste de palettes à entrer :</strong> <span id="reste-modal-valeur"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="bl-modal">Bon de livraison</label>
                            <input type="text" class="form-control" name="bon_livraison" id="bl-modal" required>
                            <div id="error-modal-bl" class="error-message">Veuillez entrer un bon de livraison valide.</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fichier-modal">Fichier (PDF)</label>
                            <input type="text" class="form-control" id="current-file" readonly>
                            <input type="file" class="form-control" name="fichier" id="fichier-modal" accept="application/pdf">
                            <div id="error-modal-fichier" class="error-message">Veuillez sélectionner un fichier PDF.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nom-modal">Nom du chauffeur</label>
                            <input type="text" class="form-control" name="chauffeur" id="nom-modal" required>
                            <div id="error-modal-nom" class="error-message">Veuillez entrer le nom du chauffeur.</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="matricule-modal_camion">Numéro camion</label>
                            <input type="text" class="form-control" name="numero_camion" id="matricule-modal_camion" maxlength="12" required>
                            <div id="error-matricule-modal_camion" class="error-message">Veuillez entrer une matricule valide.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Fermer</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@section('script')
<!-- Inclure Font Awesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="assets/js/jsPdf.js"></script>
<script src="assets/js/auto-table.js"></script>
<script>
const { jsPDF } = window.jspdf;

// Fonction pour générer le PDF avec jsPDF
function generatePDF(entree) {
    const {
        id_entree_magasin,
        matricule_entrant,
        annee,
        navire,
        chauffeur,
        numero_camion,
        bon_livraison,
        quantite_palette,
        numero_station,
        station,
        date_entrant
    } = entree;

    const doc = new jsPDF();

    // Ajout du Logo
    const logoUrl = 'assets/images/SMMC-Logo.png';
    const img = new Image();
    img.src = logoUrl;
    doc.addImage(img, 'PNG', 10, 10, 100, 20);

    // En-tête
    doc.setFontSize(12);
    doc.setFont('Helvetica', 'normal');
    doc.text("SMMC", 130, 20);
    doc.setFontSize(10);
    doc.text("TAOMASINA", 130, 28);
    doc.text("Téléphone : +261 20 53 312 63", 130, 35);
    doc.text("Email : contact@smmc.mg", 130, 42);

    // Dessiner une ligne sous l'en-tête
    doc.setLineWidth(0.5);
    doc.line(10, 50, 200, 50);

    // Informations principales de l'entrée
    doc.setFontSize(10);
    const detailsStartY = 60;
    const lineSpacing = 7;

    doc.text(`Bon d'entrée : ${id_entree_magasin}`, 10, detailsStartY);
    doc.text(`Bon de livraison : ${bon_livraison}`, 10, detailsStartY + lineSpacing);
    doc.text(`Campagne : ${annee}`, 10, detailsStartY + 2 * lineSpacing);
    doc.text(`Date : ${date_entrant}`, 10, detailsStartY + 3 * lineSpacing);
    doc.text(`Navire : ${navire}`, 10, detailsStartY + 4 * lineSpacing);
    doc.text(`Numéro station : ${numero_station} - ${station}`, 10, detailsStartY + 5 * lineSpacing);
    doc.text(`Agent : ${matricule_entrant}`, 10, detailsStartY + 6 * lineSpacing);

    // Tableau des données
    const startTableY = detailsStartY + 8 * lineSpacing;
    doc.setFontSize(10);
    doc.text("Détails des entrées", 10, startTableY - 5);

    doc.autoTable({
        startY: startTableY,
        head: [['Chauffeur', 'Camion', 'Quantité', 'Unité']],
        body: [[chauffeur, numero_camion, quantite_palette, 'Palette']],
        styles: {
            fontSize: 10,
            halign: 'center',
            fontStyle: 'normal'
        },
        theme: 'grid',
    });

    // Pied de page
    const pageHeight = doc.internal.pageSize.height;
    doc.setFontSize(8);
    doc.text("SMMC - Alpha House", 10, pageHeight - 10);
    doc.text("Page 1", 190, pageHeight - 10, { align: 'right' });

    // Sauvegarde du PDF
    doc.save(`bon_entree_${id_entree_magasin}.pdf`);
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

const baseDownloadUrl = '{{ url('/telecharger') }}';

function appendEntree(entree) {
    console.log(entree);
    const button = entree.etat == 0 ? `<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifierModal" data-id_entree="${entree.id_entree_magasin}"><i class="fas fa-edit"></i> Modifier</button>` : "";
    const row = `
        <tr>
            <td><a href="#" class="download-link" onclick='generatePDF(${JSON.stringify(entree)})'>${entree.id_entree_magasin} </a></td>
            <td>${entree.matricule_entrant}</td>
            <td>${entree.annee}</td>
            <td>${entree.navire}</td>
            <td>${entree.chauffeur}</td>
            <td>${entree.numero_camion}</td>
            <td><a href="${baseDownloadUrl}/${entree.id_entree_magasin}" target="_blank" class="download-link">${entree.bon_livraison} </a></td>
            <td>${entree.description}</td>
            <td>${entree.quantite_palette}</td>
            <td>${entree.numero_station} <small>(${entree.station || 'Station inconnue'})</small></td>
            <td>${entree.date_entrant}</td>
            <td>${button}</td>
        </tr>`;
    $('#table-body').append(row);
}

function appendPagination(data) {
    let pagination = '';

    if (data.prev_page_url) {
        pagination += '<button class="btn btn-primary mx-1" onclick="loadEntree(' + (data.current_page - 1) + ')">Précédent</button>';
    } else {
        pagination += '<button class="btn btn-secondary mx-1" disabled>Précédent</button>';
    }

    for (let i = 1; i <= data.last_page; i++) {
        pagination += '<button class="btn ' + (i === data.current_page ? 'btn-dark' : 'btn-light') + ' mx-1" onclick="loadEntree(' + i + ')">' + i + '</button>';
    }

    if (data.next_page_url) {
        pagination += '<button class="btn btn-primary mx-1" onclick="loadEntree(' + (data.current_page + 1) + ')">Suivant</button>';
    } else {
        pagination += '<button class="btn btn-secondary mx-1" disabled>Suivant</button>';
    }

    $('#pagination').html(pagination);
}

function loadEntree(page = 1) {
    const navire = $('#filter-navire').val();
    const campagne = $('#filter-annee').val();
    const station = $('#filtre-station').val();
    const shift = $('#filter-shift').val();
    const bon_livraison = $('#filter-bon_livraison').val();
    const camion = $('#filter-camion').val();
    const debut = $('#debut').val();
    const fin = $('#fin').val();
    $.ajax({
        url: '/get-entree?page=' + page,
        type: 'GET',
        data: {
            navire: navire,
            campagne: campagne,
            station: station,
            shift: shift,
            bon_livraison: bon_livraison,
            camion: camion,
            debut: debut,
            fin: fin
        },
        success: function(data) {
            $('#table-body').empty();
            data.data.forEach(function(entree) {
                appendEntree(entree);
            });
            appendPagination(data);
        },
        error: function(xhr, status, error) {
            console.error("Erreur lors du chargement des entrées : ", error);
        }
    });
}

$(document).ready(function() {
    // Gestion du bouton "Afficher/Masquer les filtres"
    $('#show-filter-btn').on('click', function() {
        if ($('#filter-card').is(':visible')) {
            $('#filter-card').slideUp();
            $(this).html('<i class="fas fa-filter"></i> Afficher les filtres').removeClass('btn-danger').addClass('btn-secondary');
        } else {
            $('#filter-card').slideDown();
            $(this).html('<i class="fas fa-times"></i> Fermer les filtres').removeClass('btn-secondary').addClass('btn-danger');
        }
    });

    // Gestion du filtre
    $('#filter-btn').on('click', function() {
        loadEntree(1);
    });

    // Gestion de la quantité restante
    $('#navire, #station').on('change', function() {
        const idNavire = $('#navire').val();
        const idNumeroStation = $('#station').val();
        if (idNavire && idNumeroStation) {
            $.ajax({
                url: `{{ url('reste-quantite-palette-station') }}/${idNumeroStation}/${idNavire}`,
                method: 'GET',
                success: function(data) {
                    const reste = data.reste;
                    $('#quantite').attr('max', reste);
                    $('#quantite').val('');
                    $('#reste-valeur').text(reste ? reste : 'Aucune palette disponible');
                    $('#reste-info').show();
                },
                error: function(xhr) {
                    $('#reste-valeur').text('Erreur de récupération');
                    $('#reste-info').show();
                }
            });
        } else {
            $('#reste-valeur').text('');
            $('#reste-info').hide();
        }
    });

    // Gestion de la quantité restante dans le modal
    $('#navire-modal, #station-modal').on('change', function() {
        const idNavire = $('#navire-modal').val();
        const idNumeroStation = $('#station-modal').val();
        if (idNavire && idNumeroStation) {
            $.ajax({
                url: `{{ url('reste-quantite-palette-station') }}/${idNumeroStation}/${idNavire}`,
                method: 'GET',
                success: function(data) {
                    const reste = data.reste;
                    $('#quantite-modal').attr('max', reste);
                    $('#quantite-modal').val('');
                    $('#reste-modal-valeur').text(reste ? reste : 'Aucune palette disponible');
                    $('#reste-modal-info').show();
                },
                error: function(xhr) {
                    $('#reste-modal-valeur').text('Erreur de récupération');
                    $('#reste-modal-info').show();
                }
            });
        } else {
            $('#reste-modal-valeur').text('');
            $('#reste-modal-info').hide();
        }
    });

    // Chargement initial des entrées
    loadEntree(1);

    // Soumission du formulaire d'ajout
$('#ajout_magasin').submit(function(e) {
    e.preventDefault();
    $('.error-message').hide();
    var formData = new FormData(this);
    $.ajax({
        url: "{{ route('entre.store') }}",
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            $('#ajout_magasin')[0].reset();
            $('#reste-valeur').text('');
            $('#reste-info').hide();
            loadEntree();
            // Afficher le message de confirmation
            $('#confirmation-message').fadeIn().delay(3000).fadeOut();
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, messages) {
                    $('#error-' + key).text(messages[0]).show();
                });
            } else {
                // Afficher une erreur dans le même conteneur
                $('#confirmation-message')
                    .removeClass('alert-success')
                    .addClass('alert-danger')
                    .html('<i class="fas fa-exclamation-circle mr-2"></i> Erreur : ' + xhr.responseJSON.message)
                    .fadeIn().delay(3000).fadeOut();
            }
        }
    });
});

// Soumission du formulaire de modification
$('#modifier').submit(function(e) {
    e.preventDefault();
    $('.error-message').hide();
    var formData = new FormData(this);
    $.ajax({
        url: "{{ route('entre.modifier') }}",
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            $('#modifier')[0].reset();
            $('#modifierModal').modal('hide');
            loadEntree();
            // Afficher le message de confirmation
            $('#confirmation-message').fadeIn().delay(3000).fadeOut();
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, messages) {
                    $('#error-modal-' + key).text(messages[0]).show();
                });
            } else {
                // Afficher une erreur dans le même conteneur
                $('#confirmation-message')
                    .removeClass('alert-success')
                    .addClass('alert-danger')
                    .html('<i class="fas fa-exclamation-circle mr-2"></i> Erreur : ' + xhr.responseJSON.message)
                    .fadeIn().delay(3000).fadeOut();
            }
        }
    });
});

    // Gestion du clic sur le bouton Modifier
    $(document).on('click', '.btn[data-toggle="modal"][data-target="#modifierModal"]', function() {
        var id = $(this).data('id_entree');
        $.ajax({
            url: '/get-entree/' + id,
            type: 'GET',
            success: function(entree_magasin) {
                $('#id_entree-modal').val(entree_magasin.id_entree_magasin);
                $('#encien-fichier').val(entree_magasin.path_bon_livraison || 'Aucun');
                $('#station-modal').val(entree_magasin.numero_station_id).trigger('change');
                $('#navire-modal').val(entree_magasin.navire_id).trigger('change');
                $('#quantite-modal').val(entree_magasin.quantite_palette);
                $('#bl-modal').val(entree_magasin.bon_livraison);
                $('#nom-modal').val(entree_magasin.chauffeur);
                $('#matricule-modal_camion').val(entree_magasin.numero_camion);
                $('#current-file').val(entree_magasin.path_bon_livraison || 'Aucun fichier sélectionné.');
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors de la récupération de l'entrée : ", error);
            }
        });
    });
});
</script>
@endsection