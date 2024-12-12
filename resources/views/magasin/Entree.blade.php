@extends('template.Layout')
@section('titre')
    Entre magasin
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
    .card-header {
        padding: 15px;
        font-size: 18px;
        font-weight: bold;
    }
    .card-body {
        padding: 20px;
    }
    .form-group label {
        font-weight: bold;
    }
    .table th {
        background-color: #007bff;
        color: white;
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                Entrée en Magasin des camion
            </div>
            <div class="card-body">
                <form id="ajout_magasin" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="navire">Navire</label>
                            <select id="navire" name="navire_id" class="form-control" required>
                                <option value="">Sélectionner</option>
                                @foreach($navires as $navire)
                                    <option value="{{ $navire->id_navire }}">{{ $navire->navire }}</option>
                                @endforeach
                            </select>
                            <div id="error-navire" class="error-message">Veuillez sélectionner un navire.</div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="station">Station</label>
                            <select id="station" name="numero_station_id" class="form-control" required>
                                <option value="">Sélectionner</option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id_numero_station }}">{{ $station->station }} / {{ $station->numero_station }}</option>
                                @endforeach
                            </select>
                            <div id="error-station" class="error-message">Veuillez sélectionner une station.</div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="quantite">Quantité de palette</label>
                            <input type="number" class="form-control" name="quantite_palette" id="quantite" min="1" required>
                            <div id="error-quantite" class="error-message" style="display:none;">Veuillez entrer une quantité valide.</div>
                            <div id="reste-info" class="text-success" style="margin-top: 5px;"></div>
                        </div>



                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="bl">Bon de livraison</label>
                            <input type="text" class="form-control" name="bon_livraison" id="bl" required>
                            <div id="error-bon_livraison" class="error-message"></div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="fichier">Fichier</label>
                            <input type="file" class="form-control" name="fichier" id="fichier" accept="application/pdf">
                            <div id="error-fichier" class="error-message">Veuillez sélectionner un fichier.</div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="nom">Nom du chauffeur</label>
                            <input type="text" class="form-control" name="chauffeur" id="nom" required>
                            <div id="error-nom" class="error-message">Veuillez entrer le nom du chauffeur.</div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="matricule_camion">Numero camion</label>
                            <input type="text" class="form-control" name="numero_camion" id="matricule_camion" maxlength="12" required>
                            <div id="error-matricule_camion" class="error-message">Veuillez entrer une matricule valide.</div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Validé</button>
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
                            <label for="filter-bon_livraison">Bon livraison</label>
                            <input type="text" class="form-control"  id="filter-bon_livraison" required>
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
            <!-- [Liste des réservations] -->
            <div class="card-body">
                <h5 class="c-black-900"><b>Liste des entrées</b></h5>
                <div class="mT-30">

                    <div id="table-container">
                        <table id="" class="table table-hover table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th>Bon d'entré</th>
                                    <th>Agent</th>
                                    <th>Campagne</th>
                                    <th>Navire</th>
                                    <th>Chaufeur</th>
                                    <th>Numero de camion</th>
                                    <th>Bon de livraison</th>
                                    <th>Shift</th>
                                    <th>Quantité de palette</th>
                                    <th>Nº station</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="pagination" class="mt-3 text-center"></div>
            </div>
        </div>
    </div>
</div>


