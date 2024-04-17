<table>
    <thead>
        <tr>
            <th> Código </th>
            <th> Fecha </th>
            <th> Cliente </th>
            <th> Origen </th>
            <th> Valor </th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $idx => $item)
            <tr>
                <td> {{ $item->id }} </td>
                <td> {{ $item->created_at }} </td>
                <td> {{ $item->cliente?->nombre ?? "" }} </td>
                <td> {{ $item->origen_label ?? "" }} </td>
                <td> {{ number_format($item->valor, 0, '.', ',') ?? 0 }} </td>
            </tr>
        @endforeach
    </tbody>
</table>