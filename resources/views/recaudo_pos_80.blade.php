@php
    forEach( $factura->detalles as $_item) {
        $impuestos = 0;

        forEach( $_item->producto?->impuestos as $impto) {
            if ($impto->impuesto?->tipo_impuesto == "I") {
                if ($impto->impuesto->tipo_tarifa == "P") {
                    $impuestos +=
                        (($_item->precio_venta ?? 0) *
                            ($impto->impuesto->tarifa)) /
                        100;
                } else if ($impto->impuesto->tipo_tarifa == "V") {
                    $impuestos += $impto->impuesto->tarifa;
                }
            }
        }

        $_item->total_impuestos = $impuestos;
    }

    $sum = $factura->detalles->reduce( function ($sum, $item) {
            return $sum + ($item->precio_venta * $item->cantidad) + ($item->total_impuestos * $item->cantidad);
        }, 0);

    $saldo = $factura->recaudos->reduce( function ($sum, $item) {
        return $sum + ($item->valor);
    }, 0);

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

    .header {
        font-size: 12px;
    }

    .cliente {
        font-size: 12px;
        margin-top: 20px;
    }

    .cliente th {
        text-align: left;
        margin-left: 10px;    
    }

    .detalle {
        margin-top: 20px;
        font-size: 11px;
    }
    
    .detalle th {
        text-align: left;
        margin-left: 10px;    
    }

    .total {
        margin-top: 20px;
        font-size: 11px;
    }
    .total th {
        text-align: right;
    }

    .mensaje {
        text-align: center;
        font-size: 12px;
    }

    .footer { font-size: 11px; position: fixed; right: 0px; bottom: 10px; text-align: center;border-top: 1px solid black;}
    .footer .page:after { content: counter(page, decimal); }
    @page { margin: 20px 30px 40px 50px; }

</style>
<body>
    <img src="{{ asset('img/logo.svg') }}" width="125px" width="125px" />
    <img src="{{ asset( '../../tenant_' . tenant()->id . '/' . $empresa->logo ) }}" width="125px" width="125px" alt='' />

    <table class="header">
        <tr>
            <th style="width: 120px">Fecha: </th>
            <td style=""> {{ \Carbon\Carbon::parse($factura->created_at)->format('Y-m-d') }} </td>
        </tr>
        <tr>
            <th style="width: 120px">Hora: </th>
            <td style=""> {{ \Carbon\Carbon::parse($factura->created_at)->format('H:i a') }} </td>
        </tr>
        <tr>
            <th style="width: 120px">No. Factura: </th>
            <td style=""> {{ $factura->id }} </td>
        </tr>
    </table>
     
    <table class="cliente">
        <tr>
            <th style="width: 120px">Tipo de Venta: </th>
            <td style="width: 265px"> {{ $factura->forma_pago->tipo }} </td>
        </tr>
        <tr>
            <th style="width: 120px">Dirección: </th>
            <td style="width: 265px"> {{ $factura->cliente->direccion }} </td>
        </tr>
        <tr>
            <th style="width: 120px">Documento: </th>
            <td style=""> {{ $factura->cliente->documento }} </td>
        </tr>
        <tr>
            <th style="width: 120px">Teléfono: </th>
            <td style=""> {{ $factura->cliente->celular }} </td>
        </tr>
        <tr>
            <th style="width: 120px">Nombre: </th>
            <td style=""> {{ $factura->cliente->nombre }} </td>
        </tr>
        <tr>
            <th style="width: 120px">Correo: </th>
            <td style=""> {{ $factura->cliente->correo }} </td>
        </tr>
        <tr>
            <th>Valor Total: </th>
            <td> {{ number_format($sum, 0, ',', '.') }} </td>
        </tr>
        <tr>
            <th>Saldo: </th>
            <td> {{ number_format($sum - $saldo, 0, ',', '.') }} </td>
        </tr>
    </table>

    <table class="detalle"  cellpadding="3" cellspacing="0">
        <tr class="font-12">
            <th style="width: 60px">Código</th>
            <th style="width: 95px">Fecha</th>
            <th style="width: 95px">Valor</th>
        </tr>
        <tr class="font-12">
            <th colspan="3">Descripción</th>
        </tr>
        
        @foreach ($factura->recaudos as $index => $item)
            <tr>
                <td style="width: 60px">{{ $item->id ?? '' }}</td>
                <td style="width: 95px">{{ $item->created_at ?? '' }}</td>
                <td style="width: 95px">{{ number_format($item->valor, 0, ',', '.') }}</td>
            </tr>
            <tr class="font-12">
                <td colspan="3">{{ $item->descripcion ?? '' }}</td>
            </tr>

        @endforeach
        
    </table>

    <table class="total" cellpadding="3" cellspacing="0">
        <tr>
            <th style="width: 115px"> </th>
            <th style="width: 50px"> Total: </th>
            <td style="width: 80px"> {{ number_format($saldo, 0, ',', '.') }} </td>
        </tr>
    </table>

    <div class="mensaje">
        Gracias por confiar en nosotros, <br /> 
        ¡Tu satisfacción es nuestra prioridad!
    </div>

</body>