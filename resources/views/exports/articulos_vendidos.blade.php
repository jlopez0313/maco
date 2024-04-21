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

<table border="1" class="reporte">
    <thead>
        <tr>
            <th style="width: 120px"> Fecha </th>
            <th style="width: 110px"> Referencia </th>
            <th style="width: 110px"> Origen </th>
            <th style="width: 100px"> Cantidad </th>
            <th style="width: 110px"> Valor Unitario </th>
            <th style="width: 110px"> Valor Total </th>
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