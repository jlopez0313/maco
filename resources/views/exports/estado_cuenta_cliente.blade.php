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
    $valor = $invoices->map( function ($item) {
            return (
                $item->detalles->reduce (
                    function ($carry, $det) {
                        return $carry + ( $det->precio_venta * $det->cantidad ) ;
                    }, 0
                ) ?? 0
            );
        });
        
    $cobros = $invoices->map( function ($item) {
            return (
                $item->recaudos->reduce( 
                    function ($carry, $det) {
                        return $carry + $det->valor ;
                    }, 0
                ) ?? 0
            );
        });
@endphp

<table border="1" class="reporte">
    <thead>
        <tr>
            <th style="width: 150px"> Fecha </th>
            <th style="width: 150px"> Cliente </th>
            <th style="width: 150px"> Valor Total </th>
            <th style="width: 150px"> Saldo </th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $idx => $item)
            <tr>
                <td> {{ $item->created_at }} </td>
                <td> {{ $item->cliente?->nombre ?? "" }} </td>
                <td> {{ number_format($valor[$idx], 0, '.', ',') ?? 0 }} </td>
                <td> {{ number_format( ($valor[$idx] ?? 0) - ($cobros[$idx] ?? 0), 0, '.', ',') ?? 0 }} </td>
            </tr>
        @endforeach 
    </tbody>
</table>