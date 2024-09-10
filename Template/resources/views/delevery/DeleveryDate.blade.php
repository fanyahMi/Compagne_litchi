<style>
    .error-message {
        color: red;
        margin-top: 5px;
    }
</style>
<div class="masonry-item col-md-10  ">
    <div class="bgc-white p-20 bd">
      <h6 class="c-grey-900">Demande de liste des livraisons</h6>
      <div class="mT-30">
        <form action="{{ url('deleveryDetail') }}" method="get" enctype="multipart/form-data">
            @csrf


          <div class="row mT-15">
            <div class="mb-12 col-md-6">
              <label class="form-label" for="input">Date</label>
              <input type="date" name="date" class="form-control" id="input" placeholder="number" required>
                @error('date')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
          </div>

          <div class="row mT-3" style="margin-bottom: -3%">
            <div class="mb-5 col-md-12">
              <label class="form-label" for="inputState">Axe</label>
              <select id="inputState" class="form-control" name="axe_id">
                    @foreach($axes as $axe)
                        <option value="{{ $axe->id_axe }}">{{ $axe->id_axe }}  </option>
                    @endforeach
              </select>
            </div>
        </div>


          <button type="submit" class="btn btn-primary btn-color">Valider</button>
        </form>
      </div>
    </div>
  </div>

