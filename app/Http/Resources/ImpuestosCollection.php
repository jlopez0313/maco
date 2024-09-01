<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ImpuestosCollection extends ResourceCollection
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
            'id', 'concepto', 'tarifa', 'tipo_tarifa', 'tipo_tarifa_label', 'tipo_impuesto', 'tipo_impuesto_label'
        );
    }
}
