@php
    $sum = 0;
@endphp


<style>
    .page-break {
        page-break-after: always;
    }

    .py-12 {
        width: 100%;
    }

    .grid {
        display: grid;
    }

    .detalle {
        margin-top: 20px;
        font-size: 11px;
    }

</style>

<div className="py-12">
    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <form>
                <div className="grid grid-cols-2 gap-4">
                    <div>
                        <Label> Documento </Label>

                        <input
                            type="text"
                            value="{{$factura->id}}"
                            className="mt-1 block w-full"
                        />
                    </div>
                    
                    <div>
                        <Label> Cliente </Label>

                        <Input
                            type="text"
                            value="{{$factura->cliente->nombre}}"
                            className="mt-1 block w-full"
                        />
                    </div>
                    
                    <div>
                        <Label> Fecha </Label>

                        <Input
                            type="text"
                            value="{{$factura->created_at}}"
                            className="mt-1 block w-full"
                        />
                    </div>
                    
                    <div>
                        <Label> Valor Total </Label>
                        
                        <Input
                            type="text"
                            value="{{ $sum }}"
                            className="mt-1 block w-full"
                        />
                    </div>
                    
                </div>
            </form>
        </div>


        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <table border="1" class="detalle">
                <tr class="font-12">
                    <th style="width: 180px">Artículo</th>
                    <th style="width: 180px">Referencia</th>
                    <th style="width: 80px">Color</th>
                    <th style="width: 60px">Medida</th>
                    <th style="width: 60px">Cantidad</th>
                    <th style="width: 100px">Precio Venta</th>
                </tr>
                @foreach ($factura->detalles as $index => $item)
                    <tr>
                        <td style="width: 180px">{{ $item->producto->inventario->articulo ?? '' }}</td>
                        <td style="width: 180px">{{ $item->producto->referencia ?? '' }}</td>
                        <td style="width: 80px">{{ $item->producto->color->color ?? '' }}</td>
                        <td style="width: 60px">{{ $item->producto->medida->medida ?? '' }}</td>
                        <td style="width: 60px">{{ $item->cantidad }}</td>
                        <td style="width: 100px">{{ $item->precio_venta }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        
    </div>
</div>