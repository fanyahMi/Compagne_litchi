@extends('template.Layout')
@section('titre')
    Liste des navires
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
                        <h5 class="mt-5">Insertion de nouveau navire</h5>
                        <hr><form id="ajout_navireForm" action="{{ url('ajout-navire') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom">
                                    <div class="mb-3">
                                        <div id="error-nom" class="error-message text-danger"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">

                                <div class="form-group col-md-3">
                                    <label for="nb_compartiment">Nombre de compartiment</label>
                                    <input type="number" class="form-control" name="nb_compartiment" id="nb_compartiment" >
                                    <div class="mb-3">
                                        <div id="error-nb_compartiment" class="error-message text-danger"></div>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="quantite_max">Capacite maximal</label>
                                    <input type="number" class="form-control" name="quantite_max" id="quantite_max">
                                    <div class="mb-3">
                                        <div id="error-quantite_max" class="error-message text-danger"></div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="type_navire">Type de navire</label>
                                    <select id="type_navire" name="type_navire" class="form-control" required>
                                        @foreach($type_navire as $type)
                                            <option value="{{ $type->id_type_navire }}">{{ $type->type_navire }}</option>
                                        @endforeach
                                    </select>
                                    <!-- Optional error message for 'type_navire' -->
                                    <div class="mb-3">
                                        <div id="error-type_navire" class="error-message text-danger"></div>
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
                                <div class="form-group mr-3">
                                    <label for="filter-navire" class="mr-2">Nom:</label>
                                    <input type="text" id="filter-navire" class="form-control" >
                                </div>
                                <div class="form-group mr-3">
                                    <label for="filter-type">Type</label>
                                    <select id="filter-type" class="form-control">
                                        <option value="">Sélectionner type</option>
                                        @foreach($type_navire as $type)
                                            <option value="{{ $type->id_type_navire }}">{{ $type->type_navire }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mr-3">
                                    <label for="filter-capacite" class="mr-2">Capacité:</label>
                                    <input type="number" id="filter-capacite" class="form-control" >
                                </div>
                                <div class="form-group mr-3">
                                    <label for="filter-condition" class="mr-2">Condition:</label>
                                    <select id="filter-condition" class="form-control">
                                        <option value="">Sélectionner</option>
                                        <option value="greater" > ≥ </option>
                                        <option value="less" > ≤ </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2" style="align-content: flex-end">
                                    <button type="button" class="btn btn-secondary" id="filter-btn">Filtrer</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <h5 class="c-black-900"><b>Liste des navires</b></h5>
                        <div class="mT-30">
                            <div id="table-container table-responsive">
                                <table id="produitTable" class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Navire</th>
                                            <th>Type</th>
                                            <th>Nombre de compartiment</th>
                                            <th>Capacite</th>
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
                            <input type="hidden" id="id_navire-modal" name="id_navire">
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input type="text" class="form-control" id="nom-modal" name="nom">
                            </div>
                            <div  class="form-group">
                                <div id="error-modal-nom" class="error-message text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label for="nb_compartiment">Nombre de compartiment</label>
                                <input type="number" class="form-control" id="nb_compartiment-modal" name="nb_compartiment">
                            </div>
                            <div  class="form-group">
                                <div id="error-modal-nb_compartiment" class="error-message text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label for="quantite_max">Capacite maximal</label>
                                <input type="number" class="form-control" id="quantite_max-modal" name="quantite_max" maxlength="12">
                            </div>
                            <div  class="form-group">
                                <div id="error-modal-quantite_max" class="error-message text-danger"></div>
                            </div>
                            <div class="form-group">
                                <label for="type_navire">Type de navire</label>
                                <select id="type_navire-modal" name="type_navire" class="form-control">
                                    <option value="">Sélectionner</option>
                                    @foreach($type_navire as $type)
                                        <option value="{{ $type->id_type_navire }}">{{ $type->type_navire }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div  class="form-group">
                                <div id="error-modal-type_navire" class="error-message text-danger"></div>
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

    const type_navire = @json($type_navire);

    const typeMap = {};
    type_navire.forEach(navire => {
        typeMap[navire.id_type_navire] = navire.type_navire; // Corrected this line
    });

    function appendNavire(navire) {
        var row = '<tr>' +
            '<td>' + navire.navire + '</td>' +
            '<td>' + typeMap[navire.type_navire_id] + '</td>' +
            '<td>' + navire.nb_compartiment + '</td>' +
            '<td>' + navire.quantite_max + '</td>' +
            '<td>' +
                    '<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifierModal" data-id_navire="' + navire.id_navire + '">' +
                    '<i class="fas fa-edit"></i></button>' +
            '</td>' +
        '</tr>';
        $('#table-body').append(row);
    }

    function appendPagination(data) {
            let pagination = '';

            // Bouton "Précédent"
            if (data.prev_page_url) {
                pagination += '<button class="btn btn-primary mx-1" onclick="loadNavire(' + (data.current_page - 1) + ')">Précédent</button>';
            } else {
                pagination += '<button class="btn btn-secondary mx-1" disabled>Précédent</button>';
            }

            // Numéros de pages
            for (let i = 1; i <= data.last_page; i++) {
                pagination += '<button class="btn ' + (i === data.current_page ? 'btn-dark' : 'btn-light') + ' mx-1" onclick="loadNavire(' + i + ')">' + i + '</button>';
            }

            // Bouton "Suivant"
            if (data.next_page_url) {
                pagination += '<button class="btn btn-primary mx-1" onclick="loadNavire(' + (data.current_page + 1) + ')">Suivant</button>';
            } else {
                pagination += '<button class="btn btn-secondary mx-1" disabled>Suivant</button>';
            }

            $('#pagination').html(pagination);
        }

        function loadNavire(page=1) {
            const navire = $('#filter-navire').val();
            const type = $('#filter-type').val();
            const capacite = $('#filter-capacite').val();
            const condition = $('#filter-condition').val();
        $.ajax({
            url: '/get-navire?page=' + page,
            type: 'GET',
            data: {
                navire: navire,
                type: type,
                capacite: capacite,
                condition: condition,
            },
            success: function(data) {
                console.log(data);
                $('#table-body').empty();
                $('#pagination').empty();

                data.data.forEach(function(navires) {
                    appendNavire(navires);
                });
                appendPagination(data);
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors du chargement des navires : ", error);
            }
        });
    }



$(document).ready(function() {

    loadNavire();
    $('#ajout_navireForm').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert('Agent ajouté avec succès !');
                console.log(response);
                $('p.error-message').text('');
                $('#ajout_navireForm')[0].reset();
                loadNavire();
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
                            loadNavire();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Erreur lors de la suppression : ", error);
                    }
                });
            }
        });





    $(document).on('click', '.btn[data-toggle="modal"][data-target="#modifierModal"]', function() {
        var id = $(this).data('id_navire');
        $.ajax({
            url: '/get-navire/' + id,
            type: 'GET',
            success: function(navireData) {
                $('#id_navire-modal').val(navireData.id_navire);
                $('#nom-modal').val(navireData.navire);
                $('#nb_compartiment-modal').val(navireData.nb_compartiment);
                $('#quantite_max-modal').val(navireData.quantite_max);
                $('#type_navire-modal').val(navireData.type_navire_id).trigger('change');
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
            url: '/update-navire',
            method: 'PUT',
            data: formData,
            success: function(response) {
                console.log(response);
                alert('Modifications enregistrées avec succès !');
                $('#modifierModal').modal('hide');
                loadNavire();
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, messages) {
                    $('#error-modal-' + key).text(messages[0]);
                });r
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
