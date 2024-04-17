@php
    $sum = 0;
    $break = 0;
    $total = 0;
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
    </table>

    <table border="1" class="detalle">
        <tr class="font-12">
            <th style="width: 170px">Artículo</th>
            <th style="width: 140px">Referencia</th>
            <th style="width: 80px">Color</th>
            <th style="width: 60px">Medida</th>
            <th style="width: 55px">Cantidad</th>
            <th style="width: 80px">Precio Venta</th>
            <th style="width: 80px">Total</th>
        </tr>
        
        @foreach ($factura->detalles as $index => $item)
            <tr>
                <td style="width: 170px">{{ $item->producto->inventario->articulo ?? '' }}</td>
                <td style="width: 140px">{{ $item->producto->referencia ?? '' }}</td>
                <td style="width: 80px">{{ $item->producto->color->color ?? '' }}</td>
                <td style="width: 60px">{{ $item->producto->medida->medida ?? '' }}</td>
                <td style="width: 55px">{{ $item->cantidad }}</td>
                <td style="width: 80px">{{ number_format($item->precio_venta, 0, ',', '.') }}</td>
                <td style="width: 80px">{{ number_format($item->precio_venta * $item->cantidad, 0, ',', '.') }}</td>
            </tr>
            
            @if( $index == 25 || $break == 50 )
                </table>
                    <div class="page-break"></div>
                <table border="1" class="detalle">
                @php
                    $break = 0;
                @endphp
            @endif
            
            @php
                $break ++;
                $total += ( $item->precio_venta * $item->cantidad )
            @endphp

        @endforeach
    </table>

    <table border="1" class="total">
        <tr>
            <th style="width: 615px"> Total: </th>
            <td style="width: 80px"> {{ number_format($total, 0, ',', '.') }} </td>
        </tr>
    </table>

    <div class="footer">
        <p class="page">Pág. </p>
    </div> 

</body>