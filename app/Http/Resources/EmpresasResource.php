<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmpresasResource extends JsonResource
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
            'documento' => $this->documento,
            'responsabilidad' => $this->responsabilidad,
            'dv' => $this->dv, 
            'ciudad' => $this->ciudad,
            'nombre' => $this->nombre,
            'comercio' => $this->comercio,
            'matricula' => $this->matricula,
            'direccion' => $this->direccion,
            'contacto' => $this->contacto,
            'tipo' => $this->tipo,
        ];
    }
}
