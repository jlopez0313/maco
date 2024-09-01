<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TiposDocumentosResource extends JsonResource
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
            'codigo' => $this->codigo,
            'tipo' => $this->tipo,
        ];
    }
}
