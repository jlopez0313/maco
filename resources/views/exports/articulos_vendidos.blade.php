<table>
    <thead>
        <tr>
            <th> Fecha </th>
            <th> Referencia </th>
            <th> Origen </th>
            <th> Cantidad </th>
            <th> Valor Unitario </th>
            <th> Valor Total </th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $item)
            @foreach($item->detalles as $det)
                <tr>
                    <td> {{ $item->created_at }} </td>
                    <td> {{ $det->producto?->referencia ?? "" }} </td>
                    <td> {{ $det->producto?->inventario?->origenLabel ?? "" }} </td>
                    <td> {{ $det->cantidad ?? 0 }} </td>
                    <td> {{ number_format($det->precio_venta, 0, '.', ',') ?? 0 }} </td>
                    <td> {{ number_format($det->precio_venta * $det->cantidad, 0, '.', ',') ?? 0 }} </td>    
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>