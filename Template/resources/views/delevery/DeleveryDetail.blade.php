<?php
    use App\Models\FormatDate;
    use App\Models\FormatLetter;
?>
<div class="row mT-30">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
          <h4 class="c-grey-900 mB-20">Liste des livraisons le <b>{{  FormatDate::format($date) }}</b>  sur l'axe {{ $axe_id }}</h4>
          <p>
            <form action="{{ url('exportDelevery') }}" method="post">
                @csrf <!-- Ajoute un jeton CSRF pour protéger votre formulaire -->
                <input type="hidden" name="date" value="{{ $date }}">
                <input type="hidden" name="axe_id" value="{{ $axe_id }}">
                <button type="submit" class="btn btn-primary">Export</button>
            </form>
          </p>
          <table class="table table-striped">
            <thead>
              <tr>
                  <th>Vendeur</th>
                  <th>Lieu</th>
                  <th>Client</th>
                  <th>Phone</th>
                  <th>Nombre des packs</th>
                  <th>Montant</th>

              </tr>
            </thead>
            <tbody>
                  @foreach($datas as $data)
                  <tr>
                      <td>{{ $data->seller }}</td>
                      <td>{{ $data->place }}</td>
                      <td>{{ $data->name }}</td>
                      <td>{{ $data->phone }}</td>
                      <td style="text-align: right">{{  number_format($data->number_pack,2,',',' ')  }}</td>
                      <td style="text-align: right">{{ number_format($data->montant, 2, ',', ' ')  }}</td>

                  </tr>
                  @endforeach
            </tbody>
          </table>
        </div>
      </div>
</div>