<div id="modifierModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModificationEntree" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="modifier"  method="POST">
                    @csrf
                    <input type="hidden" id="id_entree-modal" name="id_entree">
                    <input type="hidden" id="encien-fichier" name="encien">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="station-modal">Station</label>
                            <select id="station-modal" name="numero_station_id" class="form-control" required>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id_numero_station }}">{{ $station->station }} / {{ $station->numero_station }}</option>
                                @endforeach
                            </select>
                            <div id="error-modal-station" class="error-message text-danger"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="navire">Navire</label>
                            <select id="navire-modal" name="navire_id" class="form-control" required>
                                <option value="">Sélectionner</option>
                                @foreach($navires as $navire)
                                    <option value="{{ $navire->id_navire }}">{{ $navire->navire }}</option>
                                @endforeach
                            </select>
                            <div id="error-modal-navire" class="error-message">Veuillez sélectionner un navire.</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="quantite-modal">Quantité de palette</label>
                        <input type="number" class="form-control" name="quantite_palette" id="quantite-modal" min="1" required>
                        <div id="error-modal-quantite" class="error-message">Veuillez entrer une quantité valide.</div>
                    </div>
                    <div class="form-group">
                        <label for="bl-modal">Bon de livraison</label>
                        <input type="text" class="form-control" name="bon_livraison" id="bl-modal" required>
                        <div id="error-modal-bl" class="error-message">Veuillez entrer un bon de livraison valide.</div>
                    </div>
                    <div class="form-group ">
                        <label for="fichier-modal">Fichier</label>
                        <input type="text" class="form-control" id="current-file" readonly>
                        <input type="file" class="form-modal-control" name="fichier" id="fichier-modal" accept="application/pdf" >
                        <div id="error-modal-fichier" class="error-message"></div>
                    </div>
                    <div class="form-group ">
                        <label for="nom-modal">Nom du chauffeur</label>
                        <input type="text" class="form-control" name="chauffeur" id="nom-modal" required>
                        <div id="error-modal-nom" class="error-message"></div>
                    </div>
                    <div class="form-group ">
                        <label for="matricule-modal_camion">Numero camion</label>
                        <input type="text" class="form-control" name="numero_camion" id="matricule-modal_camion" maxlength="12" required>
                        <div id="error-matricule-modal_camion" class="error-message">Veuillez entrer une matricule valide.</div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Insérer</button>
            </div>
        </form>
        </div>
    </div>
</div>


@endsection

