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
            'responsabilidad' => $this->responsabilidad,
            'documento' => $this->documento,
            'dv' => $this->dv, 
            'ciudad' => $this->ciudad,
            'nombre' => $this->nombre,
            'comercio' => $this->comercio,
            'direccion' => $this->direccion,
            'tipo' => $this->tipo,
            'celular' => $this->celular,
            'correo' => $this->correo,
            'matricula' => $this->matricula,
        ];
    }
}
