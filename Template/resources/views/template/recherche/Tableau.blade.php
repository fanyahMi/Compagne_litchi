<?php use App\Models\FormatDate; ?>


<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Id Département</th>
                <th>Nom Département</th>
                <th>Date d'embauche</th>
                <th>Salaire</th>
                <th>Email</th>
                <th>Numéro de téléphone</th>
                <th>Adresse</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recherches as $data)
                <tr>
                    <td>{{ $data->employee_id }}</td>
                    <td>{{ $data->first_name }}</td>
                    <td>{{ $data->last_name }}</td>
                    <td>{{ $data->department_id }}</td>
                    <td>{{ $data->department_name }}</td>
                    <td> {{ FormatDate::format($data->hire_date) }}</td>
                    <td style="text-align: right">{{ number_format($data->salary, 2, '.', ',')  }}</td>
                    <td>{{ $data->email }}</td>
                    <td>{{ $data->phone_number }}</td>
                    <td>{{ $data->address }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if(count($recherches) != 0)
        {{$recherches->links('pagination::bootstrap-4')}}
    @endif
</div>
