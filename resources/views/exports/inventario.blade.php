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
        <tr className="font-bold text-left">
            <th colspan="2"> Artículo </th>
            <th colspan="2"> Orígen </th>
            <th colspan="2"> Cantidad </th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $item)
            <tr>
                <td colspan="2"> {{ $item->articulo }} </td>
                <td colspan="2"> {{ $item->origenLabel }} </td>
                <td colspan="2"> {{ $item->productos->reduce( function ($sum, $item) { return $sum + $item->cantidad; }, 0) }} </td>
            </tr>
            <tr>
                <th style="width:105px"> Artículo </th>
                <th style="width:105px"> Referencia </th>
                <th style="width:107px"> Color </th>
                <th style="width:107px"> Medida </th>
                <th style="width:106px"> Cantidad </th>
                <th style="width:106px"> Precio Costo </th>
            </tr>
            @foreach( $item->productos as $prod )
                <tr>
                    <td> {{ $item->articulo }} </td>
                    <td> {{ $prod->referencia }} </td>
                    <td> {{ $prod->color->color }} </td>
                    <td> {{ $prod->medida->medida }} </td>
                    <td> {{ $prod->cantidad }} </td>
                    <td> {{ number_format($prod->precio, 0, '.', ',') }} </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>