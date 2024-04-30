@php
    $break = 0;
    
    $sum = $factura->detalles->reduce( function ($sum, $item) {
            return $sum + ($item->precio_venta * $item->cantidad);
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

    .total {
        margin-top: 20px;
        font-size: 11px;
    }
    .total th {
        text-align: right;
    }

    .footer { font-size: 11px; position: fixed; right: 0px; bottom: 10px; text-align: center;border-top: 1px solid black;}
    .footer .page:after { content: counter(page, decimal); }
    @page { margin: 20px 30px 40px 50px; }

</style>
<body>
    <table class="header"> 
        <tr>
            <td style="width: 400px">
                <img src="{{ public_path() . '/img/logo.svg' }}" width="300px" width="300px" />
            </td>
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
        </tr>
    </table>

    <table class="cliente">
        <tr>
            <th style="">Tipo de Venta: </th>
            <td style="width: 265px"> {{ $factura->forma_pago->tipo }} </td>
            <th style="">Dirección: </th>
            <td style="width: 265px"> {{ $factura->cliente->direccion }} </td>
        </tr>
        <tr>
            <th>Documento: </th>
            <td> {{ $factura->cliente->documento }} </td>
            <th>Teléfono: </th>
            <td> {{ $factura->cliente->celular }} </td>
        </tr>
        <tr>
            <th>Nombre: </th>
            <td> {{ $factura->cliente->nombre }} </td>
            <th>Correo: </th>
            <td> {{ $factura->cliente->correo }} </td>
        </tr>
        <tr>
            <th>Valor Total: </th>
            <td> {{ number_format($sum, 0, ',', '.') }} </td>
            <th>Saldo: </th>
            <td> {{ number_format($sum - $saldo, 0, ',', '.') }} </td>
        </tr>
    </table>

    <table border="1" class="detalle"  cellpadding="3" cellspacing="0">
        <tr class="font-12">
            <th style="width: 150px">Código</th>
            <th style="width: 150px">Valor</th>
            <th style="width: 210px">Descripción</th>
            <th style="width: 150px">Fecha</th>
        </tr>
        
        @foreach ($factura->recaudos as $index => $item)
            <tr>
                <td style="width: 150px">{{ $item->id ?? '' }}</td>
                <td style="width: 150px">{{ number_format($item->valor, 0, ',', '.') }}</td>
                <td style="width: 210px">{{ $item->descripcion ?? '' }}</td>
                <td style="width: 150px">{{ $item->created_at ?? '' }}</td>
            </tr>
            
            @if( $index == 25 || $break == 50 )
                </table>
                    <div class="page-break"></div>
                <table border="1" class="detalle"  cellpadding="3" cellspacing="0">
                @php
                    $break = 0;
                @endphp
            @endif
            
            @php
                $break ++;
            @endphp

        @endforeach
        <tr>
            <th style="width: 150px"> Total: </th>
            <td colspan="3"> {{ number_format($saldo, 0, ',', '.') }} </td>
        </tr>
    </table>

    <div class="footer">
        <p class="page">Pág. </p>
    </div> 

</body>