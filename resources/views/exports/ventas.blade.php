<style>
    @font-face {
        font-family: "source_sans_proregular";           
        src: local("Source Sans Pro"), url("fonts/sourcesans/sourcesanspro-regular-webfont.ttf") format("truetype");
        font-weight: normal;
        font-style: normal;
    }

    body {
        font-family: "source_sans_proregular", Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;
    }
   
    .page-break {
        page-break-after: always;
    }

    .reporte {
        font-size: 12px;
        margin-top: 20px;
    }

    .reporte th {
        text-align: left;
        margin-left: 10px;    
    }

    @page { margin: 20px 30px 40px 50px; }

</style>

@php
    $sum = $invoices->map( function ($item) {
        
        foreach( $item->detalles as $_item) {
            $impuestos = 0;

            foreach( $_item->producto?->impuestos as $impto) {
                if ($impto->impuesto?->tipo_impuesto == "I") {

                    if ($impto->impuesto->tipo_tarifa == "P") {

                        $impuestos +=
                        (($_item->precio_venta ?? 0) *
                        $impto->impuesto->tarifa) /
                        100;
                    } else if ($impto->impuesto->tipo_tarifa == "V") {
                        $impuestos += $impto->impuesto->tarifa;
                    }
                }
                
            }
                $_item->total_impuestos = $impuestos;
        }

        return (
            $item->detalles->reduce(
                function ($carry, $det) {
                    return $carry + 
                    ($det['precio_venta'] * $det['cantidad']) +
                    ($det['total_impuestos'] * $det['cantidad']);
                }, 0
            ) ?? 0
        );
    });
@endphp

<table border="1" class="reporte">
    <thead>
        <tr>
            <th style="width: 130px"> Código </th>
            <th style="width: 130px"> Fecha </th>
            <th style="width: 130px"> Cliente </th>
            <th style="width: 130px"> Forma de Pago </th>
            <th style="width: 130px"> Valor Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $idx => $item)
            <tr>
                <td> {{ $item->id }} </td>
                <td> {{ $item->created_at }} </td>
                <td> {{ $item->cliente?->nombre ?? "" }} </td>
                <td> {{ $item->forma_pago?->descripcion ?? "" }} </td>
                <td> {{ number_format($sum[$idx], 0, '.', ',') ?? 0 }} </td>
            </tr>
        @endforeach
    </tbody>
</table>