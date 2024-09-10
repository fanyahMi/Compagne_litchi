<div id="detailModal" class="modal" style="display: none;" tabindex="-1" aria-labelledby="detailModal" aria-hidden="true">
    <form id="editDetailForm" action="{{ url('updateM') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modifier </b> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"  onclick="closeModal()" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <div class="row">
                    <div class="mb-12 col-md-12">
                        <label class="form-label" for="inputext">Type text</label>
                        <input type="text" name="inputText" class="form-control" id="inputText"  placeholder="text"  >
                        <span id="inputText_error" class="error-message"></span>
                    </div>
                </div>

                <!-- Number Field -->
                <div class="row mT-15">
                    <div class="mb-12 col-md-12">
                        <label class="form-label" for="input">Number</label>
                        <input type="number" name="inputNumber" class="form-control" id="inputNumber" placeholder="number"  >
                        <span id="inputNumber_error" class="error-message"></span>
                    </div>
                </div>

                <!-- Date Field -->
                <div class="row mT-15">
                    <div class="mb-12 col-md-12">
                        <label class="form-label" for="input">Date</label>
                        <input type="date" name="inputdate" class="form-control" id="inputdate" placeholder=""  >
                        <span id="inputdate_error" class="error-message"></span>
                    </div>
                </div>

                <!-- Images Field -->
                <div class="row mT-15">
                    <div class="mb-12 col-md-12">
                        <label class="form-label" for="image">Images</label>
                        <input type="file" name="imageM[]" class="form-control" id="imageM" accept="image/*" multiple>
                        <span id="imageM_error" class="error-message"></span>
                    </div>
                </div>

                <!-- CSV File Field -->
                <div class="row mT-15">
                    <div class="mb-12 col-md-12">
                        <label class="form-label" for="csv_file">Fichier CSV</label>
                        <input type="file" name="csv_fileM" class="form-control" id="csv_fileM" accept="text/csv">
                        <span id="csv_fileM_error" class="error-message"></span>
                    </div>
                </div>

                <!-- Excel File Field -->
                <div class="row mT-15">
                    <div class="mb-12 col-md-12">
                        <label class="form-label" for="excel_file">Fichier Excel</label>
                        <input type="file" name="excel_fileM" class="form-control" id="excel_fileM" accept=".xlsx, .xls" >
                        <span id="excel_fileM_error" class="error-message"></span>
                    </div>
                </div>

                <!-- Select Field -->
                <div class="row mT-15">
                    <div class="mb-5 col-md-5">
                        <label class="form-label" for="inputState">Select Option</label>
                        <select id="inputSelect" class="form-control" name="inputSelect" >
                            <option value="0" {{ old('select') == 0 ? 'selected' : '' }}>Choose...</option>
                            @foreach($selectOptions as $option)
                                <option value="{{ $option->id }}" >{{ $option->name }}</option>
                            @endforeach
                        </select>
                        <span id="inputSelect_error" class="error-message"></span>
                    </div>
                </div>

                <!-- Textarea Field -->
                <div class="row mT-5">
                    <div class="mb-12 col-md-12">
                        <label class="form-label" for="textarea">Zone de texte</label>
                        <textarea name="textareaM" class="form-control" id="textareaM" placeholder="Votre texte" ></textarea>
                        <span id="textareaM_error" class="error-message"></span>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  onclick="closeModal()" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
            </div>
        </div>
    </form>
</div>



<script>
 $(document).ready(function(){
    $('.edit-detail').click(function(){
        var id = $(this).data('id');
        $.ajax({
            url: "{{ url('/formUpdate') }}/" + id,
            type: 'GET',
            success: function(response) {
                $('#inputText').val(response.text);
                $('#inputNumber').val(response.number);
                $('#inputdate').val(response.date);
                $('#inputSelect').val(response.select);
                $('#textareaM').val(response.textarea);
                $('#detailModal').show();
            }
        });
    });

    $('#editDetailForm').submit(function(e){
        e.preventDefault(); // Empêche le comportement par défaut du formulaire
        var form = $(this);
        var url = form.attr('action');
        var method = form.attr('method');
        var formData = new FormData(form[0]);
        console.log(url + "   " + method);
        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response){
                $('#detailModal').hide();
                window.location.reload();
            },
            error: function(xhr){
                var jsonResponse = xhr.responseJSON;
                if (jsonResponse && jsonResponse.errors) {
                    $.each(jsonResponse.errors, function (fieldName, errorMessages) {
                        var prefix = fieldName.substring(0, fieldName.indexOf('.'));
                        if(prefix ==="imageM"){
                            var errorElements = $('#imageM').siblings('.error-message');
                            if (errorElements.length > 0) {
                                var errorMessagesString = errorMessages.join(', ');
                                errorElements.text(errorMessagesString);
                            } else {
                                console.error("Erreur: Aucun élément trouvé pour le champ " + fieldName);
                            }
                        }else{
                            var errorElements = $('#' + fieldName).siblings('.error-message');
                            if (errorElements.length > 0) {
                                var errorMessagesString = errorMessages.join(', ');
                                errorElements.text(errorMessagesString);
                            } else {
                                console.error("Erreur: Aucun élément trouvé pour le champ " + fieldName);
                            }
                        }

                    });

                }
            }
        });
    });
});



function closeModal() {
    var modal = document.getElementById('detailModal');
    modal.style.display = 'none';
}

    </script>
