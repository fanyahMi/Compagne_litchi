<style>
    .error-message {
        color: red;
        margin-top: 5px;
    }
</style>

<div class="row mT-30">

    <div class="masonry-item col-md-10  ">
        <div class="bgc-white p-20 bd">
          <h6 class="c-grey-900">Ajout produits au pack {{$pack}}</h6>
          <div class="mT-30">
            <form id="addDetailForm" action="{{ url('createDetailPack') }}" method="post" enctype="multipart/form-data">
                @csrf
              <div class="row mT-15" style="margin-bottom: -3%">
                <div class="mb-5 col-md-6">
                  <label class="form-label" for="inputState">Produits</label>
                  <select id="inputState" class="form-control" name="product_id">
                        @foreach($products as $product)
                            <option value="{{ $product->id_product }}">{{ $product->product}}  </option>
                        @endforeach
                  </select>
                    @error('product_id')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
              </div>

              <div class="row mT-15">
                <div class="mb-12 col-md-6">
                  <label class="form-label" for="input">Quantite de produit</label>
                  <input type="number" name="quantity_product" value="1" class="form-control" id="input" placeholder="" required>
                  <input type="hidden" name="pack_id" value="{{$pack}}" class="form-control" id="input" placeholder="" required>
                     <!-- Placeholder pour les messages d'erreur -->
                </div>
              </div>

              <button type="submit" class="btn btn-primary btn-color mT-15">Valider</button>
            </form>
          </div>
        </div>
      </div>

    <div class="row mT-15">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
              <h4 class="c-grey-900 mB-20">Detail du pack {{$pack}}</h4>
              <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Produit</th>
                      <th>Quantite</th>
                      <th>Option</th>
                  </tr>
                </thead>
                <tbody>
                      @foreach($details as $data)
                      <tr>
                          <td>{{ $data->product }}</td>
                          <td>{{ $data->quantity_product }}</td>
                          <td>
                            <a href="#" class="pR-20 edit-detail" data-id="{{$data->id_detail_pack}}">
                                <span class="icon-holder">
                                    <i class="fas fa-edit"></i>
                                </span>
                            </a>

                            <form id="delete-form-{{$data->id_detail_pack}}" action="{{ url('/deletePackDetail/' . $data->id_detail_pack) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>

                            <a href="#" onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer cet élément?')) { document.getElementById('delete-form-{{$data->id_detail_pack}}').submit(); }">
                                <span class="icon-holder">
                                    <i class="fas fa-trash-alt"></i>
                                </span>
                            </a>

                        </td>
                      </tr>
                      @endforeach
                </tbody>
              </table>
            </div>
          </div>

    </div>

</div>

<div id="detailModal" class="modal" style="display: none;" tabindex="-1" aria-labelledby="detailModal" aria-hidden="true">
    <form id="editDetailForm" action="{{ url('updateDetailPack') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modifier le  detail du pack</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"  onclick="closeModal()" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <div class="row mT-15" style="margin-bottom: -3%">
                    <div class="mb-5 col-md-12">
                        <label class="form-label" for="inputState">Produits</label>
                        <select id="inputState" class="form-control" name="product_id">
                            @foreach($products as $product)
                                <option value="{{ $product->id_product }}">{{ $product->product}}</option>
                            @endforeach
                        </select>
                        <span id="product_id_error" class="error-message"></span> <!-- Placeholder pour les messages d'erreur -->
                    </div>
                </div>
                <div class="row mT-15">
                    <div class="mb-12 col-md-12">
                        <label class="form-label" for="input">Quantite de produit</label>
                        <input type="number" id="quantity_product" name="quantity_product" value="" class="form-control" id="quantity_product" placeholder="" required>
                        <input type="hidden" id="id_detail_pack" name="id_detail_pack" value="bjn" class="form-control" >
                        <span id="id_detail_pack_error" class="error-message"></span> <!-- Placeholder pour les messages d'erreur -->
                        <span id="quantity_product_error" class="error-message"></span> <!-- Placeholder pour les messages d'erreur -->
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('.edit-detail').click(function(){
        var id = $(this).data('id');
        $.ajax({
           url: "{{ url('/getDetailPack') }}/" + id,
            type: 'GET',
            success: function(response) {
                console.log(response);
                $('#quantity_product').val(response.quantity_product);
                $('#pack_id').val(response.pack_id);
                console.log(response.id_detail_pack);
                $('#id_detail_pack').val(response.id_detail_pack);
                var productId = response.product_id;
                $('#inputState option').each(function() {
                    if ($(this).val() == productId) {
                        $(this).prop('selected', true);
                    } else {
                        $(this).prop('selected', false);
                    }
                });
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
        console.log(url+"   "+method);
        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response){
                $('#detailModal').hide();
                // Mettre à jour l'interface utilisateur ou afficher un message de succès
            },
            error: function(xhr){
                // Accéder à la réponse JSON
                var jsonResponse = xhr.responseJSON;
                // Vérifier si la réponse contient des erreurs
                if(jsonResponse && jsonResponse.errors) {
                    // Parcourir les erreurs
                    $.each(jsonResponse.errors, function(key, values){
                        // Trouver l'élément correspondant au champ dans le modal
                        var errorMessageElement = $('#' + key + '_error');
                        if(errorMessageElement.length > 0) { // Vérifie si l'élément existe
                            // Convertir les valeurs d'erreur en chaîne de caractères
                            var errorMessages = values.map(function(error) { return error; }).join(', ');
                            errorMessageElement.text(errorMessages); // Affiche le message d'erreur
                        } else {
                            console.error("Erreur: L'élément pour le champ " + key + " n'existe pas.");
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
