<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ClientesCollection extends ResourceCollection
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
            'id',
            'tipo_doc',
            'documento',
            'dv',
            'nombre',
            'comercio',
            'ciudad',
            'direccion',
            'celular',
            'correo',
            'tipo',
            'responsabilidad',
            'matricula',
            'contacto',
        );
    }
}
