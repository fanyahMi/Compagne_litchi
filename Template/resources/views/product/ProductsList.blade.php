<style>
    .error-message {
        color: red;
        margin-top: 5px;
    }
</style>
<div class="row mT-30">

    <div class="masonry-item col-md-10  ">
        <div class="bgc-white p-20 bd">
          <h6 class="c-grey-900">Ajout produits</h6>
          <div class="mT-30">
            <form action="{{ url('createDetailPack') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row mT-15" style="margin-bottom: -3%">
                    <div class="mb-5 col-md-6">
                      <label class="form-label" for="inputState">Produits</label>
                      <select id="inputState" class="form-control" name="unit_id">
                            @foreach($units as $unit)
                                <option value="{{ $unit->id_unit }}">{{ $unit->unite }}  </option>
                            @endforeach
                      </select>
                    </div>
                  </div>
              <div class="row">
                <div class="mb-12 col-md-6">
                  <label class="form-label" for="inputext">Nom</label>
                  <input type="text" name="product" class="form-control"  id="inputtext"   required>
                    @error('product')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
              </div>




              <div class="row mT-15">
                <div class="mb-12 col-md-6">
                  <label class="form-label" for="input">Quantite unitaire</label>
                  <input type="number" name="unitary_quantity" value="1" class="form-control" id="input" placeholder="" required>
                    @error('unitary_quantity')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
              </div>

              <div class="row mT-15">
                <div class="mb-12 col-md-6">
                  <label class="form-label" for="input">Cout de revient</label>
                  <input type="number" name="cost_price" value="1" class="form-control" id="input" placeholder="" required>
                    @error('cost_price')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
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
                <h4 class="c-grey-900 mB-20">Liste des produits</h4>
                <div id="table-container">
                    @include('product.Products_table', ['products' => $products])
                </div>
            </div>
        </div>
    </div>

</div>

<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script>
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                $('#table-container').html(data);
            }
        });
    });

</script>
