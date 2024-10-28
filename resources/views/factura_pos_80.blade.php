@php
    $sum = 0;
    $total = 0;
    $impuestos = 0;
@endphp

<script>
    window.onload = function() {
        window.print();
    };
</script>

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

    .empresa {
        border-bottom: 1px dashed #000;
    }

    .empresa td {
        font-size: 12px;
        font-weight: bold;
    }

    .header {
        font-size: 12px;
    }

    .header th {
        text-align: left;
        margin-left: 10px;    
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

    <table class="empresa">
        <tr>
            <td style="width: 250px"> {{ $empresa->comercio }} </td>
        </tr>
        <tr>
            <td style="width: 250px"> {{ $empresa->tipo_doc->tipo }} {{ $empresa->documento }} - {{ $empresa->dv }} </td>
        </tr>
        <tr>
            <td style="width: 250px"> Régimen: {{ $empresa->tipo->tipo }} </td>
        </tr>
        <tr>
            <td style="width: 250px"> {{ $empresa->direccion }}, {{ $empresa->ciudad->ciudad }} Colombia</td>
        </tr>
        <tr>
            <td style="width: 250px"> Tel. {{ $empresa->contacto->celular }} </td>
        </tr>
    </table>


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
            <th style="width: 120px">Forma de Pago: </th>
            <td style="width: 265px"> {{ $factura->forma_pago->descripcion }} </td>
        </tr>
        <tr>
            <th style="width: 120px">Medio de Pago: </th>
            <td style="width: 265px"> {{ $factura->medio_pago->descripcion }} </td>
        </tr>
        <tr>
            <th style="width: 120px">Dirección: </th>
            <td style="width: 265px"> {{ $factura->cliente->direccion }} </td>
        </tr>
        <tr>
            <th style="width: 120px">Documento: </th>
            <td> {{ $factura->cliente->documento }} </td>
        </tr>
        <tr>
            <th style="width: 120px">Teléfono: </th>
            <td> {{ $factura->cliente->celular }} </td>
        </tr>
        <tr>
            <th style="width: 120px">Nombre: </th>
            <td> {{ $factura->cliente->nombre }} </td>
        </tr>
        <tr>
            <th style="width: 120px">Correo: </th>
            <td> {{ $factura->cliente->correo }} </td>
        </tr>
    </table>

    <table class="detalle" cellpadding="3" cellspacing="0">
        <tr class="font-12">
            <th style="width: 140px">Referencia</th>
            <th style="width: 50px">Cant.</th>
            <th style="width: 60px">Precio</th>
        </tr>
        <tr class="font-12">
            <th style="width: 140px"></th>
            <th style="width: 50px">Imp.</th>
            <th style="width: 60px">Total</th>
        </tr>
        
        @foreach ($factura->detalles as $index => $item)
            <tr>
                <td style="width: 140px">{{ $item->producto->referencia ?? '' }}</td>
                <td style="width: 50px">{{ $item->cantidad }}</td>
                <td style="width: 60px">{{ number_format($item->precio_venta, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="width: 140px"></td>
                <td style="width: 50px">{{ number_format( getImpuestos( $item ) , 0, ',', '.') }}</td>
                <td style="width: 60px">{{ number_format($item->precio_venta * $item->cantidad, 0, ',', '.') }}</td>
            </tr>
            
            @php
                $total += ( $item->precio_venta * $item->cantidad );
                $impuestos += ( getImpuestos( $item )  * $item->cantidad );
            @endphp

        @endforeach
    </table>

    <br /><br />
    
    <table class="total" cellpadding="3" cellspacing="0">
        <tr>
            <th style="width: 115px"> </th>
            <th style="width: 50px"> SubTotal: </th>
            <td style="width: 80px"> {{ number_format($total, 0, ',', '.') }} </td>
        </tr>
        <tr>
            <th style="width: 115px"> </th>
            <th style="width: 50px"> Impuestos: </th>
            <td style="width: 80px"> {{ number_format($impuestos, 0, ',', '.') }} </td>
        </tr>
        <tr>
            <th style="width: 115px" > </th>
            <th style="width: 50px" > Total: </th>
            <td style="width: 80px"> {{ number_format($total + $impuestos, 0, ',', '.') }} </td>
        </tr>

    </table>

    <div class="mensaje">
        Gracias por confiar en nosotros, <br /> 
        ¡Tu satisfacción es nuestra prioridad!
    </div>

</body>