@php
    $sum = $invoices->map( function ($item) {
        return (
            $item->detalles->reduce(
                function ($carry, $det) {
                    return $carry + ($det['precio_venta'] * $det['cantidad']);
                }, 0
            ) ?? 0
        );
    });
@endphp

<table>
    <thead>
        <tr>
            <th> Código </th>
            <th> Fecha </th>
            <th> Cliente </th>
            <th> Forma de Pago </th>
            <th> Valor Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $idx => $item)
            <tr>
                <td> {{ $item->id }} </td>
                <td> {{ $item->created_at }} </td>
                <td> {{ $item->cliente?->nombre ?? "" }} </td>
                <td> {{ $item->forma_pago->tipo ?? "" }} </td>
                <td> {{ number_format($sum[$idx], 0, '.', ',') ?? 0 }} </td>
            </tr>
        @endforeach
    </tbody>
</table>