<!-- resources/views/partial/products_table.blade.php -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>Numéro product</th>
            <th>Nom</th>
            <th>Unite</th>
            <th>Quantite unitaire</th>
            <th>cout de revient</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $data)
        <tr>
            <td>{{ $data->id_product }}</td>
            <td>{{ $data->product }}</td>
            <td>{{ $data->unite }}</td>
            <td>{{ $data->unitary_quantity }}</td>
            <td>{{ $data->cost_price }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $products->links('pagination::bootstrap-4') }}



