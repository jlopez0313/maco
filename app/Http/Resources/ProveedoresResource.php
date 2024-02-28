<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProveedoresResource extends JsonResource
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
            'tipo_doc' => $this->tipo_doc,
            'tipo_doc_label' => $this->tipo_doc_label,
            'documento' => $this->documento,
            'ciudad' => $this->ciudad,
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'celular' => $this->celular,
        ];
    }
}
