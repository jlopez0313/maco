<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GastosCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        if (is_null($this->resource)) {
            return [];
        }
        
        return $this->collection->map->only(
            'id',
            'transaccionID',
            'prefijo',
            'folio',
            'proveedor',
            'forma_pago',
            'medio_pago',
            'valor',
            'created_at',
            'detalles',
            'recaudos',
            'cobros',
            'estado',
            'estado_label'
        );
    }
}
