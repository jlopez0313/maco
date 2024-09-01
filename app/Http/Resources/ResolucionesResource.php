<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResolucionesResource extends JsonResource
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
            'empresa' => $this->empresa,
            'resolucion' => $this->resolucion,
            'prefijo' => $this->prefijo,
            'consecutivo_inicial' => $this->consecutivo_inicial,
            'consecutivo_final' => $this->consecutivo_final,
            'fecha_inicial' => $this->fecha_inicial,
            'fecha_final' => $this->fecha_final,
            'estado' => $this->estado,
            'estado_label' => $this->estado_label,
        ];
    }
}
