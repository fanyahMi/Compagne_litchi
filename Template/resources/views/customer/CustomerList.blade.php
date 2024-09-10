<style>
    .error-message {
        color: red;
        margin-top: 5px;
    }
</style>
<div class="row mT-30">

    <div class="masonry-item col-md-10  ">
        <div class="bgc-white p-20 bd">
          <h6 class="c-grey-900">Ajout client</h6>
          <div class="mT-30">
            <form action="{{ url('customers') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="mb-12 col-md-6">
                      <label class="form-label" for="inputext">Nom</label>
                      <input type="text" name="name" class="form-control"  id="inputtext"   required>
                        @error('name')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                  </div>

                  <div class="mb-12 col-md-6">
                    <label class="form-label" for="inputext">Prenoms</label>
                    <input type="text" name="first_name" class="form-control"  id="inputtext"   required>
                      @error('first_name')
                          <p class="error-message">{{ $message }}</p>
                      @enderror
                  </div>
                </div>



                <div class="row mT-15" style="margin-bottom: -3%">
                    <div class="mb-5 col-md-6">
                      <label class="form-label" for="inputState">Genre</label>
                      <select id="inputState" class="form-control" name="sex">
                            <option value="F">Femme</option>
                            <option value="H">Homme</option>
                      </select>
                    </div>
                  </div>

                  <div class="row">
                    <div class="mb-12 col-md-6">
                      <label class="form-label" for="inputext">Phone</label>
                      <input type="text" name="phone" class="form-control"  id="inputtext"   required>
                        @error('phone')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                  </div>



              <div class="row">
                <div class="mb-12 col-md-6">
                  <label class="form-label" for="inputext">email</label>
                  <input type="email" name="email" class="form-control"  id="inputtext"   required>
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
              </div>



              <div class="row">
                <div class="mb-12 col-md-6">
                  <label class="form-label" for="inputext">Address</label>
                  <input type="text" name="address" class="form-control"  id="inputtext"   required>
                    @error('address')
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
              <h4 class="c-grey-900 mB-20">Liste des clients</h4>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Numero</th>
                      <th>Nom</th>
                      <th>Prenoms</th>
                      <th>Genre</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Address</th>

                  </tr>
                </thead>
                <tbody>
                      @foreach($customers as $data)
                      <tr>
                          <td>{{ $data->id_customer }}</td>
                          <td>{{ $data->name }}</td>
                          <td>{{ $data->first_name }}</td>
                          <td>{{ $data->sex }}</td>
                          <td>{{ $data->phone }}</td>
                          <td>{{ $data->email }}</td>
                          <td>{{ $data->address }}</td>
                      </tr>
                      @endforeach
                </tbody>
              </table>
            </div>
          </div>

    </div>


</div>
