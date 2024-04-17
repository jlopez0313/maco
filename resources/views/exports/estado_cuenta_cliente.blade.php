@php
    $valor = $invoices->map( function ($item) {
            return (
                $item->detalles->reduce (
                    function ($carry, $det) {
                        return $carry + ( $det->precio_venta * $det->cantidad ) ;
                    }, 0
                ) ?? 0
            );
        });
        
    $cobros = $invoices->map( function ($item) {
            return (
                $item->recaudos->reduce( 
                    function ($carry, $det) {
                        return $carry + $det->valor ;
                    }, 0
                ) ?? 0
            );
        });
@endphp

<table>
    <thead>
        <tr>
            <th> Fecha </th>
            <th> Cliente </th>
            <th> Valor Total </th>
            <th> Saldo </th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $idx => $item)
            <tr>
                <td> {{ $item->created_at }} </td>
                <td> {{ $item->cliente?->nombre ?? "" }} </td>
                <td> {{ number_format($valor[$idx], 0, '.', ',') ?? 0 }} </td>
                <td> {{ number_format( ($valor[$idx] ?? 0) - ($cobros[$idx] ?? 0), 0, '.', ',') ?? 0 }} </td>
            </tr>
        @endforeach 
    </tbody>
</table>