@php
    $total = 0;
    $sum = $data->map( function ($item) {
        
        foreach( $item->detalles as $_item) {
            $impuestos = 0;

            foreach( $_item->producto?->impuestos as $impto) {
                if ($impto->impuesto?->tipo_impuesto == "I") {
                    if ($impto->impuesto->tipo_tarifa == "P") {
                        $impuestos +=
                            ($_item->precio_venta ?? 0) *
                                $impto->impuesto->tarifa /
                            100;
                    } else if ($impto->impuesto->tipo_tarifa == "V") {
                        $impuestos += $impto->impuesto->tarifa;
                    }
                }
            }

            $_item->total_impuestos = $impuestos;
        }
        

        return (
            $item->detalles->reduce( function ($sum, $det) {
                return  $sum + ($det->precio_venta * $det->cantidad) +
                    ($det->total_impuestos * $det->cantidad);
                })
        );
    });

    if (count($sum)) {
        $total = $sum->reduce( function($x, $acum) {
            return $x + $acum;
        });
    }
@endphp


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

    .cliente {
        font-size: 12px;
        margin-top: 20px;
    }

    .cliente th {
        text-align: left;
        margin-left: 10px;    
    }

    .footer { font-size: 11px; position: fixed; right: 0px; bottom: 10px; text-align: center;border-top: 1px solid black;}
    .footer .page:after { content: counter(page, decimal); }
    @page { margin: 20px 30px 40px 50px; }

</style>
<body>
    <img src="{{ public_path() . '/img/logo.svg' }}" width="250px" width="250px" />
    
    <table class="cliente"> 
        <tr>
            <th style="width: 200px">Fecha: </th>
            <td style=""> {{ \Carbon\Carbon::today()->format('d/m/Y') }} </td>
        </tr>
        <tr>
            <th style="width: 200px">Total de Ventas a Contado del día: </th>
            <td style=""> $ {{ number_format($total, 0, '.', ',') ?? 0}} </td>
        </tr>
    </table>
</body>