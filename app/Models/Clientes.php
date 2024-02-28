<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clientes extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = 'clientes';
    protected $guarded = [];

    public function ciudad() {
        return $this->hasOne(Ciudades::class, 'id', 'ciudad_id');
    }
    
    public function tipo() {
        return $this->hasOne(TiposClientes::class, 'id', 'tipo_id');
    }

    public function getTipoDocLabelAttribute() {
        $lista = config('constants.tipo_doc');
        $origenObj = \Arr::first($lista, function($val, $key) {
            return $val['key'] == $this->tipo_doc;
        });
        
        return $origenObj['valor'] ?? 'N/A';
    }
}
