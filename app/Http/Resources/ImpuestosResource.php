<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImpuestosResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        if (is_null($this->resource)) {
            return [];
        }

        return [
            'id' => $this->id,
            'concepto' => $this->concepto,
            'tarifa' => $this->tarifa,
            'tipo_tarifa' => $this->tipo_tarifa,
            'tipo_tarifa_label' => $this->tipo_tarifa_label,
            'tipo_impuesto' => $this->tipo_impuesto,
            'tipo_impuesto_label' => $this->tipo_impuesto_label,
        ];
    }
}
