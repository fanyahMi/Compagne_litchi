<style>
    .error-message {
        color: red;
        margin-top: 5px;
    }
</style>
<div class="masonry-item col-md-10  ">
    @if(Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    @endif
    <div class="bgc-white p-20 bd">
      <h6 class="c-grey-900">Vente des billets</h6>
      <div class="mT-30">
        <form action="{{ url('importVente') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row mT-15">
                <div class="mb-12 col-md-6">
                    <label class="form-label" for="csv_file">Fichier CSV</label>
                    <input type="file" name="csv_file" class="form-control" id="csv_file" accept="text/csv">
                    @error('csv_file')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-6 mT-15">
                    <button type="submit" class="btn btn-primary btn-color mT-15">Importé</button>
                </div>

            </div>
        </form>
      </div>
      <hr>
      <div class="mT-30">
        <form action="{{ url('createTicket') }}" method="post" enctype="multipart/form-data">
            @csrf
          <div class="row">
            <div class="mb-12 col-md-6">
              <label class="form-label" for="inputext">Numero d' etudiant</label>
              <input type="text" name="student" class="form-control"  id="inputtext"  value="{{session('id_user')}}" required>
                @error('student')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
          </div>


          <div class="row mT-15" style="margin-bottom: -3%">
            <div class="mb-5 col-md-6">
              <label class="form-label" for="inputState">Pack</label>
              <select id="inputState" class="form-control" name="pack_id">
                    @foreach($packs as $pack)
                        <option value="{{ $pack->id_pack }}">{{ $pack->name }}  {{ number_format($pack->price, 2, ',', ' ') }} AR</option>
                    @endforeach
              </select>
            </div>
          </div>

          <div class="row mT-3" style="margin-bottom: -3%">
            <div class="mb-5 col-md-12">
              <label class="form-label" for="inputState">Places</label>
              <select id="inputState" class="form-control" name="place_id">
                    @foreach($places as $place)
                        <option value="{{ $place->id_place }}">{{ $place->place }}  </option>
                    @endforeach
              </select>
            </div>
        </div>

          <div class="row mT-15">
            <div class="mb-12 col-md-6">
              <label class="form-label" for="input">Nombre</label>
              <input type="number" name="number" value="1" class="form-control" id="input" placeholder="number" required>
                @error('number')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
          </div>

          <button type="submit" class="btn btn-primary btn-color mT-15">Valider</button>
        </form>
      </div>
    </div>
  </div>

