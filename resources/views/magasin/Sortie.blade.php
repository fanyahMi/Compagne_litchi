@extends('template.Layout')
@section('titre')
    Sortie de Magasin
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
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Sortie camion dans le magasin</h4>
            </div>
            <div class="card-body">
                <form id="sortie_magasin_form" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="entree_magasin_id">Camion</label>
                            <select id="entree_magasin_id" name="entree_magasin_id" class="form-control" required>
                                <option value="">Sélectionner un camion</option>
                                @foreach($camions as $camion)
                                    <option value="{{ $camion->id_entree_magasin }}">{{ $camion->numero_camion }}</option>
                                @endforeach
                            </select>
                            <div id="error-entree_magasin_id" class="error-message">Veuillez sélectionner un camion.</div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="quantite_sortie">Quantité de Sortie</label>
                            <input type="number" class="form-control" name="quantite_sortie" id="quantite_sortie" min="1" required>
                            <div id="error-quantite_sortie" class="error-message">Veuillez entrer une quantité valide.</div>
                        </div>
                    </div>

                    <b id="quantite-affiche">Quantité Entrant : <span id="quantite-valeur"></span></b><br>

                    <button type="submit" class="btn btn-primary">Enregistrer la Sortie</button>
                </form>
            </div>


            <div class="card-body">
                <div class="mT-30">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="filter-navire">Navire</label>
                            <select id="filter-navire" class="form-control">
                                <option value="">Sélectionner </option>
                                @foreach($normal_navires as $navire)
                                    <option value="{{ $navire->id_navire }}">{{ $navire->navire }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filtre-station">Station</label>
                            <select id="filtre-station" class="form-control">
                                <option value="">Sélectionner</option>
                                @foreach( $normal_stations as $station)
                                    <option value="{{ $station->id_station }}">{{ $station->station }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filter-annee">Annee</label>
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
                            <label for="filter-camion">Numero Camion</label>
                            <input type="text" class="form-control"  id="filter-camion" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="debut">Date debut</label>
                            <input type="date" class="form-control"  id="debut" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="fin">Date fin</label>
                            <input type="date" class="form-control"  id="fin" required>
                        </div>
                        <div class="form-group col-md-2" style="align-content: flex-end">
                            <button type="button" class="btn btn-secondary" id="filter-btn">Filtrer</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="mT-30">
                    <div id=" table-responsive">
                        <table id="" class="table table-hover table-bordered ">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Campagne</th>
                                    <th>Navire</th>
                                    <th>Chaufeur</th>
                                    <th>Numero de camion</th>
                                    <th>Date Sortie</th>
                                    <th>Shift</th>
                                    <th>Nº station</th>
                                    <th>Quantité sortant</th>
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

@endsection

@section('script')
<script src="assets/js/jsPdf.js"></script>
<script src="assets/js/auto-table.js"></script>
<script>

const { jsPDF } = window.jspdf;
    // Fonction pour générer le PDF avec jsPDF
    function generatePDF(entree) {
    const {
        id_entree_magasin,
        id_sortant_magasin,
        matricule_sortant,
        annee,
        navire,
        chauffeur,
        numero_camion,
        bon_livraison,
        quantite_sortie,
        numero_station,
        station,
        date_sortie
    } = entree;

    const doc = new jsPDF();

    // Ajout du Logo (image encodée en base64)
    const logoUrl = 'assets/images/SMMC-Logo.png';
    const img = new Image();
    img.src = logoUrl;
    doc.addImage(img, 'PNG', 10, 10, 100, 20);

    // En-tête
    doc.setFontSize(12);
    doc.setFont('Helvetica', 'B');
    doc.text("SMMC", 130, 20);
    doc.setFontSize(10);
    doc.text("TAMATAVE", 130, 28);
    doc.text("Téléphone : 034 90 133 58", 130, 35);
    doc.text("Email : alpha.house@gmail.com", 130, 42);

    // Dessiner une ligne sous l'en-tête
    doc.setLineWidth(0.5);
    doc.line(10, 50, 200, 50);

    // Informations principales de l'entrée
    doc.setFontSize(10);
    const detailsStartY = 60;
    const lineSpacing = 7; // Espacement entre les lignes

    doc.text(`Bon de sortie : ${id_sortant_magasin}`, 10, detailsStartY);
    doc.text(`Bon d'entré : ${id_entree_magasin}`, 10, detailsStartY + lineSpacing);
    doc.text(`Campagne : ${annee}`, 10, detailsStartY + 2 * lineSpacing);
    doc.text(`Date : ${date_sortie}`, 10, detailsStartY + 3 * lineSpacing);
    doc.text(`Navire : ${navire}`, 10, detailsStartY + 4 * lineSpacing);
    doc.text(`Numéro station : ${numero_station} - ${station}`, 10, detailsStartY + 5 * lineSpacing);
    doc.text(`Agent : ${matricule_sortant}`, 10, detailsStartY + 6 * lineSpacing);

    // Tableau des données
    const startTableY = detailsStartY + 8 * lineSpacing;
    doc.setFontSize(10);

    doc.text("Détails des entrées", 10, startTableY - 5);

    // Utiliser autoTable pour créer le tableau
    doc.autoTable({
        startY: startTableY,
        head: [['Chauffeur', 'Camion', 'Quantité']],
        body: [[chauffeur, numero_camion, quantite_sortie]],
        styles: {
            fontSize: 10,
            halign: 'center',
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

    function appendSortie(sortie) {
    var row = `
        <tr>
            <td><a href="#" onclick='generatePDF(${JSON.stringify(sortie)})'>${sortie.id_sortant_magasin}</a></td>
            <td>${sortie.annee}</td>
            <td>${sortie.navire}</td>
            <td>${sortie.chauffeur}</td>
            <td>${sortie.numero_camion}</td>
            <td>${sortie.date_sortie}</td>
            <td>${sortie.description_sortie}</td>
            <td>${sortie.numero_station}<small> (${sortie.station || 'Station inconnue'})</small></td>
            <td>${sortie.quantite_sortie}</td>
        </tr>`;

    $('#table-body').append(row);
}


    function appendPagination(data) {
        let pagination = '';

        // Bouton "Précédent"
        if (data.prev_page_url) {
            pagination += '<button class="btn btn-primary mx-1" onclick="loadSortie(' + (data.current_page - 1) + ')">Précédent</button>';
        } else {
            pagination += '<button class="btn btn-secondary mx-1" disabled>Précédent</button>';
        }

        // Numéros de pages
        for (let i = 1; i <= data.last_page; i++) {
            pagination += '<button class="btn ' + (i === data.current_page ? 'btn-dark' : 'btn-light') + ' mx-1" onclick="loadSortie(' + i + ')">' + i + '</button>';
        }

        // Bouton "Suivant"
        if (data.next_page_url) {
            pagination += '<button class="btn btn-primary mx-1" onclick="loadSortie(' + (data.current_page + 1) + ')">Suivant</button>';
        } else {
            pagination += '<button class="btn btn-secondary mx-1" disabled>Suivant</button>';
        }

        $('#pagination').html(pagination);
    }

    function loadSortie(page = 1) {
        const navire = $('#filter-navire').val();
        const campagne = $('#filter-annee').val();
        const station = $('#filtre-station').val();
        const shift = $('#filter-shift').val();
        const camion = $('#filtre-camion').val();
        const debut = $('#debut').val();
        const fin  = $('#fin').val();
        $.ajax({
            url: '/get-sortie?page='+page,
            type: 'GET',
            data: {
                    navire:navire,
                    campagne:campagne,
                    station: station,
                    shift:shift,
                    camion:camion,
                    debut:debut,
                    fin:fin
                },
            success: function(data) {
                $('#table-body').empty();
                data.data.forEach(function(sortie) {
                    appendSortie(sortie);
                });
                appendPagination(data);
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors du chargement des sortant du magasin : ", error);
            }
        });
    }
$(document).ready(function() {

    $('#filter-btn').on('click', function() {
        loadSortie(1);
    });
    loadSortie(1);

    $('#entree_magasin_id').change(function() {
        var idEntreMagasin = $(this).val();
        if (idEntreMagasin) {
            $.ajax({
                url: "/quantite-entree/" + idEntreMagasin,
                method: 'GET',
                success: function(data) {
                    $('#quantite-valeur').text(data ? data.quantite_palette : 'Aucune quantité disponible');
                },
                error: function(xhr) {
                    $('#quantite-valeur').text('Erreur de récupération de la quantité');
                }
            });
        } else {
            $('#quantite-valeur').text('');
        }
    });

    $('#sortie_magasin_form').submit(function(e) {
        e.preventDefault();
        $('.error-message').hide();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('sortie.store') }}",
            method: 'POST',
            data: formData,
            success: function(response) {
                $('#sortie_magasin_form')[0].reset();
                $('#quantite-valeur').text('');
                loadSortie();
            },
            error: function(xhr) {
                console.log(xhr);
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, messages) {
                        $('#error-' + key).text(messages[0]).show();
                    });
                } else {
                    alert('Erreur : ' + xhr.responseJSON.message);
                }
            }
        });
    });




});
</script>
@endsection
