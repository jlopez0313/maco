<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactosResource extends JsonResource
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
            'nombre' => $this->nombre,
            'celular' => $this->celular,
            'correo' => $this->correo,
            'principal' => $this->principal,
            'principal_label' => $this->principal_label,
        ];
    }
}
