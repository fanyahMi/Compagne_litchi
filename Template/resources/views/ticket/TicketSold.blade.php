<div class="row mT-30">
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
              <h4 class="c-grey-900 mB-20">Liste des billets vendu</h4>
              <p>Par etudiant</p>
              <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Numéro etudiant</th>
                      <th>Nom</th>
                      <th>Nom du pack</th>
                      <th>Prix</th>
                      <th>Nombre</th>

                  </tr>
                </thead>
                <tbody>
                      @foreach($datas as $data)
                      <tr>
                          <td>{{ $data->id_user }}</td>
                          <td>{{ $data->user_name }}</td>
                          <td>{{ $data->pack_name }}</td>
                          <td>{{ $data->price }}</td>
                          <td>{{ $data->number }}</td>

                      </tr>
                      @endforeach
                </tbody>
              </table>
              </div>
          </div>
    </div>


    <div class="row mT-15">

        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
              <h4 class="c-grey-900 mB-20">Prix des materiel </h4>
              <p>Par etudiant</p>
              <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Numéro etudiant</th>
                      <th>Pack</th>
                      <th>Nom du pack</th>
                      <th>Nombre de billet</th>
                      <th>Prix materiel(Pack)</th>
                      <th>Prix materiel</th>

                  </tr>
                </thead>
                <tbody>
                      @foreach($priceMaterials as $data)
                      <tr>
                          <td>{{ $data->id_user }}</td>
                          <td>{{ $data->id_pack }}</td>
                          <td>{{ $data->pack }}</td>
                          <td>{{ $data->number_tickets }}</td>
                          <td>{{ $data->total_material_pack }}</td>
                          <td>{{ $data->total_price_material }}</td>

                      </tr>
                      @endforeach
                </tbody>
              </table>
            </div>
          </div>

    </div>


    <div class="row mT-15">

        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
              <h4 class="c-grey-900 mB-20">Montant reçus  et le reste à payer par pack en <b>Ariary</b></h4>
              <p>Par etudiant</p>
              <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Numéro etudiant</th>
                      <th>Pack</th>
                      <th>Nom du pack</th>
                      <th>Prix du pack</th>
                      <th>Montant total</th>
                      <th>Montant reçu</th>
                      <th>Montant à payer</th>

                  </tr>
                </thead>
                <tbody>
                      @foreach($total_amounts as $data)
                      <tr>
                          <td>{{ $data->id_user }}</td>
                          <td>{{ $data->id_pack }}</td>
                          <td>{{ $data->pack_name }}</td>
                          <td>{{ $data->price }}</td>
                          <td>{{ $data->total_amount }}</td>
                          <td>{{ $data->total_amount_received }}</td>
                          <td>{{ $data->total_amount_remaining }}</td>
                      </tr>
                      @endforeach
                </tbody>
              </table>
            </div>
          </div>

    </div>

    <div class="row mT-15">



</div>
