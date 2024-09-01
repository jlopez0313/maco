<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ResolucionesCollection extends ResourceCollection
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
            'empresa',
            'resolucion',
            'prefijo',
            'consecutivo_inicial',
            'consecutivo_final',
            'fecha_inicial',
            'fecha_final',
            'estado',
            'estado_label',
        );
    }
}
