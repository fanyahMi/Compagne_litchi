@extends('template.Layout')
@section('titre')
    Liste des agents
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
                        <h5 class="mt-5">Insertion de nouvel agent</h5>
                        <hr><form id="ajout_agentForm" action="{{ url('ajout-agent') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom">
                                    <div class="mb-3">
                                        <div id="error-nom" class="error-message text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="prenom">Prénom</label>
                                    <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prénom">
                                    <!-- Optional error message for 'prenom' -->
                                    <div class="mb-3">
                                        <div id="error-prenom" class="error-message text-danger"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="dateNaissance">Date de naissance</label>
                                    <input type="date" class="form-control" name="dateNaissance" id="dateNaissance">
                                    <div class="mb-3">
                                        <div id="error-dateNaissance" class="error-message text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="cin">CIN</label>
                                    <input type="text" class="form-control" name="cin" id="cin" maxlength="12">
                                    <div class="mb-3">
                                        <div id="error-cin" class="error-message text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="sexe">Sexe</label>
                                    <select id="sexe" name="sexe" class="form-control" required>
                                        <option value="">Sélectionner</option>
                                        @foreach($sexes as $sexe)
                                            <option value="{{ $sexe->id_sexe }}">{{ $sexe->sexe }}</option>
                                        @endforeach
                                    </select>
                                    <!-- Optional error message for 'sexe' -->
                                    <div class="mb-3">
                                        <div id="error-sexe" class="error-message text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="situation">Situation familiale</label>
                                    <select id="situation" name="situation" class="form-control" required>
                                        @foreach($situations as $situation)
                                            <option value="{{ $situation->id_situation_familial }}">{{ $situation->situation_familial }}</option>
                                        @endforeach
                                    </select>
                                    <!-- Optional error message for 'situation' -->
                                    <div class="mb-3">
                                        <div id="error-situation" class="error-message text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="role">Role</label>
                                    <select id="role" name="role" class="form-control" required>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id_role }}">{{ $role->role}}</option>
                                        @endforeach
                                    </select>
                                    <!-- Optional error message for 'role' -->
                                    <div class="mb-3">
                                        <div id="error-role" class="error-message text-danger"></div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Insérer</button>
                        </form>
                        <div id="error-message" class="error-message"></div>
                    </div>

                    <div class="card-body">
                        <div class="mT-30">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="filter-name">Nom</label>
                                    <input type="text" class="form-control" id="filter-name" placeholder="Filtrer par nom">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="filter-sexe">Sexe</label>
                                    <select id="filter-sexe" class="form-control">
                                        <option value="">Sélectionner sexe</option>
                                        @foreach($sexes as $sexe)
                                            <option value="{{ $sexe->id_sexe }}">{{ $sexe->sexe }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="filter-role">Rôle</label>
                                    <select id="filter-role" class="form-control">
                                        <option value="">Sélectionner rôle</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id_role }}">{{ $role->role }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2" style="align-content: flex-end">
                                    <button type="button" class="btn btn-secondary" id="filter-btn">Filtrer</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <h5 class="c-black-900"><b>Liste des réservations</b></h5>
                        <div class="mT-30">
                            <div id="table-responsive">
                                <table id="produitTable" class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Matricule</th>
                                            <th>Nom et prénom</th>
                                            <th>Date de naissance</th>
                                            <th>CIN</th>
                                            <th>Sexe</th>
                                            <th>Situation patrimoniale</th>
                                            <th>Embauché le</th>
                                            <th>Rôle</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body"></tbody>
                                </table>
                            </div>
                            <div id="pagination" class="mt-3 text-center"></div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- [ form-element ] end -->
        </div>
        <!--  Liste   --->

        <!-- [ modal ] start -->
		<div id="modifierModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModificationAgent" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Modification</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form id="modifier_agentForm" action="" method="POST">
                            @csrf
                            <input type="hidden" id="id_utilisateur-modal" name="id_utilisateur">
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input type="text" class="form-control" id="nom-modal" name="nom">
                            </div>
                            <div  class="form-group">
                                <div id="error-modal-nom" class="error-message text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label for="prenom">Prénom</label>
                                <input type="text" class="form-control" id="prenom-modal" name="prenom">
                            </div>
                            <div  class="form-group">
                                <div id="error-modal-prenom" class="error-message text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label for="dateNaissance">Date de naissance</label>
                                <input type="date" class="form-control" id="dateNaissance-modal" name="dateNaissance">
                            </div>
                            <div  class="form-group">
                                <div id="error-modal-dateNaissance class="error-message text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label for="cin">CIN</label>
                                <input type="text" class="form-control" id="cin-modal" name="cin" maxlength="12">
                            </div>
                            <div  class="form-group">
                                <div id="error-modal-cin" class="error-message text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label for="sexe">Sexe</label>
                                <select id="sexe-modal" name="sexe" class="form-control">
                                    <option value="">Sélectionner</option>
                                    @foreach($sexes as $sexe)
                                        <option value="{{ $sexe->id_sexe }}">{{ $sexe->sexe }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div  class="form-group">
                                <div id="error-modal-sexe" class="error-message text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label for="situation">Situation familiale</label>
                                <select id="situation-modal" name="situation" class="form-control">
                                    @foreach($situations as $situation)
                                        <option value="{{ $situation->id_situation_familial }}">{{ $situation->situation_familial }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div  class="form-group">
                                <div id="error-modal-situation" class="error-message text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select id="role-modal" name="role" class="form-control">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id_role }}">{{ $role->role }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div  class="form-group">
                                <div id="error-modal-role" class="error-message text-danger"></div>
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

<script src="assets/js/plugins/jquery-ui.min.js"></script>
<script>
 $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const sexes = @json($sexes);
    const roles = @json($roles);
    const situations = @json($situations);

    const sexeMap = {};
    sexes.forEach(sexe => {
        sexeMap[sexe.id_sexe] = sexe.sexe;
    });

    const roleMap = {};
    roles.forEach(role => {
        roleMap[role.id_role] = role.role;
    });

    const situationMap = {};
    situations.forEach(situation => {
        situationMap[situation.id_situation_familial] = situation.situation_familial;
    });

    function appendAgent(agent) {
        var row = '<tr>' +
                '<td>' + agent.matricule  + '</td>' +
                  '<td>' + agent.nom + ' ' + agent.prenom + '</td>' + // Added space
                  '<td>' + agent.date_naissance + '</td>' +
                  '<td>' + agent.cin + '</td>' +
                  '<td>' + sexeMap[agent.sexe_id]+ '</td>' +
                  '<td>' + situationMap[agent.situation_familial_id] + '</td>' +
                  '<td>' + agent.created_at + '</td>' +
                  '<td>' + roleMap[agent.role_id] + '</td>' +
                  '<td>' +
                    '<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifierModal" data-id_agent="' + agent.id_utilisateur + '">' +
                    '<i class="fas fa-edit"></i></button>' +
                  '</td>' +
                  '<td>' +
                    '<button class="btn btn-danger btn-sm delete-btn" data-id_agent="' + agent.id_utilisateur + '">' +
                    '<i class="fas fa-trash-alt"></i></button>' +
                  '</td>' +
                  '</tr>';
        $('#table-body').append(row);
    }

function appendPagination(data) {
            let pagination = '';

            // Bouton "Précédent"
            if (data.prev_page_url) {
                pagination += '<button class="btn btn-primary mx-1" onclick="loadAgent(' + (data.current_page - 1) + ')">Précédent</button>';
            } else {
                pagination += '<button class="btn btn-secondary mx-1" disabled>Précédent</button>';
            }

            // Numéros de pages
            for (let i = 1; i <= data.last_page; i++) {
                pagination += '<button class="btn ' + (i === data.current_page ? 'btn-dark' : 'btn-light') + ' mx-1" onclick="loadAgent(' + i + ')">' + i + '</button>';
            }

            // Bouton "Suivant"
            if (data.next_page_url) {
                pagination += '<button class="btn btn-primary mx-1" onclick="loadAgent(' + (data.current_page + 1) + ')">Suivant</button>';
            } else {
                pagination += '<button class="btn btn-secondary mx-1" disabled>Suivant</button>';
            }

            $('#pagination').html(pagination);
        }


        function loadAgent(page = 1) {
            const name = $('#filter-name').val(); // Valeur du champ de recherche par nom
            const sexe = $('#filter-sexe').val(); // Valeur du filtre sexe
            const role = $('#filter-role').val(); // Valeur du filtre rôle

            $.ajax({
                url: '/get-agent?page=' + page,
                type: 'GET',
                data: {
                    name: name,
                    sexe: sexe,
                    role: role,
                },
                success: function(data) {
                    // Effacer le tableau et les boutons de pagination
                    $('#table-body').empty();
                    $('#pagination').empty();

                    // Ajouter les agents au tableau
                    data.data.forEach(function(agent) {
                        appendAgent(agent);
                    });

                    // Générer les boutons de pagination
                    appendPagination(data);
                },
                error: function(xhr, status, error) {
                    console.error("Erreur lors du chargement des réservations : ", error);
                }
            });
        }


$(document).ready(function() {

    $('#filter-btn').on('click', function() {
        loadAgent(1);
    });

    loadAgent(1);
    $('#ajout_agentForm').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert('Agent ajouté avec succès !');
                console.log(response);
                $('p.error-message').text('');
                $('#ajout_agentForm')[0].reset();
                loadAgent();
            },
            error: function(xhr) {
                $('p.error-message').text('');
                $('#error-message').text('');
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, messages) {
                        $('#error-' + key).text(messages[0]);
                    });
                }
            }
        });
    });



    $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id_agent');

            if (confirm('Êtes-vous sûr de vouloir supprimer cette agent ?')) {
                $.ajax({
                    url: '/supp-agent/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            alert(response.message);
                            loadAgent();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Erreur lors de la suppression : ", error);
                    }
                });
            }
        });


    $(document).on('click', '.btn[data-toggle="modal"][data-target="#modifierModal"]', function() {
        var id = $(this).data('id_agent');
        $.ajax({
            url: '/get-agent/' + id,
            type: 'GET',
            success: function(agentData) {
                $('#id_utilisateur-modal').val(agentData.id_utilisateur);
                $('#nom-modal').val(agentData.nom);
                $('#prenom-modal').val(agentData.prenom);
                $('#dateNaissance-modal').val(agentData.date_naissance);
                $('#cin-modal').val(agentData.cin);
                $('#sexe-modal').val(agentData.sexe_id).trigger('change');
                $('#situation-modal').val(agentData.situation_familial_id).trigger('change');
                $('#role-modal').val(agentData.role_id).trigger('change');
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors de la récupération de l'agent : ", error);
            }
        });
    });

    $('#saveChangesBtn').on('click', function(e) {
        e.preventDefault();
        var formData = $('#modifier_agentForm').serialize();
        $.ajax({
            url: '/update-agent',
            method: 'PUT',
            data: formData,
            success: function(response) {
                alert('Modifications enregistrées avec succès !');
                $('#modifierModal').modal('hide');
                loadAgent();
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, messages) {
                    $('#error-modal-' + key).text(messages[0]);
                });
            }
        });
    });


    $('#exampleModal').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var recipient = button.data('whatever')
		var modal = $(this)
		modal.find('.modal-title').text('New message to ' + recipient)
		modal.find('.modal-body input').val(recipient)
	})

});

</script>
@endsection
