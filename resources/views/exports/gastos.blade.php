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
            <th style="width: 130px"> Código </th>
            <th style="width: 130px"> Fecha </th>
            <th style="width: 130px"> Cliente </th>
            <th style="width: 130px"> Origen </th>
            <th style="width: 130px"> Valor </th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $idx => $item)
            <tr>
                <td> {{ $item->id }} </td>
                <td> {{ $item->created_at }} </td>
                <td> {{ $item->cliente?->nombre ?? "" }} </td>
                <td> {{ $item->origen_label ?? "" }} </td>
                <td> {{ number_format($item->valor, 0, '.', ',') ?? 0 }} </td>
            </tr>
        @endforeach
    </tbody>
</table>