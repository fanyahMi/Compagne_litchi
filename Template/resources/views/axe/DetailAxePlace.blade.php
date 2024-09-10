<div class="row mT-30">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
          <h4 class="c-grey-900 mB-20">Detail de l'axe</h4>
          <table class="table table-striped">
            <thead>
              <tr>
                  <th>Axe</th>
                  <th>Place</th>
                  <th>Description</th>
              </tr>
            </thead>
            <tbody>
                  @foreach($detailAxes as $data)
                  <tr>
                      <td>{{ $data->id_axe }}</td>
                      <td>{{ $data->place }}</td>
                      <td>{{ $data->desc }}</td>
                  </tr>
                  @endforeach
            </tbody>
          </table>
        </div>
      </div>

</div>
</div>
