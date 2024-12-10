@php
    $sum = 0;
    $break = 0;
    $total = 0;
    $impuestos = 0;
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
                    <td style=""> {{ \Carbon\Carbon::parse($gasto->created_at)->format('Y-m-d') }} </td>
                </tr>
                <tr>
                    <th style="width: 120px">Hora: </th>
                    <td style=""> {{ \Carbon\Carbon::parse($gasto->created_at)->format('H:i a') }} </td>
                </tr>
                <tr>
                    <th style="width: 120px">No. Factura: </th>
                    <td style=""> {{ $gasto->id }} </td>
                </tr>
            </table>
        </tr>
    </table>

    <table class="cliente">
        <tr>
            <th style="">Tipo de Venta: </th>
            <td style="width: 265px"> {{ $gasto->forma_pago->descripcion }} </td>
            <th style="">Dirección: </th>
            <td style="width: 265px"> {{ $gasto->proveedor->direccion }} </td>
        </tr>
        <tr>
            <th>Documento: </th>
            <td> {{ $gasto->proveedor->documento }} </td>
            <th>Teléfono: </th>
            <td> {{ $gasto->proveedor->celular }} </td>
        </tr>
        <tr>
            <th>Nombre: </th>
            <td> {{ $gasto->proveedor->nombre }} </td>
            <th>Correo: </th>
            <td> {{ $gasto->proveedor->correo }} </td>
        </tr>
    </table>

    <table border="1" class="detalle" cellpadding="3" cellspacing="0">
        <tr class="font-12">
            <th style="width: 140px">Artículo</th>
            <th style="width: 140px">Referencia</th>
            <th style="width: 60px">Color</th>
            <th style="width: 60px">Medida</th>
            <th style="width: 50px">Cantidad</th>
            <th style="width: 60px">Valor Unitario</th>
            <th style="width: 60px">Impuestos Unit.</th>
            <th style="width: 60px">Total</th>
        </tr>
        
        @foreach ($gasto->detalles as $index => $item)
            <tr>
                <td style="width: 140px">{{ $item->producto->inventario->articulo ?? '' }}</td>
                <td style="width: 140px">{{ $item->producto->referencia ?? '' }}</td>
                <td style="width: 60px">{{ $item->producto->color->color ?? '' }}</td>
                <td style="width: 60px">{{ $item->producto->medida->medida ?? '' }}</td>
                <td style="width: 50px">{{ $item->cantidad }}</td>
                <td style="width: 60px">{{ number_format($item->precio_venta, 0, ',', '.') }}</td>
                <td style="width: 60px">{{ number_format( getImpuestos( $item ) , 0, ',', '.') }}</td>
                <td style="width: 60px">{{ number_format($item->precio_venta * $item->cantidad, 0, ',', '.') }}</td>
            </tr>
            
            @if( $index == 25 || $break == 50 )
                </table>
                    <div class="page-break"></div>
                <table border="1" class="detalle" cellpadding="3"  cellspacing="0">
                @php
                    $break = 0;
                @endphp
            @endif
            
            @php
                $break ++;
                $total += ( $item->precio_venta * $item->cantidad );
                $impuestos += ( getImpuestos( $item )  * $item->cantidad );
            @endphp

        @endforeach

        <tr>
            <th colspan="6"> </th>
            <th> SubTotal: </th>
            <td style="width: 80px"> {{ number_format($total, 0, ',', '.') }} </td>
        </tr>
        <tr>
            <th colspan="6"> </th>
            <th> Impuestos: </th>
            <td style="width: 80px"> {{ number_format($impuestos, 0, ',', '.') }} </td>
        </tr>
        <tr>
            <th colspan="6"> </th>
            <th> Total: </th>
            <td style="width: 80px"> {{ number_format($total + $impuestos, 0, ',', '.') }} </td>
        </tr>

    </table>

    <div class="footer">
        <p class="page">Pág. </p>
    </div> 

</body>