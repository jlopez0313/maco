<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FacturasResource extends JsonResource
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
            'detalles' => $this->detalles,
            'cliente' => $this->cliente,
            'recaudos' => $this->recaudos,
            'tipo_pago' => $this->tipo_pago,
            'forma_pago' => $this->forma_pago,
            'valor' => $this->valor,
            'estado' => $this->estado,
            'estado_label' => $this->estado_label,
            'created_at' => $this->created_at,
        ];
    }
}
