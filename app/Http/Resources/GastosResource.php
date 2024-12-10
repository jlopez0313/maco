<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GastosResource extends JsonResource
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
            'transaccionID' => $this->transaccionID,
            'prefijo' => $this->prefijo,
            'folio' => $this->folio,
            'proveedor' => $this->proveedor,
            'forma_pago' => $this->forma_pago,
            'medio_pago' => $this->medio_pago,
            'valor' => $this->valor,
            'created_at' => $this->created_at,
            'detalles' => $this->detalles,
            'recaudos' => $this->recaudos,
            'cobros' => $this->cobros,
            'estado' => $this->estado,
            'estado_label' => $this->estado_label,
            'created_at' => $this->created_at,
        ];
    }
}