@section('script')
<script src="assets/js/plugins/jquery-ui.min.js"></script>
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

    // Utiliser autoTable pour créer le tableau
    doc.autoTable({
        startY: startTableY,
        head: [['Chauffeur', 'Camion', 'Quantité']],
        body: [[chauffeur, numero_camion, quantite_palette]],
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
    const baseDownloadUrl = '{{ url('/telecharger') }}';
    function appendEntree(entree) {
        const row = `
            <tr>
                <td><a href="#" onclick='generatePDF(${JSON.stringify(entree)})'>${entree.id_entree_magasin}</a></td>
                <td>${entree.matricule_entrant}</td>
                <td>${entree.annee}</td>
                <td>${entree.navire}</td>
                <td>${entree.chauffeur}</td>
                <td>${entree.numero_camion}</td>
                <td><a href="${baseDownloadUrl}/${entree.id_entree_magasin}" target="_blank">${entree.bon_livraison}</a></td>
                <td>${entree.description}</td>
                <td>${entree.quantite_palette}</td>
                <td>${entree.numero_station} <small>(${entree.station || 'Station inconnue'})</small></td>
                <td>${entree.date_entrant}</td>
                <td>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifierModal" data-id_entree="${entree.id_entree_magasin}">Modifier</button>
                </td>
            </tr>
        `;
        $('#table-body').append(row);
    }

    function appendPagination(data) {
        let pagination = '';

        // Bouton "Précédent"
        if (data.prev_page_url) {
            pagination += '<button class="btn btn-primary mx-1" onclick="loadEntree(' + (data.current_page - 1) + ')">Précédent</button>';
        } else {
            pagination += '<button class="btn btn-secondary mx-1" disabled>Précédent</button>';
        }

        // Numéros de pages
        for (let i = 1; i <= data.last_page; i++) {
            pagination += '<button class="btn ' + (i === data.current_page ? 'btn-dark' : 'btn-light') + ' mx-1" onclick="loadEntree(' + i + ')">' + i + '</button>';
        }

        // Bouton "Suivant"
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
        const bon_livraison = $('#filtre-bon_livraison').val();
        const camion = $('#filtre-camion').val();
        const debut = $('#debut').val();
        const fin  = $('#fin').val();
        $.ajax({
            url: '/get-entree?page='+page,
            type: 'GET',
            data: {
                    navire:navire,
                    campagne:campagne,
                    station: station,
                    shift:shift,
                    bon_livraison:bon_livraison,
                    camion:camion,
                    debut:debut,
                    fin:fin
                },
            success: function(data) {
                $('#table-body').empty();
                data.data.forEach(function(entree) {
                   appendEntree(entree);
                });
                appendPagination(data);
            },
            error: function(xhr, status, error) {
               console.log(xhr.responseJSON);
            }
        });
    }

$(document).ready(function() {

    $('#filter-btn').on('click', function() {
        loadEntree(1);
    });

    $('#navire, #station').on('change', function () {
        const idNavire = $('#navire').val();
        const idNumeroStation = $('#station').val();

        if (idNavire && idNumeroStation) {
            $.ajax({
                url:  `{{ url('reste-quantite-palette-station') }}/${idNumeroStation}/${idNavire}`,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    const reste = data.reste;
                    $('#quantite').attr('max', reste);
                    $('#quantite').val('');
                    $('#reste-info').text(`Reste de palettes à entrer : ${reste}`);
                    $('#error-quantite').hide();
                },
                error: function (xhr, status, error) {
                    alert('Une erreur s\'est produite lors de la récupération du reste');
                }
            });
        }
    });



    loadEntree(1);

    $('#ajout_magasin').submit(function(e) {
        e.preventDefault();

        $('p.error-message').text('');
        var fileInput = document.getElementById('fichier');
        var file = fileInput.files[0];
        var formData = new FormData($('#ajout_magasin')[0]);

        if (file) {
            var reader = new FileReader();
            reader.onloadend = function() {
                formData.append('fichier_base64', reader.result);
                submitForm(formData);
            };
            reader.readAsDataURL(file);
        } else {
            submitForm(formData); // Envoyer sans fichier
        }
    });

    $('#modifier').submit(function(e) {
        e.preventDefault();
        $('p.error-message').text('');
        var fileInput = document.getElementById('fichier-modal');
        var file = fileInput.files[0];
        var formData = new FormData($('#modifier')[0]);

        if (file) {
            var reader = new FileReader();
            reader.onloadend = function() {
                formData.append('fichier_base64', reader.result);
                submitUpdate(formData);
            };
           reader.readAsDataURL(file);
        } else {
            submitUpdate(formData);

        }
        location.reload();

    });

    function submitForm(formData) {
        $.ajax({
            url: "{{ route('entre.store') }}",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert('Vous avez effectué un entré');
                $('#ajout_magasin')[0].reset();
                $('#reste-info').text(``);
                loadEntree();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, messages) {
                        console.log(messages+ "  "+ key);
                        $('#error-' + key).text(messages[0]).show();
                    });
                }
            }
        });
    }

    function submitUpdate(formData) {
        $.ajax({
            url: "{{ route('entre.modifier') }}",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert('Vous avez effectué un entré');
                $('#modifier')[0].reset();
                loadEntree();
            },
            error: function(xhr) {
                console.log(xhr);
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, messages) {
                        $('#error-modal-' + key).text(messages[0]).show();
                    });
                }
            }
        });
    }


    $(document).on('click', '.btn[data-toggle="modal"][data-target="#modifierModal"]', function() {
        var id = $(this).data('id_entree');
        $.ajax({
            url: '/get-entree/' + id,
            type: 'GET',
            success: function(entree_magasin) {
                console.log(entree_magasin.numero_station_id);
                $('#id_entree-modal').val(entree_magasin.id_entree_magasin);
                if(entree_magasin.path_bon_livraison){
                    $('#encien-fichier').val(entree_magasin.path_bon_livraison);
                }else{
                    $('#encien-fichier').val("Aucun");
                }

                $('#station-modal').val(entree_magasin.numero_station_id).trigger('change');
                $('#navire-modal').val(entree_magasin.navire_id).trigger('change');
                $('#quantite-modal').val(entree_magasin.quantite_palette);
                $('#bl-modal').val(entree_magasin.bon_livraison);
                $('#nom-modal').val(entree_magasin.chauffeur);
                $('#matricule-modal_camion').val(entree_magasin.numero_camion);
                if (entree_magasin.path_bon_livraison) {
                    $('#current-file').val(entree_magasin.path_bon_livraison);
                } else {
                    $('#current-file').val('Aucun fichier sélectionné.');
            }

            },
            error: function(xhr, status, error) {
                console.error("Erreur lors de la récupération de l'entree en magasin : ", error);
            }
        });
    });




});
</script>
@endsection
