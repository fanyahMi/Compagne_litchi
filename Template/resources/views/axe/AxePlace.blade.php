<style>
    .error-message {
        color: red;
        margin-top: 5px;
    }
</style>
<div class="row mT-30">

    <div class="row">

        <div class="col-md-4">
            <div class="masonry-item col-md-10  ">
                <div class="bgc-white p-20 bd">
                  <h6 class="c-grey-900">Ajout Lieu Livraison</h6>
                  <div class="mT-30">
                    <form action="{{ url('places') }}" method="post" enctype="multipart/form-data">
                        @csrf
                      <div class="row">
                        <div class="mb-12 col-md-12">
                          <label class="form-label" for="inputext">Lieu</label>
                          <input type="text" name="place" class="form-control"  id="inputtext"   required>
                            @error('lieu')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                      </div>

                      <button type="submit" class="btn btn-primary btn-color mT-15">Valider</button>
                    </form>
                  </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="masonry-item col-md-10  ">
                <div class="bgc-white p-20 bd">
                  <h6 class="c-grey-900">Ajout Axe</h6>
                  <div class="mT-30">
                    <form action="{{ url('axes') }}" method="post" enctype="multipart/form-data">
                        @csrf

                      <div class="row">
                        <div class="mb-12 col-md-12">
                          <label class="form-label" for="inputext">Axe</label>
                          <input type="text" name="desc" class="form-control"  id="inputtext"   required>
                            @error('lieu')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                      </div>

                      <button type="submit" class="btn btn-primary btn-color mT-15">Valider</button>
                    </form>
                  </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="masonry-item col-md-10  ">
                <div class="bgc-white p-20 bd">
                  <h6 class="c-grey-900">Ajout Place par axe</h6>
                  <div class="mT-30">
                    <form action="{{ url('placesAxe') }}" method="post" enctype="multipart/form-data">
                        @csrf
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

                        <div class="row" style="margin-bottom: -3%">
                            <div class="mb-5 col-md-12">
                              <label class="form-label" for="inputState">Lieu</label>
                              <select id="inputState" class="form-control" name="place_id">
                                    @foreach($places as $place)
                                        <option value="{{ $place->id_place }}">{{ $place->place }}  </option>
                                    @endforeach
                              </select>
                            </div>
                          </div>

                      <button type="submit" class="btn btn-primary btn-color mT-15">Valider</button>
                    </form>
                  </div>
                </div>
            </div>
        </div>




    </div>



    <div class="row mT-15">
        <div class="col-md-6">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
              <h4 class="c-grey-900 mB-20">Liste des Axes</h4>
              <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Axe</th>
                      <th>desc</th>
                      <th>Option</th>
                  </tr>
                </thead>
                <tbody>
                      @foreach($axes as $data)
                      <tr>
                          <td>{{ $data->id_axe }}</td>
                          <td>{{ $data->desc }}</td>
                          <td>
                            <a href="{{ url('axes/'.$data->id_axe) }}">
                                <span class="icon-holder">
                                    <i class="c-yellow-500 fas fa-pencil-alt"></i>
                                </span>
                            </a>
                          </td>
                      </tr>
                      @endforeach
                </tbody>
              </table>
            </div>
          </div>


          <div class="col-md-4">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
              <h4 class="c-grey-900 mB-20">Liste des Lieux de livraison</h4>
              <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Place</th>
                  </tr>
                </thead>
                <tbody>
                      @foreach($places as $data)
                      <tr>
                          <td>{{ $data->place }}</td>

                      </tr>
                      @endforeach
                </tbody>
              </table>
            </div>
          </div>

    </div>


</div>
