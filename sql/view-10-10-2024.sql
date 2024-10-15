create or replace view v_mouvement_camion as
select
   *
from entree_magasin e
left join sortant_magasin s on s.entree_magasin_id = e.id_entree_magasin
;


create or replace view v_mouvement_magasin as
select
    em.id_entree_magasin, em.numero_camion, em.bon_livraison, em.chauffeur, em.quantite_palette, em.date_entrant, em.agent_id as id_ag_entrant, age.matricule as matricule_entrant, age.nom as nom_entrant,
    em.station_id, s.station, em.magasin_id, m.magasin, em.path_bon_livraison, em.navire_id, n.navire,
    sm.id_sortant_magasin, sm.quantite_sortie, sm.date_sortie, sm.agent_id as id_ag_sortant, ag.matricule  as matricule_sortant, ag.nom as nom_sortant
from
entree_magasin em
join station s on s.id_station = em.station_id
join magasin m on m.id_magasin = em.magasin_id
left join sortant_magasin sm on sm.entree_magasin_id = em.id_entree_magasin
join v_utilisateur_global  age on age.id_utilisateur = em.agent_id
left join v_utilisateur_global ag on ag.id_utilisateur = sm.agent_id
join navire n on n.id_navire = em.navire_id;



@section('script')
<script src="assets/js/plugins/jquery-ui.min.js"></script>
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadEntree();

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

    function submitForm(formData) {
        $.ajax({
            url: '/insertion-url',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert('Vous avez effectué un entré');
                $('#ajout_magasin')[0].reset();
                loadEntree();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, messages) {
                        $('#error-' + key).text(messages[0]).show();
                    });
                }
            }
        });
    }

    function loadEntree() {
        $.ajax({
            url: '/get-entree',
            type: 'GET',
            success: function(data) {
                $('#table-body').empty();
                data.forEach(function(entree) {
                    appendEntree(entree);
                });
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors du chargement des entree en magasin : ", error);
            }
        });
    }

    const stations = @json($stations);
    const station = {};

    // Remplir l'objet 'station' avec des clés basées sur l'id_station
    stations.forEach(s => {
        station[s.id_station] = s.station; // Utilisation correcte de 's' pour accéder aux propriétés
    });

    function appendEntree(entree) {
        var row = '<tr>' +
                    '<td>' + entree.numero_camion + '</td>' +
                    '<td>' + entree.bon_livraison + ' (' + entree.path_bon_livraison + ')</td>' +
                    '<td>' + entree.quantite_palette + '</td>' +
                    '<td>' + (station[entree.station_id] || 'Station inconnue') + '</td>' + // Vérifie si la station existe
                    '<td>' +
                        '<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifierModal" data-id_entree="' + entree.id_entree_magasin + '">Modifier</button>' +
                    '</td>' +
                    '</tr>';
        $('#table-body').append(row);
    }

    $(document).on('click', '.btn[data-toggle="modal"][data-target="#modifierModal"]', function() {
        var id = $(this).data('id_entree');
        $.ajax({
            url: '/get-entree/' + id,
            type: 'GET',
            success: function(entree_magasin) {
                $('#id_entree-modal').val(entree_magasin.id_entree_magasin);
                $('#station-modal').val(entree_magasin.station_id).trigger('change');
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


