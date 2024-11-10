@extends('template.Layout')

@section('titre')
    Liste des Shifts
@endsection

@section('page')
<style>
    #error-message {
        color: red;
        display: block !important;
        font-size: 14px;
        padding: 5px;
        margin-top: 10px;
    }
</style>

<!-- [ Main Content ] start -->
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="mt-5">Ajouter un nouveau Shift</h5>
                <hr>
                <form id="ajout_shiftForm" action="{{ url('ajout-shift') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" name="description" id="description" placeholder="Description">
                            <div class="mb-3">
                                <div id="error-description" class="error-message text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="debut">Heure de Début</label>
                            <input type="time" class="form-control" name="debut" id="debut">
                            <div class="mb-3">
                                <div id="error-debut" class="error-message text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="fin">Heure de Fin</label>
                            <input type="time" class="form-control" name="fin" id="fin">
                            <div class="mb-3">
                                <div id="error-fin" class="error-message text-danger"></div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
                <div id="error-message" class="error-message"></div>
            </div>
            <div class="card-body">
                <h5 class="c-black-900"><b>Liste des Shifts</b></h5>
                <div class="mT-30">
                    <div id="table-container" class="table-responsive">
                        <table id="shiftTable" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Heure de Début</th>
                                    <th>Heure de Fin</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                <!-- Les shifts seront chargés ici via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- [ modal ] start -->
<!-- Modal de Modification -->
<div class="modal fade" id="modifierModal" tabindex="-1" role="dialog" aria-labelledby="modifierModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="modifier_shiftForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="modifierModalLabel">Modifier Shift</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_shift-modal" name="id_shift">
                    <div class="form-group">
                        <label for="description-modal">Description</label>
                        <input type="text" class="form-control" id="description-modal" name="description" required>
                    </div>
                    <div class="form-group">
                        <label for="debut-modal">Début (HH:MM)</label>
                        <input type="time" class="form-control" id="debut-modal" name="debut" required>
                        <div class="error-message text-danger" id="error-debut-modal"></div>
                    </div>
                    <div class="form-group">
                        <label for="fin-modal">Fin (HH:MM)</label>
                        <input type="time" class="form-control" id="fin-modal" name="fin" required>
                        <div class="error-message text-danger" id="error-fin-modal"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="saveChangesBtn">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- [ modal ] end -->
@endsection

@section('script')
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadShifts();

    $('#ajout_shiftForm').on('submit', function(event) {
        event.preventDefault();

        // Vérifiez le format du champ fin
        var fin = $('#fin').val();
        if (!/^\d{2}:\d{2}$/.test(fin)) {
            $('#error-fin').text('Veuillez entrer l\'heure de fin au format HH:MM (ex: 14:30).');
            return; // Empêche l'envoi du formulaire
        } else {
            $('#error-fin').text(''); // Réinitialise le message d'erreur
        }

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert('Shift ajouté avec succès !');
                $('#ajout_shiftForm')[0].reset();
                loadShifts();
                $('#error-message').text(''); // Reset error message on success
            },
            error: function(xhr) {
                console.log(xhr);
                $('#error-message').text(''); // Clear previous error messages
                if (xhr.status === 422) { // Validation error
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, messages) {
                        $('#error-' + key).text(messages[0]); // Display the first error message for each field
                    });
                } else {
                    $('#error-message').text('Une erreur est survenue.'); // General error message
                }
            }
        });
    });

    function loadShifts() {
        $.ajax({
            url: '/get-shifts',
            type: 'GET',
            success: function(data) {
                $('#table-body').empty();
                $.each(data, function(index, shift) {
                    $('#table-body').append(`
                        <tr>
                            <td>${shift.description}</td>
                            <td>${shift.debut}</td>
                            <td>${shift.fin}</td>
                            <td>
                                <button class="btn btn-warning edit-btn" data-id="${shift.id_shift}">Modifier</button>
                                <button class="btn btn-danger delete-btn" data-id="${shift.id_shift}">Supprimer</button>
                            </td>
                        </tr>
                    `);
                });
            },
            error:function(xhr){
                console.log(xhr);
            }
        });
    }

    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        if (confirm('Êtes-vous sûr de vouloir supprimer ce shift ?')) {
            $.ajax({
                url: '/shift/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert('Shift supprimé avec succès !');
                    loadShifts();
                },
                error: function(xhr) {
                    console.error("Erreur lors de la suppression : ", xhr);
                }
            });
        }
    });

    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '/shift/' + id,
            type: 'GET',
            success: function(data) {
                $('#id_shift-modal').val(data.id_shift);
                $('#description-modal').val(data.description);
                $('#debut-modal').val(data.debut);
                $('#fin-modal').val(data.fin);
                $('#modifierModal').modal('show');
            }
        });
    });

    $('#saveChangesBtn').on('click', function() {
        var id = $('#id_shift-modal').val();
        // Réinitialisez tous les messages d'erreur
        $('.error-message').text('');

        // Vérifiez le format des champs debut et fin
        var debut = $('#debut-modal').val();
        var fin = $('#fin-modal').val();
        var timeFormat = /^\d{2}:\d{2}$/; // Format HH:MM

        if (!timeFormat.test(debut)) {
            $('#error-debut-modal').text('Veuillez entrer l\'heure de début au format HH:MM (ex: 14:30).');
            return; // Empêche l'envoi du formulaire
        }

        if (!timeFormat.test(fin)) {
            $('#error-fin-modal').text('Veuillez entrer l\'heure de fin au format HH:MM (ex: 14:30).');
            return; // Empêche l'envoi du formulaire
        }

        $.ajax({
            url: '/shift/' + id,
            method: 'PUT',
            data: $('#modifier_shiftForm').serialize(),
            success: function(response) {
                alert('Shift mis à jour avec succès !');
                $('#modifierModal').modal('hide');
                loadShifts(); // Rechargez les shifts après la mise à jour
            },
            error: function(xhr) {
                console.log(xhr);
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, messages) {
                        $('#error-' + key + '-modal').text(messages[0]); // Assurez-vous que l'ID des éléments d'erreur correspond
                    });
                } else {
                    $('#error-message').text('Une erreur est survenue.'); // Message d'erreur général
                }
            }
        });
    });
});
</script>
@endsection
