<?php use App\Models\FormatDate; ?>


<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Text</th>
                <th>Varchar</th>
                <th>Integer</th>
                <th>Decimal</th>
                <th>Double</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Timstamps</th>
                <th>Bool</th>
            </tr>
        </thead>
        <tbody id="table-body">
            @foreach($recherches as $data)
                <tr>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->texte_texte }}</td>
                    <td>{{ $data->texte_varchar }}</td>
                    <td style="text-align: right">{{ number_format($data->nombre_entier, 2, '.', ',') }}</td>
                    <td style="text-align: right">{{ number_format($data->nombre_decimal, 2, '.', ',') }}</td>
                    <td style="text-align: right">{{ number_format($data->nombre_double, 2, '.', ',') }}</td>
                    <td>{{ FormatDate::format($data->date_col) }}</td>
                    <td>{{ $data->heure_col }}</td>
                    <td>{{ FormatDate::formatDateTime($data->timestamp_col) }}</td>
                    <td>{{ $data->bool_col ? 'Oui' : 'Non' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if(count($recherches) != 0)
    {{$recherches->links('pagination::bootstrap-4')}}
@endif
</div>
