
@php
                    
    $totalInventario = $inventario;
    $totalNacional = $compraContado['nacional'] + $compraCredito['nacional'] - $gastos['nacional'];
    $totalImportado = $compraContado['importado'] + $compraCredito['importado'] - $gastos['importado'];

    $list = [
        ['Inventario', number_format($inventario ?? 0, 0, '.', ','), ''],
        ['Orden de Compra Contado', '', number_format($compraContado['total'] ?? 0, 0, '.', ',')],
        ['', 'Nacional', number_format($compraContado['nacional'] ?? 0, 0, '.', ',')],
        ['', 'Importado', number_format($compraContado['importado'] ?? 0, 0, '.', ',')],
        [' ', ' ', ' '],
        ['Orden de Compra Crédito', '', number_format($compraCredito['total'] ?? 0, 0, '.', ',')],
        ['', 'Nacional', number_format($compraCredito['nacional'] ?? 0, 0, '.', ',')],
        ['', 'Importado', number_format($compraCredito['importado'] ?? 0, 0, '.', ',')],
        [' ', ' ', ' '],
        ['Recaudos Crédito', '', number_format($recaudos ?? 0, 0, '.', ',')],
        [' ', ' ', ' '],
        ['Gastos', '', number_format($gastos['total'] ?? 0, 0, '.', ',')],
        ['', 'Nacional', number_format($gastos['nacional'] ?? 0, 0, '.', ',')],
        ['', 'Importado', number_format($gastos['importado'] ?? 0, 0, '.', ',')],
        [' ', ' ', ' '],
        ['Total', number_format($totalInventario ?? 0, 0, '.', ','), ''],
        [' ', ' ', ' '],
        ['Caja Nacional', '', number_format($totalNacional ?? 0, 0, '.', ',')],
        [' ', ' ', ' '],
        ['Caja Importado', '', number_format($totalImportado ?? 0, 0, '.', ',')],
    ]
@endphp
<table>
    <thead>
        <tr>
            <th> Concepto </th>
            <th> Inventario </th>
            <th> Orden de Compra </th>
        </tr>
    </thead>
    <tbody>
        @foreach( $list as $item  )
            <tr>
                @foreach( $item as $dato  )
                    <td> {{ $dato }} </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>